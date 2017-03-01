<?php
 
class Zend_View_Helper_ControllerName extends Zend_View_Helper_Abstract
{
    public function controllername()
	{
		return Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
	}
}