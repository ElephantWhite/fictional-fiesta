<?php
require_once 'Zend/Controller/Action.php';
class AuthController extends Zend_Controller_Action
{
	
	public function deactivateaccountAction(){
		 $this->_helper->layout->disableLayout();
		 $this->_response->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
		 
		 $params 			=	$this->getRequest()->getParams();
         $passwordverified 	= 	false;
         $password 			= 	isset($params['deactivate_password_input']) ? $params['deactivate_password_input'] 	: '';
		 if(password_verify($params['deactivate_password_input'], $_SESSION['user'][0]['usr_password']))
			{
				$passwordverified 	= true;
			}
		
		 if($passwordverified)
		 {
		 	$q_user = Doctrine_Query::create()
                                            ->update("Users usr")
                                            ->set("usr.usr_active", "?", "0")
                                            ->where('usr.id_user = ?', $_SESSION['user'][0]['id_user']);
			$rows = $q_user->execute();
			if(count($rows) > 0)
				{
					session_destroy();
					echo Zend_Json::encode(array('result' => "success"));die;
					
				}
				else {
					echo Zend_Json::encode(array('result' => "failure", 'error' => "Nothing changed!"));die;
				}
		 }
		 else {
			 echo Zend_Json::encode(array('result' => "failure", 'error' => "You have entered a wrong password!!"));die;
		 }
	}
	
	public function changepasswordAction(){
		 $this->_helper->layout->disableLayout();
		 $this->_response->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
		 
		 $params = $this->getRequest()->getParams();
        
         $newpassword 			= 	isset($params['password_input']) 		? $params['password_input'] 		: '';
		 $newpasswordagain 		= 	isset($params['password_again_input']) 	? $params['password_again_input'] 	: '';
		 $oldpassword 			= 	isset($params['old_password_input']) 	? $params['old_password_input'] 	: '';
		 $passwordverified 		= 	false;
		 $passwordsmatch 		= 	false;
		 $longenough 			= 	false;
		 
		 if(password_verify($params['old_password_input'], $_SESSION['user'][0]['usr_password']))
			{
				$passwordverified 	= true;
			}
		 if($newpassword == $newpasswordagain)
		 	{
		 		$passwordsmatch 	= true;
		 	}
		 if(strlen($newpassword) > 5)
		 	{
		 		$longenough			= true;
		 	}
		 if($passwordverified && $passwordsmatch && $longenough)
		 	{
		 		$hashed = password_hash($newpassword, PASSWORD_DEFAULT);
		 		$q_user = Doctrine_Query::create()
                                            ->update("Users usr")
                                            ->set("usr.usr_password", "?", $hashed)
                                            ->where('usr.id_user = ?', $_SESSION['user'][0]['id_user'])
											->andWhere("usr.usr_active = 1");
				$rows = $q_user->execute();
				if(count($rows) > 0)
				{
					$_SESSION['user'][0]['usr_password'] = $hashed;
					echo Zend_Json::encode(array('result' => "success"));die;
				}
				else {
					echo Zend_Json::encode(array('result' => "failure", 'error' => "Nothing changed!"));die;
				}
		 	}
		 else {
		 	if($longenough)
			{
				echo Zend_Json::encode(array('result' => 'failure', 'error' => 'Your old password is incorrect'));die;
			}
			echo Zend_Json::encode(array('result' => 'failure', 'error' => 'The password has to be atleast 6 characters long'));die;
		 }
	}	
	
	public function saveemailAction()
	{
		 $this->_helper->layout->disableLayout();
		 $this->_response->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
		 
		 $params 	= 	$this->getRequest()->getParams();
        
         $email 	= 	isset($params['email_input']) ? $params['email_input'] : '';
		 
		 $user 		= 	new Users();
		 
		 if($_SESSION['user'][0]['usr_email'] == $email)
		 {
		 	echo Zend_Json::encode(array('result' => "success",  'email' => $_SESSION['user'][0]['usr_email']));die;
		 }
		 
		 if($user->check_email_exists($email))
		 {
		 	echo Zend_Json::encode(array('result' => "exists",  'email' => $_SESSION['user'][0]['usr_email']));die;
		 }
		 if($_SESSION['user'][0]['usr_email'] != $email)
		 {
		 	$q_user = Doctrine_Query::create()
                                            ->update("Users usr")
                                            ->set("usr.usr_email", "?", $email)
                                            ->where('usr.id_user = ?', $_SESSION['user'][0]['id_user'])
											->andWhere("usr.usr_active = 1");
			$rows = $q_user->execute();
			if(count($rows) > 0)
			{
				$_SESSION['user'][0]['usr_email'] = $email;
				echo Zend_Json::encode(array('result' => "success", 'email' => $_SESSION['user'][0]['usr_email']));die;
			}
			else {
				echo Zend_Json::encode(array('result' => "failure", 'email' => $_SESSION['user'][0]['usr_email'], 'error' => "Nothing changed!"));die;
			}
			
		 }
		 
		 echo Zend_Json::encode(array('result' => "failure", "error" => "Unexpected error"));die;
	}
	
