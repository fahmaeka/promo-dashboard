<?php

/*
 * 
 * @author fandi, prasetya, ricardo
 * 
 * this library contain function for general purpose
 * 
 */
class Functions
{
    function send_mail($username, $password, $subject, $to , $cc, $bcc, $content, $HTML, $SMTPSecure, $from = '', $from_name = '', $host = '', $port = '', $attachment = array())
    {
        $CI =& get_instance();
        $CI->load->library('phpmailer');
        $CI->phpmailer->IsSMTP();
        $CI->phpmailer->SMTPDebug = 1;
        $CI->phpmailer->SMTPAuth = true;
        $CI->phpmailer->SMTPSecure = $SMTPSecure;

        if($host == '')
        {
            $host = 'smtp.mandrillapp.com';
        }

        if($port == '')
        {
            $port = '465';
        }
		
        $CI->phpmailer->Host = $host;
        $CI->phpmailer->Port = $port; 
        
        if($username == '')
        {
            $username = DEFAULT_MAIL_USERNAME;
        }
        $CI->phpmailer->Username = $username;  
		
        if($password == '')
        {
            $password = DEFAULT_MAIL_PASSWORD;
        }
        $CI->phpmailer->Password = $password;
		
        if($from == '')
        {
            $from = 'no-reply@ezytravel.co.id';
        }

        if($from_name == '')
        {
            $from_name = 'Ezytravel.co.id';
        }
		
        $CI->phpmailer->From = $from;
        $CI->phpmailer->FromName = $from_name;
        $CI->phpmailer->ClearAddresses();

        foreach($attachment as $at)
        {
            $CI->phpmailer->AddAttachment($at); //attachment with url
        }
		
        if($to != '')
        {
            foreach($to as $a)
            {
                $CI->phpmailer->AddAddress($a['email'], $a['name']);
            }
        }

        if($cc != '')
        {
            foreach($cc as $a)
            {
                $CI->phpmailer->AddCC($a['email'], $a['name']);
            }    
        }

        if($bcc != '')
        {
            foreach($bcc as $a)
            {
                $CI->phpmailer->AddBCC($a['email'], $a['name']);
            }  
        }

        $CI->phpmailer->IsHTML($HTML);
        $CI->phpmailer->Subject = $subject;
        $CI->phpmailer->Body = $content;
        
        if($CI->phpmailer->Send()) 
        {
            $result['status'] = TRUE;
            $result['message'] = 'Success';
        }
        else
        {
            $result['status'] = FALSE;
            $result['message'] = $CI->phpmailer->ErrorInfo;
        }
        
        return $result;
    }
	
    /******* END OF LOG_FILE *******/
    function build_slug($slug)
    {
        /*
         * @param : $slug (bad URL)
         * return $slug (already rebuild, remove get only alpha numeric and replacing other string with -)
         */
        $slug = strtolower($slug);
        $slug = ltrim($slug);
        $slug = rtrim($slug);
        $slug = preg_replace("/[^a-zA-Z0-9]+/i","-",$slug);
        
        return $slug;
    }
    /******* END OF BUILD_SLUG *******/
    

    /******* END OF GET_TIMEZONE *******/
    
