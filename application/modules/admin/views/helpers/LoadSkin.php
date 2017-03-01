<?php
/**
 * this class loads the skin's css files using the skin.xml file 
 *
 */
class Zend_View_Helper_LoadSkin extends Zend_View_Helper_Abstract {
    
    public function loadSkin($baseurl, $skin) 
    {
        // load the skin config file
        $skinData = new Zend_Config_Xml ('./skins/' . $skin . '/skin.xml' );
        $stylesheets = $skinData->stylesheet;
        echo $this->view->headLink()->appendStylesheet ($baseurl.'/skins/' . $skin . '/css/' . $stylesheets );                             

    }
}