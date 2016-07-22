<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author 
 * @brief CRUD for User
 */

class User extends EX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('user_model');
        $this->load->model('customer_type_model');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    /**
     * List page
     * Generate table list view of User
     * @return html
     * */
    public function index()
    {
        $this->data['output'] = array(
            'js_files' => array(
                'assets/scripts/pages/user_list.js'
            )
        );

        $this->load->view('user/list_view', $this->data);
    }

    /**
     * Datatable JSON autogeneration
     * Generate content of table list view
     * @return JSON
     * */
    public function get_json()
    {
        $this->load->library('datatable');

        $actions = anchor('user/update/$1', '<i class="fa fa-pencil"></i> edit', array('class' => 'btn btn-xs btn-default green-stripe'));
        $actions .= ' ' . anchor('user/delete/$1', '<i class="fa fa-trash-o"></i> delete', array('class' => 'btn btn-xs btn-default red-stripe', 'onclick' => "return confirm('Are you sure you want to delete this record?');"));

        $this->datatable->select('customer_id, customer_username, customer_email, customer_status, customer_type_name');
        $this->datatable->from('customer');
        $this->datatable->join('customer_type', 'customer_type.customer_type_id=customer.customer_type_id');
        $this->datatable->add_column('actions', $actions, 'customer_id');

        $array = json_decode($this->datatable->generate(), TRUE);
        foreach ($array['data'] as $key => $value)
        {
            if ($value['customer_status'] == 1)
            {
                $array['data'][$key]['customer_status'] = '<span class="label label-success">Active</span>';
            }
            else
            {
                $array['data'][$key]['customer_status'] = '<span class="label label-danger">Inactive</span>';
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
            $this->data['form_title'] = 'Add New User';
            $this->data['form_action'] = site_url('user/create');
            $this->data['form'] = $this->generate_form();

            $this->load->view('user/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('customer_username', 'Username', 'required');
            $this->form_validation->set_rules('customer_password', 'Password', 'required|min_length[7]');
            $this->form_validation->set_rules('customer_email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                //check username
                if (!preg_match('/^[a-zA-Z0-9]+$/', $data['customer_username']))
                {
                    echo error_message('Username "'.$data['customer_username'].'" is not valid, use only alphanumeric!');
                    exit();
                }

                $check_duplicated = $this->user_model->check_duplicated($data);
                if ($check_duplicated > 0)
                {
                    echo error_message('Username "'.$data['customer_username'].'" is already exists.');
                    exit();
                }

                $save = $this->user_model->insert($data); //save data into database
                if ($save === TRUE)
                {
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                    echo ajax_redirect('user');
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
    public function update($user_id)
    {
        if (!$this->input->post())
        {
            $user_data = $this->get_data($user_id);

            $this->data['form_title'] = 'Edit User';
            $this->data['form_action'] = site_url('user/update/' . $user_id);
            $this->data['form'] = $this->generate_form($user_data);

            $this->load->view('user/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            //$this->form_validation->set_rules('customer_username', 'Username', 'required');
            $this->form_validation->set_rules('customer_email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                //$user_id = $this->input->post('user_id', TRUE);
                $data = $this->input->post(NULL, TRUE);

                //check username
                //if (!preg_match('/^[a-zA-Z0-9]+$/', $data['customer_username']))
                //{
                //    echo error_message('Username "'.$data['customer_username'].'" is not valid, use only alphanumeric!');
                //    exit();
                //}

                //$check_duplicated = $this->user_model->check_duplicated($data, $user_id);
                //if ($check_duplicated > 0)
                //{
                //    echo error_message('There are duplicated data on database.');
                //    exit();
                //}
                if ($data['customer_status'] == '0')
                {
                    $this->user_model->delete_session($user_id);
                }

                $save = $this->user_model->update($user_id, $data);
                if ($save)
                {

                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully updated.'));
                    echo ajax_redirect('user');
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
    public function delete($user_id)
    {
        $this->get_data($user_id);
//        $check_foreign_key = $this->user_model->check_foreign($user_id);
//        if ($check_foreign_key === TRUE)
//        {
//            $this->session->set_flashdata('error_message', error_message('Your data cannot be deleted from the database.'));
//            redirect('user');
//        }

        $delete = $this->user_model->delete($user_id);
        if ($delete)
        {
            $this->user_model->delete_session($user_id);
            $this->session->set_flashdata('success_message', success_message('Your data has been successfully deleted from the database.'));
            redirect('user');
        }
        else
        {
            $this->session->set_flashdata('error_message', error_message('Your data was not deleted from the database.'));
            redirect('user');
        }
    }

    /**
     * Get Data
     *
     * @return Object
     * */
    public function get_data($user_id)
    {
        $user_data = $this->user_model->get($user_id);
        if (!$user_data)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('user');
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

        $username_field = array(
            'id' => 'customer_username',
            'label' => 'Username',
            'value' => (!is_null($data)) ? $data->customer_username : '',
            'placeholder' => 'Username',
            'required' => 'true'
        );
        if (!is_null($data))
        {
            $username_field['disabled'] = TRUE;
        }

        $output = $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'customer_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->customer_id : '',
                ),
                $username_field,
                array(
                    'id' => 'customer_password',
                    'type' => 'password',
                    'label' => (!is_null($data)) ? 'Password<br><small>Leave password blank if not changed</small>' : 'Password',
                    'value' => '',
                    'placeholder' => 'Password'
                ),
                array(
                    'id' => 'customer_email',
                    'label' => 'Email',
                    'value' => (!is_null($data)) ? $data->customer_email : '',
                    'placeholder' => 'Email',
                    'required' => 'true'
                ),
                array(
                    'id' => 'customer_type_id',
                    'type' => 'dropdown',
                    'label' => 'Type',
                    'value' => (!is_null($data)) ? $data->customer_type_id : '',
                    'options' => $this->customer_type_model->dropdown(),
                    'required' => 'true'
                ),
                array(
                    'id' => 'customer_status',
                    'type' => 'dropdown',
                    'label' => 'Status',
                    'value' => (!is_null($data)) ? $data->customer_status : '',
                    'options' => array(1 => 'Active', 0 => 'Inactive'),
                    'required' => 'true'
                )
            )
        );
        return $output;
    }
    
}