    function convert_datetime($timestamp, $day_format = '', $month_format = '', $year_format = '', $lang, $date_only = TRUE)
    {
        /* 
         * @param : $timestamp unix_timestamp
         * @param : $day_format (l, L) support only long month (L) Senin, short month (l) Sen
         * @param : $month_format (l, L) support only long month (L) Januari, short month (l) Jan
         * @param : $lang (support ID only)
         * return $datetime formatted datetime  
         * 
         * further development will have format based on request, multiple lang 
         */
		
    	 /* format date */
    	$day = date( "d",$timestamp);      // day
    	$month = date( "n",$timestamp);      // month
        $day_in_week =date( "w",$timestamp); //day in week
    	$year = date( "Y",$timestamp);      // year
    	$hour = date( "H",$timestamp);         // hour
    	$minute = date( "i",$timestamp);     // minute
        $seconds = date( "s",$timestamp);     // second
        
        if($lang == 'ID')
        {            
            /* day long format */
            $day_long[0] = "Minggu";
            $day_long[1] = "Senin";
            $day_long[2] = "Selasa";
            $day_long[3] = "Rabu";
            $day_long[4] = "Kamis";
            $day_long[5] = "Jumat";
            $day_long[6] = "Sabtu";
            
             /* day short format */
            $day_short[0] = "Mgg";
            $day_short[1] = "Sen";
            $day_short[2] = "Sel";
            $day_short[3] = "Rab";
            $day_short[4] = "Kam";
            $day_short[5] = "Jum";
            $day_short[6] = "Sab";
            
            
             /* month long format */
            $month_long[1] = "Januari";
            $month_long[2] = "Februari";
            $month_long[3] = "Maret";
            $month_long[4] = "April";
            $month_long[5] = "Mei";
            $month_long[6] = "Juni";
            $month_long[7] = "Juli";
            $month_long[8] = "Agustus";
            $month_long[9] = "September";
            $month_long[10] = "Oktober";
            $month_long[11] = "November";
            $month_long[12] = "Desember";
            
             /* month short  format */
            $month_short[1] = "Jan";
            $month_short[2] = "Feb";
            $month_short[3] = "Mar";
            $month_short[4] = "Apr";
            $month_short[5] = "Mei";
            $month_short[6] = "Jun";
            $month_short[7] = "Jul";
            $month_short[8] = "Agu";
            $month_short[9] = "Sep";
            $month_short[10] = "Okt";
            $month_short[11] = "Nov";
            $month_short[12] = "Des";        
        }
        else if($lang == 'EN') //additional function for email EN version
        {
            #region EN
			/* day long format */
            $day_long[0] = "Sunday";
            $day_long[1] = "Monday";
            $day_long[2] = "Tuesday";
            $day_long[3] = "Wednesday";
            $day_long[4] = "Thursday";
            $day_long[5] = "Friday";
            $day_long[6] = "Saturday";
            
             /* day short format */
            $day_short[0] = "Sun";
            $day_short[1] = "Mon";
            $day_short[2] = "Tue";
            $day_short[3] = "Wed";
            $day_short[4] = "Thu";
            $day_short[5] = "Fri";
            $day_short[6] = "Sat";
            
            
             /* month long format */
            $month_long[1] = "January";
            $month_long[2] = "February";
            $month_long[3] = "March";
            $month_long[4] = "April";
            $month_long[5] = "May";
            $month_long[6] = "June";
            $month_long[7] = "July";
            $month_long[8] = "August";
            $month_long[9] = "September";
            $month_long[10] = "October";
            $month_long[11] = "November";
            $month_long[12] = "December";
            
             /* month short  format */
            $month_short[1] = "Jan";
            $month_short[2] = "Feb";
            $month_short[3] = "Mar";
            $month_short[4] = "Apr";
            $month_short[5] = "May";
            $month_short[6] = "Jun";
            $month_short[7] = "Jul";
            $month_short[8] = "Aug";
            $month_short[9] = "Sep";
            $month_short[10] = "Oct";
            $month_short[11] = "Nov";
            $month_short[12] = "Dec";
			#endregion
        }
        
         /* Format day */
    	switch ($day_format)
        {
    	    case  "l":
    	    $day = $day_long[$day_in_week]. ', '.$day;                 // Senin, 23
    	    break;
    	    case  "s":
    	    $day = $day_short[$day_in_week]. ', '.$day;                 // Sen, 23
    	    break;
    	    case  "sl":
    	    $day = $day_long[$day_in_week];                 // Sen, 23
    	    break;
            
    	}
        
        /* Format month */
    	switch ($month_format) {
    	    case  "l":
    	    $month =  ' '.$month_long[$month];              // Januari
    	    break;
    	    case  "s":
    	    $month =  ' '.$month_short[$month];              // Jan
    	    break;
    	    case  "":
    	    $month =  '';              // Jan
    	    break;
    	}
        
        $datetime = $day.' '.$month;
        
        /* Format year */
        switch ($year_format)
        {
            case  "": $year = '';              // empty
                      break;
            case  "l": $year = $year;              // 2014
                        break;
        }
        
        if($date_only)
        {
            $datetime = $day.' '.$month.' '.$year;
        }
        else
        {
            $datetime = $day.' '.$month.' '.$year.' '.$hour.':'.$minute.':'.$seconds;
        }
		
        return $datetime;
    }
	
