<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author 
 * @brief CRUD for User Access
 */

class User_access extends EX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('menu_model');
        $this->load->model('user_model');
        $this->load->model('customer_type_model');
        $this->load->model('customer_access_model');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    /**
     * List page
     * Generate table list view of User Access
     * @return html
     * */
    public function index()
    {
        $this->data['output'] = array(
            'js_files' => array(
                'assets/scripts/pages/user_access_list.js'
            )
        );

        $this->load->view('user_access/list_view', $this->data);
    }

    /**
     * Datatable JSON autogeneration
     * Generate content of table list view
     * @return JSON
     * */
    public function get_json()
    {
        $this->load->library('datatable');

        $actions = anchor('user_access/update/$1', '<i class="fa fa-pencil"></i> edit', array('class' => 'btn btn-xs btn-default green-stripe'));
        $actions .= ' ' . anchor('user_access/delete/$1', '<i class="fa fa-trash-o"></i> delete', array('class' => 'btn btn-xs btn-default red-stripe', 'onclick' => "return confirm('Are you sure you want to delete this record?');"));

        $this->datatable->select('customer_type_id, customer_type_name');
        $this->datatable->from('customer_type');
        $this->datatable->add_column('actions', $actions, 'customer_type_id');

        echo $this->datatable->generate();
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
            $this->data['form_title'] = 'Add New User Access';
            $this->data['form_action'] = site_url('user_access/create');
            $this->data['form'] = $this->generate_form();
            $this->data['menus'] = array();
            $get_parent_menus = $this->menu_model->get_sub();
            if ($get_parent_menus)
            {
                foreach ($get_parent_menus->result() as $parent_menu)
                {
                    $this->data['menus'][$parent_menu->menu_id]['data'] = $parent_menu;
                    $this->data['menus'][$parent_menu->menu_id]['sub_menus'] = array();
                    $get_sub_menus = $this->menu_model->get_sub($parent_menu->menu_id);
                    if ($get_sub_menus)
                    {
                        foreach ($get_sub_menus->result() as $sub_menu)
                        {
                            $this->data['menus'][$parent_menu->menu_id]['sub_menus'][] = $sub_menu;
                        }
                    }
                }
            }
            
            $this->load->view('user_access/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('customer_type_name', 'User Type', 'required');
            $this->form_validation->set_rules('menu_id', 'Menu', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                $check_duplicated = $this->customer_type_model->check_duplicated($data);
                if ($check_duplicated > 0)
                {
                    echo error_message('User Type "'.$data['customer_type_name'].'" is already exists.');
                    exit();
                }

                $save = $this->customer_type_model->insert($data); //save data into database
                if ($save)
                {
                    $this->customer_access_model->delete_by_customer_type($save);
                    foreach ($data['menu_id'] as $menu_id)
                    {
                        $data_access = array(
                            'customer_type_id' => $save,
                            'menu_id' => $menu_id
                        );
                        $this->customer_access_model->insert($data_access);
                    }

                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                    echo ajax_redirect('user_access');
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
    public function update($customer_type_id)
    {
        if (!$this->input->post())
        {
            $user_data = $this->get_data($customer_type_id);

            $this->data['form_title'] = 'Edit User Access';
            $this->data['form_action'] = site_url('user_access/update/' . $customer_type_id);
            $this->data['form'] = $this->generate_form($user_data);
            $this->data['access'] = $this->customer_access_model->get_by_customer_type($customer_type_id);
            $this->data['menus'] = array();
            $get_parent_menus = $this->menu_model->get_sub();
            if ($get_parent_menus)
            {
                foreach ($get_parent_menus->result() as $parent_menu)
                {
                    $this->data['menus'][$parent_menu->menu_id]['data'] = $parent_menu;
                    $this->data['menus'][$parent_menu->menu_id]['sub_menus'] = array();
                    $get_sub_menus = $this->menu_model->get_sub($parent_menu->menu_id);
                    if ($get_sub_menus)
                    {
                        foreach ($get_sub_menus->result() as $sub_menu)
                        {
                            $this->data['menus'][$parent_menu->menu_id]['sub_menus'][] = $sub_menu;
                        }
                    }
                }
            }
            
            $this->load->view('user_access/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('customer_type_name', 'User Type', 'required');
            $this->form_validation->set_rules('menu_id', 'Menu', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                $check_duplicated = $this->customer_type_model->check_duplicated($data, $customer_type_id);
                if ($check_duplicated > 0)
                {
                    echo error_message('User Type "'.$data['customer_type_name'].'" is already exists.');
                    exit();
                }

                $save = $this->customer_type_model->update($customer_type_id, $data);
                if ($save)
                {
                    $this->customer_access_model->delete_by_customer_type($customer_type_id);
                    foreach ($data['menu_id'] as $menu_id)
                    {
                        $data_access = array(
                            'customer_type_id' => $customer_type_id,
                            'menu_id' => $menu_id
                        );
                        $this->customer_access_model->insert($data_access);
                    }

                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully updated.'));
                    echo ajax_redirect('user_access');
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
    public function delete($customer_type_id)
    {
        $this->get_data($customer_type_id);
        $check_foreign_key = $this->customer_type_model->check_foreign($customer_type_id);
        if ($check_foreign_key === TRUE)
        {
            $this->session->set_flashdata('error_message', error_message('Your data cannot be deleted from the database.'));
            redirect('user_access');
        }

        $this->customer_access_model->delete_by_customer_type($customer_type_id);
        $delete = $this->customer_type_model->delete($customer_type_id);
        if ($delete)
        {
            $this->session->set_flashdata('success_message', success_message('Your data has been successfully deleted from the database.'));
            redirect('user_access');
        }
        else
        {
            $this->session->set_flashdata('error_message', error_message('Your data was not deleted from the database.'));
            redirect('user_access');
        }
    }

    /**
     * Get Data
     *
     * @return Object
     * */
    public function get_data($user_id)
    {
        $user_data = $this->customer_type_model->get($user_id);
        if (!$user_data)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('user_access');
            exit;
        }
        return $user_data;
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
                    'id' => 'customer_type_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->customer_type_id : '',
                ),
                array(
                    'id' => 'customer_type_name',
                    'label' => 'User Type',
                    'value' => (!is_null($data)) ? $data->customer_type_name : '',
                    'placeholder' => 'User Type',
                    'required' => 'true'
                )
            )
        );
        return $output;
    }

}
