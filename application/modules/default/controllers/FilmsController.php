<?php

require_once 'Zend/Controller/Action.php';

class FilmsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	public function indexAction()
	{
		
		
	}

    public function showAction()
    {
    	$session 		= 	Zend_Session::namespaceGet("micheljonk-session");
		$s_rtp_roletype = 	isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
		$id 			= 	null;
		$params 		= 	$this->getRequest()->getParams();
		if (isset($params['id']) && (is_numeric($params['id'])))
		{
			$id 		= 	$params['id'];
			//Movie Info
			$q_movie = Doctrine_Query::create()
										
												->select()
												->from('Movies mvs')
												->leftJoin('mvs.FilmserieType fst')
												->leftJoin('mvs.Franchises fcs')
												->where('mvs.mvs_active = 1')
												->andWhere('mvs.id_movie = ?', $id);
												
			$o_movie = $q_movie->fetchOne();
			
			//Publishers
			$q_publishers_movies = Doctrine_Query::create()
													->select()
													->from('PublishersHasMovies phm')
													->leftJoin("phm.Publishers pbs")
													->where('phm_active = 1')
													->andWhere('id_movie = ?', $id)
													->andWhere('pbs_active = 1');
			$o_publishers_movies = $q_publishers_movies->fetchArray();
			
			//Producers
			$q_producers_movies = Doctrine_Query::create()
													->select()
													->from('ProducersHasMovies phm')
													->leftJoin("phm.Producers pdr")
													->where('phm_active = 1')
													->andWhere('id_movie = ?', $id)
													->andWhere('pdr_active = 1');
			$o_producers_movies = $q_producers_movies->fetchArray();
			
			//Genres
			$q_genres_movies = Doctrine_Query::create()
													->select()
													->from('MoviesHasGenres mhg')
													->leftJoin("mhg.Genres gnr")
													->where('mhg_active = 1')
													->andWhere('id_movie = ?', $id)
													->andWhere('gnr_active = 1');
			$o_genres_movies = $q_genres_movies->fetchArray();
			
			//Characters
			$q_characters_movies = Doctrine_Query::create()
													->select()
													->from('CharactersHasMovies chm')
													->leftJoin("chm.Characters chr")
													->where('chm_active = 1')
													->andWhere('id_movie = ?', $id)
													->andWhere('chr_active = 1');
			$o_characters_movies = $q_characters_movies->fetchArray();
			
			//Subtitles
			$q_subtitles_movies = Doctrine_Query::create()
													->select()
													->from('MovieSubtitles ms')
													->leftJoin("ms.Languages lgg")
													->where('ms_active = 1')
													->andWhere('id_movie = ?', $id)
													->andWhere('lgg_active = 1');
			$o_subtitles_movies = $q_subtitles_movies->fetchArray();
			
			//Audio
			$q_audio_movies = Doctrine_Query::create()
													->select()
													->from('MovieAudio ma')
													->leftJoin("ma.Languages lgg")
													->where('ma_active = 1')
													->andWhere('id_movie = ?', $id)
													->andWhere('lgg_active = 1');
			$o_audio_movies = $q_audio_movies->fetchArray();
			
			//send to view
			$this->view->o_audio_movies 		= 	$o_audio_movies;
			
			$this->view->o_subtitles_movies 	= 	$o_subtitles_movies;
			
			$this->view->o_characters_movies 	= 	$o_characters_movies;
			
			$this->view->o_genres_movies 		= 	$o_genres_movies;
			
			$this->view->o_producers_movies 	= 	$o_producers_movies;
			
			$this->view->o_publishers_movies 	= 	$o_publishers_movies;
			
			$this->view->o_movie 				= 	$o_movie;
			
		}
		else {
			$this->view->o_movie 				= 	null;
		}
		
		
		
		
		
	}
   

}

