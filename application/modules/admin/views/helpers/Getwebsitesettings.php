<?php
 
class Zend_View_Helper_Getwebsitesettings extends Zend_View_Helper_Abstract
{
	//Type = logo or favicon
    public function getwebsitesettings ($url = '', $type = "logo")
    {
    	$image = '';
    	$url = str_replace("https://","",$url);
    	$url = str_replace("http://","",$url);
    	
    	switch ($url)
    	{

    		default:
    			if($type == "logo")
   					$image = 'logo-optimit.png';
   				elseif($type == "skin")
   					$image = 'default';
                elseif($type =="jquerythemecss")
                    $image = 'bootstrap/jquery.ui.theme.css';
                elseif($type =="jquery")
                    $image = 'js/jquery-1.10.2.js';
                elseif($type =="jquerythemejs")
                    $image = 'js/jquery-ui.min.js';
				elseif($type == "micheljonkcss")
					$image = 'micheljonk.css';
   				else
   					$image = 'nbc-icon.png';
    			break;
    	}
        return $image;
    }
}