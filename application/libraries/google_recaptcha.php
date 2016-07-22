<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_recaptcha
{
    function check_captcha($private_key, $remote_ip, $challenge, $response)
    {	
		$CI =& get_instance();
		$CI->load->library('scurl');
        $site = 'http://www.google.com/recaptcha/api/verify';
		$post = 'privatekey='.$private_key.'&remoteip='.$remote_ip.'&challenge='.$challenge.'&response='.$response;
		$referer = '';
		$method = 'POST';
		
		$response = $CI->scurl->scurl($site ,$post ,$referer, $method, '', '');
		$response = explode("\n", $response);
		
		return $response;
    }
}