	public function saveusernameAction(){
		 $this->_helper->layout->disableLayout();
		 $this->_response->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
		 
		 $params = $this->getRequest()->getParams();
        
         $username = isset($params['username_input']) ? $params['username_input'] : '';
		 $user = new Users();
		 if($_SESSION['user'][0]['usr_username'] == $username)
		 {
		 	echo Zend_Json::encode(array('result' => "success", 'username' => $username));die;
		 }
		 if($user->check_username_exists($username))
		 {
		  	
		  	echo Zend_Json::encode(array('result' => "exists", 'username' => $_SESSION['user'][0]['usr_username']));die;
		 }
		
		 if($_SESSION['user'][0]['usr_username'] != $username)
		 {
		 	
		 	$q_user = Doctrine_Query::create()
                                            ->update("Users usr")
                                            ->set("usr.usr_username", "?", $username)
                                            ->where('usr.id_user = ?', $_SESSION['user'][0]['id_user'])
											->andWhere("usr.usr_active = 1");
			$rows = $q_user->execute();
			if(count($rows) > 0)
			{
				$_SESSION['user'][0]['usr_username'] = $username;
				echo Zend_Json::encode(array('result' => "success", 'username' => $_SESSION['user'][0]['usr_username']));die;
			}
			else
			{
				echo Zend_Json::encode(array('result' => "failure", 'username' => $_SESSION['user'][0]['usr_username'], 'error' => "Nothing Updated"));die;
			}
	
		 }
		 
		 echo Zend_Json::encode(array('result' => "failure", 'error' => "Unexpected error"));die;
	}

    public function loginAction()
    {
    	$params = $this->getRequest()->getParams();
    	
		if(isset($_SESSION['user'])){
			$this->_redirect("/");
		}
		else 
			{
				if($this->getRequest()->isPost())
				{
					if (isset($params['email']) && isset($params['password']))
					{
						$q_user = Doctrine_Query::create()
													->select()
													->from("Users usr")
													->where("usr.usr_email = ?", $params['email'])
													->andWhere("usr.usr_active = 1");
						$user = $q_user->fetchArray();
						if(sizeof($user) > 0)
						{
							if(password_verify($params['password'], $user[0]['usr_password']))
							{
								$_SESSION['user'] = $user;
								$this->_redirect("/");
							}
							else {
								$this->view->loginerror = "Password is invalid";
							}
						}
						else {
							$this->view->loginerror = "There is no user with this email.";
						}
						
					}
				}
				
			}
	}
     
    public function signupAction()
    {
    	$params = $this->getRequest()->getParams();
		if(isset($_SESSION['user'])){
			$this->_redirect('/');
		}
		else 
			{
				if($this->getRequest()->isPost())
				{
					$username 			= 	isset($params['username']) 		? 	$params['username'] 		: '';
					$email 				= 	isset($params['email']) 		? 	$params['email'] 			: '';
					$password 			= 	isset($params['password']) 		? 	$params['password'] 		: '';
					if ($username != '' && $email != '' && $password != '')
					{
						$q_user = Doctrine_Query::create()
															->select()
															->from("Users usr")
															->where("usr.usr_username = ?", $username)
															->orWhere("usr.usr_email = ?", $password);
						$a_user = $q_user->fetchArray();
						if(count($a_user) == 0)
						{
							$user = new Users();
							$user->usr_username = $username;
							$user->usr_password = password_hash($password, PASSWORD_DEFAULT);
							$user->usr_email = $email;
							$user->save();
							$_SESSION['user'] = $user;
						}
						
					}
				}
				
			}
    } 
    public function logoutAction()
    {
		if(isset($_SESSION['user']))
		{
			session_destroy();
			
		}
		$this->_redirect("/");
    }
    public function homeAction()
    {
    	if(!isset($_SESSION['user']))
		{
			$this->_redirect("/");
		}
    }
}

?>