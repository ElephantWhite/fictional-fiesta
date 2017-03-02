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

        //Only try to edit something if there is an identifier.
        if(isset($params['id'])) {
            //Get the current data for the selected album to edit.
            $q_album = Doctrine_Query::create()
                ->select()
                ->from('Album alb')
                ->leftJoin("alb.AlbumMeta am")
                ->where('alb.id = ' . $params['id']);
            $ar_album = $q_album->fetchArray();
            foreach($ar_album as $album)
            {
                $album['album_length'] = $album['AlbumMeta'][0]['album_length'];
                if($album['album_length'] == null)
                {
                    $album['album_length'] = 0;
                }
            }
            //Return the selected album.
            $this->view->ar_albums = $ar_album;
        }
        //Get the parameters of the current request.
        $params = $this->getRequest()->getParams();
        //Only edit if there is something to edit. If either of there parameters are missing, something went wrong.
        if((isset($params['txt_title'])) && (isset($params['txt_artist'])) && (isset($params['txt_album_length'])))
        {
            //Create a new entity to save data to, and set data.
            $model = new Album();
            $model_meta = new AlbumMeta();
            $model->id = isset($params['txt_id']) ? $params['txt_id'] : null;
            $model->artist = isset($params['txt_artist']) ? $params['txt_artist'] : null;
            $model->title = isset($params['txt_title']) ? $params['txt_title'] : null;
            $model_meta->album_id = isset($params['txt_id']) ? $params['txt_id'] : null;
            $model_meta->album_length = isset($params['txt_album_length']) ? $params['txt_album_length'] : null;
            //Create the query to update the selected album.
            $q_updateAlbum = Doctrine_Query::create()
                ->update("Album alb")
                ->set('artist', '?', $model->artist)
                ->set('title', '?', $model->title)
                ->where('id = ?', $model->id);
            //Execute the created query.
            $q_updateAlbum->execute();

            $q_UpdateAlbumMeta = Doctrine_Query::create()
                ->update("AlbumMeta am")
                ->set('album_length', '?', $model_meta->album_length)
                ->where('album_id = ?', $model_meta->album_id);
            $q_UpdateAlbumMeta->execute();
            //Return to the index page.
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
        //Get request parameters from POST and GET to get an identifier to delete an album.
        $params = $this->getRequest()->getParams();
        //Check if there is an identifier, if not an album can't be deleted.
        if(isset($params['id']))
        {
            AlbumRepository::DeleteAlbum($params['id']);
            $this->_redirect("/default/album/index");
        }
        else
        {
            //Inform the user that no album was selected.
            echo "No album was selected.";
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
           $params['id']            = isset($params['txt_id'])              ? $params['txt_id']             : null;
           $params['title']         = isset($params['txt_title'])           ? $params['txt_title']          : null;
           $params['artist']        = isset($params['txt_artist'])          ? $params['txt_artist']         : null;
           $params['album_length']  = isset($params['txt_album_length'])    ? $params['txt_album_length']   : null;

           $o_album = array(
               'id' => $params['id'],
               'title' => $params['title'],
               'artist' => $params['artist'],
               'album_length' => $params['album_length']
           );

           $o_album = AlbumRepository::SaveAlbum($o_album);

           $o_album_meta = array(
               'album_id' => $o_album->id,
               'album_length' => $params['album_length'],
           );
           AlbumRepository::SaveAlbumMeta($o_album_meta);
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
            if($album['AlbumMeta'][0]['album_length'] == null)
            {
                $album['AlbumMeta'][0]['album_length'] = 0;
            }
            array_push($albums, array('id' => $album['id'],
                'artist' => $album['artist'],
                'title' => $album['title'],
                'album_length' => $album['AlbumMeta'][0]['album_length']));
        }
        $this->view->ar_songs = SongsRepository::LoadSongsPerAlbum($id);
        $this->view->ar_albums = $albums;
    }
}