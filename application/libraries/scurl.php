<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Scurl
{
    function scurl($parameter = array())
    {
        /*
            parameter array structure :
            $parameter['site']
            $parameter['post']
            $parameter['referer']
            $parameter['method']
            $parameter['cookie_file']
            $parameter['proxy']['proxy_port']
            $parameter['proxy']['proxy_ipaddress']
            $parameter['proxy']['username']
            $parameter['proxy']['password']
            $parameter['header']
            $parameter['http_header']
            $parameter['user_agent']
            $parameter['timeout']
        */
        
        //for return curl result
        $result = '';
        
        if(empty($parameter['user_agent']))
        {
            //setup default user agent
            $parameter['user_agent'] = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.10) Gecko/20100914';
        }
        
        if(!isset($parameter['referer']))
        {
            $parameter['referer'] = '';
        }
        if(!isset($parameter['site']))
        {
            $parameter['site'] = '';
        }
        if(!isset($parameter['post']))
        {
            $parameter['post'] = '';
        }
        
        $curl_handle = curl_init();
        
        if(isset($parameter['cookie_file']))
        {
            if($parameter['cookie_file'] != '')
            {
                if(!file_exists($parameter['cookie_file']))
                {
                    $fh = fopen($parameter['cookie_file'], "w");
                    fwrite($fh, "");
                    fclose($fh);
                }
            }
            
            curl_setopt($curl_handle, CURLOPT_COOKIEJAR, $parameter['cookie_file']);
            curl_setopt($curl_handle, CURLOPT_COOKIEFILE, $parameter['cookie_file']);
        }
        
        curl_setopt($curl_handle, CURLOPT_USERAGENT, $parameter['user_agent']);
        curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_handle, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl_handle, CURLOPT_REFERER, $parameter['referer']);
        curl_setopt($curl_handle, CURLOPT_URL, $parameter['site']);
        
        if(isset($parameter['method']))
        {
            if($parameter['method'] == 'POST')
            {
                curl_setopt($curl_handle, CURLOPT_POST,TRUE);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $parameter['post']);
            }
            else if($parameter['method'] == 'GET')
            {
                curl_setopt($curl_handle, CURLOPT_HTTPGET,TRUE);
            }
        }
        
        if(isset($parameter['header']))
        {
			curl_setopt($curl_handle, CURLOPT_HEADER, $parameter['header']);
        }
        
        //setup http header
        if(isset($parameter['http_header']))
        {
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $parameter['http_header']);
        }
        
        if(isset($parameter['timeout']))
        {
            curl_setopt($curl_handle, CURLOPT_TIMEOUT, $parameter['timeout']);
        }

        if(isset($parameter['proxy']))
        {
            if(isset($parameter['proxy']['proxy_ipaddress']))
            {
                curl_setopt($curl_handle, CURLOPT_PROXY, $parameter['proxy']['proxy_ipaddress']);
            }
            
            if(isset($parameter['proxy']['proxy_port']))
            {
                curl_setopt($curl_handle, CURLOPT_PROXYPORT, $parameter['proxy']['proxy_port']);
            }
            
            if(isset($parameter['proxy']['proxy_username']) && isset($parameter['proxy']['proxy_password']))
            {
                curl_setopt($curl_handle, CURLOPT_PROXYUSERPWD, $parameter['proxy']['proxy_username'].':'.$parameter['proxy']['proxy_password']);
            }
        }
        
        $result = curl_exec($curl_handle);
        
        curl_close($curl_handle);
        
        return $result;
    }
}
?>
