<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author Eka Fahma
 * @brief CRUD for Promo Code Generate
 */

class Promo_code_generate extends EX_Controller
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
            $this->data['form_action'] = site_url('promo_code_generate');
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
    
    public function generate_form($data = NULL)
    {
        $this->load->library('form_builder');

        $output = $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'promo_id',
                    'type' => 'dropdown',
                    'label' => 'Promo',
                    'options' => $this->promo_model->dropdown(),
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_code_prefix_input',
                    'label' => 'Prefix Code',
                    'placeholder' => 'Max Prefix 4 Characters',
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_code_repeat',
                    'label' => 'Generate Code',
                    'placeholder' => 'Generate',
                    'required' => 'true',
                    'class' => 'only_number'
                ),
                array(
                    'id' => 'promo_code_time',
                    'label' => 'Promo Code Period',
                    'placeholder' => 'Period',
                    'required' => 'true'
                )
            )
        );
        return $output;
    }
}
