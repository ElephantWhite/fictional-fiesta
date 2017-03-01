<?php

require_once 'Zend/Controller/Action.php';

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

	public function logoutAction()
	{
		if(isset($_SESSION['admin']))
		{
			session_destroy();
			$this->redirect("/admin");
		}
	}
	
	

	public function indexAction()
    {
    	$session = Zend_Session::namespaceGet("micheljonk-session");
		$s_rtp_roletype = isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
		$this->_helper->layout->disableLayout();
		if(isset($_SESSION['admin'])){
			$this->_redirect("/admin/dashboard");
		}
		if($this->getRequest()->isPost())
		{
			$params = $this->getRequest()->getParams();
			if (isset($params['email_input']) && isset($params['password_input']))
			{
				$q_user = Doctrine_Query::create()
											->select()
											->from("Users usr")
											->where("usr.usr_email = ?", $params['email_input'])
											->andWhere("usr.usr_active = 1")
											->andWhere("usr.usr_is_admin = 1");
				$user 	= $q_user->fetchArray();
				if(sizeof($user) > 0)
				{
					if(password_verify($params['password_input'], $user[0]['usr_password']))
					{
						$_SESSION['admin'] = $user;
						$this->_redirect("/admin/dashboard");
					}
					else {
						$this->view->errorlogin = "Wrong Username/Password";
					}
				}
				else {
					$this->view->errorlogin = "Wrong Username/Password";
				}
				
			}
		}
	}

	public function getsearchboxAction()
	{
   		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$all 	= array();
		$params = $this->getRequest()->getParams();
		
		
		$s_search_textbox = isset($params['term']) ? $params['term'] : '';
		//
		$q_series = Doctrine_Query::create()
													->select()
													->from("Series srs")
													->where("srs.srs_title LIKE ?", '%'.$s_search_textbox.'%');
		$series_temp = $q_series->fetchArray();
		
		foreach($series_temp as $serie)
		{
			array_push($all, array('id' => $serie['id_serie'], 'label' => $serie['srs_title'], 'category' => "Series"));
		}
		//
		$q_movies = Doctrine_Query::create()
													->select()
													->from("Movies mvs")
													->where("mvs.mvs_title LIKE ?", '%'.$s_search_textbox.'%');
		$movies_temp = $q_movies->fetchArray();
		foreach($movies_temp as $movie)
		{
			array_push($all, array('id' => $movie['id_movie'], 'label' => $movie['mvs_title'], 'category' => "Movies"));
		}
		//
		$q_franchises = Doctrine_Query::create()
													->select()
													->from("Franchises fcs")
													->where("fcs.fcs_title LIKE ?", '%'.$s_search_textbox.'%');
		$franchises_temp = $q_franchises->fetchArray();
		foreach($franchises_temp as $franchise)
		{
			array_push($all, array('id' => $franchise['id_franchise'], 'label' => $franchise['fcs_title'], 'category' => "Franchises"));
		}
		//
		$q_characters = Doctrine_Query::create()
													->select()
													->from("Characters chr")
													->where("chr.chr_name LIKE ?", '%'.$s_search_textbox.'%');
		$characters_temp = $q_characters->fetchArray();
		foreach($characters_temp as $character)
		{
			array_push($all, array('id' => $character['id_character'], 'label' => $character['chr_name'], 'category' => "Characters"));
		}
		//
		$q_publishers = Doctrine_Query::create()
													->select()
													->from("Publishers pbs")
													->where("pbs.pbs_name LIKE ?", '%'.$s_search_textbox.'%');
		$publishers_temp = $q_publishers->fetchArray();
		foreach($publishers_temp as $publisher)
		{
			array_push($all, array('id' => $publisher['id_publisher'], 'label' => $publisher['pbs_name'], 'category' => "Publishers"));
		}
		//
		$q_producers = Doctrine_Query::create()
													->select()
													->from("Producers pdr")
													->where("pdr.pdr_name LIKE ?", '%'.$s_search_textbox.'%');
		$producers_temp = $q_producers->fetchArray();
		foreach($producers_temp as $producer)
		{
			array_push($all, array('id' => $producer['id_producer'], 'label' => $producer['pdr_name'], 'category' => "Producers"));
		}
		echo json_encode($all);
   }
   
}

