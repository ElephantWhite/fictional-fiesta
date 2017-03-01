<?php

require_once 'Zend/Controller/Action.php';

class OptimizeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$session = Zend_Session::namespaceGet("micheljonk-session");
		$s_rtp_roletype = isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
		
	}
}

