<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image
{
	
   public function resize($width = 0, $height = 0, $file, $info_data, $default = '') {
		if (!$info_data || !$info_data['height']) {
			return;
		}

		$xpos = 0;
		$ypos = 0;
		$scale = 1;

		$scale_w = $width / $info_data['width'];
		$scale_h = $height / $info_data['height'];

		if ($default == 'w') {
			$scale = $scale_w;
		} elseif ($default == 'h'){
			$scale = $scale_h;
		} else {
			$scale = min($scale_w, $scale_h);
		}

		if ($scale == 1 && $scale_h == $scale_w && $info_data['mime'] != 'image/png') {
			return;
		}

		$new_width = (int)($info_data['width'] * $scale);
		$new_height = (int)($info_data['height'] * $scale);			
		$xpos = (int)(($width - $new_width) / 2);
		$ypos = (int)(($height - $new_height) / 2);

		
		$mime = $info_data['mime'];
		
		if ($mime == 'image/gif') {
			$data_ane = imagecreatefromgif($file);
		} elseif ($mime == 'image/png') {
			$data_ane = imagecreatefrompng($file);
		} elseif ($mime == 'image/jpeg') {
			$data_ane = imagecreatefromjpeg($file);
		} 
		
		
		$image_old = $data_ane;
		
		$dataimg_2 = imagecreatetruecolor($width, $height);

		if (isset($info_data['mime']) && $info_data['mime'] == 'image/png') {		
			imagealphablending($dataimg_2, false);
			imagesavealpha($dataimg_2, true);
			$background = imagecolorallocatealpha($dataimg_2, 255, 255, 255, 127);
			imagecolortransparent($dataimg_2, $background);
		} else {
			$background = imagecolorallocate($dataimg_2, 255, 255, 255);
		}

		imagefilledrectangle($dataimg_2, 0, 0, $width, $height, $background);

		imagecopyresampled($dataimg_2, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $info_data['width'], $info_data['height']);
		
		imagejpeg($dataimg_2,$file,100);
		
		imagedestroy($image_old);
		
	}

	
	function image_name_value($md5_name,$data_type,$px_data = '')
        { 	
		    //date
			date_default_timezone_set('Asia/Jakarta');
			// waktu sekarang
			$sekarang = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')); /* akan menghasilkan waktu sekarang*/
			
			if($px_data == '') 
            {
                $data = md5($md5_name)."_".$sekarang.str_replace('image/','.',$data_type);
			} 
            else 
            {
                $data = md5($md5_name)."_".$sekarang."-".$px_data."x".$px_data.str_replace('image/','.',$data_type);
			}
			return $data;
	}  
	
	public function resize_final($file,$size_panjang,$size_lebar) {
		
        if (file_exists($file)) {
				
				$info = getimagesize($file);
                
				$info_data = array(
					'width'  => $info[0],
					'height' => $info[1],
					'bits'   => $info['bits'],
					'mime'   => $info['mime']
				);

				$this->resize($size_panjang,$size_lebar, $file, $info_data);
                
		} else { die("<script>alert('Sorry, you do not fill up the image or you can not upload Image products other than Photo');window.history.go(-1);</script>"); }
	} 
	
	
	// paling utama
	function upload_resize($path,$files,$panjang,$lebar,$code = '') 
    {	
	    // upload images prod one
		$data_images = $this->image_name_value($files['name'].$code,$files['type']);
		$images_name_tmp = $files['tmp_name'];
		$new_image = $path.$data_images;
		// END upload images prod one
        
		// file ORI
		$move = move_uploaded_file($images_name_tmp,$new_image);
		
		$this->resize_final($new_image,$panjang,$lebar);
		
		return $data_images;
	}		

}
