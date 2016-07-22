<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author Eka Fahma
 * @brief CRUD for Payment Discount
 */

class Promo_rule extends EX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('promo_rule_model');
        $this->load->model('promo_model');
        $this->load->model('rule_model');
        $this->load->model('range_model');
        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    /**
     * List page
     * Generate table list view of Payment Discount
     * @return html
     * */
    public function index()
    {
        $this->data['output'] = array(
            'js_files' => array(
                'assets/scripts/pages/promo_rule_list.js'
            )
        );

        $this->load->view('promo_rule/list_view', $this->data);
    }

    /**
     * Datatable JSON autogeneration
     * Generate content of table list view
     * @return JSON
     * */
    public function get_json()
    {
        $this->load->library('datatable');

        $check = form_checkbox('data[]', '$1');
        $actions = anchor('promo_rule/update/$1', '<i class="fa fa-pencil"></i> edit', array('class' => 'btn btn-xs btn-default green-stripe'));
        $actions .= ' ' . anchor('promo_rule/delete/$1', '<i class="fa fa-trash-o"></i> delete', array('class' => 'btn btn-xs btn-default red-stripe', 'onclick' => "return confirm('Are you sure you want to delete this record?');"));

        $this->datatable->select('promo_rule_id,d.promo_name, promo_rule_created_date, c.customer_firstname, promo_rule_status,d.promo_id,rule_id');
        $this->datatable->from('promo_rule');
        $this->datatable->join('promo d', 'd.promo_id= promo_rule.promo_id');
        $this->datatable->join('customer c', 'c.customer_id= promo_rule.promo_rule_created_by');
        $this->datatable->where('promo_status = 1');
        $this->datatable->add_column('check', $check, 'promo_rule_id');
        $this->datatable->add_column('actions', $actions, 'promo_rule_id');

        $array = json_decode($this->datatable->generate(), TRUE);
        foreach ($array['data'] as $key => $value)
        {
            if ($value['promo_rule_status'] == 1)
            {
                $array['data'][$key]['promo_rule_status'] = '<span class="label label-success">Active</span>';
            }
            else
            {
                $array['data'][$key]['promo_rule_status'] = '<span class="label label-danger">Inactive</span>';
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
            $this->data['form_title'] = 'Add New Promo Rule';
            $this->data['form_action'] = site_url('promo_rule/create');
            $this->data['form'] = $this->generate_form();
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_rule_form.js'
                )
            );

            $this->load->view('promo_rule/form_view', $this->data);
        }
        else
        {
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_id', 'Promo', 'required');
            $this->form_validation->set_rules('rule_id', 'Rule', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $data = $this->input->post(NULL, TRUE);

                if (isset($data['range_id']))
                {
                    $err_msg = '';
                    $err_empty_count = 0;
                    $err_int_count = 0;
                    for ($a = 1; $a < count($data['range_id']); $a++)
                    {
                        if ($data['range_id'][$a] == '' || 
                            $data['promo_rule_detail_fixed_value'][$a] == '' || 
                            $data['promo_rule_detail_max_value'][$a] == '' ||
                            $data['promo_rule_detail_percent'][$a] == '')
                        {
                            $err_msg .= '- There is an empty column on Detail line '.$a.'<br>';
                            $err_empty_count += 1;
                        }

                        if ($data['promo_rule_detail_fixed_value'][$a] < 0 || 
                            $data['promo_rule_detail_max_value'][$a] < 0 ||
                            $data['promo_rule_detail_percent'][$a] < 0)
                        {
                            $err_msg .= '- There is an invalid digits on Detail line '.$a.'<br>';
                            $err_int_count += 1;
                        }
                        
                    }

                    if ($err_empty_count > 0 || $err_int_count > 0)
                    {
                        echo error_message($err_msg);
                        exit();
                    }
                }

                $save = $this->promo_rule_model->insert($data);
                           
                if (isset($data['range_id']))
                {
                    $detail_data_array = array();
                       for ($a = 1; $a < count($data['range_id']); $a++)
                       {
                           if ( !empty($data['range_id'][$a]))
                           {
                               $detail_data_array[] = array(
                                   'promo_rule_id' => $save,
                                   'promo_rule_detail_fixed_value' => $data['promo_rule_detail_fixed_value'][$a],
                                   'promo_rule_detail_max_value' => $data['promo_rule_detail_max_value'][$a],
                                   'promo_rule_detail_percent' => $data['promo_rule_detail_percent'][$a],
                                   'range_id' => $data['range_id'][$a]
                               );
                           }
                       }

                    $detail_data_array_merge = array_map('unserialize', array_unique(array_map('serialize', $detail_data_array)));
                    foreach ($detail_data_array_merge as $detail_data)
                    {   
                        $check_duplicated_insert = $this->promo_rule_model->check_duplicated($data,$detail_data);
                        if ($check_duplicated_insert > 0)
                        {
                            $this->promo_rule_model->delete_insert_duplicated($detail_data);
                            $this->promo_rule_model->delete_after_duplicated($detail_data);
                            echo error_message('There are duplicated data on database.');
                            exit();
                        }

                        $check_duplicated = $this->promo_rule_model->check_promo_range($detail_data);
                        if ($check_duplicated > 0)
                        {
                            $this->promo_rule_model->delete_insert_duplicated($detail_data);
                            $this->promo_rule_model->delete_after_duplicated($detail_data);
                            echo error_message('There are duplicated data on database.');
                            exit();
                        }
                                
                        $this->promo_rule_model->insert_rule_detail($detail_data);
                    }

                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully stored into the database.'));
                    echo ajax_redirect('promo_rule');
                            
                    }
                

            }
            else
            {
                echo error_message(validation_errors());
            }
        }
    }

    
    public function update($promo_rule_id)
    {
        if (!$this->input->post())
        {
            $promo_rule_data = $this->get_data($promo_rule_id);
            

            $this->data['form_title'] = 'Edit Promo Rule';
            $this->data['form_action'] = site_url('promo_rule/update/' . $promo_rule_id);
            $this->data['form'] = $this->generate_form($promo_rule_data);
           
            $this->data['data'] = $promo_rule_data;
            
            $this->data['details'] = $this->promo_rule_model->get_by_promo_rule($promo_rule_id); 
            
            
            
            $this->data['output'] = array(
                'js_files' => array(
                    'assets/scripts/pages/promo_rule_form.js'
                )
            );

            $this->load->view('promo_rule/form_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('promo_id', 'Promo', 'required');
            $this->form_validation->set_rules('rule_id', 'Rule', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                
                $data = $this->input->post(NULL, TRUE);
                
                if (isset($data['range_id']))
                {
                    $err_msg = '';
                    $err_empty_count = 0;
                    $err_int_count = 0;
                    for ($a = 1; $a < count($data['range_id']); $a++)
                    {
                        if ($data['range_id'][$a] == '' || 
                            $data['promo_rule_detail_fixed_value'][$a] == '' || 
                            $data['promo_rule_detail_max_value'][$a] == '' ||
                            $data['promo_rule_detail_percent'][$a] == '')
                        {
                            $err_msg .= '- There is an empty column on Detail line '.$a.'<br>';
                            $err_empty_count += 1;
                        }

                        if ($data['promo_rule_detail_fixed_value'][$a] < 0 || 
                            $data['promo_rule_detail_max_value'][$a] < 0 ||
                            $data['promo_rule_detail_percent'][$a] < 0)
                        {
                            $err_msg .= '- There is an invalid digits on Detail line '.$a.'<br>';
                            $err_int_count += 1;
                        }
                        
                    }

                    if ($err_empty_count > 0 || $err_int_count > 0)
                    {
                        echo error_message($err_msg);
                        exit();
                    }
                }

                $save = $this->promo_rule_model->update($data);

                
                
                if (isset($data['range_id']))
                    {
                        $detail_data_array = array();
                        for ($a = 1; $a < count($data['range_id']); $a++)
                        {
                            if ( !empty($data['range_id'][$a]))
                            {
                                $detail_data_array[] = array(
                                    'promo_rule_id' => $data['promo_rule_id'],
                                    'promo_rule_detail_fixed_value' => $data['promo_rule_detail_fixed_value'][$a],
                                    'promo_rule_detail_max_value' => $data['promo_rule_detail_max_value'][$a],
                                    'promo_rule_detail_percent' => $data['promo_rule_detail_percent'][$a],
                                    'range_id' => $data['range_id'][$a]
                                );
                            }
                        }
                        $this->promo_rule_model->delete_by_promo_rule($data['promo_rule_id']);
                        $detail_data_array_merge = array_map('unserialize', array_unique(array_map('serialize', $detail_data_array)));
                        foreach ($detail_data_array_merge as $detail_data)
                        {
                            $check_duplicated = $this->promo_rule_model->check_promo_range($detail_data);
                            if ($check_duplicated > 0)
                            {
                                echo error_message('There are duplicated data on database.');
                                exit();
                            }
                            
                            $check_duplicated_insert = $this->promo_rule_model->check_duplicated($data,$detail_data);
                            if ($check_duplicated_insert > 0)
                            {
                                //$this->promo_rule_model->delete_insert_duplicated($detail_data);
                                //$this->promo_rule_model->delete_after_duplicated($detail_data);
                                echo error_message('There are duplicated data on database.');
                                exit();
                            }

                            $this->promo_rule_model->insert_rule_detail($detail_data);
                        }
                    }

                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully updated.'));
                    echo ajax_redirect('promo_rule');
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
    public function delete($promo_rule_id)
    {
        $data_rule = $this->promo_rule_model->get_id_rule_delete($promo_rule_id);
        foreach ($data_rule as $p) 
          {
                $this->promo_rule_model->delete_by_promo_rule($p);
                $delete = $this->promo_rule_model->delete($p);
                if ($delete)
                {
                    $this->session->set_flashdata('success_message', success_message('Your data has been successfully deleted from the database.'));
                    redirect('promo_rule');
                }
                else
                {
                    $this->session->set_flashdata('error_message', error_message('Your data was not deleted from the database.'));
                    redirect('promo_rule');
                }
          }
    }

    /**
     * Get Data
     *
     * @return Object
     * */
    public function get_data($promo_rule_id)
    {
        $promo_rule_data = $this->promo_rule_model->get($promo_rule_id);
        if (!$promo_rule_data)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('promo_rule');
            exit;
        }
        return $promo_rule_data;
    }

    public function get_data_rule($p)
    {
        $promo_rule_data = $this->promo_rule_model->getrule($p);
        if (!$promo_rule_data_rule)
        {
            $this->session->set_flashdata('error_message', error_message('Data not found.'));
            redirect('promo_rule');
            exit;
        }
        return $promo_rule_data_rule;
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
                    'id' => 'promo_rule_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->promo_rule_id : '',
                ),
                array(
                    'id' => 'promo_rule_detail_id',
                    'type' => 'hidden',
                    'value' => (!is_null($data)) ? $data->promo_rule_id : '',
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
                    'id' => 'rule_id',
                    'type' => 'dropdown',
                    'label' => 'Promo Rule',
                    'value' => (!is_null($data)) ? $data->rule_id : '',
                    'options' => $this->rule_model->dropdown(),
                    'required' => 'true'
                ),
                array(
                    'id' => 'promo_rule_status',
                    'type' => 'dropdown',
                    'label' => 'Status',
                    'value' => (!is_null($data)) ? $data->promo_rule_status : '',
                    'options' => array(0 => 'Inactive', 1 => 'Active'),
                    'required' => 'true'
                )
            )
        );
        return $output;
    }

}
