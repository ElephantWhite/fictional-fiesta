<?php
class SongsRepository
{
    /**
     * @param int $album_id
     * @return Doctrine_Collection
     * @throws Exception
     */
    public static function LoadSongsPerAlbum($album_id)
    {
        if(empty($album_id))
        {
            throw new Exception("SongsRepository::LoadSongsPerAlbum: Parameter 'album_id' can not be empty.");
        }
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