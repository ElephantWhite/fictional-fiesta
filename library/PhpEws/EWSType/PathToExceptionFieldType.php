<?php
/**
 * Definition of the PathToExceptionFieldType type
 *
 * @package php-ews
 * @subpackage Types
 */

/**
 * Definition of the PathToExceptionFieldType type
 */
class EWSType_PathToExceptionFieldType extends EWSType
{
    /**
     * FieldURI property
     *
     * @var EWSType_ExceptionPropertyURIType
     */
    public $FieldURI;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schema = array(
            array(
                'name' => 'FieldURI',
                'required' => false,
                'type' => 'ExceptionPropertyURIType',
            ),
        );
    }
}
