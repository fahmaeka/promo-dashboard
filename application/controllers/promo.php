<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author Eka Fahma
 * @brief CRUD for Promo
 */

class Promo extends EX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('promo_model');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    public function index()
    {
        $this->data['output'] = array(
            'js_files' => array(
                'assets/scripts/pages/promo_list.js'
            )
        );

        $this->load->view('promo/list_view', $this->data);
    }

    
    public function get_json()
    {
        $this->load->library('datatable');

        //$check = form_checkbox('data[]', '$1');
        $actions = anchor('promo/update/$1', '<i class="fa fa-pencil"></i> edit', array('class' => 'btn btn-xs btn-default green-stripe'));
        //$actions .= ' ' . anchor('promo/delete/$1', '<i class="fa fa-trash-o"></i> delete', array('class' => 'btn btn-xs btn-default red-stripe', 'onclick' => "return confirm('Are you sure you want to delete this record?');"));

        $this->datatable->select('promo_id, promo_name, promo_created_date, c.customer_firstname, promo_status');
        $this->datatable->from('promo');
        $this->datatable->join('customer c', 'c.customer_id= promo.promo_created_by');
        //$this->datatable->join('promo_payment p', 'p.promo_id= promo.promo_id');
        //$this->datatable->join('pg_payment q', 'q.pg_payment_id = p.pg_payment_id');
        //$this->datatable->join('payment r', 'r.payment_id = q.payment_id');
        //$this->datatable->where('promo_status = 1');
        //$this->datatable->add_column('check', $check, 'promo_id');
        $this->datatable->add_column('actions', $actions, 'promo_id');

        $array = json_decode($this->datatable->generate(), TRUE);
        foreach ($array['data'] as $key => $value)
        {
            if ($value['promo_status'] == 1)
            {
                $array['data'][$key]['promo_status'] = '<span class="label label-success">Enabled</span>';
            }
            else
            {
                $array['data'][$key]['promo_status'] = '<span class="label label-danger">Disabled</span>';
            }
        }

        echo json_encode($array);
    }

    
    public function create()
    {
        if (!$this->input->post())
        {
            $this->data['form_title'] = 'Add New Promo';
            $this->data['form_action'] = site_url('promo/create');
            $this->data['form'] = $this->generate_form();
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_form.js'
                )
            );
            $get = $this->promo_model->get_payment();
            $this->data['check_payment'] = $get;
            $this->load->view('promo/form_view', $this->data);
        }
        else
        {
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_name', 'Promo Name', 'required');
            $this->form_validation->set_rules('pg_payment_id[]', 'Promo Payment', 'required');
            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);
                $check_duplicated = $this->promo_model->check_duplicated($data);
                if ($check_duplicated > 0)
                {
                    echo error_message('There are duplicated data on database.');
                    exit();
                }

                $this->promo_model->insert($data); //save data into database
                $id_promo = $this->promo_model->get_id_promo_page($data);
                    
                foreach ($data['pg_payment_id'] as $pay) 
                {
                    foreach ($id_promo as $p) 
                    {
                        $this->promo_model->insert_payment($p,$pay);
                        $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                        echo ajax_redirect('promo');
                    }
                }
            }
            else
            {
                echo error_message(validation_errors());
            }
        }
    }

    
    public function update($promo_id)
    {
        if (!$this->input->post())
        {
            $promo_data = $this->get_data($promo_id);

            $this->data['form_title'] = 'Edit Promo';
            $this->data['form_action'] = site_url('promo/update/' . $promo_id);
            $this->data['form'] = $this->generate_form($promo_data);
            $this->data['data'] = $promo_data;
            
            $this->data['access'] = $this->promo_model->get_payment_promo_id($promo_id);
            $get_pay = $this->promo_model->get_payment();
            
            $this->data['check_payment'] = $get_pay;
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_form.js'
                )
            );

            $this->load->view('promo/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_name', 'Promo Name', 'required');
            $this->form_validation->set_rules('pg_payment_id[]', 'Promo Payment', 'required');
            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                $check_duplicated = $this->promo_model->check_duplicated($data, $promo_id);
                if ($check_duplicated > 0)
                {
                    echo error_message('There are duplicated data on database.');
                    exit();
                }

                $save = $this->promo_model->update($data);
                if ($save)
                {
                    $this->promo_model->update($data);
                    $this->promo_model->delete_by_promo_id($promo_id);
                    foreach ($data['pg_payment_id'] as $payment_data)
                    {   
                    $this->promo_model->insert_payment_update($promo_id,$payment_data);
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully updated.'));
                    echo ajax_redirect('promo');
                    }
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

    
    public function delete($promo_id)
    {
        $this->get_data($promo_id);

        $check_foreign_payment = $this->promo_model->check_foreign_payment($promo_id);
        if ($check_foreign_payment === TRUE)
        {
            $this->session->set_flashdata('error_message', error_message('Your data cannot be deleted from the database.'));
            redirect('promo');
        }

        $check_foreign_rule = $this->promo_model->check_foreign_rule($promo_id);
        if ($check_foreign_rule === TRUE)
        {
            $this->session->set_flashdata('error_message', error_message('Your data cannot be deleted from the database.'));
            redirect('promo');
        }

        $this->promo_model->delete_by_promo_id($promo_id);
        $delete = $this->promo_model->delete($promo_id);
        if ($delete)
        {
            $this->session->set_flashdata('success_message', success_message('Your data has been successfully deleted from the database.'));
            redirect('promo');
        }
        else
        {
            $this->session->set_flashdata('error_message', error_message('Your data was not deleted from the database.'));
            redirect('promo');
        }
    }

    
    public function get_data($promo_id)
    {
        $promo_data = $this->promo_model->get($promo_id);
        if (!$promo_data)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('promo');
            exit;
        }
        return $promo_data;
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
                    'id' => 'promo_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->promo_id : '',
                ),
                array(
                    'id' => 'promo_name',
                    'label' => 'Promo Name',
                    'value' => (!is_null($data)) ? $data->promo_name : '',
                    'placeholder' => 'Promo Name',
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_status',
                    'type' => 'dropdown',
                    'label' => 'Status',
                    'value' => (!is_null($data)) ? $data->promo_status : '',
                    'options' => array(1 => 'Enabled', 0 => 'Disabled'),
                    'required' => 'true'
                )
            )
        );
        return $output;
    }

}
