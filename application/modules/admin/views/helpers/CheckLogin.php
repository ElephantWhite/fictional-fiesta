<?php
 
class Zend_View_Helper_CheckLogin extends Zend_View_Helper_Abstract
{
    public function checklogin()
    {
		if(isset($_SESSION['user']))
		{
			return true;
		}
		else
		{
			return false;
		}
    }
}