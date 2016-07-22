<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author 
 * @brief CRUD for Menu
 */

class Menu extends EX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('menu_model');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    /**
     * List page
     * Generate table list view of Menu
     * @return html
     * */
    public function index()
    {
        $this->data['output'] = array(
            'js_files' => array(
                'assets/scripts/pages/menu_list.js'
            )
        );

        $this->load->view('menu/list_view', $this->data);
    }

    /**
     * Datatable JSON autogeneration
     * Generate content of table list view
     * @return JSON
     * */
    public function get_json()
    {
        $this->load->library('datatable');

        $actions = anchor('menu/update/$1', '<i class="fa fa-pencil"></i> edit', array('class' => 'btn btn-xs btn-default green-stripe'));
        $actions .= ' ' . anchor('menu/delete/$1', '<i class="fa fa-trash-o"></i> delete', array('class' => 'btn btn-xs btn-default red-stripe', 'onclick' => "return confirm('Are you sure you want to delete this record?');"));

        $this->datatable->select('menu.menu_id, menu.menu_name, menu.menu_slug, menu.menu_icon, menu.menu_precedence, menu.menu_status, p.menu_name as parent_name');
        $this->datatable->from('menu');
        $this->datatable->join('menu p', 'p.menu_id=menu.menu_parent_id', 'LEFT');
        $this->datatable->add_column('actions', $actions, 'menu_id');

        $array = json_decode($this->datatable->generate(), TRUE);
        foreach ($array['data'] as $key => $value)
        {
            if ($value['menu_status'] == 1)
            {
                $array['data'][$key]['menu_status'] = '<span class="label label-success">Active</span>';
            }
            else
            {
                $array['data'][$key]['menu_status'] = '<span class="label label-danger">Inactive</span>';
            }
        }

        echo json_encode($array);
    }

    /**
     * Form Create
     * 
     * @return html
     * */
    public function create()
    {
        if (!$this->input->post())
        {
            $this->data['form_title'] = 'Add New Menu';
            $this->data['form_action'] = site_url('menu/create');
            $this->data['form'] = $this->generate_form();

            $this->load->view('menu/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('menu_name', 'Menu Name', 'required');
            $this->form_validation->set_rules('menu_slug', 'Slug', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                $check_duplicated = $this->menu_model->check_duplicated($data);
                if ($check_duplicated > 0)
                {
                    echo error_message('There are duplicated data on database.');
                    exit();
                }

                $save = $this->menu_model->insert($data); //save data into database
                if ($save === TRUE)
                {
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                    echo ajax_redirect('menu');
                }
                else
                {
                    echo error_message('An error has occurred on insert.');
                }
            }
            else
            {
                echo error_message(validation_errors());
            }
        }
    }

    /**
     * Form Edit
     *
     * @return html
     * @author Sandi Anjar Maulana
     * */
    public function update($menu_id)
    {
        if (!$this->input->post())
        {
            $menu_data = $this->get_data($menu_id);

            $this->data['form_title'] = 'Edit Menu';
            $this->data['form_action'] = site_url('menu/update/' . $menu_id);
            $this->data['form'] = $this->generate_form($menu_data);

            $this->load->view('menu/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('menu_name', 'Menu Name', 'required');
            $this->form_validation->set_rules('menu_slug', 'Slug', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $menu_id = $this->input->post('menu_id', TRUE);
                $data = $this->input->post(NULL, TRUE);

                $check_duplicated = $this->menu_model->check_duplicated($data, $menu_id);
                if ($check_duplicated > 0)
                {
                    echo error_message('There are duplicated data on database.');
                    exit();
                }

                $save = $this->menu_model->update($menu_id, $data);
                if ($save)
                {
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully updated.'));
                    echo ajax_redirect('menu');
                }
                else
                {
                    echo error_message('An error has occurred on saving.');
                }
            }
            else
            {
                echo error_message(validation_errors());
            }
        }
    }

    /**
     * Delete
     *
     * @return html
     * */
    public function delete($menu_id)
    {
        $this->get_data($menu_id);
        $check_foreign_key = $this->menu_model->check_foreign($menu_id);
        if ($check_foreign_key === TRUE)
        {
            $this->session->set_flashdata('error_message', error_message('Your data cannot be deleted from the database.'));
            redirect('menu');
        }

        $delete = $this->menu_model->delete($menu_id);
        if ($delete)
        {
            $this->session->set_flashdata('success_message', success_message('Your data has been successfully deleted from the database.'));
            redirect('menu');
        }
        else
        {
            $this->session->set_flashdata('error_message', error_message('Your data was not deleted from the database.'));
            redirect('menu');
        }
    }

    /**
     * Get Data
     *
     * @return Object
     * */
    public function get_data($menu_id)
    {
        $menu_data = $this->menu_model->get($menu_id);
        if (!$menu_data)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('menu');
            exit;
        }
        return $menu_data;
    }

    /**
     * Bootstrap Form Builder
     *
     * @return html
     * */
    public function generate_form($data = NULL)
    {
        $this->load->library('form_builder');

        $output = $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'menu_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->menu_id : '',
                ),
                array(
                    'id' => 'menu_name',
                    'label' => 'Menu Name',
                    'value' => (!is_null($data)) ? $data->menu_name : '',
                    'placeholder' => 'Menu Name',
                    'required' => 'true'
                ),
                array(
                    'id' => 'menu_slug',
                    'label' => 'Slug',
                    'value' => (!is_null($data)) ? $data->menu_slug : '',
                    'placeholder' => 'Slug',
                    'required' => 'true'
                ),
                array(
                    'id' => 'menu_icon',
                    'label' => 'Icon',
                    'value' => (!is_null($data)) ? $data->menu_icon : '',
                    'placeholder' => 'Icon'
                ),
                array(
                    'id' => 'menu_parent_id',
                    'type' => 'dropdown',
                    'label' => 'Parent',
                    'value' => (!is_null($data)) ? $data->menu_parent_id : '',
                    'options' => $this->menu_model->dropdown()
                ),
                array(
                    'id' => 'menu_precedence',
                    'label' => 'Precedence',
                    'value' => (!is_null($data)) ? $data->menu_precedence : '',
                    'placeholder' => 'Precedence',
					'required' => 'true'
                ),
                array(
                    'id' => 'menu_status',
                    'type' => 'dropdown',
                    'label' => 'Status',
                    'value' => (!is_null($data)) ? $data->menu_status : '',
                    'options' => array(1 => 'Active', 0 => 'Inactive'),
                    'required' => 'true'
                )
            )
        );
        return $output;
    }

}