    function month_name($month_number, $type, $lang)
    {
        $month_number = (int)$month_number;
        //s for short
        //l for long
        if($lang == 'ID')
        {            
             /* month long format */
            $month_long[1] = "Januari";
            $month_long[2] = "Februari";
            $month_long[3] = "Maret";
            $month_long[4] = "April";
            $month_long[5] = "Mei";
            $month_long[6] = "Juni";
            $month_long[7] = "Juli";
            $month_long[8] = "Agustus";
            $month_long[9] = "September";
            $month_long[10] = "Oktober";
            $month_long[11] = "November";
            $month_long[12] = "Desember";
            
             /* month short  format */
            $month_short[1] = "Jan";
            $month_short[2] = "Feb";
            $month_short[3] = "Mar";
            $month_short[4] = "Apr";
            $month_short[5] = "Mei";
            $month_short[6] = "Jun";
            $month_short[7] = "Jul";
            $month_short[8] = "Agu";
            $month_short[9] = "Sep";
            $month_short[10] = "Okt";
            $month_short[11] = "Nov";
            $month_short[12] = "Des";        
        }
        else if($lang == 'EN') //additional function for email EN version
        {
             /* month long format */
            $month_long[1] = "January";
            $month_long[2] = "February";
            $month_long[3] = "March";
            $month_long[4] = "April";
            $month_long[5] = "May";
            $month_long[6] = "June";
            $month_long[7] = "July";
            $month_long[8] = "August";
            $month_long[9] = "September";
            $month_long[10] = "October";
            $month_long[11] = "November";
            $month_long[12] = "December";
            
             /* month short  format */
            $month_short[1] = "Jan";
            $month_short[2] = "Feb";
            $month_short[3] = "Mar";
            $month_short[4] = "Apr";
            $month_short[5] = "May";
            $month_short[6] = "Jun";
            $month_short[7] = "Jul";
            $month_short[8] = "Aug";
            $month_short[9] = "Sep";
            $month_short[10] = "Oct";
            $month_short[11] = "Nov";
            $month_short[12] = "Dec";
			#endregion
        }
		
        if($type == 's')
        {
            $month_name = $month_short[$month_number];
        }
        elseif($type == 'l')
        {
            $month_name = $month_long[$month_number];
        }
		
        return $month_name;
    }
	
