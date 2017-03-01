<?php
/**
 *
 * @author Siebe
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * SplitElement helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_SplitElement {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
    /**
     * returns an array containing the element's 
     * body, label and error messages
     *
     * @param Zend_Form_Element $element
     * @return array
     */
    public function splitElement(Zend_Form_Element $element) {
        $result = array();
        $result['body'] = $element->getView()->{$element->helper}(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
 
        $result['label'] = $element->getLabel();
        $result['messages'] = $element->getMessages();
 
        return $result;
    }
		
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

