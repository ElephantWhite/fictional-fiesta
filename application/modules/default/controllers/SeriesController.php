<?php

require_once 'Zend/Controller/Action.php';

class SeriesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	public function indexAction()
	{
		
		
	}
	
	public function episodeinfoAction()
	{
		$this->_helper->layout->disableLayout();
		$params = $this->getRequest()->getParams();
        
        
        
        
		if (isset($params['idserie']) && (is_numeric($params['idserie'])) && isset($params['idseason']) && is_numeric($params['idseason']) && isset($params['idepisode']) && is_numeric($params['idepisode']))
		{
			$q_episode = Doctrine_Query::create()
									
											->select()
											->from('Episodes epd')
											->leftJoin("epd.Seasons sss")
											->where('epd.epd_active = 1')
											->andWhere("sss.sss_active = 1")
											->andWhere('epd.id_season = ?', $params['idseason'])
											->andWhere('epd.id_serie = ?', $params['idserie'])
											->andWhere('epd.id_episode = ?', $params['idepisode']);
											
			$o_episode = $q_episode->fetchOne();
			
		 
			$this->view->o_episode = $o_episode;
		}
	}
	
	
	public function seasoninfoAction()
	{
		$this->_helper->layout->disableLayout();
		$params = $this->getRequest()->getParams();
		if (isset($params['idserie']) && (is_numeric($params['idserie'])) && isset($params['idseason']) && is_numeric($params['idseason']) )
		{
			$q_episodes = Doctrine_Query::create()
									
											->select()
											->from('Episodes epd')
											->where('epd.epd_active = 1')
											->andWhere('epd.id_season = ?', $params['idseason'])
											->andWhere('epd.id_serie = ?', $params['idserie']);
											
			$ar_episodes = $q_episodes->fetchArray();
			
			$q_characters = Doctrine_Query::create()
									
											->select()
											->from('CharactersHasSeasons chs')
											->leftJoin('chs.Seasons sss')
											->leftJoin('chs.Characters chr')
											->where('chs.chs_active = 1')
											->andWhere('sss.id_season = ?', $params['idseason'])
											->andWhere('sss.id_serie = ?', $params['idserie'])
											->andWhere('chr.chr_active = 1')
											->andWhere("sss.sss_active = 1");

											
			$ar_characters = $q_characters->fetchArray();
			
			$q_season = Doctrine_Query::create()
                                            ->select()
                                            ->from('Seasons sss')
                                            ->where('sss.sss_active = 1')
                                            ->andWhere('sss.id_season = ?', $params['idseason']);
            
         	$o_season = $q_season->fetchOne();
		 
			$this->view->o_season = $o_season;
			$this->view->ar_characters = $ar_characters;
			$this->view->ar_episodes = $ar_episodes;
		}
		
	}
	


    public function showAction()
    {
    	$session = Zend_Session::namespaceGet("micheljonk-session");
		$s_rtp_roletype = isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
		$id = null;
		$params = $this->getRequest()->getParams();
		if (isset($params['id']) && (is_numeric($params['id'])))
		{
			$id = $params['id'];
			//Movie Info
			$q_serie = Doctrine_Query::create()
										
												->select()
												->from('Series srs')
												->leftJoin('srs.FilmserieType fst')
												->leftJoin('srs.Franchises fcs')
												->where('srs.srs_active = 1')
												->andWhere('srs.id_serie = ?', $id);
												
			$o_serie = $q_serie->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
			
			//Publishers
			$q_publishers_series = Doctrine_Query::create()
													->select()
													->from('PublishersHasSeries phs')
													->leftJoin("phs.Publishers pbs")
													->where('phs_active = 1')
													->andWhere('id_serie = ?', $id)
													->andWhere('pbs_active = 1');
			$o_publishers_series = $q_publishers_series->fetchArray();
			
			//Producers
			$q_producers_series = Doctrine_Query::create()
													->select()
													->from('ProducersHasSeries phs')
													->leftJoin("phs.Producers pdr")
													->where('phs_active = 1')
													->andWhere('id_serie = ?', $id)
													->andWhere('pdr_active = 1');
			$o_producers_series = $q_producers_series->fetchArray();
			
			//Genres
			$q_genres_series = Doctrine_Query::create()
													->select()
													->from('SeriesHasGenres shg')
													->leftJoin("shg.Genres gnr")
													->where('shg_active = 1')
													->andWhere('id_serie = ?', $id)
													->andWhere('gnr_active = 1');
			$o_genres_series = $q_genres_series->fetchArray();
			
			//Subtitles
			$q_subtitles_series = Doctrine_Query::create()
													->select()
													->from('SerieSubtitles ss')
													->leftJoin("ss.Languages lgg")
													->where('ss_active = 1')
													->andWhere('id_serie = ?', $id)
													->andWhere('lgg_active = 1');
			$o_subtitles_series = $q_subtitles_series->fetchArray();
			
			//Audio
			$q_audio_series = Doctrine_Query::create()
													->select()
													->from('SerieAudio sa')
													->leftJoin("sa.Languages lgg")
													->where('sa_active = 1')
													->andWhere('id_serie = ?', $id)
													->andWhere('lgg_active = 1');
			$o_audio_series = $q_audio_series->fetchArray();
			
			//Seasons
			$q_seasons_series = Doctrine_Query::create()
													->select()
													->from('Seasons sss')
													->where('sss_active = 1')
													->andWhere('id_serie = ?', $id);
			$o_seasons_series = $q_seasons_series->fetchArray();
			
			
			
			//send to view
	
			
			$this->view->o_seasons_series 		= 	$o_seasons_series;
			
			$this->view->o_audio_series 		= 	$o_audio_series;
			
			$this->view->o_subtitles_series 	= 	$o_subtitles_series;
			
			$this->view->o_genres_series 		= 	$o_genres_series;
			
			$this->view->o_producers_series 	= 	$o_producers_series;
			
			$this->view->o_publishers_series 	= 	$o_publishers_series;
			
			$this->view->o_serie = $o_serie;
			
		}
		else {
			$this->view->o_movie 				= 	null;
		}
		
	}
   

}

