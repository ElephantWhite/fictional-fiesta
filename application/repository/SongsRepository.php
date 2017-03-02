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

    public static function SearchForSong($search_string)
    {
        if(empty($search_string))
        {
            throw new Exception("SongsRepository::SearchForSong: The parameter 'search_string' can not be ampty.");
        }

        $s_search_string = "%" . $search_string . "%";
        $q_search = Doctrine_Query::create()
            ->select()
            ->from("Songs s")
            ->where("lower(s.title) LIKE ?", strtolower($s_search_string));
        $ar_results = $q_search->fetchArray();
        return $ar_results;
    }
}