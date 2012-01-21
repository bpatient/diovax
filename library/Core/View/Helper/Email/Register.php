<?php
/**
 * This class will send registration informations to the user. 
 */
class Core_View_Helper_Email_Register extends Core_View_Helper_Email_Email{

	
	
/***/
	public function register( $mixed = '', $options = array( 'message' => '', '' => '' )) {

		
		
		$_register = ''; 
	
		$this->password = isset($options['password']) && $options['password'] ? $options['password'] : "";
		$this->message = isset($options['message']) && $options['message'] ?  $options['message'] : "";
		$this->email = isset($options['email']) && $options['email'] ? $options['email'] : "";
		
		if( $mixed instanceof Core_Model_User ) { $mixed = $mixed->toArray(); } 
		if( is_array($mixed) ) {
			foreach(  $mixed as $k => $value ){
                            $_register .= '<div  style=\'width:500px; float: left; clear: both;\'><div style=\'width:200px; float: left;\'>'.$k.'</div><div style=\'width:200px; float: left;\'>'.$value.'</div></div>';
			}			
			$_register .= '<hr/>';
		} 
		$_register .= '<div style=\'width:500px;\'>'; 
			if( $this->message) $_register .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->message.'</div>';
			if( $this->email) $_register .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->email.'</div>';
			if( $this->password) $_register .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->password.'</div>';
		$_register .= '</div>'; 
		
		return $_register; 
	}
	
}
?>