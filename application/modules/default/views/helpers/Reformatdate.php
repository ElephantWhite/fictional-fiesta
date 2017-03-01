<?php
 
class Zend_View_Helper_Reformatdate extends Zend_View_Helper_Abstract
{
   public function reformatdate($_date = '', $_timestamp = FALSE)
   {
        $return_date = "";
        if($_date != '')
        {
    	    if ($_timestamp) {
    	    	
    			$return_date = date("d-m-Y H:i", strtotime($_date));
    			
    		} else {
    	
    	        if ($_date != "" && $_date != '0000-00-00' && $_date != '0000-00-00 00:00:00') {    
    	            
    	            $date_array = explode("-",substr($_date,0,10));
    	            
    	            $return_date = $date_array[2]."-".$date_array[1]."-".$date_array[0];
    	            
    	        }
    		}
        }
		
        return $return_date;
		
    } 
}

