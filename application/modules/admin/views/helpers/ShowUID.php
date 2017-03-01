<?php
class Zend_View_Helper_ShowUID extends Zend_View_Helper_Abstract{
	public function showUID($uid){
		$initial = Doctrine_Query::create()
									->select()
									->from('SystemUser su')
									->leftJoin('su.PersonHasSystemUser phs')
									->leftJoin('phs.Person prs')
									->where('id_sysuser = '.$uid)
									->fetchOne('',Doctrine_Core::HYDRATE_ARRAY);
		if(isset($initial) && $initial['PersonHasSystemUser'][0]['Person'] && $initial['PersonHasSystemUser'][0]['Person']['prs_initials']!=''){
			return $initial['PersonHasSystemUser'][0]['Person']['prs_initials'];
		}else{
			return '';
		}
		
	}
}