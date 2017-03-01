<?php
class Autolayout extends Zend_Controller_Plugin_Abstract {
	public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		Zend_Layout::getMvcInstance()->getInflector()->setStaticRule( 'module', strtolower($request->getModuleName()) );
	}
	/**
	 * this function load readesk navigation menu
	 * @param $request
	 */
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request){
		$moduleName = $request->getModuleName();
		switch ($moduleName){
			case "default": $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'navdefault');
					        $container = new Zend_Navigation($config);
					        $view = Zend_Layout::getMvcInstance()->getView();
					        $view->navigation($container);
							break;
				        
			case "tablet": 
							$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'navdefault');
							$container = new Zend_Navigation($config);
							$view = Zend_Layout::getMvcInstance()->getView();
							$view->navigation($container);
					         break;	
       
					        
			default: 		return;
							break;
		}
	}
	
}