<?php

/**
 * Songs
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Songs extends BaseSongs
{

    /**
     * @param integer $id
     * @return Doctrine_Collection|Doctrine_Collection_OnDemand|Doctrine_Record|int|mixed|null
     * @throws Exception
     */
    public static function LoadEntity($id)
    {
        $songsTable = Doctrine_Core::getTable('Songs');
        $song = $songsTable->find($id);
        if($song == null || !isset($song))
        {
            throw new Exception("Songs::LoadEntity: Couldn't load the entity with the given identifier.");
        }
        return $song;
    }

    /**
     * @return array|Doctrine_Collection|Doctrine_Collection_OnDemand|int|mixed
     */
    public static function LoadAllEntities()
    {
        $q_songs = Doctrine_Query::create()
            ->select()
            ->from("Songs s");
        $songs = $q_songs->fetchArray();

        return $songs;
    }


    /**
     * @param array $o_song
     * @throws Exception
     */
    public static function SaveEntity($o_song)
    {
        if(empty($o_song))
        {
            throw new Exception("Songs::SaveEntity: The object passed to the function is empty.");
        }

        $song_id = empty($o_song['song_id']) ? null : $o_song['song_id'];
        $song_title = empty($o_song['song_title']) ? null : $o_song['song_title'];
        $song_length = empty($o_song['song_length']) ? null : $o_song['song_length'];
        $song_album_id = empty($o_song['song_album_id']) ? null : $o_song['song_album_id'];

        if(empty($song_title))
        {
            throw new Exception("Songs::SaveEntity: Song title can not be empty.");
        }
        if (empty($song_length))
        {
            throw new Exception("Songs::SaveEntity: Song length can not be empty.");
        }
        if(empty($song_album_id))
        {
            throw new Exception("Songs:SaveEntity: Song must be linked to an album. (Album id is empty)");
        }

        $model = new Songs();

        if(isset($o_song['song_id']))
        {
            $model = self::LoadEntity($o_song['song_id']);
        }

        $model->title = $song_title;
        $model->length = $song_length;
        $model->album_id = $song_album_id;

        $model->save();
    }

    /**
     * @param integer $song_id
     * @throws Exception
     */
    public static function DeleteSong($song_id)
    {

        $id = empty($id) ? $song_id : null;

        if(empty($id))
        {
            throw new Exception("Songs::DeleteSong: The identifier can not be empty.");
        }

        $q_delete_song = Doctrine_Query::create()
            ->delete()
            ->from("Songs s")
            ->where("s.id = ?", $id);
        $q_delete_song->execute();
        return;
    }
}