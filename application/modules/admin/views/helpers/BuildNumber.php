<?php
 
class Zend_View_Helper_BuildNumber extends Zend_View_Helper_Abstract
{
    public function buildnumber()
    {
		$fileApplicationIni = APPLICATION_PATH .'/configs/application.ini';
		$config = new Zend_Config_Ini($fileApplicationIni, APPLICATION_ENV);
	  	
        return $config->buildNumber;
    }
}