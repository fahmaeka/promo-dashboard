<?php defined('BASEPATH') OR exit('No direct script access allowed ! ');
/*
 * @author
 * @brief Login page
 */

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('login_model');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

    /**
     * Login page
     * @return html
     * */
    public function index()
    {
        header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        if (!$this->input->post())
        {
            if ($this->session->userdata('logged'))
            {
                redirect('/', 'refresh');
            }

            $this->load->view('login/login_view', $this->data);
        }
        else
        {
            //only ajax request are allowed
            $this->input->is_ajax_request() OR exit('No direct access allowed!');
            $this->form_validation->set_rules('login_username', 'Username', 'required');
            $this->form_validation->set_rules('login_password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) //validate the form
            {
                $username = $this->input->post('login_username', TRUE);
                $password = $this->input->post('login_password', TRUE);
                //check to see if the user is logging in
                if ($this->login_model->login($username, $password))
                {
                    //if the login is successful redirect to dashboard
                    echo ajax_redirect('/');
                }
                else
                {
                    //if the login was un-successful
                    echo $this->session->flashdata('error_message');
                }
            }
            else
            {
                echo validation_errors();
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->set_flashdata('success_message', success_message('Logged out successfully.'));

        redirect('login');
    }

}
