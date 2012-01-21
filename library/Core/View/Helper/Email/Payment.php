<?php


/***
 * This template will be used to send credit card payment information to admin and client 
 * It takes CreditCard, XML response and options. anything sent from options as 'message' will
 * be displayed as it is in the message section. 
 * 
 * 
 * @todo how can we implement inheritance functionalities this section??? 
 * 
 */

class Core_View_Helper_Email_Payment extends Core_View_Helper_Email_Email{
	
	
	
	
	
	
	
	private $_pmo, $_message, $_isHTML, $_payment, $_options;  
	
	/**The constructor*/
		/**
		 * It takes the payment model object, and additional options 
		 * this obejct will be used to send payment notification.
		 * It will give an idea of the credit card used, amount and the reason of the payment. 
		 * Briefly, it gonna contain gateway payment response. 
		 */
	function __construct( $pmo = null , $options = array() ){
		
		//was  $pmo Models_Payment  
		parent::__construct( );
		
		
		
		/**Payment model object */
		if( !($this->_pmo = $pmo) ) $this->_pmo = new Models_Payment( array( 'time' => date('Y-m-d h:i:s', time())  ) );
		
		
		
		
		/**Initializing the options array*/
		if( !($this->_options = $options) ) $this->_options = array('message' => "");
		/**
		 * Initializing the custom message
		 */                
		if( !($this->_message = $this->_options['message']) ) $this->_message = '';/***/
		/**
		 *initializing html flag  
		 */
		$this->_isHTML = true;
	 	if( isset($this->_options['html']) && ( false === $this->_options['html'] )  ) $this->_isHTML = false;
		
	}
	
	
	/**
	 * Takes the payment object either as an array, or an explicit object
	 * @param mixed | array | Models_Payment $payment_object
	 * @return string $_payment
	 */
	function payment( $mixed_pmo = '' ){
		/**PMO stands for payment model object*/
		if( is_array($mixed_pmo ) ) $mixed_pmo = new Models_Payment( $mixed_pmo );
		if( !($mixed_pmo instanceof Models_Payment) ) throw new Exception( ' Payment Object expected '.__CLASS__ .' :: ' . __METHOD__ .' @ '. __LINE__ .' ');
		/***/
		//if( $mixed_pmo && !$this->_pmo ) $this->_pmo = $mixed_pmo;		
		$this->_pmo = $mixed_pmo;		
		/**html holder file */
		$_payment = '';
		$_to_array = $this->_pmo->toArray();
		foreach ( $_to_array as $k => $value  ){

			
			/*
			if( $k && is_string( $value)  ) $_payment .= '<div style=\'clear: both;\'><div style=\'width: 200px; float: left;\' > '.$k.'</div><div style=\'width: 200px; float: left;\' > '.$value.'</div></div>';
			elseif(  $k && is_object( $value )  &&  $value->card_number ) $_payment .= '<div style=\'clear: both;\' ><div style=\'width: 200px; float: left;\' > '.$k.'</div><div style=\'width:200px; float: left;\' > '.(str_pad(substr($value->card_number, -4), strlen($value->card_number), 'x', STR_PAD_LEFT)).'</div></div>';		
			*/
			if(  $k == 'card_number' ) $value = (str_pad(substr($value, -4), strlen($value), 'x', STR_PAD_LEFT)).'</div></div>';		
			$_payment .= '<div style=\'clear: both;\'><div style=\'width: 200px; float: left;\' > '.$k.'</div><div style=\'width: 200px; float: left;\' > '.$value.'</div></div>';
			
		
		}	

		/**Setting up the message*/
		if( $this->_message ) $_payment = $this->_message ."\n".$_payment; 
		
		return $_payment;
	}
	
	
	
	
	
	
	
	
	
		
		/**
		 * 
		 */
		//if( is_object($pmo) ) $pmo = ( array )$pmo;
		
		/**extracting options in $options array *
		extract($options);//		
		$this->mail->addTo($options['email'], $options['name']);
		$this->mail->setSubject("Payment from Rentis TM");
		*/
		
		/***
		$this->cart = ($options['cart'])?$options['cart']:null;
		if ( $this->cart instanceof Core_Util_Cart ){
			**Invoice view helper*
			$this->message = $this->payment_helper->payment($this->cart); 
		}*/
		
		
		/**New line \n pushes errors when sending messages*/
		/*
		$html = "";
		foreach ( $pmo as $k => $val ):
			
			if( !is_string($val)  ) continue;
			if ( $isHtml ):
				$html .= "<dt>".$k."</dt><dd>".$val."</dd>";
			else:
				$html .= " $k : $val "."\r\n";
			endif;
		endforeach;
		$msg = ( $isHtml )? "<dl>$html</dl>" : $html ;
		$msg .= $this->message ?  $this->message : '';
		if ( false === $isHtml)
			$this->mail->setBodyText($msg);
		else
			$this->mail->setBodyHtml($msg);		
		$this->mail->send();
		*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

?>