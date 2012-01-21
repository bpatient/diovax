<?php



/***
 * the email here will be sent to the user to notify the payement he/she made. 
 */
class Core_View_Helper_Email_Password extends Core_View_Helper_Email_Email{

	
	
	
	
	private $_password, $_message; 
	
	function __construct( $password = "", $options = array() ) {
		
		
		
		parent::__construct();
		
		/*
		 * 
		 * 
		 * how to filter: this is not form the customer, but from the system insted. there is no need to 
		 * filter anything
		 * 
		 * */
		if(  $password != "" && ( is_string($password) && strlen($password) >= 8 ) ){
			$this->_password = $password;
		}
		
	}

	
	/**retuns template to send a new password to the customer */
	function password( $password = "", $options = array() ){




                $options['message'] = isset( $options['message'] ) ? $options['message'] : "";
                $npass  = $password;
		/***/
		if( !$this->_password && $password ) $this->_password = $password;
		if( !$this->_message && $options['message'] ) $this->_message = $options['message'];
		/***/
		$password = '';
		if( $this->_message ) $password .= $this->_message; 
		if( $this->_password )  $password .= $this->_password;
		
		$name  = '';
		if(  $options['name']  ) $name = ' '. $options['name'] . ', ';
		
		$html = 'Dear '. $name. ' your password has been changed to ' . $npass . ' ';
		$msg = ( isset($options['html']) && $options['html'] && (true === $options['html']) )? '<div > '.$html.' </div>' : $html ;
		return $msg.'  '.$password; 
	
	}
	
}
?>