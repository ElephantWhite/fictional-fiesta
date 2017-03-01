<?php
 
class Zend_View_Helper_ShowImage extends Zend_View_Helper_Abstract
{
	public function showImage ($filename,$i_id_organization,$id_product) {
	
		if($filename != '') {
		
		    $s_filename = APPLICATION_PATH.'/data/uploads/products/'.$i_id_organization.'/'.$id_product.'/'.$filename;
		    //echo $s_filename;die;
		    $ar_file = array_reverse(explode(".", $s_filename));
		        
		    $path_parts = pathinfo($s_filename);
		    $s_extention = $path_parts['extension'];
		    
		    $fp = fopen($s_filename, 'rb');
		    
		    // send the right headers
		    if(strtolower($s_extention) == 'jpg' OR strtolower($s_extention) == 'jpeg')
		        header("Content-Type: image/jpg");
		    elseif(strtolower($s_extention) == 'png')
		        header("Content-Type: image/png");
		    
		    header("Content-Length: " . filesize($s_filename));
		    
		    // dump the picture and stop the script
		    fpassthru($fp);
	    }
	}
}