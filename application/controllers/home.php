<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author 
 * @brief this controller is build for booking airlines and return it in xml / json
 */

class Home extends EX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('administrator');
    }
 
    function index()
    {
        $this->load->view('home/index_view');
    }
}
