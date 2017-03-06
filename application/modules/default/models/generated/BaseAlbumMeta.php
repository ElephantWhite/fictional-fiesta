<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AlbumMeta', 'doctrine');

/**
 * BaseAlbumMeta
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $album_length
 * @property Doctrine_Collection $Album
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAlbumMeta extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('album_meta');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('album_length', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Album', array(
             'local' => 'id',
             'foreign' => 'album_meta_id'));
    }
}