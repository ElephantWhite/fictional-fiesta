<?php 
error_reporting( E_ALL | E_STRICT );

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));



// Include path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));
/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
            
require_once 'controllers/ControllerTestCase.php';