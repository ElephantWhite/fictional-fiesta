<?php
require_once('Zend/Acl.php');

class DbAcl extends Zend_Acl {
	
    public $_getUserRoleName = null; 
 
    public $_getUserRoleId = null; 
    
    public $_user = null;

    protected $_cache = null;
    
    public function __construct($user) 
    {         
    	//init cache
    	$this->_cache = Zend_Registry::get('app_cache');
    	//loading classes needed
    	$this->_user = $user ? $user : 'guest'; 
        self::roleResource();
 		$q = Doctrine_Query::create()
 		                            ->select('s.id_systemuser,s.id_role,s.su_active,s.su_username,s.su_password,s.su_email,
 		                                     r.id_role,r.id_roletype,rt.id_roletype,rt.rtp_active_ind,rt.rtp_roletype,rt.rtp_description')
 									->from('SystemUser s WITH s.su_active =1')
 									->leftJoin('s.Role r ')
 									->leftJoin('r.Roletype rt')
 									->where('s.su_username =\''.$this->_user.'\'');
 									//->useQueryCache(true)
 									//->useResultCache(true);
 		//echo $q->getSqlQuery();die;						
 		$getUserRole = $q->fetchOne('',Doctrine_Core::HYDRATE_ARRAY);
 		if(!empty($getUserRole)){
 			$this->_getUserRoleId = $getUserRole['id_role']; 
        	$this->_getUserRoleName = $getUserRole['Role']['Roletype']['rtp_roletype']; 
 			
 		}else{
 			$this->_getUserRoleId = 1;
 			$this->_getUserRoleName = 'guest';
 		}
 		if(!in_array($this->_getUserRoleName,$this->getRoles())){
 			$this->addRole(new Zend_Acl_Role($this->_user), $this->_getUserRoleName);  
 		}
 		
    } 
   
    private function initRoles() 
    { 
    	if(!($roles = $this->_cache->load('acl_roles'))){
    		//get all roles from database
	        $q = Doctrine_Query::create()
	        					->select('r.id_role,rt.rtp_roletype')
	        					->from('Role r')
	        					->innerJoin('r.Roletype rt');
	        					//->useQueryCache(true)
	 							//->useResultCache(true);
	    	$roles = $q->fetchArray();
	    	$this->_cache->save($roles,'acl_roles');
    	}else{
    		$roles = $this->_cache->load('acl_roles');	
    	}
    	        
    	foreach ($roles as $role) { 
            $this->addRole(new Zend_Acl_Role($role['Roletype']['rtp_roletype'])); 
        }

    } 
 
    private function initResources() 
    { 
        self::initRoles();
        if(!($resources = $this->_cache->load('acl_resources'))){
        	$q = Doctrine_Query::create()->select('srg_object_name')
        							 ->from('SystemRights');
        							//->useQueryCache(true)
 									//->useResultCache(true);
        						 
        	$resources = $q->fetchArray();
        	$this->_cache->save($resources,'acl_resources');
        }else{
        	$resources = $this->_cache->load('acl_resources');
        }
        
        foreach ($resources as $key=>$value){
 			if (!$this->has($value['srg_object_name'])) { 
                $this->add(new Zend_Acl_Resource($value['srg_object_name'])); 
            } 
        }
        
    } 
 
    private function roleResource() 
    { 
    	self::initResources();
    	if(!($acl = $this->_cache->load('acl_acl'))){
    		$q = Doctrine_Query::create()
        	->select('r.id_role,r.id_roletype,rt.rtp_active_ind,rt.rtp_roletype,rt.rtp_description,
        			 re.id_role,re.id_system_rights,p.id_system_rights,p.srg_object_name,p.srg_type,p.srg_read,p.srg_create,p.srg_mutate')
        	->from('Role r')
        	->leftJoin('r.Roletype rt WITH rt.rtp_active_ind =1')
        	->leftJoin('r.RoleSystemRights re')
        	->leftJoin('re.SystemRights p');
        	//->useQueryCache(true)
 			//->useResultCache(true);
        	$acl = $q->fetchArray();
        	$this->_cache->save($acl,'acl_acl');
    	}else{
    		$acl = $this->_cache->load('acl_acl');
     	} 
     	//print_r($acl);die;
        foreach ($acl as $key=>$value) {
        	$role = $value['Roletype']['rtp_roletype'];
        	foreach ($value['RoleSystemRights'] as $key=>$value2){
        		$resource = $value2['SystemRights']['srg_object_name'];
        		$privileges = array();
        		if($value2['SystemRights']['srg_read']) $privileges[] = 'read';
        		if($value2['SystemRights']['srg_create']) $privileges[] = 'create';
        		if($value2['SystemRights']['srg_mutate']) $privileges[] = 'mutate';
        		$this->allow($role,$resource,$privileges);
        		
        	}
            
        }
        
    } 
 
    public function listRoles() 
    { 
        $q = Doctrine_Query::create()
        	->select() 
            ->from('Role');
        return $q->fetchArray(); 
    } 
    /**
     * 
     * @param String $roleName
     */
    public function getRoleId($roleName) 
    { 
        $q = Doctrine_Query::create()
        	->select('id_roletype') 
            ->from('Roletype') 
            ->where('rtp_role_type = "' . $roleName . '"')
            ->useQueryCache(true)
 			->useResultCache(true);
        $result = $q->fetchOne('',HYDRATE_ARRAY);
        return $result['id_roletype']; 
    } 
 
    public function listResources() 
    { 
        if(!($resources = $this->_cache->load('acl_resources'))){
        	$q = Doctrine_Query::create()
        	->select('srg_object_name') 
            ->from('SystemRights sr'); 
        	$resources = $q->fetchArray();
        	$this->_cache->save($resources,'acl_resources');
        	return $resources;   
        }else{
        	$resources = $this->_cache->load('acl_resources');
        	return $resources;
        }
            
        return false;
    } 
 
    public function isUserAllowed($resource, $permission) 
    { 
        return ($this->isAllowed($this->_user, $resource, $permission)); 
    }

    public function getAllResources() {
		$options = Zend_Registry::get ( 'options' );
		
		$modules_path = $options ['resources'] ['frontController'] ['moduleDirectory'];
		$controller_path_name = "controllers";
		$acl_resources = array ();
		$srTable = Doctrine_Core::getTable('SystemRights');
		foreach ( scandir ( $modules_path ) as $module ) {
			if (in_array ( $module, array ('.', '..','.svn' ) ) || ! is_dir ( $modules_path . DIRECTORY_SEPARATOR . $module ))
				continue;

			foreach ( scandir ( $modules_path . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $controller_path_name ) as $file ) {
				if (strstr ( $file, "Controller.php" ) !== false) {
					
					include_once $modules_path . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $controller_path_name . DIRECTORY_SEPARATOR . $file;
					
					foreach ( get_declared_classes () as $class ) {
						
						if (is_subclass_of ( $class, 'Zend_Controller_Action' )) {
							
							$controller = strtolower ( substr ( $class, 0, strpos ( $class, "Controller" ) ) );
							
							$actions = array ();
							
							foreach ( get_class_methods ( $class ) as $action ) {
								
								if (strstr ( $action, "Action" ) !== false) {
									$actions [] = $action;
								}
							}
						}
					}
					
					$acl_resources [$module] [$controller] = $actions;
					
				}
			
			}
		}
		//saves all resources in system rights table
		foreach ($acl_resources as $module=>$controllers){
			$check1 = $srTable->findOneBy('srg_object_name',$module);
			if(empty($check1)){
				$sr_module = new SystemRights();
				$sr_module->srg_object_name = $module;
				$sr_module->srg_object_type = "module";
				$sr_module->srg_type = "private";
				$sr_module->save();	
			}
			foreach ($controllers as $controller=>$actions){
				$check2 = $srTable->findOneBy('srg_object_name',$module."/".$controller);
					if(empty($check2)){
						$sr_controller = new SystemRights();
						$sr_controller->srg_object_name = $module."/".$controller;
						$sr_controller->srg_object_type = "controller";
						$sr_controller->srg_type = "private";
						$sr_controller->save();	
					}
				foreach ($actions as $action){
					$check3 = $srTable->findOneBy('srg_object_name',$module."/".$controller."/".$action);
						if(empty($check3)){
							$sr_action = new SystemRights();
							$sr_action->srg_object_name = $module."/".$controller."/".$action;
							$sr_action->srg_object_type = "action";
							$sr_action->srg_read = true;
							$sr_action->srg_type = "private";
							$sr_action->save();
						}
				}					
			}	
		}
	}

}


?>