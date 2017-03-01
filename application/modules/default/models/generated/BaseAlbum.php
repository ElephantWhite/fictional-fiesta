<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Album', 'doctrine');

/**
 * BaseAlbum
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $artist
 * @property string $title
 * @property Doctrine_Collection $AlbumMeta
 * @property Doctrine_Collection $Songs
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAlbum extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('album');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('artist', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('title', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('AlbumMeta', array(
             'local' => 'id',
             'foreign' => 'album_id'));

        $this->hasMany('Songs', array(
             'local' => 'id',
             'foreign' => 'album_id'));
    }
}