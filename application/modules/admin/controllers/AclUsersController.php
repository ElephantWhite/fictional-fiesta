<?php

class AclUsersController extends Zend_Controller_Action{
	
	public function init(){
		$this->_flashMessenger =
		$this->_helper->getHelper('FlashMessenger');
		$this->initView();
	}
	

	public function loginAction(){
		
		
	}
	

	public function logoutAction(){
		
		$session = Zend_Session::namespaceGet("michel-session");

		if(!empty($session['user']))
		{
			Zend_Session::destroy();
			unset($session);
			
		}
		$this->_helper->redirector->setGotoSimple("index","index");
	}
}