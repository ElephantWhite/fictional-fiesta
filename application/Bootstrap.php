<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public static $frontController  = null;
	public static $databaseSourceName  = null;
	public static $doctrineConfig = array();
	public static $zendLayoutPath = null;
	public static $pathToDoctrine = null;
	public static $dateTimeZone = null;
		
	public function run()
	{
		//$this->fillFromApplicationIni();
		self::setupEnvironment();
		self::prepare();
		//self::_initLog();
		$response = self::$frontController->dispatch();
		self::sendResponse($response);
	}
	
	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
            'admin' => '',
        ));
        return $autoloader;
    }

    protected function _initDoctrine()
    {
    	$this->getApplication()->getAutoloader()->registerNamespace('Doctrine')
												->pushAutoloader(array('Doctrine', 'autoload'))
                               					->pushAutoloader(array('Doctrine_Core','modelsAutoload'));							   
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
            Doctrine::ATTR_MODEL_LOADING,
            Doctrine::MODEL_LOADING_CONSERVATIVE
        );
        //$cacheDriver = new Doctrine_Cache_Apc();
        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
        //$manager->setAttribute(Doctrine_Core::ATTR_QUERY_CACHE, $cacheDriver);
        //load all db models conservatively(just classname and path)
        //load all models name and path in cache so we don't have to loop the map everytime
        //first create the caching back end if not exists
        $frontendOptions = array ('cache_id_prefix' => 'app_cache', 'lifetime' => 86400, 'automatic_serialization' => true );
		$backendOptions = array ('cache_dir' => APPLICATION_PATH . '/data/cache' );
		$cache = Zend_Cache::factory ( 'Core', 'File', $frontendOptions, $backendOptions );
		Zend_Registry::set('app_cache',$cache);
        
   				
		if(!($models = $cache->load('doctrine_models'))){
   			Doctrine::loadModels(APPLICATION_PATH.'/modules/default/models',Doctrine::MODEL_LOADING_CONSERVATIVE);
   			$cache->save(Doctrine_Core::getLoadedModelFiles(),'doctrine_models');	
   		}else{
   			$models = $cache->load('doctrine_models');
   			foreach ($models as $key=>$value){
   				Doctrine_Core::loadModel($key,$value);
   			}
   		}
           		       
        $dsn = $this->getOption('dsn');
        $conn = Doctrine_Manager::connection($dsn, 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        
		//set the caching at connection and manager level
		//$conn->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, $cacheDriver);
        return $conn;
    }

	protected function _initRouter(){
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/router.ini', 'production');
        //$router->addConfig($config, 'routes');
        // Returns the router resource to bootstrap resource registry
        return $router;
    }
	
	private function fillFromApplicationIni()
	{
		$fileApplicationIni = dirname(__FILE__).'/configs/application.ini';
		$config = new Zend_Config_Ini($fileApplicationIni, APPLICATION_ENV);

		self::$zendLayoutPath = $config->zend->layoutPath;
		self::$dateTimeZone   = $config->phpSettings->date->timezone;
		self::$pathToDoctrine = $config->doctrine->path;
		
		
		
		
		
//		$fileRouteXml = dirname(__FILE__).'/configs/route.xml';
//		$config2 = new Zend_Config_Xml($fileRouteXml, 'development');
//		$router = new Zend_Controller_Router_Rewrite();
//		$router->addConfig($config2, 'routes');
		
		Zend_Registry::set ( 'options', $this->_options ); 
	}

	public static function setupEnvironment()
	{
		error_reporting(E_ALL|E_STRICT);
		Zend_Layout::startMvc(array("layoutPath" => APPLICATION_PATH."/layouts/scripts","layout" => "layout"));		
		//this generates all models from db scheme (*** warning !! this will create models only if the model does not exists *****)
        Doctrine_Core::generateModelsFromDb(dirname(__FILE__).'/modules/default/models', array('doctrine'), array('generateTableClasses' => true));	
		
		if(!Zend_Registry::isRegistered('Zend_Locale')){
			//set locale
			$locale = new Zend_Locale('nl_NL');
			Zend_Registry::set('Zend_Locale', $locale);
		}	
        
                
        $currency = new Zend_Currency('nl_NL');
        Zend_Registry::set('Zend_Currency', $currency);
        	
		
        //start the session
        Zend_Session::start();
		if(!isset($_SESSION)){session_start();}
		//require_once("password.php");
	}
  		
	public static function prepare()
	{
		self::setupFrontController();
		self::setupView();
	}
	 
	public static function setupFrontController()
	{
		self::$frontController = Zend_Controller_Front::getInstance();
		self::$frontController->throwExceptions(true);
		self::$frontController->returnResponse(true);
		//create cache file for plugin
		$classFileIncCache = APPLICATION_PATH . '/data/pluginLoaderCache.php';
		if (file_exists($classFileIncCache)) {
    		include_once $classFileIncCache;
		}
		Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
		self::$frontController->registerPlugin(new Zend_Controller_Plugin_ErrorHandler());
		//require_once dirname(__FILE__).'/modules/default/controllers/plugins/acl/DbAclPlugin.php';
        //self::$frontController->registerPlugin(new DbAclPlugin());
        //we do not use this for now so commented
//     	require_once dirname(__FILE__).'/modules/default/controllers/plugins/translate/TranslatePlugin.php';
//		self::$frontController->registerPlugin(new TranslatePlugin());
		require_once dirname(__FILE__).'/modules/default/controllers/plugins/layout/Autolayout.php';
		self::$frontController->registerPlugin(new Autolayout());
        
        require_once 'dompdf/dompdf_config.inc.php';
        Zend_Loader_Autoloader::getInstance()->pushAutoloader('DOMPDF_autoload','DOMPDF_');
	}
	 
	public static function setupView()
	{
		$view = new Zend_View;
		//add extra helper for jquery
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$view->addHelperPath(dirname(__FILE__).'/modules/default/views/helpers/', 'Modules_Default_Views_Helpers');
		$view->setEncoding('UTF-8');
		$view->skin = "default";
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		Zend_Controller_Action_HelperBroker::addHelper(new ZendX_JQuery_Controller_Action_Helper_AutoComplete());
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/default/controllers/helpers/');	
	}
	 
	public static function sendResponse(Zend_Controller_Response_Http $response)
	{
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->sendResponse();
	}
}

