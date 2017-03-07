<?php
include "C:/wamp64/www/root3/application/repository/BaseRepository.php";
class AlbumController extends Zend_Controller_Action
{
    /**
     * @return void
     */
    public function init()
    {
        $session = Zend_Session::namespaceGet("album_session");
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        $albums = array();
        $q_albums = Doctrine_Query::create()
            ->select()
            ->from("Album alb");
        $temp_albums = $q_albums->fetchArray();

        foreach($temp_albums as $album)
        {
            array_push($albums, array('id' => $album['id'],
                'artist' => $album['artist'],
                'title' => $album['title']));
        }
        $this->view->ar_albums = $albums;
    }

    /**
     * @return void
     */
    public function editalbumAction()
    {
        $params = $this->getRequest()->getParams();
        if(!isset($params['btn_submit']))
            $this->view->ar_album = Album::LoadEntity($params['id']);

        if(isset($params['btn_submit']))
        {
            $o_album = array();
            $o_album['album_id'] = empty($params['txt_id']) ? null : $params['txt_id'];
            $o_album['album_artist'] = empty($params['txt_artist']) ? null : $params['txt_artist'];
            $o_album['album_title'] =  empty($params['txt_title']) ? null : $params['txt_title'];
            $o_album['album_length'] =  empty($params['txt_album_length']) ? null : $params['txt_album_length'];

            Album::SaveEntity($o_album);
            $this->_redirect("/default/album/index");
        }
    }

    /**
     * @return void
     */
    public function deletealbumAction()
    {
        $params = $this->getRequest()->getParams();
        if (isset($params['id']))
        {
            Album::DeleteAlbum($params['id']);
        }
        $this->_redirect("/default/album/index/");
    }

    /**
     * @return void
     */
   public function addalbumAction()
   {

       $params = $this->getRequest()->getParams();
       if(isset($params['btn_submit']))
       {
           $params['album_id']            = isset($params['txt_id'])              ? $params['txt_id']             : null;
           $params['album_title']         = isset($params['txt_title'])           ? $params['txt_title']          : null;
           $params['album_artist']        = isset($params['txt_artist'])          ? $params['txt_artist']         : null;
           $params['album_length']        = isset($params['txt_album_length'])    ? $params['txt_album_length']   : null;

           $o_album = array(
               'album_id' => $params['album_id'],
               'album_title' => $params['album_title'],
               'album_artist' => $params['album_artist'],
               'album_length' => $params['album_length']
           );

           Album::SaveEntity($o_album);
           $this->_redirect("/default/album/index/");
       }
   }

    /**
     * @return void
     */
    public function albumdetailsAction()
    {
        $params = $this->getRequest()->getParams();
        $id = empty($params['id']) ? null : $params['id'];
        $album = Album::LoadEntity($id);
        $albums = array( 0 => $album);

        $this->view->ar_songs = SongsRepository::LoadSongsPerAlbum($id);
        $this->view->ar_albums = $albums;
    }
}