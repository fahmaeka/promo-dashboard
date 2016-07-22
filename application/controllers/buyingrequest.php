<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author Eka Fahma
 * @brief buying request
 */

class Buyingrequest extends EX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('promo_code_model');
        $this->load->model('promo_model');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    public function index()
    {
        if (!$this->input->post())
        {
            $this->data['form_title'] = 'Add New Promo Code';
            $this->data['form_action'] = site_url('buyingrequest');
            $this->data['form'] = $this->generate_form();
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_code_generate_form.js'
                )
            );

            $this->load->view('promo_code_generate/form_view', $this->data);
        }
        else
        {
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_code_prefix_input', 'Code', 'required');
            $this->form_validation->set_rules('promo_code_repeat', 'Code', 'required');
            $this->form_validation->set_rules('promo_id', 'Code', 'required');

            if ($this->form_validation->run() === TRUE)
            {
                $data = $this->input->post(NULL, TRUE);

                if (strlen($data['promo_code_prefix_input']) > 4) {
                    echo error_message('There are code data promo more than 4 character.');
                    exit();
                }

                if (strlen($data['promo_code_prefix_input']) > 10000) {
                    echo error_message('There are Generate Repeated more than 10000x.');
                    exit();
                }
            
                $period = explode(' - ', $data['promo_code_time']); // split daterange
                $data['promo_code_start_date'] = str_replace('/', '-', $period[0]);
                $data['promo_code_expired'] = str_replace('/', '-', $period[1]);

                $generate = 1;
                while($generate <= $data['promo_code_repeat']) { 
                    $characters = $data['promo_code_prefix_input'];             
                    $random_code = substr(strtoupper(md5(uniqid(rand().microtime(),true))),0, (10 - strlen($data['promo_code_prefix_input'])));
                    $random_string = $characters.$random_code;
                    $data['promo_code_prefix'] = $random_string;

                    $data['customer_id'] = $this->customer_id();
                    $data['promo_code_created_by'] = $this->customer_id();
                    $data['promo_code_updated_by'] = $this->customer_id();

                    $data['promo_code_count'] = 0;
                    $data['promo_code_max_count'] = 1;

                    $check_duplicated = $this->promo_code_model->check_duplicated($data);
                    if($check_duplicated == 0)
                    {
                        /* $characters_dup = $data['promo_code_prefix_input'];             
                        $random_code_dup = substr(strtoupper(md5(uniqid(rand().microtime(),true))),0, (10 - strlen($data['promo_code_prefix_input'])));
                        $random_string_dup = $characters_dup.$random_code_dup;
                        $data['promo_code_prefix'] = $random_string_dup; */
                        $save = $this->promo_code_model->insert($data);
                        $generate++;
                    }
                } 
                if ($save === TRUE)
                    {
                        $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                        echo ajax_redirect('promo_code');
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
     * Form Create
     * 
     * @return html
     * */
    public function create()
    {
        if (!$this->input->post())
        {
            $this->data['form_title'] = 'Add New Promo Code';
            $this->data['form_action'] = site_url('promo_code/create');
            $this->data['form'] = $this->generate_form();
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_code_form.js'
                )
            );

            $this->load->view('promo_code/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            //$this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_code_value', 'Code', 'required');
            $this->form_validation->set_rules('promo_id', 'Code ID', 'required');
            $this->form_validation->set_rules('promo_code_max_count', 'Max Count', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);
                $period = explode(' - ', $data['promo_code_time']); // split daterange
                $data['promo_code_start_date'] = str_replace('/', '-', $period[0]);
                $data['promo_code_expired'] = str_replace('/', '-', $period[1]);

                $check_duplicated = $this->promo_code_model->check_duplicated($data);
                if ($check_duplicated > 0)
                {
                    echo error_message('There are duplicated data on database.');
                    exit();
                }
                $data['promo_code_created_by'] = $this->customer_id();
                $data['promo_code_updated_by'] = $this->customer_id();
                $data['promo_code_count'] = 0;
                $data['promo_code_prefix'] = $data['promo_code_value'];
                
                $save = $this->promo_code_model->insert($data); //save data into database
                if ($save === TRUE)
                {
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                    echo ajax_redirect('promo_code');
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
    public function update($promo_code_id)
    {
        if (!$this->input->post())
        {
            $promo_code_data = $this->get_data($promo_code_id);

            $this->data['form_title'] = 'Edit Promo Code';
            $this->data['form_action'] = site_url('promo_code/update/' . $promo_code_id);
            $this->data['form'] = $this->generate_form($promo_code_data);
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_code_form.js'
                )
            );

            $this->load->view('promo_code/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_code_value', 'Code', 'required');
            $this->form_validation->set_rules('promo_id', 'Promo Id', 'required');
            $this->form_validation->set_rules('promo_code_max_count', 'Max Count', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                $period = explode(' - ', $data['promo_code_time']); // split daterange
                $data['promo_code_start_date'] = str_replace('/', '-', $period[0]);
                $data['promo_code_expired'] = str_replace('/', '-', $period[1]);
                $data['promo_code_updated_by'] = $this->customer_id();
                $data['promo_code_prefix'] = $data['promo_code_value'];

                $save = $this->promo_code_model->update($promo_code_id, $data);
                if ($save)
                {
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully updated.'));
                    echo ajax_redirect('promo_code');
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
    public function delete($promo_code_id)
    {
        $this->get_data($promo_code_id);

        $delete = $this->promo_code_model->delete($promo_code_id);
        if ($delete)
        {
            $this->session->set_flashdata('success_message', success_message('Your data has been successfully deleted from the database.'));
            redirect('promo_code');
        }
        else
        {
            $this->session->set_flashdata('error_message', error_message('Your data was not deleted from the database.'));
            redirect('promo_code');
        }
    }

    /**
     * Get Data
     *
     * @return Object
     * */
    public function get_data($promo_code_id)
    {
        $promo_code_data = $this->promo_code_model->get($promo_code_id);
        if (!$promo_code_data)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('promo_code');
            exit;
        }
        return $promo_code_data;
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
                    'id' => 'promo_code_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->promo_code_id : ''
                ),
                array(
                    'id' => 'promo_id',
                    'type' => 'dropdown',
                    'label' => 'Promo',
                    'value' => (!is_null($data)) ? $data->promo_id : '',
                    'options' => $this->promo_model->dropdown(),
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_code_value',
                    'label' => 'Code',
                    'value' => (!is_null($data)) ? $data->promo_code_value : '',
                    'placeholder' => 'Code',
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_code_max_count',
                    'label' => 'Max Count',
                    'value' => (!is_null($data)) ? $data->promo_code_max_count : '',
                    'placeholder' => 'Max Count',
                    'onKeyPress' => 'return isNumberKey(event)',
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_code_time',
                    'label' => 'Promo Code Period',
                    'value' => (!is_null($data)) ? $data->promo_code_start_date.' - '.$data->promo_code_expired : '',
                    'placeholder' => 'Period',
                    'required' => 'true'
                )
            )
        );
        return $output;
    }
}
