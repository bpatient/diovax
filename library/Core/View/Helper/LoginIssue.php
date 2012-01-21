<?php
/**
 * 
 * This helper will display the sign-up & forgot links/messages 
 * 
 * @author Pascal Maniraho 
 *
 */

class Core_View_Helper_LoginIssue{
	
	
	/***/
	function loginIssue( $options = array(	'class' => '', 'signup_label' => '', 'forgot_label' => '', 'signup_title' => '', 'forgot_title' => '', 'forgot_content' => '', 'signup_content' => '','title' => '','id' => '') ){
		
		
		/**identifiers*/
		$_id = isset( $options['id'] ) ? $options['id'] : ''; 
		$_class = isset( $options['class'] ) ? $options['class'] : '';

		
		
		/**content intialization*/
		$this->forgot_content = '';
		$this->signup_content = '';
		
		
		/**content and links*/
		$_forgot_content = isset( $options['forgot_content'] ) ? $options['forgot_content'] : $this->forgot_content; 
		$_signup_content = isset( $options['signup_content'] ) ? $options['signup_content'] : $this->signup_content;
		
		
		
		/**if different from default*/
		$_forgot_link =  isset( $options['forgot_link'] ) ? $options['forgot_link'] : ''; 
		$_signup_link = isset( $options['signup_link'] ) ? $options['signup_link'] : ''; 
		
		$_forgot_label =  isset( $options['forgot_label'] ) ? $options['forgot_label'] : ''; 
		$_signup_label = isset( $options['signup_label'] ) ? $options['signup_label'] : ''; 
		/***/
		$_title = ( isset($options['title'])  && ($_title = $options['title'])  ) ? '<div class=\'login-issue-title-div\'>'.$_title.'</div>' : "";
		
		/***/
		return '<div class=\'login-issue-div '.$_class.'\'>'.$_title. 					 
					'<div class=\'login-issue-sign-up-div\'>'.$_signup_content.'<a class=\'\' href=\'/app/auth/register\'>'.$_signup_label.'</a></div>'.
					'<div class=\'login-issue-forgot-div\'>'.$_forgot_content.'	<a  class=\'\' href=\'/app/auth/forgot\'>'.$_forgot_label.'</a></div>'.
		'</div>';
		
	}
	
}	

?>