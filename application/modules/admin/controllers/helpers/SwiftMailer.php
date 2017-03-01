<?php

require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';
require_once 'swiftmailer/lib/swift_required.php';

/**
 * ArrayToTable Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_SwiftMailer extends Zend_Controller_Action_Helper_Abstract {
    /**
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    
    /**
     * Constructor: initialize plugin loader
     * 
     * @return void
     */
    public function __construct() {
        // TODO Auto-generated Constructor
        $this->pluginLoader = new Zend_Loader_PluginLoader ();
    }

   public function sendEmail($_title = '', $_body = '', $_from = array(), $_to = array(), $_cc = array(), $_bcc = array(), $_attachment = array())
   {
        $optimit_session = Zend_Session::namespaceGet("optimit-session");
        
        $i_id_company = $optimit_session['id_company'];
        $i_id_organization = $optimit_session['id_organization'];
        $i_id_systemuser = $optimit_session['id_systemuser'];
        
        $s_from_email = '';
        $s_from_name = '';
        $s_mailer = '';
        $s_return_path = '';
        $s_smtp_host = '';
        $s_smtp_port = '';
        $s_encryption = '';
        $s_auth_username = '';
        $s_auth_password = '';
        $s_authentication = '';
        
        $q_company_option = Doctrine_Query::create()
                                            ->select()
                                            ->from("CompanyHasOption ohc")
                                            ->leftJoin("ohc.CompanyOption co")
                                            ->where("co.co_code = 'smtp_information'")
                                            ->andWhere("ohc.id_organization = ?", $i_id_organization)
                                            ->andWhere("ohc.id_company = ?", $i_id_company)
                                            ->andWhere("ohc.ohc_active = 1");
        
        $o_company_option = $q_company_option->fetchOne();
        
        if($o_company_option != null)
        {
            $ar_smtp = unserialize($o_company_option->ohc_value);
            
            $s_from_email       = $ar_smtp['from_email'];
            $s_from_name        = $ar_smtp['from_name'];
            $s_mailer           = $ar_smtp['mailer'];
            $s_return_path      = $ar_smtp['return_path'];
            $s_smtp_host        = $ar_smtp['smtp_host'];
            $s_smtp_port        = $ar_smtp['smtp_port'];
            $s_encryption       = $ar_smtp['encryption'];
            $s_authentication   = $ar_smtp['authentication'];
            $s_auth_username    = $ar_smtp['auth_username'];
            $s_auth_password    = $ar_smtp['auth_password'];
        }
        
        if($s_from_name != '' && $s_from_email != '' )
            $_from = array($s_from_email => $s_from_name);
        
        $transport = Swift_MailTransport::newInstance();
        
        if($s_mailer == 'SMTP')
        {
            $transport = Swift_SmtpTransport::newInstance()
                                                            ->setHost($s_smtp_host)
                                                            ->setPort($s_smtp_port);
            if($s_encryption == 'yes')
            {
                $transport  ->setEncryption($s_encryption);
            }
            
            if($s_authentication == 'yes') {
                $transport  ->setUsername($s_auth_username)
                            ->setPassword($s_auth_password);
            }
        }
        
        $mailer = Swift_Mailer::newInstance($transport);
        
        $_to    = array_filter($_to);
        $_cc    = array_filter($_cc);
        $_bcc   = array_filter($_bcc);

        $message = Swift_Message::newInstance();
        $message->setSubject($_title);
        $message->setFrom($_from);
        $message->setTo($_to);
        
        if(sizeof($_cc) > 0)
            $message->setCc($_cc);
        
        if(sizeof($_bcc) > 0)
            $message->setBcc($_bcc);
        
        $message->setBody($_body, 'text/html', 'iso-8859-2');
        
        if(sizeof($_attachment) > 0)
            $message->attach(Swift_Attachment::newInstance($_attachment[0], $_attachment[1], $_attachment[2]));
        
        if($result = $mailer->send($message))
            return "succes";
        else
            return "failed";
    }  
}

