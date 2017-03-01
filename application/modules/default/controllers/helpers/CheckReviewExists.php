<?php

require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * ArrayToTable Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_CheckReviewExists extends Zend_Controller_Action_Helper_Abstract {
	/**
	 * @var Zend_Loader_PluginLoader
	 */
	public $pluginLoader;
	
	/**
	 * Constructor: initialize plugin loader
	 * 
	 * @return void
	 */
	public function __construct() {
		// TODO Auto-generated Constructor
		$this->pluginLoader = new Zend_Loader_PluginLoader ();
	}

	 public function checkreviewexists($userid, $type)
	{
		$ar_reviews = null;
		
		if($userid != '' && $type['id_movie'] == '')
		{
			$q_reviews = Doctrine_Query::create()
														->select()
														->from('Reviews rvw')
														->leftJoin('rvw.Users usr')
														->where('rvw.rvw_active = 1')
														->andWhere('usr.id_user = ?', $userid);
			
			
			if($type['id_serie'] != '' && $type['id_season'] != '' && $type['id_episode'] != '')
			{
				$q_reviews->andWhere('rvw.epd_id_serie = ?', $type['id_serie'])
						  ->andWhere('rvw.epd_id_season = ?', $type['id_season'])
						  ->andWhere('rvw.epd_id_episode = ?', $type['id_episode']);
				
			}
			else if($type['id_serie'] != '' && $type['id_season'] != '')
			{
				$q_reviews->andWhere('rvw.sss_id_serie = ?', $type['id_serie'])
						  ->andWhere('rvw.sss_id_season = ?', $type['id_season']);
			}
			
			$ar_reviews = $q_reviews->fetchArray();
			
		}
		else if($type['id_movie'] != '' && $userid != '')
		{
			$q_reviews = Doctrine_Query::create()
													->select()
													->from('Reviews rvw')
													->leftJoin('rvw.Users usr')
													->where('rvw.rvw_active = 1')
													->andWhere('mvs_id_movie = ?', $type['id_movie'])
													->andWhere('usr.id_user = ?', $userid);
			$ar_reviews = $q_reviews->fetchArray();
		}
		if(sizeof($ar_reviews) > 0)
			{
				return true;
			}
			else 
			return false;
	}
}

