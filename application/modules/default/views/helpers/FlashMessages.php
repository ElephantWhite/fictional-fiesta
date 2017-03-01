<?php
/**
 *
 * @author Iwan
 * @version 
 */
require_once 'Zend/View/Helper/Abstract.php';

/**
 * FlashMessenger helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_FlashMessages extends Zend_View_Helper_Abstract {
	
	public $view;
	
	/**
	 * flashMessages function.
	 *
	 * Takes a specially formatted array of flash messages and prepares them
	 * for output.
	 *
	 * SAMPLE INPUT (in, say, a controller):
	 * $this->_flashMessenger->addMessage(array('message' => 'Success message #1', 'status' => 'success'));
	 * $this->_flashMessenger->addMessage(array('message' => 'Error message #1', 'status' => 'error'));
	 * $this->_flashMessenger->addMessage(array('message' => 'Warning message #1', 'status' => 'warning'));
	 * $this->_flashMessenger->addMessage(array('message' => 'Success message #2', 'status' => 'success'));
	 *
	 * SAMPLE OUTPUT (in a view):
	 * <div class="success">
	 * <ul>
	 * <li>Success message #1</li>
	 * <li>Success message #2</li>
	 * </ul>
	 * </div>
	 * <div class="error">Error message #1</div>
	 * <div class="warning">Warning message #2</div>
	 *
	 * @access public
	 * @return string HTML of output messages
	 */
	public function flashMessages() {
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper ( 'FlashMessenger' );
		// Set up some variables, including the retrieval of all flash messages.
		$messages = $flashMessenger->getMessages ();
		
		//add any messages from this request
		if ($flashMessenger->hasCurrentMessages ()) {
			$messages = array_merge ( $messages, $flashMessenger->getCurrentMessages () );
			//we don't need to display them twice.
			$flashMessenger->clearCurrentMessages ();
		}
		$statMessages = array ();
		$output = '';
		
		// If there are no messages, don't bother with this whole process.
		if (count ( $messages ) > 0) {
			// This chunk of code takes the messages (formatted as in the above sample
			// input) and puts them into an array of the form:
			//    Array(
			//        [status1] => Array(
			//            [0] => "Message 1"
			//            [1] => "Message 2"
			//        ),
			//        [status2] => Array(
			//            [0] => "Message 1"
			//            [1] => "Message 2"
			//        )
			//        ....
			//    )
			foreach ( $messages as $message ) {
				if (! array_key_exists ( $message ['status'], $statMessages ))
					$statMessages [$message ['status']] = array ();
				if($message['message']!='')
				//translating the message
				array_push ( $statMessages [$message ['status']], $this->view->translate ( $message ['message'] ) );
				
			}
			
			// This chunk of code formats messages for HTML output (per
			// the example in the class comments).
			foreach ( $statMessages as $status => $messages ) {
				$template = $this->_getTemplate($status);
				$output .= '<div id="message" class="' . $status . '">';
				// If there is only one message to look at, we don't need to deal with
				// ul or li - just output the message into the div.
				if (count ( $messages ) == 1)
					$output .= sprintf($template,$messages [0]);
					
				// If there are more than one message, format it in the fashion of the
				// sample output above.
				else {
					//$output .= '<ul>';
					foreach ( $messages as $message )
						sprintf($template,$message);
						//$output .= '<li>' . $message . '</li>';
					//$output .= '</ul>';
				}
				
				$output .= '</div>';
			}
			//add jQuery effect to hide the message after showing
			$output .= "<script>
						setTimeout(function(){
							$('#message:visible').removeAttr('style').hide().fadeOut();
							}, 5000);
			
						</script>";
			// Return the final HTML string to use.
			return $output;
		}
	
	}
	/**
	 * 
	 * @param $view 
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
	/**
	 * 
	 * @param String $status define the message status
	 * @return String $template returning jquery ui template for the flashmessage
	 */
	public function _getTemplate($status){
		$template = '';
		switch($status){
			case "error":
			case "warning": $template = '
                                <div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;"> 
                                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span> 
                                        %s</p>
                                </div>';
			break;	
			default: $template = '
                                <div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em;"> 
                                        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.3em;"></span> 
                                        %s</p>
                                </div>'; 	
		}
		return $template;
	}
}


