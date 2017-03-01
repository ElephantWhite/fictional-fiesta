<?php
 
class Zend_View_Helper_CountSeries extends Zend_View_Helper_Abstract
{
    public function countseries()
	{
		$q_series = Doctrine_Query::create()
											->select()
											->from("Series srs")
											->andWhere("srs.srs_active = 1");
		$series = $q_series->fetchArray();
		return sizeof($series);
	}
}