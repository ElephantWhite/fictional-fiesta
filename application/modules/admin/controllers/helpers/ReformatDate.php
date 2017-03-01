<?php

require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * ArrayToTable Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_ReformatDate extends Zend_Controller_Action_Helper_Abstract {
	/**
	 * @var Zend_Loader_PluginLoader
	 */
	public $pluginLoader;
	
	/**
	 * Constructor: initialize plugin loader
	 * 
	 * @return void
	 */
	public function __construct() {
		// TODO Auto-generated Constructor
		$this->pluginLoader = new Zend_Loader_PluginLoader ();
	}

   public function reformatdate($_date = '', $_timestamp = FALSE)
   {
        $return_date = "";
	        
	    if ($_timestamp) {
	    	
			$return_date = date("d-m-Y H:i", strtotime($_date));
			
		} else {
	
	        if ($_date != "" && $_date != '0000-00-00' && $_date != '0000-00-00 00:00:00') {    
	            
	            $date_array = explode("-",substr($_date,0,10));
	            
	            $return_date = $date_array[2]."-".$date_array[1]."-".$date_array[0];
	            
	        }
		}
		
        return $return_date;
		
    }  
}

