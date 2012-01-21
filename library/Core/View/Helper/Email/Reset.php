<?php




/***
 * 
 * This is the template used to send a reset verification code,  
 * 
 */
class Core_View_Helper_Email_Reset extends Core_View_Helper_Email_Email{
	
	
	
	/***/
	public function reset( $mixed = '', $options = array( 'message' => '', '' => '' )) {
		
		if( $options['password'] ) $this->password = $options['password'];
		if( $options['message'] ) $this->message = $options['message'];
		if( $options['email'] ) $this->email = $options['email'];
		
		$_reset = ''; 
		$_reset .= '<div style=\'width:500px;\'>'; 
			if( $this->message) $_reset .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->message.'</div>';
			if( $this->email) $_reset .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->email.'</div>';
			if( $this->password) $_reset .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->password.'</div>';
		$_reset .= '</div>'; 
		
		return $_reset; 
	}
}

?>