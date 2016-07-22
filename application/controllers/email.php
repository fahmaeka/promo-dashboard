<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends EX_Controller 
{
	public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');

        $this->data['error_message'] = $this->session->flashdata('error_message');
        $this->data['success_message'] = $this->session->flashdata('success_message');
    }

	public function index()
	{
		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'mail.wiryainformatika.com',
		  'smtp_port' => '25',
		  'smtp_user' => 'eka@wiryainformatika.com',
		  'smtp_pass' => 'marimasuk',
		  'mailtype' => 'html',
             'charset' => 'iso-8859-1',
             'wordwrap' => TRUE
		);
		  $this->load->library('email', $config);
		  // $this->email->set_newline(“\r\n”);
		  $this->email->set_newline("rn");
		  $this->email->from('eka@wiryainformatika.com', 'Eka');
		  $this->email->to('fahmaeka@gmail.com');
		  $this->email->subject(' Your Subject here.. ');
		  $this->email->message('Your Message here..');
		  if (!$this->email->send()) {
		    show_error($this->email->print_debugger()); }
		  else {
		    echo 'Your e-mail has been sent!';
		  }
	}

}

/* End of file email.php */
/* Location: ./application/controllers/email.php */