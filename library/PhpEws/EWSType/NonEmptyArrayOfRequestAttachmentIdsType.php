<?php
/**
 * Definition of the NonEmptyArrayOfRequestAttachmentIdsType type
 *
 * @package php-ews
 * @subpackage Types
 */

/**
 * Definition of the NonEmptyArrayOfRequestAttachmentIdsType type
 */
class EWSType_NonEmptyArrayOfRequestAttachmentIdsType extends EWSType
{
    /**
     * AttachmentId property
     *
     * @var EWSType_RequestAttachmentIdType
     */
    public $AttachmentId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schema = array(
            array(
                'name' => 'AttachmentId',
                'required' => false,
                'type' => 'RequestAttachmentIdType',
            ),
        );
    }
}
