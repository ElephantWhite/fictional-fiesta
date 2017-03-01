<?php

require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * ArrayToTable Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_Counter extends Zend_Controller_Action_Helper_Abstract {
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

	public function countfilms()
	{
		$q_enabled = Doctrine_Query::create()
											->select()
											->from("Movies mvs")
											->where("mvs.mvs_active = 1");
		$enabled = $q_enabled->fetchArray();
		$q_disabled = Doctrine_Query::create()
											->select()
											->from("Movies mvs")
											->where("mvs.mvs_active = 0");
		$disabled = $q_disabled->fetchArray();
		$enabledpercent = ((sizeof($enabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		$disabledpercent = ((sizeof($disabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		return array("enabled" => sizeof($enabled), "disabled" => sizeof($disabled) , "enabled_percent" => $enabledpercent, "disabled_percent" => $disabledpercent);
	}
	
	public function countseries()
	{
		$q_enabled = Doctrine_Query::create()
											->select()
											->from("Series srs")
											->where("srs.srs_active = 1");
		$enabled = $q_enabled->fetchArray();
		$q_disabled = Doctrine_Query::create()
											->select()
											->from("Series srs")
											->where("srs.srs_active = 0");
		$disabled = $q_disabled->fetchArray();
		$enabledpercent = ((sizeof($enabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		$disabledpercent = ((sizeof($disabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		return array("enabled" => sizeof($enabled), "disabled" => sizeof($disabled) , "enabled_percent" => $enabledpercent, "disabled_percent" => $disabledpercent);
	}
	
	public function countpublishers()
	{
		$q_enabled = Doctrine_Query::create()
											->select()
											->from("Publishers pbs")
											->where("pbs.pbs_active = 1");
		$enabled = $q_enabled->fetchArray();
		$q_disabled = Doctrine_Query::create()
											->select()
											->from("Publishers pbs")
											->where("pbs.pbs_active = 0");
		$disabled = $q_disabled->fetchArray();
		$enabledpercent = ((sizeof($enabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		$disabledpercent = ((sizeof($disabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		return array("enabled" => sizeof($enabled), "disabled" => sizeof($disabled) , "enabled_percent" => $enabledpercent, "disabled_percent" => $disabledpercent);
	}
	
	public function countproducers()
	{
		$q_enabled = Doctrine_Query::create()
											->select()
											->from("Producers pdr")
											->where("pdr.pdr_active = 1");
		$enabled = $q_enabled->fetchArray();
		$q_disabled = Doctrine_Query::create()
											->select()
											->from("Producers pdr")
											->where("pdr.pdr_active = 0");
		$disabled = $q_disabled->fetchArray();
		$enabledpercent = ((sizeof($enabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		$disabledpercent = ((sizeof($disabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		return array("enabled" => sizeof($enabled), "disabled" => sizeof($disabled) , "enabled_percent" => $enabledpercent, "disabled_percent" => $disabledpercent);
	}
	
	public function countfranchises()
	{
		$q_enabled = Doctrine_Query::create()
											->select()
											->from("Franchises fcs")
											->where("fcs.fcs_active = 1");
		$enabled = $q_enabled->fetchArray();
		$q_disabled = Doctrine_Query::create()
											->select()
											->from("Franchises fcs")
											->where("fcs.fcs_active = 0");
		$disabled = $q_disabled->fetchArray();
		$enabledpercent = ((sizeof($enabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		$disabledpercent = ((sizeof($disabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		return array("enabled" => sizeof($enabled), "disabled" => sizeof($disabled) , "enabled_percent" => $enabledpercent, "disabled_percent" => $disabledpercent);
	}
	
	public function countusers()
	{
		$q_enabled = Doctrine_Query::create()
											->select()
											->from("Users usr")
											->where("usr.usr_active = 1");
		$enabled = $q_enabled->fetchArray();
		$q_disabled = Doctrine_Query::create()
											->select()
											->from("Users usr")
											->where("usr.usr_active = 0");
		$disabled = $q_disabled->fetchArray();
		$enabledpercent = ((sizeof($enabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		$disabledpercent = ((sizeof($disabled) / (sizeof($enabled) + sizeof($disabled))) * 100);
		return array("enabled" => sizeof($enabled), "disabled" => sizeof($disabled) , "enabled_percent" => $enabledpercent, "disabled_percent" => $disabledpercent);
	}
}

