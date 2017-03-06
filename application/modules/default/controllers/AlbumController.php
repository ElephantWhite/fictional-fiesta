<?php
include "C:/wamp64/www/root3/application/repository/BaseRepository.php";
class AlbumController extends Zend_Controller_Action
{
    /**
     * Init the controller. Get a zend session. I have no clue why but I did it anyway because the example did as well.
     *
     * @return void
     */
    public function init()
    {
        $session = Zend_Session::namespaceGet("album_session");
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * Show all albums on the index page.
     *
     * @return void
     */
    public function indexAction()
    {
        //create an array to store albums.
        $albums = array();
        //$this->_helper->layout->disableLayout();

        //create a query to select all albums
        $q_albums = Doctrine_Query::create()
            ->select()
            ->from("Album alb");
        //Store all albums in a temporary variable.
        $temp_albums = $q_albums->fetchArray();

        //make an actual array for all albums in the temporary albums variable.
        foreach($temp_albums as $album)
        {
            //insert every album in the temp albums variable to the actual array
            array_push($albums, array('id' => $album['id'],
                'artist' => $album['artist'],
                'title' => $album['title']));
        }
        // pass the albums to the view
        $this->view->ar_albums = $albums;
    }

    /**
     * Edit the selected album and return to /album/index/ when done
     *
     * @return void
     */
    public function editalbumAction()
    {
        //Get request parameters (POST/GET)
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
     * Delete the selected album from the database.
     *
     * @return void
     *
     */
    public function deletealbumAction()
    {
        $params = $this->getRequest()->getParams();
        if(isset($params['conf']))
        {
            if ($params['conf'] == true)
            {
                if (isset($params['id']))
                {
                    AlbumRepository::DeleteAlbum($params['id']);
                }
                $this->_redirect("/default/songs/index/");
            }
        }
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
               'id' => $params['album_id'],
               'title' => $params['album_title'],
               'artist' => $params['album_artist'],
               'album_length' => $params['album_length']
           );

           Album::SaveEntity($o_album);
           $this->_redirect("/default/album/index/");
       }
   }


    /**
     * Show ALL the details of the selected album, including the album metadata.
     *
     * @return void
     *
     */
    public function albumdetailsAction()
    {
        //Get request parameters from POST and GET.
        $params = $this->getRequest()->getParams();
        $id = isset($params['id']) ? $params['id'] : 0;
        $albums = array();

        $q_albums = Doctrine_Query::create()
            ->from("Album alb")
            ->leftJoin("alb.AlbumMeta am")
            ->orderBy('id')
            ->where('alb.id = ' . $id);

        $temp_albums = $q_albums->fetchArray();

        foreach($temp_albums as $album)
        {
            if($album['AlbumMeta']['album_length'] == null)
            {
                $album['AlbumMeta']['album_length'] = 0;
            }
            array_push($albums, array('id' => $album['id'],
                'artist' => $album['artist'],
                'title' => $album['title'],
                'album_length' => $album['AlbumMeta']['album_length']));
        }
        $this->view->ar_songs = SongsRepository::LoadSongsPerAlbum($id);
        $this->view->ar_albums = $albums;
    }
}