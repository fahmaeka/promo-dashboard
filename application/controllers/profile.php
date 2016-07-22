<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author 
 * @brief CRUD for Transaction
 */

class Profile extends EX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('transaction_model');
        // $this->load->model('payment_model');
		// $this->load->model('pg_payment_model');
        // $this->load->model('product_model');
        // $this->load->model('action_model');
		// $this->load->model('doku_model');
		$this->load->model('login_model');
		
		$this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    /**
     * Form Create
     * 
     * @return html
     * */
    public function index()
    {
        $post = $this->input->post();
		
		$session = $this->session->userdata('login');
		
		$dropdown = array();
		if (!$post)
        {
            $datas = $this->login_model->get_customer_by_id($session['customer_id']);
			
			$customer_type = $this->get_customer_type();
			$dropdown['customer_type'] = array(''=> '--Select Customer Type--') + $customer_type;
			
			$list_city = json_encode($this->transaction_model->list_city(''));
			$this->data['form_title'] = 'Edit Profile';
            $this->data['form_action'] = site_url('profile');
			$this->data['form_change_password_action'] = site_url('profile/change_password');
			
            $this->data['form'] = $this->generate_form($dropdown, $datas);
			
			$custom_js = 'jQuery(document).ready(function() {
    var data_b =  '.$list_city.';
    BookingForm.init(data_b);
});

	$("#customer_dob").keydown(function (e) {
	//press delete will erase the dob
	if(e.keyCode == 46 || e.keyCode == 8)
	{
		document.getElementById("customer_dob").value = "";
	}
});';
            $this->data['output'] = array(
				'js_files' => array(
					'assets/scripts/core/jquery.validate.min.js',
					'assets/scripts/custom/booking_form.js',
					'assets/scripts/pages/profile_form.js'
				),
				'custom_js' => $custom_js
			);

            $this->load->view('login/profile_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            //$this->input->is_ajax_request() OR exit('No direct access allowed!');
			// if ($this->form_validation->run() === TRUE) //validate the form
            {
				#region check name length
				$error_pax = "";
				if(strlen($post['customer_firstname']) + strlen($post['customer_lastname']) > 22)
				{
					$error_pax .= 'Total length of contact first name and contact last name must less than 22 characters<br>';
				}
				if(strpos($post['customer_lastname'], " ") !== false)
				{
					$error_pax .= 'Space on contact last name not allowed<br>';
				}
				if(!empty($error_pax))
				{
					echo error_message($error_pax);
					exit;
				}
				#endregion
				
				// echo '<pre>';print_r($post).'</pre>';exit;
				$this->login_model->update_customer_by_id($post, $session['customer_id']);
				
				if(isset($response['error_message']))
				{
					echo error_message($response['error_message']);
					exit;
				}
				else
				{
					// echo 'sukses';print_r($response);
					$this->session->set_flashdata('success_message', success_message('Your profile has been successfully updated.'));
                    echo ajax_redirect('profile');
				}
			}
			// else
            // {
                // echo error_message(validation_errors());
            // }
			// exit;
			
			
			
            // $this->form_validation->set_rules('customer_username', 'Username', 'required');
            // $this->form_validation->set_rules('customer_password', 'Password', 'required|min_length[7]');
            // $this->form_validation->set_rules('customer_email', 'Email', 'required|valid_email');

            // if ($this->form_validation->run() === TRUE) //validate the form
            // {
                // $data = $this->input->post(NULL, TRUE);

                
            // }
            // else
            // {
                // echo error_message(validation_errors());
            // }
        }
    }
	
	/*
	*	Change Password 
	*/
	public function change_password()
    {
        $post = $this->input->post();
		
		$session = $this->session->userdata('login');
		
		$dropdown = array();
		if ($post)
        {
			$post['customer_id'] = $session['customer_id'];
            //only ajax request are allowed
            //$this->input->is_ajax_request() OR exit('No direct access allowed!');
			// if ($this->form_validation->run() === TRUE) //validate the form
            {
				#region check name length
				$error_pax = "";
				if($post['new_password'] != $post['confirm_password'])
				{
					$error_pax .= 'New Password must be match with Confirm Password<br>';
				}
				if(!empty($error_pax))
				{
					echo error_message($error_pax);
					exit;
				}
				#endregion
				
				// echo '<pre>';print_r($post).'</pre>';exit;
				$this->login_model->update_change_password($post, $session['customer_id']);
				
				if(isset($response['error_message']))
				{
					echo error_message($response['error_message']);
					exit;
				}
				else
				{
					// echo 'sukses';print_r($response);
					$this->session->set_flashdata('success_message', success_message('Your profile has been successfully updated.'));
                    echo ajax_redirect('profile');
				}
			}
        }
    }
	
	/*
	*	Check Password
	*/
    public function check_password()
	{
		$post = $this->input->post();
		
		if ($post)
        {
			$this->input->is_ajax_request() OR exit('No direct access allowed!');
			
			$session = $this->session->userdata('login');
			
			$data = $this->login_model->get_customer_by_id($session['customer_id']);
			
			if(count($data) > 0)
			{
				if($data['customer_password'] == md5($post['old_password']))
				{
					echo 'true';
				}
				else
				{
					echo 'false';
				}
			}
			else
			{
				echo 'false';
			}
			
		}
	}
	
    
    /**
     * Bootstrap Form Builder
     *
     * @return html
     * */
    public function generate_form($dropdown = NULL, $data = NULL)
    {
        $this->load->library('form_builder');
		$login_session = $this->session->userdata('login');

        $output = $this->form_builder->build_form_horizontal(
            array(
                array(
                    'id' => 'customer_type_id',
                    'type' => 'dropdown',
                    'label' => 'Customer Type',
                    'value' => $data['customer_type_id'],
                    'options' => $dropdown['customer_type'],
					'disabled'	=> true,
                    'required' => 'true'
                ),
                
				array(
                    'id' => 'customer_username',
                    'label' => 'Username',
                    'class' => 'only_letter',
                    'required' => 'true',
					'readonly'	=>	'true',
					'maxlength' => 20,
					/*'minlength' => 5,*/
					'value'		=> $data['customer_username']
                ),
				/* array(
                    'id' => 'customer_password',
                    'label' => 'Password',
					'type'	=>	'password',
					'title' => 'Please fill if you want to change password. Or leave empty if don\'t.',
					'maxlength' => 20,
					'minlength' => 5,
                ), */
				array(
                    'id' => 'customer_title',
                    'type' => 'dropdown',
                    'label' => 'Title',
                    'value' => $data['customer_title'],
                    'options' => $this->transaction_model->title_dropdown(),
                    'required' => 'true'
                ),
				array(
                    'id' => 'customer_gender',
                    'type' => 'dropdown',
                    'label' => 'Gender',
					'value' => $data['customer_gender'],
                    'options' => array("M" => "Male", "F" => "Female"),
                    'required' => 'true'
                ),
                array(
                    'id' => 'customer_firstname',
                    'label' => 'First Name',
                    'placeholder' => 'First Name',
                    'class' => 'only_letter',
                    'required' => 'true',
					'maxlength' => 20, 
					/*'minlength' => 2, */
					'value'		=> $data['customer_firstname']
                ),
                array(
                    'id' => 'customer_lastname',
                    'label' => 'Last Name',
                    'placeholder' => 'Last Name',
                    'class' => 'only_letter',
					'value'		=> $data['customer_lastname'],
					/* 'minlength' => 2, */
					'maxlength' => 20
                ),
				array(
                    'id' => 'customer_dob',
                    'label' => 'Date Of Birth',
					'value'	=> $data['customer_dob'] == '0000-00-00' ? '' : $data['customer_dob'],
					'class'	=> 'adult_dob_picker',
					'title'	=> 'Your date of birth. Press \'delete\' or \'backspace\' to erase.',
					'readonly' => true
                ),
				array(
                    'id' => 'customer_address',
                    'label' => 'Address',
                    'type' => 'textarea',
					'value'		=> $data['customer_address'],
                ),
                array(
                    'id' => 'customer_phone',
                    'label' => 'Contact Phone',
                    'placeholder' => 'Contact Phone',
                    'class' => 'only_number',
					'value'	=>	$data['customer_phone'],
					'maxlength' => 20
                ),
                array(
                    'id' => 'customer_email',
                    'label' => 'Email',
                    'placeholder' => 'Email',
                    'required' => 'true',
					'email'		=> 'true',
					'maxlength' => 100,
					'value'		=> $data['customer_email']
                )
            )
        );
        return $output;
    }
	
	private function get_customer_type()
	{
		$result = $this->login_model->get_customer_type_by_id();
		$type = array();
		foreach($result as $cg)
		{
			$type[ $cg['customer_type_id'] ] = $cg['customer_type_name'];
		}
		return $type;
	}
    
}
