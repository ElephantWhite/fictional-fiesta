<?php
/**
 * Definition of the SyncFolderHierarchyDeleteType type
 *
 * @package php-ews
 * @subpackage Types
 */

/**
 * Definition of the SyncFolderHierarchyDeleteType type
 */
class EWSType_SyncFolderHierarchyDeleteType extends EWSType
{
    /**
     * FolderId property
     *
     * @var EWSType_FolderIdType
     */
    public $FolderId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schema = array(
            array(
                'name' => 'FolderId',
                'required' => false,
                'type' => 'FolderIdType',
            ),
        );
    }
}
