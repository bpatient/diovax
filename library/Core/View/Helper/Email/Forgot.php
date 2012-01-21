<?php
/**
 * Review this view helper before use. 
 * Its supposed return a formatted email template. 
 */
class Core_View_Helper_Email_Forgot extends Core_View_Helper_Email_Email {
	
	
	
	
	function email( $mixed = '', $options = array('name' => '', 'key' => '', 'email' => '' ) ){	
	
		
		$_forgot = ''; 
		
		/***/
		if( $options['name'] ) $this->password = $options['name'];
		if( $options['message'] ) $this->message = $options['message'];
		if( $options['email'] ) $this->email = $options['email'];
		if( $options['key'] ) $this->key = $options['key'];
		
		
		
		/***/
		if( is_array($mixed) ) {
			foreach(  $mixed as $k => $value ){
				$_forgot .= '<div  style=\'width:500px; float: left; clear: both;\'><div style=\'width:200px; float: left;\'>'.$k.'</div><div style=\'width:200px; float: left;\'>'.$value.'</div></div>';					
			}			
		}elseif( is_string( $mixed ) ){
				$_forgot .= '<div  style=\'width:500px; float: left; clear: both;\'>'.$mixed.'</div>';					
		} 

		
		/***/
		if( $_forgot ) 		$_forgot .= '<hr/>';
		$_forgot .= '<div style=\'width:500px;\'>'; 
			if( $this->message) $_forgot .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->message.'</div>';
			if( $this->key) $_forgot .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->key.'</div>';
			if( $this->email) $_forgot .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->email.'</div>';
			if( $this->password) $_forgot .= '<div  style=\'width:500px; float: left; clear: both;\'>'. $this->password.'</div>';
		$_forgot .= '</div>'; 		
		return $_forgot; 
	
	}
	
}
?>