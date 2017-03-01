<?php
class SongsRepository
{
    /**
     * Returns all songs in the format Array[Songs]
     * Returning an array of entities.
     *
     * @return array $songs
     */
    public static function LoadAllSongs()
    {
        $songs = array();

        $q_songs = Doctrine_Query::create()
            ->select()
            ->from("Songs s");
        $ar_songs = $q_songs->fetchArray();

        foreach ($ar_songs as $song)
        {
            $_song = new Songs();
            $_song->id = $song['id'];
            $_song->album_id = $song['album_id'];
            $_song->length = $song['length'];
            $_song->title = $song['title'];
            array_push($songs, $_song);
        }
        return $songs;
    }

    /**
     * @param $id
     * @return bool|Doctrine_Record|mixed|null
     * @throws Exception
     * @return Songs $song
     */
    public static function LoadSong($id)
    {
        if(empty($id))
        {
            throw new Exception("SongRepository::LoadSong: Identifier can not be empty.");
        }
        $q_songs = Doctrine_Query::create()
            ->select()
            ->from("Songs s")
            ->where("id = ?", $id);
        $song = $q_songs->fetchOne();
        return $song;
    }

    /**
     * @param array $ar_data
     * @return void
     * @throws Exception
     */
    public static function SaveSong(array $ar_data)
    {
        if(empty($ar_data))
        {
            throw new Exception("SongRepository::SaveSong: Parameter 'ar_data' can not be empty.");
        }
        $model = new Songs();

        if(isset($ar_data['id']))
        {
            $model = self::LoadSong($ar_data['id']);
        }

        $model->album_id = $ar_data['album'];
        $model->title = $ar_data['title'];
        $model->length = $ar_data['length'];

        $model->save();
    }

    /**
     * @param int $album_id
     * @return array
     * @throws Exception
     */
    public static function LoadSongsPerAlbum($album_id)
    {
        if(empty($album_id))
        {
            throw new Exception("SongsRepository::LoadSongsPerAlbum: Parameter 'album_id' can not be empty.");
        }

        /*$q_albumSongs = Doctrine_Query::create()
            ->select()
            ->from("Songs s")
            ->where("s.album_id = ?", $album_id);
        $ar_temp_songs = $q_albumSongs->fetchArray();

        $ar_songs = array();

        foreach($ar_temp_songs as $song)
        {
            $_song = new Songs();
            $_song->id = $song['id'];
            $_song->title = $song['title'];
            $_song->album_id = $song['album_id'];
            $_song->length = $song['length'];
            array_push($ar_songs, $_song);
        }*/

        $o_album = AlbumRepository::LoadAlbum($album_id);
        return $o_album->Songs;
    }

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
    public static function DeleteSong($id)
    {
        if((empty($id)) or ($id == null or 0))
        {
            throw new Exception("SongsRepository::DeleteSong: parameter 'id' can not be empty.");
        }

        $q_deleteSong = Doctrine_Query::create()
            ->delete()
            ->from("Songs s")
            ->where("s.id = ?", $id);
        $q_deleteSong->execute();
        return;
    }
}