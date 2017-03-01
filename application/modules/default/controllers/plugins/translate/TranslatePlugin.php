<?php
class TranslatePlugin extends Zend_Controller_Plugin_Abstract {
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		
		$locale = new Zend_Locale ();
		
		$frontendOptions = array ('cache_id_prefix' => 'app_cache', 'lifetime' => 86400, 'automatic_serialization' => true );
		$backendOptions = array ('cache_dir' => APPLICATION_PATH . '/data/cache/' );
		$cache = Zend_Cache::factory ( 'Core', 'File', $frontendOptions, $backendOptions );
		Zend_Translate::setCache ( $cache );
		$options = array ('scan' => null );
		$language = $locale->getLanguage();
		$translation_file_path = realpath('../languages/');
		if(file_exists($translation_file_path.$language)){
			$translate = new Zend_Translate ( 'csv', '../languages/' . $language . '/translations.csv', $language, $options );
			$translate->addTranslation ( '../languages/' . $language . '/translations.csv', $language);
			$translate->setLocale ( $locale );
			
		}else{
			$language = 'nl';
			$translate = new Zend_Translate ( 'csv', '../languages/nl/translations.csv', 'nl', $options );
			$translate->addTranslation ( '../languages/nl/translations.csv', 'nl');
			$translate->setLocale ( 'nl' );
		}		
		setcookie ( 'lang', $language, null, '/' );
		Zend_Registry::set ( 'locale', $language);
		Zend_Registry::set ( 'Zend_Translate', $translate );
	}
}