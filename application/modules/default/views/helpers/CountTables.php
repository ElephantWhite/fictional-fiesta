<?php
 
class Zend_View_Helper_CountTables extends Zend_View_Helper_Abstract
{
    public function countfilms()
	{
		$q_movies = Doctrine_Query::create()
											->select('count(*)')
											->from("Movies mvs")
											->where("mvs.mvs_active = 1");

		$array = ($q_movies->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	public function countseries()
	{
		$q_series = Doctrine_Query::create()
											->select("count(*)")
											->from("Series srs")
											->where("srs.srs_active = 1");
		$array = ($q_series->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countfranchises()
	{
		$q_franchises = Doctrine_Query::create()
												->select("count(*)")
												->from("Franchises fcs")
												->where("fcs.fcs_active = 1");
		$array = ($q_franchises->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countcharacters()
	{
		$q_characters = Doctrine_Query::create()
												->select("count(*)")
												->from("Characters chr")
												->where("chr.chr_active = 1");
		$array = ($q_characters->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function counttypes()
	{
		$q_types = Doctrine_Query::create()
											->select("count(*)")
											->from("FilmserieType fst")
											->where("fst.fst_active = 1");
		$array = ($q_types->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countgenres()
	{
		$q_genres = Doctrine_Query::create()
											->select("count(*)")
											->from("Genres gnr")
											->where("gnr.gnr_active = 1");
		$array = ($q_genres->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countpublishers()
	{
		$q_publishers = Doctrine_Query::create()
											->select("count(*)")
											->from("Publishers pbs")
											->where("pbs.pbs_active = 1");
		$array = ($q_publishers->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countproducers()
	{
		$q_producers = Doctrine_Query::create()
											->select("count(*)")
											->from("Producers pdr")
											->where("pdr.pdr_active = 1");
		$array = ($q_producers->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countlanguages()
	{
		$q_languages = Doctrine_Query::create()
											->select("count(*)")
											->from("Languages lgg")
											->where("lgg.lgg_active = 1");
		$array = ($q_languages->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
	
	public function countusers()
	{
		$q_users = Doctrine_Query::create()
											->select("count(*)")
											->from("Users usr")
											->where('usr.usr_active = 1');
		$array = ($q_users->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY));
		return $array['count'];
	}
}