<?php

require_once 'Zend/Controller/Action.php';

class SorterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	public function indexAction()
	{
		
		
	}
    
    public function testAction()
    {
        
    }
	
    public function showAction()
    {
    	$this->_helper->layout->disableLayout();
		$params = $this->getRequest()->getParams();

			
			if (isset($params['type']))
			{
				$this->view->type 	= 	$params['type'];
				$table 				= 	null;
				$prefix 			= 	null;
				$table_f 			= 	null;
				$id 				= 	null;
				$first_letter 		= 	null;
				if($params['type'] == "movies")
				{
					$table 			=	"Movies";
					$table_f 		=	"Movie";
					$prefix 		=	"mvs";
					$id				=	"id_movie";
					$first_letter 	= 	"m";
					$this->view->type = $table;
				}
				else if($params['type'] == "series")
				{
					$table			=	"Series";
					$table_f		=	"Serie";
					$prefix			=	"srs";
					$id				=	"id_serie";
					$first_letter	=	"s";
					$this->view->type = $table;
				}
				
				if($params['type'] == "series" || $params['type'] == "movies")
				{
					//Franchises
					$q_franchises = Doctrine_Query::create()
															->select()
															->from('Franchises fcs')
															->leftJoin('fcs.' . $table . " " . $prefix)
															->where('fcs.fcs_active = 1')
															->orderBy('fcs.fcs_title');
					$ar_franchises = $q_franchises->fetchArray();
					
					//Publishers
					$q_publishers = Doctrine_Query::create()
															->select()
															->from('Publishers pbs')
															->leftJoin('pbs.' . "PublishersHas" . $table . ' ph' . $first_letter)
															->leftJoin('ph' . $first_letter . "." . $table . " " . $prefix)
															->where('ph' . $first_letter . '.ph' . $first_letter . '_active = 1')
															->orderBy('pbs.pbs_name');
					$ar_publishers = $q_publishers->fetchArray();
				
					
					//Producers
					$q_producers = Doctrine_Query::create()
															->select()
															->from('Producers pdr')
															->leftJoin('pdr.' . "ProducersHas" . $table . ' ph' . $first_letter)
															->leftJoin('ph' . $first_letter . "." . $table . " " . $prefix)
															->where('ph' . $first_letter . '.ph' . $first_letter . '_active = 1')
                                                            ->orderBy('pdr.pdr_name');
					$ar_producers = $q_producers->fetchArray();
					
					//Genres
					$q_genres = Doctrine_Query::create()
															->select()
															->from('Genres gnr')
															->leftJoin('gnr.' . $table . "HasGenres " . $first_letter . 'hg')
															->leftJoin($first_letter . 'hg' . "." . $table . " " . $prefix)
															->where($first_letter . 'hg' . "." . $first_letter . 'hg' .  '_active = 1')
															->orderBy('gnr.gnr_name');
					$ar_genres = $q_genres->fetchArray();
						
					//FilmSerie type
					$q_filmserie_type = Doctrine_Query::create()
															->select()
															->from('FilmserieType fst')
															->leftJoin('fst.' . $table . " " . $prefix)
															->where('fst' . "." . 'fst' .  '_active = 1')
															->orderBy('fst.fst_name');
					$ar_filmserie_type = $q_filmserie_type->fetchArray();
					
					//Subtitles
					$q_subtitles = Doctrine_Query::create()
															->select()
															->from('Languages lgg')
															->leftJoin('lgg.' . $table_f . "Subtitles " . $first_letter . 's')
															->leftJoin($first_letter . 's' . "." . $table . " " . $prefix)
															->where($first_letter . 's' . "." . $first_letter . 's' .  '_active = 1')
															->orderBy('lgg.lgg_name');
					$ar_subtitles = $q_subtitles->fetchArray();
					
					//Audio
					$q_audio = Doctrine_Query::create()
															->select()
															->from('Languages lgg')
															->leftJoin('lgg.' . $table_f . "Audio " . $first_letter . 'a')
															->leftJoin($first_letter . 'a' . "." . $table . " " . $prefix)
															->where($first_letter . 'a' . "." . $first_letter . 'a' .  '_active = 1')
															->orderBy('lgg.lgg_name');
					$ar_audio = $q_audio->fetchArray();
					
					
					
					
					$this->view->ar_franchises 		= 	$ar_franchises;
					$this->view->ar_publishers 		= 	$ar_publishers;
					$this->view->ar_producers 		= 	$ar_producers;
					$this->view->ar_genres 			= 	$ar_genres;
					$this->view->ar_filmserie_type 	= 	$ar_filmserie_type;
					$this->view->ar_subtitles 		= 	$ar_subtitles;
					$this->view->ar_audio 			= 	$ar_audio;
					
				}

				
			}
			
			
		}
		
	
   

}

