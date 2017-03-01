<?php

require_once 'Zend/Controller/Action.php';

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$session = Zend_Session::namespaceGet("album_session");
		$s_rtp_roletype = isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
		
	}

	public function albumsAction()
    {
        $albums = array();
        $this->_helper->layout->disableLayout();

        $q_albums = Doctrine_Query::create()
            ->select()
            ->from("Album alb");
        $temp_albums = $q_albums->fetchArray();

        foreach($temp_albums as $album)
        {
            array_push($albums, array('id' => $album['id'], 'artist' => $album['artist'], 'title' => $album['title']));
        }
        $this->view->ar_albums = $albums;
    }

    public function albumDetailsAction($id)
    {
        $albums = array();

        $this->_helper->layout->disableLayout();

        $q_albums = Doctrine_Query::create()->select()->from("Album alb")->where('alb.id = ' . $id);
        $temp_albums = $q_albums->fetchArray();

        foreach($temp_albums as $album)
        {
            array_push($albums, array('id' => $album['id'], 'artist' => $album['artist'], 'title' => $album['title']));
        }
        $this->view->ar_albums = $albums;
    }

    public function addAlbumAction(Album $album)
    {

    }

    public function editAlbum($id)
    {

    }

    public function getseriesandfilmsAction()
    {
        $all = array();
        $this->_helper->layout->disableLayout();
        $params = $this->getRequest()->getParams();


        $s_search_textbox = isset($params['term']) ? $params['term'] : '';

        $q_series = Doctrine_Query::create()
            ->select()
            ->from("Series srs")
            ->where("srs.srs_title LIKE ?", '%'.$s_search_textbox.'%')
            ->andWhere('srs.srs_active = 1');
        $series_temp = $q_series->fetchArray();

        foreach($series_temp as $serie)
        {
            array_push($all, array('id' => $serie['id_serie'], 'label' => $serie['srs_title'], 'category' => "Series"));
        }

        $q_movies = Doctrine_Query::create()
            ->select()
            ->from("Movies mvs")
            ->where("mvs.mvs_title LIKE ?", '%'.$s_search_textbox.'%')
            ->andWhere("mvs.mvs_active = 1");
        $movies_temp = $q_movies->fetchArray();
        foreach($movies_temp as $movie)
        {
            array_push($all, array('id' => $movie['id_movie'], 'label' => $movie['mvs_title'], 'category' => "Movies"));
        }
        echo json_encode($all);
    }

    public function serieslistAction()
	{
		$publishers = array();
		$franchises = array();
		$producers 	= array();
		$genres 	= array();
		$types 		= array();
		$subtitles 	= array();
		$audio 		= array();
		
		$this->_helper->layout->disableLayout();
		$params 	= $this->getRequest()->getParams();
        
        $ar_publisher 		= isset($params['publisher']) 		? $params['publisher'] 			: Array();
		$ar_franchise 		= isset($params['franchise']) 		? $params['franchise'] 			: Array();
		$ar_producer 		= isset($params['producer']) 		? $params['producer'] 			: Array();
		$ar_filmserie_type 	= isset($params['filmserie_type']) 	? $params['filmserie_type'] 	: Array();
		$ar_genre 			= isset($params['genre']) 			? $params['genre'] 				: Array();
		$ar_subtitle 		= isset($params['subtitle']) 		? $params['subtitle'] 			: Array();
		$ar_audio 			= isset($params['audio']) 			? $params['audio'] 				: Array();
        $s_search_textbox 	= isset($params['search_textbox']) 	? $params['search_textbox'] 	: '';
    
		if(sizeof($ar_publisher) > 0)
		{
			$q_publishers = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.PublishersHasSeries phs")
													->WhereIn("phs.id_publisher", $ar_publisher)
													->where("srs.srs_active = 1")
													->groupBy('srs.id_serie');
                                                    
			$publishers = $q_publishers->fetchArray();
		}
        if(sizeof($ar_franchise) > 0)
		{
			$q_franchises = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.Franchises fcs")
													->WhereIn("fcs.id_franchise", $ar_franchise)
													->where("fcs.fcs_active = 1")
													->andWhere('srs.srs_active = 1')
													->groupBy('srs.id_serie');
			$franchises = $q_franchises->fetchArray();
		}
		if(sizeof($ar_producer) > 0)
		{
			$q_producers = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.ProducersHasSeries phs")
													->WhereIn("phs.id_producer", $ar_producer)
													->where("srs.srs_active = 1")
													->groupBy('srs.id_serie');
			$producers = $q_producers->fetchArray();
		}
		if(sizeof($ar_genre) > 0)
		{
			$q_genres = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.SeriesHasGenres shg")
													->WhereIn("shg.id_genre", $ar_genre)
													->where("srs.srs_active = 1")
													->groupBy('srs.id_serie');
			$genres = $q_genres->fetchArray();
		}
		if(sizeof($ar_filmserie_type) > 0)
		{
			$q_filmserie_type = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.FilmserieType fst")
													->WhereIn("fst.id_filmserie_type", $ar_filmserie_type)
													->where('srs.srs_active = 1')
													->andWhere("fst.fst_active = 1")
													->groupBy('srs.id_serie');
			$filmserie_type = $q_filmserie_type->fetchArray();
		}
		if(sizeof($ar_subtitle) > 0)
		{
			$q_subtitles = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.SerieSubtitles ss")
													->WhereIn("ss.id_language", $ar_subtitle)
													->where("srs.srs_active = 1")
													->groupBy('srs.id_serie');
			$subtitles = $q_subtitles->fetchArray();
		}
		
		if(sizeof($ar_audio) > 0)
		{
			$q_audio = Doctrine_Query::create()
													->select("srs.id_serie")
													->from("Series srs")
													->leftJoin("srs.SerieAudio sa")
													->WhereIn("sa.id_language", $ar_audio)
													->where("srs.srs_active = 1")
													->groupBy('srs.id_serie');
			$audio = $q_audio->fetchArray();
		}
		
		$ar_temp = array_merge($publishers,$franchises,$producers,$genres, $types, $audio, $subtitles);
        
        $ar_temp = array_unique($ar_temp);
        $q_series = Doctrine_Query::create()
                                            ->select()
                                            ->from('Series srs')
                                            ->where('srs.srs_active = 1')
                                            ->orderBy("srs.srs_title");
					
		if(sizeof($ar_temp) > 0)
        {
            $q_series->andWhereIn("srs.id_serie", $ar_temp);
        }
        
        if($s_search_textbox != '')
            $q_series->andWhere("srs.srs_title LIKE ?", '%'.$s_search_textbox.'%');
		//print_r($q_series->getSqlQuery());die;
		$ar_series = $q_series->fetchArray();
        
		$this->view->ar_series = $ar_series;
		
	}
	
	public function filmlistAction()
	{
		$publishers = array();
		$franchises = array();
		$producers 	= array();
		$genres 	= array();
		$types 		= array();
		$subtitles 	= array();
		$audio 		= array();
		
		$this->_helper->layout->disableLayout();
		$params = $this->getRequest()->getParams();
        
        $ar_publisher 		= isset($params['publisher']) 		? 	$params['publisher'] 		: Array();
		$ar_franchise 		= isset($params['franchise']) 		? 	$params['franchise'] 		: Array();
		$ar_producer 		= isset($params['producer']) 		? 	$params['producer'] 		: Array();
		$ar_filmserie_type 	= isset($params['filmserie_type']) 	? 	$params['filmserie_type'] 	: Array();
		$ar_genre 			= isset($params['genre']) 			? 	$params['genre'] 			: Array();
		$ar_subtitle 		= isset($params['subtitle']) 		? 	$params['subtitle'] 		: Array();
		$ar_audio 			= isset($params['audio']) 			? 	$params['audio'] 			: Array();
        $s_search_textbox 	= isset($params['search_textbox']) 	? 	$params['search_textbox'] 	: '';
    
		if(sizeof($ar_publisher) > 0)
		{
			$q_publishers = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.PublishersHasMovies phm")
													->WhereIn("phm.id_publisher", $ar_publisher)
													->where("mvs.mvs_active = 1")
													->groupBy('mvs.id_movie');
			$publishers = $q_publishers->fetchArray();
		}
        if(sizeof($ar_franchise) > 0)
		{
			$q_franchises = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.Franchises fcs")
													->WhereIn("fcs.id_franchise", $ar_franchise)
													->where("mvs.mvs_active = 1")
													->where("fcs.fcs_active = 1")
													->groupBy('mvs.id_movie');
			$franchises = $q_franchises->fetchArray();
		}
		if(sizeof($ar_producer) > 0)
		{
			$q_producers = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.ProducersHasMovies phm")
													->WhereIn("phm.id_producer", $ar_producer)
													->where("mvs.mvs_active = 1")
													->groupBy('mvs.id_movie');
			$producers = $q_producers->fetchArray();
		}
		if(sizeof($ar_genre) > 0)
		{
			$q_genres = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.MoviesHasGenres mhg")
													->WhereIn("mhg.id_genre", $ar_genre)
													->where("mvs.mvs_active = 1")
													->groupBy('mvs.id_movie');
			$genres = $q_genres->fetchArray();
		}
		if(sizeof($ar_filmserie_type) > 0)
		{
			$q_filmserie_type = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.FilmserieType fst")
													->WhereIn("fst.id_filmserie_type", $ar_filmserie_type)
													->where("mvs.mvs_active = 1")
													->andWhere("fst.fst_active = 1")
													->groupBy('mvs.id_movie');
			$types = $q_filmserie_type->fetchArray();
		}
		if(sizeof($ar_subtitle) > 0)
		{
			$q_subtitles = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.MovieSubtitles ms")
													->WhereIn("ms.id_language", $ar_subtitle)
													->where("mvs.mvs_active = 1")
													->groupBy('mvs.id_movie');
			$subtitles = $q_subtitles->fetchArray();
		}
		
		if(sizeof($ar_audio) > 0)
		{
			$q_audio = Doctrine_Query::create()
													->select("mvs.id_movie")
													->from("Movies mvs")
													->leftJoin("mvs.MovieAudio ma")
													->WhereIn("ma.id_language", $ar_audio)
													->where("mvs.mvs_active = 1")
													->groupBy('mvs.id_movie');
			$audio = $q_audio->fetchArray();
		}
		
		$ar_temp = array_merge($publishers,$franchises,$producers,$genres, $types, $audio, $subtitles);
        
        $ar_temp = array_unique($ar_temp);
        $q_movies = Doctrine_Query::create()
                                            ->select()
                                            ->from('Movies mvs')
                                            ->where('mvs.mvs_active = 1')
                                            ->orderBy("mvs.mvs_title");
					
		if(sizeof($ar_temp) > 0)
        {
            $q_movies->andWhereIn("mvs.id_movie", $ar_temp);
        }
        
        if($s_search_textbox != '')
            $q_movies->andWhere("mvs.mvs_title LIKE ?", '%'.$s_search_textbox.'%');
		//print_r($q_series->getSqlQuery());die;
		$ar_movies = $q_movies->fetchArray();
        
		$this->view->ar_movies = $ar_movies;
	}
	
	public function getfilminfoAction()
	{
		 $this->_helper->layout->disableLayout();
		 $this->_response->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
		 
		 $params = $this->getRequest()->getParams();
        
         $id_film = isset($params['id_film']) ? $params['id_film'] : 0;
		 
		 $q_film = Doctrine_Query::create()
                                            ->select()
                                            ->from('Movies mvs')
                                            ->where('mvs.mvs_active = 1')
                                            ->andWhere('mvs.id_movie = '.$id_film);
            
         $o_film = $q_film->fetchOne();
		 
		 echo Zend_Json::encode(array('result' => "success", 'id_movie' => $o_film['id_movie'], 'mvs_title' => $o_film['mvs_title'], "mvs_description" => $o_film['mvs_description']));die;
	}
	
	public function getserieinfoAction()
	{
		 $this->_helper->layout->disableLayout();
		 $this->_response->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
		 
		 $params = $this->getRequest()->getParams();
        
         $id_serie = isset($params['id_serie']) ? $params['id_serie'] : 0;
		 
		 $q_serie = Doctrine_Query::create()
                                            ->select()
                                            ->from('Series srs')
                                            ->where('srs.srs_active = 1')
                                            ->andWhere('srs.id_serie = '.$id_serie);
            
         $o_serie = $q_serie->fetchOne();
		 echo Zend_Json::encode(array('result' => "success", 'id_serie' => $o_serie['id_serie'], 'srs_title' => $o_serie['srs_title'], "srs_description" => $o_serie['srs_description']));die;
		
	}


}

