<?php



/***
 * 
 * 
 * 
 * This class will be used to notify the user on anything changing on his/her order 
 * including status, ( eg, when item has been shipped, reviewed, closed, ... ) 
 */

class Core_View_Helper_Email_Order extends Core_View_Helper_Email_Email{
	

	
	
	/***
	 * 
	 */
	function __construct( ){
		parent::__construct();
	}
	
	/**
	 * This function takes the order object, and formats and sends updates to the customer. 
	 */	
	function order( $order = '', $options = array( 'message' => '') ){
		$_confirm = '<div style=\'width:;\' >Confirmation not yet implemented ... '.__CLASS__.' :: '.__METHOD__.' :: '.__LINE__.'</div>';
		return $_confirm;
	}
	
	


	

}

?>