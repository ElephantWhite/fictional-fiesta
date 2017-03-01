<?php
include "C:/wamp64/www/root3/application/repository/SongsRepository.php";
include "C:/wamp64/www/root3/application/repository/AlbumRepository.php";
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
        $this->view->ar_songs = SongsRepository::LoadAllSongs();
    }

    /**
     * @return void
     */
    public function addsongAction()
    {
        $params = $this->getRequest()->getParams();

        if(isset($params['btn_submit']))
        {
            $params['title']    =   isset($params['txt_song_title'])    ?       $params['txt_song_title']   :   null;
            $params['length']   =   isset($params['txt_song_length'])   ?       $params['txt_song_length']  :   null;
            $params['album']    =   isset($params['slct_album'])        ?       $params['slct_album']       :   null;

            SongsRepository::SaveSong($params);
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

        $song = SongsRepository::LoadSong($id);
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
            $song = SongsRepository::LoadSong($params['id']);
            $albums = AlbumRepository::LoadAllAlbums();

            $this->view->ar_song = $song;
            $this->view->ar_albums = $albums;
        }

        $params = $this->getRequest()->getParams();
        if(isset($params['btn_submit']))
        {
            $params['id']       =   isset($params['txt_id'])        ?   $params['txt_id']       :   null;
            $params['title']    =   isset($params['txt_title'])     ?   $params['txt_title']    :   null;
            $params['length']   =   isset($params['txt_length'])    ?   $params['txt_length']   :   null;
            $params['album']    =   isset($params['slct_album'])    ?   $params['slct_album']   :   null;

            $ar_data = array(
              'id' => $params['id'],
                'title' => $params['title'],
                'length' => $params['length'],
                'album' => $params['album']
            );

            SongsRepository::SaveSong($ar_data);
            $this->_redirect("/default/songs/index/");
        }
    }
}