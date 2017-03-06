<?php
include "C:/wamp64/www/root3/application/repository/AlbumRepository.php";
include "C:/wamp64/www/root3/application/repository/SongsRepository.php";
class BaseRepository
{
    public static function Search($_searchQuery)
    {
        $albums = AlbumRepository::SearchForAlbum($_searchQuery);
        $songs = SongsRepository::SearchForSong($_searchQuery);
        $result = array('albums' => $albums, 'songs' => $songs);
        return $result;
    }
}