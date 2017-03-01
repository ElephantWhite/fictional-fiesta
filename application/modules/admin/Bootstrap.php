<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap{
	
	protected function _initRoutes() { /* this is always called */ }
    //protected function _setupLayout() { /* this is only called if the request maps to the foo module */ }
    public function setup() { /* this should be defined in the parent class; it calls all _setup* methods */ }
    /**
     * this function used with autolayout plugin make sure that spesific resources only 
     */
    protected function _initPlugins(){
    	$this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView(); 
        $this->layout = 'admin';
        //add deafult view helpers so that they can be used in other modules
		$view->addHelperPath(APPLICATION_PATH.'/modules/default/views/helpers/','Zend_View_Helper_LoadSkin');
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$view->skin = "admin";
    }
    
	
}