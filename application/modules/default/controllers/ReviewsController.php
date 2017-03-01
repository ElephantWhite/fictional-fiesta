<?php

require_once 'Zend/Controller/Action.php';

class ReviewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	public function indexAction()
	{
		
		
	}
	
	
	
	public function postAction()
	{
		$this->_helper->layout->disableLayout();
		
		$params 			= 	$this->getRequest()->getParams();
		$checkLogin 		= 	$this->_helper->getHelper('CheckLogin');
		$checkReviewExists 	= 	$this->_helper->getHelper('CheckReviewExists');
		$title 				= 	isset($params['title']) 		? 	$params['title'] 		: '';
		$content 			= 	isset($params['content']) 		? 	$params['content'] 		: '';
		$rating 			= 	isset($params['rating']) 		? 	$params['rating'] 		: '';
		$id_serie 			= 	isset($params['id_serie']) 		? 	$params['id_serie'] 	: '';
		$id_season 			= 	isset($params['id_season']) 	? 	$params['id_season'] 	: '';
		$id_episode 		= 	isset($params['id_episode']) 	? 	$params['id_episode'] 	: '';
		$id_movie 			= 	isset($params['id_movie']) 		? 	$params['id_movie'] 	: '';
		
    	if($checkLogin->CheckLogin())
		{
			if($title != '' && $content != '' && $rating != '')
			{
				if(!$checkReviewExists->checkreviewexists($_SESSION['user'][0]['id_user'], array("id_serie" => $id_serie, "id_season" => $id_season, "id_episode" => $id_episode, "id_movie" => $id_movie)))
				{
					$review = new Reviews();
						$review->id_user 		= 	$_SESSION['user'][0]['id_user'];
						$review->rvw_title 		= 	$title;
						$review->rvw_content 	= 	$content;
						$review->rvw_grade 		= 	$rating;
					if($params['id_episode'] != '')
					{
						$review->epd_id_season 	= 	$id_season;
						$review->epd_id_serie 	= 	$id_serie;
						$review->epd_id_episode = 	$id_episode;
					}
					else if($params['id_movie'] == '')
					{
						$review->sss_id_serie 	= 	$id_serie;
						$review->sss_id_season 	= 	$id_season;
					}
					else {
						$review->mvs_id_movie 	= 	$id_movie;
					}
						$review->save();
				}
			}
		}

	}
	
    public function showAction()
    {
    	$this->_helper->layout->disableLayout();
		$q_reviews = null;
		$reviewtype = null;
		$offset = 0;
		$dialog = 0;
		$params = $this->getRequest()->getParams();

			if(isset($params['offset']) && is_numeric($params['offset']))
			{
				$offset = $params['offset'];
			}
			if(isset($params['dialog']) && is_numeric($params['dialog']))
			{
				
				$dialog = $params['dialog'];
			}
			
			$this->view->dialog = $dialog;
			
			if (isset($params['idserie']) && is_numeric($params['idserie']) && isset($params['idseason']) && is_numeric($params['idseason']) && isset($params['idepisode']) && is_numeric($params['idepisode']))
			{
				//Reviews
				$q_reviews = Doctrine_Query::create()
														->select()
														->from('Reviews rvw')
														->leftJoin('rvw.Users usr')
														->where('rvw.rvw_active = 1')
														->andWhere('epd_id_serie = ?', $params['idserie'])
														->andWhere('epd_id_season = ?', $params['idseason'])
														->andWhere('epd_id_episode = ?', $params['idepisode'])
														->limit(10)
														->offset($offset);
				$ar_reviews = $q_reviews->fetchArray();
				
			
				
				$reviewtype = "episodes";
				$this->view->review_id_serie 	= 	$params['idserie'];
				$this->view->review_id_season 	= 	$params['idseason'];
				$this->view->review_id_episode 	= 	$params['idepisode'];
							
			}
			else if(isset($params['idserie']) && is_numeric($params['idserie']) && isset($params['idseason']) && is_numeric($params['idseason']))
			{
				//Reviews
				$q_reviews = Doctrine_Query::create()
														->select()
														->from('Reviews rvw')
														->leftJoin('rvw.Users usr')
														->where('rvw.rvw_active = 1')
														->andWhere('sss_id_serie = ?', $params['idserie'])
														->andWhere('sss_id_season = ?', $params['idseason'])
														->limit(10)
														->offset($offset);
				$ar_reviews = $q_reviews->fetchArray();
				$reviewtype = "seasons";
				
				$this->view->review_id_serie 	= 	$params['idserie'];
				$this->view->review_id_season 	= 	$params['idseason'];
			}
			else if(isset($params['idmovie']) && is_numeric($params['idmovie']))
			{
				//Reviews
				$q_reviews = Doctrine_Query::create()
														->select()
														->from('Reviews rvw')
														->leftJoin('rvw.Users usr')
														->where('rvw.rvw_active = 1')
														->andWhere('mvs_id_movie = ?', $params['idmovie'])
														->limit(10)
														->offset($offset);
				$ar_reviews 					= 	$q_reviews->fetchArray();
				$reviewtype 					= 	"movies";
				$this->view->review_id_movie 	= 	$params['idmovie'];
			}
			else {
				
				$this->view->ar_reviews 	= 	null;
			}	
			
				$this->view->review_type 	= 	$reviewtype;
				$this->view->ar_reviews 	= 	$ar_reviews;
			
			}
		
	
   

}

