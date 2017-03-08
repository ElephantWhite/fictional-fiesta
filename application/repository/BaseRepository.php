<?php
include __DIR__ . "/AlbumRepository.php";
include __DIR__ . "/SongsRepository.php";
class BaseRepository
{
    /**
     * @param string $_searchQuery
     * @return array
     */
    public static function Search($_searchQuery)
    {
        $albums = AlbumRepository::SearchForAlbum($_searchQuery);
        $songs = SongsRepository::SearchForSong($_searchQuery);
        $result = array('albums' => $albums, 'songs' => $songs);
        return $result;
    }
}