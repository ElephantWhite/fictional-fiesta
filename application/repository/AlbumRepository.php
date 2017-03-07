<?php
class AlbumRepository
{
    /**
     * @param integer $album_id
     * @return bool|Doctrine_Record|mixed|null
     * @throws Exception
     */
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

    /**
     * @param string $search_string
     * @return array|Doctrine_Collection|Doctrine_Collection_OnDemand|int|mixed
     * @throws Exception
     */
    public static function SearchForAlbum($search_string)
    {
        if(empty($search_string))
        {
            throw new Exception("AlbumRepository::SearchForAlbum: The parameter 'search_string' can not be empty.");
        }
        $s_search_string = "%" . $search_string . "%";
        $q_search = Doctrine_Query::create()
            ->select()
            ->from("Album alb")
            ->where("lower(alb.title) LIKE ? OR lower(alb.artist) LIKE ?", array(strtolower($s_search_string), strtolower($s_search_string)));
        $ar_results = $q_search->fetchArray();
        return $ar_results;
    }
}