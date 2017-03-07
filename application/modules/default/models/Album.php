<?php

/**
 * Album
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Album extends BaseAlbum
{
    /**
     * @param integer $id
     * @return Doctrine_Collection|Doctrine_Collection_OnDemand|Doctrine_Record|int|mixed|null
     * @throws Exception
     */
    public static function LoadEntity($id)
    {
        $albumTable = Doctrine_Core::getTable('Album');
        $album = $albumTable->find($id);
        if($album == null || !isset($album))
        {
            throw new Exception("Album::LoadEntity: Couldn't load the entity with the given identifier.");
        }
        return $album;
    }

    /**
     * @return array|Doctrine_Collection|Doctrine_Collection_OnDemand|int|mixed
     */
    public static function LoadAllEntities()
    {
        $q_albums = Doctrine_Query::create()
            ->select()
            ->from("Album alb");
        $albums = $q_albums->fetchArray();

        return $albums;
    }

    /**
     * @param array $o_album
     * @throws Exception
     */
    public static function SaveEntity($o_album)
    {
        if(empty($o_album))
        {
            throw new Exception("Songs::SaveEntity: The object passed to the function is empty.");
        }

        $album_id = empty($o_album['album_id']) ? null : $o_album['album_id'];
        $album_title = empty($o_album['album_title']) ? null : $o_album['album_title'];
        $album_artist = empty($o_album['album_artist']) ? null : $o_album['album_artist'];
        $album_length = empty($o_album['album_length']) ? null : $o_album['album_length'];


        if(empty($album_title))
        {
            throw new Exception("Album::SaveEntity: Album title can not be empty.");
        }
        if(empty($album_length))
        {
            throw new Exception("Album::SaveEntity: Album length can not be empty.");
        }
        if(empty($album_artist))
        {
            throw new Exception("Album::SaveEntity: Album artist can not be empty.");
        }

        $model = new Album();
        $meta = new AlbumMeta();
        if(isset($o_album['album_id']))
        {
            $model = self::LoadEntity($album_id);
            $meta = $model->AlbumMeta;
        }

        $model->title = $album_title;
        $model->artist = $album_artist;

        $meta->album_length = $album_length;
        $meta->save();

        $meta = AlbumMeta::LoadLastEntity();

        if(empty($model->album_meta_id))
            $model->album_meta_id = $meta->id;

        $model->save();
    }

    /**
     * @param integer $album_id
     * @throws Exception
     */
    public static function DeleteAlbum($album_id)
    {

        $id = empty($id) ? $album_id : null;

        if(empty($id))
        {
            throw new Exception("Album::DeleteAlbum: The identifier can not be empty.");
        }

        $q_delete_album = Doctrine_Query::create()
            ->delete()
            ->from("Album al")
            ->where("al.id = ?", $id);
        $q_delete_album->execute();
        return;
    }
}