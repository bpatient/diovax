<?php

/**
 * This email is sent only once,per transaction 
 * It gives details about what the user bought from our site: 
 * 1. Custom shop message to say thank you to the client. 
 * 2. Ordering information: including billing/shipping addresses/ Grand Total ( including taxes and handling )  
 * 3. Order Summary : 
 * 	  bought items and attributes  
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @todo send get required objects, add html, spaces caption and send hand formatted string to the caller  
 * 
 * 
 */
class Core_View_Helper_Email_Invoice extends Core_View_Helper_Email_Email{

	
	/**
	 * cart and custom messages 
	 */
	private $_message, $_isHTML, $_address, $_options;  
	
	
	
	function __construct( $mixed = null, $options = array( 'message' => '', 'address' => '' , 'html' => false ) ){
		/**
		 * calling the parent constructor 
		 */
		parent::__construct( );
		/**Current cart initialization*/
		
		
		
		/**there is no way to test if $cart in the constructor is instance of Core_Util_Cart  */
		/**Initializing the options array*/
		if( !($this->_options = $options) ) $this->_options = array();
		
		
		/**
		 * Initializing the custom message
		 */
		if( !($this->_message = $this->_options['message']) ) $this->_message = 'No Message';
		
		
		
		/**
		 * In the database, we store addresses as key/value pairs, we have to extract the address and and assign it to 
		 * Model_Address instance  
		 */
		if( !($this->_address  = $this->_options['address'] ) ) $this->_address = new Core_Model_Address( new Core_Entity_Address(array())  ); 

		
		
		
		/**
		 *initializing html flag  
		 */
		$this->_isHTML = true;
	 	if( isset($this->_options['html']) && ( false === $this->_options['html'] )  ) $this->_isHTML = false;
	 	 
	
	 	
		
		
	}
	
	
	
	/***/
	public function invoice( $mixed, $options = array()  ){
		$message = __CLASS__.' NOT IMPLEMENTED';
		return $message;
	}
	

	/**
	 *This private function has to render the address object. 
	 */	
	private function _renderAddress(){ 
		$_address = '';
		if( is_array($this->_address) && !empty($this->_address) ){
			foreach( $this->_address as $k => $address ){
				if( is_array($address) ) $address =  new Models_Address( $address );
 				if( $address instanceof Models_Address )$_address .= $this->_toMicroformat( $address );
			}
		}

		if( $this->_address instanceof Models_Address )$_address .= $this->_toMicroformat( $this->_address );
		return '<div style=\'width: 200px; flaot: left;\' >'.$_address.'</div>'; 
	}
	
	
	
	
	
	/**
	 * Any object passed into this function will be formatted as a microformat 
	 * @tutorial http://en.wikipedia.org/wiki/HCard
	 */
	private function _toMicroformat( Models_Address $address ){
		$_address = '<div class=\'vcard\'>';							 
			$_address .= '<div class=\'fn\'>'.$address->name.'</div>';
			$_address .= '<div class=\'adr\'>';
				$_address .= '<div class=\'street-address\'>'.$address->street.'</div>';
				$_address .= '<div><span class=\'locality\'>'.$address->city.'</span>, <span class=\'region\'>'.$address->prs.'</span>	<span class=\'postal-code\'>'.$address->postal.'</span></div>';
				$_address .= '<div class="country-name">'.$address->country.'</div>';
			$_address .= '</div>';
			$_address .= '<div class=\'tel\' >'.$address->telephone.'</div>';
			$_address .= '</div>';
		return $_address;
	}
	
	
	/**
	 * 
	 */
	private function _renderMessage() { 
			$_message = $this->_message;
			if( $this->_message ) $_message = '<div style=\'width: 200px; flaot: left;\' >'.$this->_message.'</div>'; 
			return $_message; 
	}
	
	
	/**
	 * 
	 */
	private function formatTax( $tax_data ){		
		$ftx = '';
		if( is_array($tax_data) ) { 
			foreach ( $tax_data as $k => $tdata ) $ftx .= '<div style=\'width: 100px; float:left;\'>'.$tdata['class'].'</div><div style=\'clear: right;\'>'.$tdata['rate'].'</div>';	
		}else{
			$ftx = '<div style=\'width: 100px; float:left;\'>Taxes</div>'.$tax_data.'</div>'; 
		}
		return  $ftx;
	}
	
}
?>