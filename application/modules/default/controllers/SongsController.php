<?php
include "C:/wamp64/www/root3/application/repository/BaseRepository.php";
class SongsController extends Zend_Controller_Action
{
    /**
     * @return void
     */
    function init()
    {
        $session = Zend_Session::namespaceGet("songs_session");
        parent::init();
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->ar_songs = Songs::LoadAllEntities();
    }

    /**
     * @return void
     */
    public function addsongAction()
    {
        $params = $this->getRequest()->getParams();

        if(isset($params['btn_submit']))
        {
            $params['song_title']       =   isset($params['txt_song_title'])    ?       $params['txt_song_title']   :   null;
            $params['song_length']      =   isset($params['txt_song_length'])   ?       $params['txt_song_length']  :   null;
            $params['song_album_id']    =   isset($params['slct_album'])        ?       $params['slct_album']       :   null;

            Songs::SaveEntity($params);
            $this->_redirect("/default/songs/");
        }
    }

    /**
     * @throws Exception
     * @return void
     */
    public function songdetailsAction()
    {
        $params = $this->getRequest()->getParams();

        if(isset($params['id'])) {
            $id = $params['id'];
        }
        else
            $id = null;

        if((empty($id)) or ($id == null))
        {
            throw new Exception("SongsController->songdetailsAction: Parameter 'ID' can not be empty.");
        }

        $song = Songs::LoadEntity($id);
        $album = AlbumRepository::LoadAlbum($song->album_id);
        $this->view->ar_songs = $song;
        $this->view->ar_albums = $album;
    }

    /**
     * @return void
     */
    public function deletesongAction()
    {
        $params = $this->getRequest()->getParams();
        if(isset($params['id']))
        {
            SongsRepository::DeleteSong($params['id']);
        }
        $this->_redirect("/default/songs/index/");
    }

    /**
     * @return void
     */
    public function editsongAction()
    {
        $params = $this->getRequest()->getParams();
        if(isset($params['id']))
        {
            $song = Songs::LoadEntity($params['id']);
            $albums = AlbumRepository::LoadAllAlbums();

            $this->view->ar_song = $song;
            $this->view->ar_albums = $albums;
        }

        $params = $this->getRequest()->getParams();
        if(isset($params['btn_submit']))
        {
            $params['song_id']          =   isset($params['txt_id'])        ?   $params['txt_id']       :   null;
            $params['song_title']       =   isset($params['txt_title'])     ?   $params['txt_title']    :   null;
            $params['song_length']      =   isset($params['txt_length'])    ?   $params['txt_length']   :   null;
            $params['song_album_id']    =   isset($params['slct_album'])    ?   $params['slct_album']   :   null;

            $ar_data = array(
              'song_id' => $params['song_id'],
                'song_title' => $params['song_title'],
                'song_length' => $params['song_length'],
                'song_album_id' => $params['song_album_id']
            );

            Songs::SaveEntity($ar_data);
            $this->_redirect("/default/songs/index/");
        }
    }
}