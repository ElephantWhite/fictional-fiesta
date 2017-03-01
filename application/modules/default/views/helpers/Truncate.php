<?php
 
class Zend_View_Helper_Truncate extends Zend_View_Helper_Abstract
{
    public function truncate ($string
    						, $start 		= 0
    						, $length 		= 100
    						, $postfix 		= ' [...]'
    						, $truncOnSpace = false
    						, $float 		= false)
    {
        $truncated = trim($string);
        $start = (int) $start;
        $length = (int) $length;
        
        // Return original string if max length is 0
        if ($length < 1) return $truncated;
        
        $full_length = iconv_strlen($truncated);
        
        // Truncate if necessary
        if ($full_length > $length) {
            // Right-clipped
            if ($length + $start > $full_length) {
                $start = $full_length - $length;
                $postfix = '';
            }
            
            // Left-clipped
            if ($start == 0) $prefix = '';
            
            // Do truncate!
            $truncated = trim(substr($truncated, $start, $length));
            if ($truncOnSpace){
	            // Truncate at the last space
	            $lastSpace = strrpos ($truncated,' ');
	            $truncated = substr($truncated, $start, $lastSpace);
            }
	        if ($float!==false){
	        	$postfix = '<span style="float:'.$float.';">'.$postfix.'</span>';
	        }
	        $truncated .= $postfix;
        }
        return $truncated;
    }
}