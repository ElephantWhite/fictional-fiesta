<?php
class SongsRepository
{
    /**
     * @param integer $album_id
     * @return array
     * @throws Exception
     */
    public static function LoadSongsPerAlbum($album_id)
    {
        if(empty($album_id))
        {
            throw new Exception("SongsRepository::LoadSongsPerAlbum: Parameter 'album_id' can not be empty.");
        }
        $o_album = album::LoadEntity($album_id);
        return $o_album->Songs;
    }

    /**
     * @param string $search_string
     * @return array|Doctrine_Collection|Doctrine_Collection_OnDemand|int|mixed
     * @throws Exception
     */
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