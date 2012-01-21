<?php
/**
 * 
 * 
 * This class will restore DRY rule broken down by ErrorMessage 
 * @todo replaces all instances of ErrorMessage 
 * @author Pascal Maniraho 
 *
 */

class Core_View_Helper_Message extends Zend_View_Helper_Abstract{
	
	/**
	 * @param string | array $message 
	 */
	function message($message , $options = array('class') ){		
		$tmp_msg = is_string( $message) ? $message : ''; 		
		$class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : 'error'; 		
		$details = ( isset($options['details']) && !empty($options['details']) ) ? $options['details'] : '';
	    if (is_array($message) ): 
	   		$tmp_msg = '<ul>';
	   		foreach ( $message as $k=> $msg){
	   			if( is_array($msg) ) $msg = end( $msg );
	   			$tmp_msg .= "<li>$k  {$msg}  </li>";
			}
	   		$tmp_msg .= '</ul>';	 
	   	endif;
		return ( $tmp_msg == '' ) ? '' : '<div class=\''.$class.'\'><p>'.$tmp_msg.'</p></div>'; 
	}
	
}


?>