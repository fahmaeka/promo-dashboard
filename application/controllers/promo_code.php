<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author Eka Fahma
 * @brief CRUD for Promo Code
 */

class Promo_code extends EX_Controller
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

    /**
     * List page
     * Generate table list view of Promo Code
     * @return html
     * */
    public function index()
    {
        $this->data['output'] = array(
            'js_files' => array(
                'assets/scripts/pages/promo_code_list.js'
            )
        );

        if ($this->input->get('promo'))
        {
            $promo = $this->promo_model->get($this->input->get('promo'));
            $this->data['promo'] = $promo->promo_id;
        }
        else
        {
            $this->data['promo'] = NULL;
        }

        $this->load->view('promo_code/list_view', $this->data);
    }

    /**
     * Datatable JSON autogeneration
     * Generate content of table list view
     * @return JSON
     * */
    public function get_json()
    {
        
        $this->load->library('datatable');
        $this->datatable->select('promo_code_id, promo_code_value, promo_code_count, promo_code_max_count, promo_code_updated_date, promo_code_created_date, promo.promo_name, c.customer_firstname as created_by, u.customer_firstname as updated_by');
        $this->datatable->from('promo_code');
        $this->datatable->join('promo', 'promo.promo_id = promo_code.promo_id', 'LEFT');
        $this->datatable->join('customer c', 'promo_code.promo_code_created_by = c.customer_id', 'LEFT');
        $this->datatable->join('customer u', 'promo_code.promo_code_updated_by = u.customer_id', 'LEFT');
        if ($this->input->get('promo'))
        {
            $this->datatable->where('promo_code.promo_id', $this->input->get('promo'));
        }
        
        $array = json_decode($this->datatable->generate(), TRUE);
        foreach ($array['data'] as $key => $value)
        {
            if ($value['promo_code_count'] == 0)
            {
                $array['data'][$key]['actions'] = '<a href="promo_code/update/'.$value['promo_code_id'].'" class="btn btn-xs btn-default green-stripe"><i class="fa fa-pencil"></i> edit</a><a href="promo_code/delete/'.$value['promo_code_id'].'" onclick="return confirm(\'Are you sure you want to delete this record?\');" class="btn btn-xs btn-default red-stripe" ><i class="fa fa-trash-o"></i> delete</a>';
            }
            else
            {
                $array['data'][$key]['actions'] = '<a href="promo_code/update/'.$value['promo_code_id'].'" class="btn btn-xs btn-default green-stripe"><i class="fa fa-pencil"></i> edit</a>';
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
