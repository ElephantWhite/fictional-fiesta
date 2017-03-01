<?php
//namespace Repository\AlbumRepository;
class AlbumRepository
{
    /**
     * @param Album $model
     */
    public static function _SaveAlbum($model)
    {
        if ($model->id == null) {
            $album = new Album();
            $album->id = $model->id;
            $album->title = $model->title;
            $album->artist = $model->artist;
            $album->save();
        } else {
            $album = new Album();
            $album->title = $model->title;
            $album->artist = $model->artist;
            $album->save();
        }
        return;
    }


    /**
     * @param $o_album array
     * @throws Exception
     * @return Album $model
     */
    public static function SaveAlbum($o_album)
    {
        if(empty($o_album))
        {
            throw new Exception("AlbumRepository::SaveAlbum: The data-object that was passed along is empty.");
        }

        $model = new Album();

        //$model->id      =   isset($o_album['id'])       ?   $o_album['id']      :   null;
        $model->artist  =   isset($o_album['artist'])   ?   $o_album['artist']  :   null;
        $model->title   =   isset($o_album['title'])    ?   $o_album['title']   :   null;

        if(empty($model->artist))
        {
            throw new Exception("The field 'Artist' can not be empty.");
        }

        if(empty($model->title))
        {
            throw new Exception("The field 'Title' can not be empty.");
        }

        $model->save();
        return $model;
    }

    /**
     * @param array $o_albumMeta
     * @throws Exception
     */
    public static function SaveAlbumMeta($o_albumMeta)
    {
        if(empty($o_albumMeta))
        {
            throw new Exception("AlbumRepository::SaveAlbumMeta: Parameter 'albumMeta' can not be empty.");
        }
        $model = self::LoadAlbumMetaByAlbumId($o_albumMeta['album_id']);
        $model->album_length    =   isset($o_albumMeta['album_length']) ?   $o_albumMeta['album_length']    : null;
        $model->album_id        =   isset($o_albumMeta['album_id'])     ?   $o_albumMeta['album_id']        : null;


        if(empty($model->album_id))
        {
            throw new Exception("Field 'album_id' can not be empty.");
        }

        if(empty($model->album_length))
        {
            throw new Exception("Field 'album_length' can not be empty.");
        }
        $model->save();
        return;
    }

    /**
     * @param $id
     * @return Album
     */
    public static function LoadAlbum($id)
    {
        $o_model = new Album();
        if($id > 0)
        {
            $q_SelectOneAlbum = Doctrine_Query::create()
                ->select()
                ->from("Album alb")
                ->leftJoin("alb.Songs s")
                ->where("alb.id = ?", $id);
            $o_model = $q_SelectOneAlbum->fetchOne();
        }
        return $o_model;
    }

    /**
     * @return array|Doctrine_Collection|Doctrine_Collection_OnDemand|int|mixed
     */
    public static function LoadAllAlbums()
    {
        $q_SelectAlbums = Doctrine_Query::create()
            ->select()
            ->from("Album alb");
        $ar_Albums = $q_SelectAlbums->fetchArray();
        return $ar_Albums;
    }

    public static function LoadAlbumMeta($id)
    {
        if(empty($id))
        {
            throw new Exception("AlbumRepository::LoadAlbumMeta: Parameter 'id' can not be empty.");
        }

        $q_albumMeta = Doctrine_Query::create()
            ->select()
            ->from("AlbumMeta am")
            ->where("am.id = ?", $id);
        $ar_albumMeta = $q_albumMeta->fetchArray();

        $o_albumMeta = new AlbumMeta();
        $o_albumMeta->album_id = $ar_albumMeta['album_id'];
        $o_albumMeta->id = $ar_albumMeta['id'];
        $o_albumMeta->album_length = $ar_albumMeta['album_length'];
        return $o_albumMeta;
    }

    public static function LoadAlbumMetaByAlbumId($album_id)
    {
        if(empty($album_id))
        {
            throw new Exception("Parameter 'album_id' can not be empty.");
        }

        $q_albumMeta = Doctrine_Query::create()
            ->select()
            ->from("AlbumMeta am")
            ->where("am.album_id = ?", $album_id);
        $o_result = $q_albumMeta->fetchOne();
        return $o_result;
    }

    public static function LoadLastAlbumMeta()
    {
        $q_albumMeta = Doctrine_Query::create()
            ->select()
            ->from("AlbumMeta am")
            ->orderBy('album_id DESC')
            ->limit(1);
        $ar_albumMeta = $q_albumMeta->fetchArray();
        var_dump($ar_albumMeta);

        $o_albumMeta = new AlbumMeta();
        $o_albumMeta->album_length = $ar_albumMeta['album_length'];
        $o_albumMeta->id = $ar_albumMeta['id'];
        $o_albumMeta->album_id = $ar_albumMeta['album_id'];
        return $o_albumMeta;
    }

    /**
     * @param $id
     */
    public static function DeleteAlbum($id)
    {
        if(isset($id))
        {
            if($id != null)
            {
                $q_deleteAlbum = Doctrine_Query::create()
                    ->delete('Album alb')
                    ->where('alb.id = ' . $id);
                //Execute the created query.
                $q_deleteAlbum->execute();
                return;
            }
        }
    }
}