    function datetime_diff($datetime_1, $datetime_2, $timezone_1, $timezone_2)
    {
        //netralize timezone
        $time_difference = ($timezone_1 - $timezone_2) * 3600;
        $datetime_1 = strtotime($datetime_1) - $time_difference;
        $datetime_2 = strtotime($datetime_2);
        $diff = abs($datetime_1 - $datetime_2); 

        $years   = floor($diff / (365*60*60*24)); 
        $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
        $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60)); 

        $result['years'] = $years;
        $result['months'] = $months;
        $result['days'] = $days;
        $result['hours'] = $hours;
        $result['minutes'] = $minutes;
        $result['total_minutes'] = $diff/60;
        $result['seconds'] = $seconds;

        return $result;
    }
    
    function time_trip($dep_time, $arr_time, $dep_timezone, $arr_timezone)
    {
        //convert into seconds
        $time_difference = ($dep_timezone - $arr_timezone) * 3600;
		
        //make all timezone the same by adding time difference
        $dep_time_netral = strtotime($dep_time) - $time_difference;

        $dep_time_netral = date('H:i', $dep_time_netral);
		
        //check if trip passing days to tomorrow or not
        if($arr_time < $dep_time_netral)
        {
            //for differ to midnight
            $netral_time_1 = strtotime('24:00:00');
            //for differ from start day
            $netral_time_2 = strtotime('00:00:00');
            $time_trip_seconds = ($netral_time_1 - strtotime($dep_time_netral)) + (strtotime($arr_time) - $netral_time_2);
        }
        else
        {
            $time_trip_seconds = (strtotime($arr_time) - strtotime($dep_time_netral));
        }
        
        $time_trip['hours'] = floor($time_trip_seconds / 3600);
        $time_trip['minutes'] = floor(($time_trip_seconds / 60)) - ($time_trip['hours'] * 60);
        $time_trip['total_minutes'] = floor($time_trip_seconds / 60);
        $time_trip['seconds'] = $time_trip_seconds - ($time_trip['hours'] * 3600) - ($time_trip['minutes'] * 60);
        $time_trip['total_seconds'] = $time_trip_seconds;
        
        return $time_trip;
    }

    /*
    * get hours by subtract datetime
    * @param $date_time_one DateTime
    * @param $date_time_two DateTime
    * @param diff_segment int, diff segment from parameter (1 or 2)
    *
    * @return array
    */
    public function get_diff_hours($date_time_one, $date_time_two, $diff_segment = 1)
    {
        if ($diff_segment == 1) {
            $date_time_diff = $date_time_one->diff($date_time_two);
        } else {
            $date_time_diff = $date_time_two->diff($date_time_one);
        }

        $hour = $date_time_diff->format('%H'); // 24-hour format of an hour with leading zeros
        $minute = $date_time_diff->format('%i'); // Minutes with leading zeros
        $seconds = $date_time_diff->format('%s'); // Seconds, numeric (1, 3, 57)

        return array(
            'hour' => ltrim($hour, '0'), 
            'minute' => $minute,
            'seconds' => $seconds
            );
    }

    /*
    * get hours by subtract datetime
    * @param $date_time_one DateTime
    * @param $date_time_two DateTime
    * @param diff_segment int, diff segment from parameter (1 or 2)
    *
    * @return int
    */
    public function get_diff_days($date_time_one, $date_time_two, $diff_segment = 1)
    {
        if ($diff_segment == 1) {
            $date_time_diff = $date_time_one->diff($date_time_two);
        } else {
            $date_time_diff = $date_time_two->diff($date_time_one);
        }

        $day = $date_time_diff->format('%d'); // Day of the month, 2 digits with leading zeros
        return $day;
    }
    
    /******* END OF TIME_TRIP *******/
    
    function remove_noise($html = '')
    {
        /*
         * removing javascript, tag html comment, space, tab, enter
         * 
         * @return $html : string (new html)
         */
        $html = preg_replace('|<!--(.*?)-->|', '', $html);
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $html = str_replace($newlines, "", $html);

        return $html;
    }
    
    function time_duration($seconds = '', $use = null, $zeros = false)
    {
        // Define time periods
        $periods = array (
            'years'     => 31556926,
            'Months'    => 2629743,
            'weeks'     => 604800,
            'days'      => 86400,
            'hours'     => 3600,
            'minutes'   => 60,
            'seconds'   => 1
            );

        // Break into periods
        $seconds = (float) $seconds;
        $segments = array();
        foreach ($periods as $period => $value) {
            if ($use && strpos($use, $period[0]) === false) {
                continue;
            }
            $count = floor($seconds / $value);
            if ($count == 0 && !$zeros) {
                continue;
            }
            $segments[strtolower($period)] = $count;
            $seconds = $seconds % $value;
        }

        // Build the string
        $string = array();
        foreach ($segments as $key => $value) {
            $segment_name = substr($key, 0, -1);
            $segment = $value . ' ' . $segment_name;
            if ($value != 1) {
                $segment .= 's';
            }
            $string[] = $segment;
        }

        return implode(', ', $string);
    }
    
    function text_limiter($string, $max)
    {
        $length = strlen($string);
        $new_string = '';
        if($length > $max)
        {
            for($i=$max; $i>0; $i--)
            {
                if($string[$i] == ' ')
                {
                    $new_string = substr($string, 0, $i);
                    break;
                }
            }
        }
        else if($length > 0 && $length < $max)
        {
            $new_string = $string;
        }
        else
        {
            $new_string = '';
        }
        return $new_string;
    }

    public function array_search_recursive( $needle, $haystack, $strict=false, $path=array() )
    {
        if( !is_array($haystack) )
        {
            return FALSE;
        }
        foreach( $haystack as $key => $val )
        {
            if( is_array($val) && $subPath = $this->array_searchRecursive($needle, $val, $strict, $path) )
            {
                $path = array_merge($path, array($key), $subPath);
                return $path;
            }
            elseif( (!$strict && $val == $needle) || ($strict && $val === $needle) )
            {
                $path[] = $key;
                return $path;
            }
        }
        return FALSE;
    }

    function is_uppercase($string)
    {
        if(preg_match("/[A-Z]/", $string)===0)
        {
            return true;
        }
        return false;
    }
    function image_watermark($image_path, $text, $font, $font_size, $result_path,$red, $green, $blue, $x, $y)
    {
        $image_source = imagecreatefromjpeg($image_path); //kalo pengen jadi PNG, jadiin imagecreatefrompng
        $color = imagecolorallocate($image_source, $red, $green, $blue); //set color via RGB
        imagettftext($image_source, $font_size, 0, $x, $y, $color, $font, $text); //set position 0,<x>,<y>
        imagejpeg($image_source, $result_path); //hapus "gambar_baru.jpg" dengan direktori tempat save gambar, atau hilangkan bila ingin langsung view tanpa save
        imagedestroy($image_source);
    }
	
    function default_flight($from = '', $to = '', $text_from = '', $text_to = '', $departure_date = '', $return_date = '')
    {
        //set default search form
        $date = date('Y-m-d');
        if($from == '')
        {
            $data['post_from'] = 'jakarta';
        }
        else
        {
            $data['post_from'] = $from;
        }

        if($to == '')
        {
            $data['post_to'] = 'bali';
        }
        else
        {
            $data['post_to'] = $to;
        }

        if($text_from == '')
        {
            $data['text_from'] = 'Jakarta (CGK)';
        }
        else
        {
            $data['text_from'] = $text_from;
        }

        if($text_to == '')
        {
            $data['text_to'] = 'Bali (DPS)';
        }
        else
        {
            $data['text_to'] = $text_to;
        }

        if($departure_date == '')
        {
            $data['default_departure_date'] = date('Y-m-d',strtotime($date.'+1 days'));
        }
        else
        {
            $data['default_departure_date'] = $departure_date;
        }

        if($return_date == '')
        {
            $data['default_return_date'] = date('Y-m-d',strtotime($date.'+2 days'));
        }
        else
        {
            $data['default_return_date'] = $return_date;
        }

        return $data;
    }
	
    function default_hotel()
    {
        $date = date('Y-m-d');
        $data['default_check_in'] = date('Y-m-d',strtotime($date.'+1 days'));
        $data['default_check_out'] = date('Y-m-d',strtotime($date.'+2 days'));

        return $data;
    }
    
    /*
     * do sort from array, by specific key
     */
    function sort_array($array, $sort_by, $sort_order)
    {
        if(! is_array($array))
        {
            return FALSE;
        }
        
        $sort_array = array();
        foreach($array as $arr)
        { 
            foreach($arr as $key => $value)
            { 
                if( ! isset($sort_array[$key]))
                { 
                    $sort_array[$key] = array(); 
                } 
                $sort_array[$key][] = $value; 
            } 
        }
        
        $order = SORT_ASC;
        if($sort_order == 'desc')
        {
            $order = SORT_DESC;
        }
        
        if($sort_by == 'total_travel_time')
        {
            array_multisort($sort_array[$sort_by], $order, $sort_array['lowest_price'], $order, $array);
        }
        else
        {
            array_multisort($sort_array[$sort_by], $order, $array);
        }
        
        return $array;
    }
    
    /*
     * array from db
     * destination_id, destination_reference_id, destination_type, destination_name, destination_code, destination_slug, destination_label
     */
    public function build_autocomplete_flight($array)
    {
        $string = '';
        foreach($array as $a)
        {
            $string .= '{ label: "'.$a['destination_label'].'", destination_slug: "'.$a['destination_slug'].'" },';
        }
        return $string;
    }
    
    /*
     * do filter in array multidimensional, by specific key
     */
    function filter_array($array, $key, $value)
    {
        if( ! is_array($array))
        {
            return FALSE;
        }
        
        $filter_by[$key] = $value;
        
        // do filter using php native function
        $result = array_filter($array, 
                                function($v) use($filter_by) 
                                {
                                    $return = true;
                                    
                                    foreach($filter_by as $key => $value)
                                    {
                                        if( ! in_array($v[$key], $value))
                                        {
                                            $return &= false;
                                        }
                                    }
                                    
                                    return $return;
                                });
        
        return array_values($result);
    }
    
    /*
    *   return gender by title
    */
    function check_gender_by_title($title)
    {
        //lower all title 
        $title = strtolower($title);
        //get only letter
        $title = preg_replace("/[^a-z]/","", $title);
        
        $male = array('mr','mstr','tuan', 'tn');
        $female = array('ms','mrs','miss','nyonya', 'ny');
        
        $gender = '';
        
        if(in_array($title, $male))
        {
            $gender = 'M';
        }
        elseif(in_array($title, $female))
        {
            $gender = 'F';
        }
        
        return $gender;
    }
}
?>
