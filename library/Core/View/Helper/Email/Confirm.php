<?php


/**
 * This message template will be sent to the user to check if the user registered with a valid email. 
 * It has to send a key to the user, with a generated key/link so that the user can validate with that kay. 
 * The key should be generated if the user.active is != 1. 
 */
class Core_View_Helper_Email_Confirm extends Core_View_Helper_Email_Email{
	/***/	
	public function confirm( $email, $options = array( 'message' => '',  'key' => '',  'link' => '' ) ){
		$_confirm  = '';
			$_confirm .= '<div style=\'width:500px;\'><h3>Thanks for register</h3><p>Please click on link below to activate or account</p><p>'.$options['link'].'</p></div>';
			/*if( $options['key'] ) $_confirm .= '<div style=\'width:500px;\' >Use this key <strong>'.$options['key'].'</strong> for validation </div>';
			if( $options['link'] ) $_confirm .= '<div style=\'width:500px;\' >Or Click on the following link '.$options['key'].' </div>';
			if( $_confirm  == '' ) 	$_confirm = '<div style=\'width:500px;\' >Confirmation not yet implemented ... '.__CLASS__.' :: '.__METHOD__.' :: '.__LINE__.'</div>';*/
		return $_confirm;
	}





	
}
?>