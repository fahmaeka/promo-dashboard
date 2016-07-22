<?php
class EX_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		
		$this->load->model('login_model');
		$this->load->model('menu_model');
		$this->init_access();
		if(ENVIRONMENT == 'development' && !$this->input->is_ajax_request()) {
            $this->output->enable_profiler(TRUE);
        } else {
            $this->output->enable_profiler(FALSE);
        }
    }
	
	public function init_data()
	{
		$data = array();
		$data['session'] = $this->session->userdata('login');
		$data['menus'] = $this->menu_model->get_menu_by_login_id_type($data['session']['customer_type_id']);
		
		$data['slug'] = $this->get_uri();
		$data['slugs'] = explode("/", $data['slug']);

		return $data;
	}
	
	public function init_access($type = 1)
	{
		$login = $this->session->userdata('login');
		
        if($login['customer_username'] == '')
		{
			$this->session->unset_userdata('login');
            
            if($this->input->is_ajax_request())
            {
                echo ajax_redirect('login');
            }
            else
            {
                redirect(base_url().'login');
            }
        }
		else //validate login access
		{
			$slugs = '';
			
			$slugs = $this->uri->segment(1);
            
			$check_access = $this->login_model->check_login_access($login['customer_type_id'], $slugs);
			
			if(!$check_access && $slugs != 'home' && $slugs != 'profile' && $slugs != 'access_denied' && $type == 1)
			{
				redirect(site_url('home'));
			}
		}
	} 


	public function get_uri() 
	{
		// result uri
		$uri = "";

		// get method name
		$method = $this->router->fetch_method();

		// get uri segment as an array
		$uri_segment = $this->uri->segment_array();

		/*
		* found sign
		* when value on uri_segment same like method name
		* then make this to TRUE
		*/
		$found = false;
		foreach ($uri_segment as $key => $value) 
		{
			/*
			* We want to prevent parameter's is reading
			* so the result only class/method without any parameter's
			*/
			if (!$found) 
			{
				$uri .= $value ."/";	
			}

			// check value is same like method name or not
			if ($value == $method) 
			{
				$found = true;
				break;
			}
		}

		// remove slash from the last string
		if ($uri != NULL || $uri != "") {
			$uri = rtrim($uri, "/");
		}
		
		return $uri;
	}
    
    protected function customer_id()
    {
        $login = $this->session->userdata('login');
        return $login['customer_id'];
    }
    
    protected function customer_type_id()
    {
        $login = $this->session->userdata('login');
        return $login['customer_type_id'];
    }
}
?>