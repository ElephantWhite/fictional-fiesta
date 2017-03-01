<?php
require_once 'DbAcl.php';

class DbAclPlugin extends Zend_Controller_Plugin_Abstract{
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$mysession = new Zend_Session_Namespace('michel-session');

		if(isset($mysession->verifiedCode)){
			$code1 = $mysession->verifiedCode;
		}
		if(isset($mysession->user)){
			$code2 = $mysession->user;
		}
		$module = strtolower($request->getModuleName());
		$controller = strtolower($request->getControllerName());
		if($module!='default'){
			$controller = $module."/".$module."_".$controller;
		}else{
			$controller = $module."/".$controller;
		}
		
		$action = strtolower($request->getActionName());
		$action = $controller."/".$action."Action";
		$params = $request->getParams();
		
		if(isset($params['code1'])){
			$code1 = $params['code1'];
		}
		
		if(isset($params['code2'])){
			$code2 = $params['code2'];
		}
		
		if(isset($code1) && $code1!=''){
			//check for mail verification
			$helper = Zend_Controller_Action_HelperBroker::getExistingHelper('MailVerification');
			if(isset($helper) && $helper instanceof Zend_Controller_Action_Helper_Abstract){
				$verified = $helper->direct($code1,$code2);
				if($verified){
					$mysession->mailVerified = true;
					$mysession->verifiedCode = $code1;
				}else{
					$request->setModuleName('default');
					$request->setControllerName('error');
					$request->setActionName('linkexpired');
				}
			}
		
		}
		
		$acl = new DbAcl($mysession->user);
		$role = $acl->_getUserRoleName;
		
		$system_rights = 'private';
		$check = Doctrine_Query::create()
									->select('srg_type,srg_object_name')
									->from('SystemRights')
									->where('srg_object_name = "'.$action.'"')
									->fetchArray();
		if(isset($check) && count($check)>0){
			$system_rights = $check[0]['srg_type'];
		}
		//add the resource if not exists in acl object
		if(!$acl->has($action)){
			$acl->addResource(new Zend_Acl_Resource($action));
		}
		if(!$acl->has($module)){
			$acl->addResource(new Zend_Acl_Resource($module));
		}
		if(!$acl->has($controller)){
			$acl->addResource(new Zend_Acl_Resource($controller));
		}
		
		//only check acl when resource is private or role is not super_admin ;)
		//here we have to check if user has access to module,controller or action
		//otherwise checked if mail verified exists in session storage
			
		if($system_rights === 'private' && $role!='super_admin' ){
			if(!$acl->isAllowed($role,$module,'read')){
				if(!$acl->isAllowed($role,$controller,'read')){
					if(!$acl->isAllowed($role,$action,'read') && $role!="guest"){
						$request->setModuleName('default');
						$request->setControllerName('error');
						$request->setActionName('denied');
					}elseif(!$acl->isAllowed($role,$action,'read') && $role==="guest"){
						$request->setModuleName('default');
						$request->setControllerName('auth');
						$request->setActionName('login');
					}
				}								
			}
		}				
		
	}

}


?>