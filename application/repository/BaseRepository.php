<?php
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