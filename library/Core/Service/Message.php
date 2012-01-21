<?php
/**
 *
 * E-mails + social network communications are handled here
 *
 * @author Pascal Maniraho
 * @uses Zend_Mail
 * @version 1.0.0
 * @deprecated
 * @todo should implement Service Abstract
 */


class Core_Service_Message extends Core_Service_Abstract{




	private $mail;
	private $cart;
	private $subject;
	private $options;
	private $message;
	private $isHtml;

	private $email;
	private $pass;
	private $smtp;
	private $destiny;






	/**
	 * helper variables to initialize.
	 * All of these helpers have to be public to allow customization from outside the class
	 */
	public $confirm_helper, $forgot_helper,$history_helper, $invoice_helper, $order_helper,
	$password_helper,$payment_helper, $register_helper,$reset_helper;
		



	public function __construct( $data = array() ){

		/**
		 * checking if there is a mail server[sendmail/postfix] installed, or use gmail by default
		 */
		$this->mail =  new Zend_Mail('UTF-8');/**we are sending emails in utf-8**/
		//trying to use gmail's or other smtp as default mail server
		$_config = Zend_Registry::get('config');
		$this->email = $_config->system->app->notification->email->email;
		$this->pass = $_config->system->app->notification->email->pswd;
		$this->smtp = $_config->system->app->notification->email->smtp;


		// print_r( $email_config );
		/***We have to get this config information from application.ini*/
		$config = array ( 'auth' => 'login', 'username' => $this->email, 'password' => $this->pass,	'ssl' => 'tls',	'port' => '587'	);
			
		$mailTransport = new Zend_Mail_Transport_Smtp($this->smtp,$config);
		$this->mail->setDefaultTransport($mailTransport);

		$this->mail->setFrom($this->email, "");//each and everytime, the system has to be notified
		$this->mail->addCc($this->email, "");//each and everytime, the system has to be notified
		$this->mail->addBcc($this->email, "");




		/**invoice view helper*/
		//$this->invoice_helper = new Core_View_Helper_Invoice();
		/**More view helpers to work with emails*/
		$this->confirm_helper = new Core_View_Helper_Email_Confirm();
		$this->forgot_helper = new Core_View_Helper_Email_Forgot();
		$this->history_helper = new Core_View_Helper_Email_History();
		$this->password_helper = new Core_View_Helper_Email_Password();
		$this->register_helper = new Core_View_Helper_Email_Register();
		$this->reset_helper = new Core_View_Helper_Email_Reset();
			
		/***/
		$this->subject = __CLASS__;
		$this->message = "Thanks";



	}




	/***
	 * This method uses zend_mail to send new generated passwords
	*/
	public function password($options = array () , $npass = "", $isHtml = true ){
		$this->options['email'] = $options['email'] ? $options['email'] : '';
		$this->options['name'] = $options['name'] ? $options['name'] : '';
		$this->options['html'] = $options['html'] = $isHtml;
		if( isset($options['object']) ) $this->subject = $options['object']; else $this->subject = "Password reset - Rentis TM";
		$this->message = $this->password_helper->password($npass, $options );
		return $this->_send();
	}

	
	public function sendUserScheduleNotification(Core_Entity_User $user, Core_Entity_Schedule $schedule){
		$this->options['email'] = $user->email ? $options->email : '';
		$this->options['name'] = $user->name ? $user->name : '';
		$this->options['html'] = $options['html'] = true;
		$this->subject = "Event Schedule Notification - Rentis TM";
		$this->message = "You have a new scheduled activity. Please visit your arentable account for more information";
		return $this->_send();
	}

	public function sendUserBookingNotification( Core_Entity_User $user, Core_Entity_Booking $booking){
		$this->options['email'] = $user->email ? $options->email : '';
		$this->options['name'] = $user->name ? $user->name : '';
		$this->options['html'] = true;
		$this->subject = "Booking Notification - Rentis TM";
		$this->message = "Booking information details is found in your rentable account";
		return $this->_send();
	}

	
	
	/** 
	 * @internal used with contact us
	 */
	public function sendSiteContactMessage( $mixed ){
		$this->subject = "Information Request :: from ".$mixed->name;
		$this->options['email'] = $mixed->email;
		$this->options['name'] = $mixed->name;
		$this->message = $mixed->message;
		return $this->_send();
	}



	/*****************************Following methods are under development, they willl be used to send messages after some events*************************/
	function confirm( $email, $options = array() ){
		if( $options ) $this->options = $options;
		if( isset($options['object']) && !empty($options['object']) ) $this->subject = $options['object'];
		$this->message = $this->confirm_helper->confirm($email, $options );
		return $this->_send();
	}



	/**For a forgotten password, we will be sending this email*/
	function forgot( $email, $options = array() ){
		if( $options ) $this->options = $options;
		if( $options['object'] ) $this->subject = $options['object'];
		$this->message = $this->invoice_helper->invoice($cart, $options );
		return $this->_send();
	}






	/***/
	function register( $email, $options = array() ){
		$this->destiny = $email;
		if( $options ) $this->options = $options;
		if( $options['object'] ) $this->subject = $options['object'];
		$this->message = $this->register_helper->register($email, $options );
		return $this->_send();
	}



	/***/
	function reset( $cart, $options = array() ){
		if( $options ) $this->options = $options;
		if( $options['object'] ) $this->subject = $options['object'];
		$this->message = $this->invoice_helper->invoice($cart, $options );
		return $this->_send();
	}



	/**
	 * This function will check current mode of email transfter and sends the email
	 * Areas that are different on any other method will be callling the proper email view helper, details about object to use and
	 * so on.
	 */
	private  function _send( ){

		if( $this->options['email'] && $this->options['name'] ){
			$this->mail->addTo($this->options['email'], $this->options['name']);
		}
		/**this section has been buggy*/
		$this->mail->clearSubject()->setSubject( $this->subject );
		if ( $this->message ){
			if ( false === $this->isHtml)
			$this->mail->setBodyText($this->message);
			else
			$this->mail->setBodyHtml($this->message);
		}
		/*try to send the message */
		try{ 
			$this->mail->send();
		}catch(Exception $e){
			//Logging should be appealing here 
			return false;
		}
		return true;
	}



	/**
	 */
	public function notification(){
		throw new Exception ( " Not Yet implemented... ");
	}

}
?>