<?php

require_once 'Zend/Controller/Action.php';

class TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

	public function sendmailAction(){
		$session = Zend_Session::namespaceGet("micheljonk-session");
		$s_rtp_roletype = isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
		$this->_helper->layout->disableLayout();
		$params = $this->getRequest()->getParams();
		$form_send  		= 	isset($params['form_send']) 		? 	$params['form_send'] 			: '';
		$person_name 		= 	isset($params['person_name']) 		? 	$params['person_name'] 			: '';
		$sick_date			= 	isset($params['sick_date'])			?	$params['sick_date']			: '';
		$arbeidsongeschikt	=	isset($params['arbeidsongeschikt'])	?	$params['arbeidsongeschikt']	: '';
		$address			=	isset($params['address'])			?	$params['address']				: '';
		$complaints			=	isset($params['complaints'])		?	$params['complaints']			: '';
		$abscence_time		=	isset($params['abscence_time'])		?	$params['abscence_time']		: '';
		$do_able_work		=	isset($params['do_able_work'])		?	$params['do_able_work']			: '';
		$treated			=	isset($params['treated'])			?	$params['treated']				: '';
		
		$has_payment		=	isset($params['has_payment'])		?	$params['has_payment']			: '';
		$handicapped		=	isset($params['handicapped'])		?	$params['handicapped']			: '';
		$end_contract		=	isset($params['end_contract'])		?	$params['end_contract']			: '';
		$contract_end_date	=	isset($params['contract_end_date'])	?	$params['contract_end_date']	: '';
		$pregnant_donation	=	isset($params['pregnant_donation'])	?	$params['pregnant_donation']	: '';
		$labor_dispute		=	isset($params['labor_dispute'])		?	$params['labor_dispute']		: '';
		$injury				=	isset($params['injury'])			?	$params['injury']				: '';
		$damage_story		=	isset($params['damage_story'])		?	$params['damage_story']			: '';
		
		$phonenumber		=	isset($params['phonenumber'])		?	$params['phonenumber']			: '';
		$email				=	isset($params['email'])				?	$params['email']				: '';
		$workgiver_name		=	isset($params['workgiver_name'])	?	$params['workgiver_name']		: '';
		$contact_name		=	isset($params['contact_name'])		?	$params['contact_name']			: '';
		
		if($phonenumber != '' && $email != '' && $workgiver_name != '' && $contact_name != '' && $person_name != '' && $sick_date != '' && $arbeidsongeschikt != '' && $address != '' && $complaints != '' && 
		$abscence_time != '' && $do_able_work != '' && $treated != '' && $has_payment != '' && $handicapped != '' && 
		$end_contract != '' && $pregnant_donation != '' && $labor_dispute != '' && $injury != '' && $damage_story != '')
		{
			
			$text = <<<EOT
Werknemer: $person_name
Email: $email
Telefoonnummer: $phonenumber
Werkgeversnaam: $workgiver_name
Contactpersoonsnaam: $contact_name
Datum ziekgemeld: $sick_date
Voor $arbeidsongeschikt % arbeidsongeschikt
Adres van werknemer: $address
Klachten gemeld door werknemer: $complaints
Verwachte verzuimduur: $abscence_time
Werkzaamheden dat de werknemer nog kan verrichten: $do_able_work
Heeft de werknemer zich onder behandeling geplaatst: $treated
			
Bijzondere situaties
Heeft/had werknemer en WAO/WAZ/WIA uitkering?: $has_payment
Is/was de werknemer arbeidsgehandicapt?: $handicapped
Eindigt het dienstverband binnenkort?: $end_contract
Zo ja wanneer: $contract_end_date
Is de arbeidsingeschiktheid het gevolg van zwangerschap/bevalling/orgaandonatie?: $pregnant_donation
Is er sprake van arbeidsconflict?: $labor_dispute
Is de arbeidsongeschiktheid veroorzaakt door een (bedrijfs)ongeval?: $injury
Kan de (verzuim)schade verhaald worden (regres)?: $damage_story	
EOT;

			//$text = str_replace("\n", '', $text);
			
			/*$mail = new Zend_Mail();
			$mail->setBodyText($text);
			$mail->setFrom('somebody@example.com', 'Some Sender');
			$mail->addTo('somebody_else@example.com', 'Some Recipient');
			$mail->setSubject('Nieuwe verzuim-melding');
			$mail->send();*/
			echo json_encode(array("result" => "success", "reason" => $text));die;
		}
		else{
			echo json_encode(array("result" => "failed", "reason" => "U heeft niet alles ingevuld"));die;
		}
	}

    public function indexAction()
    {
    	$session = Zend_Session::namespaceGet("micheljonk-session");
		$s_rtp_roletype = isset($session['rtp_roletype']) ? $session['rtp_roletype'] : '';
	}
}

