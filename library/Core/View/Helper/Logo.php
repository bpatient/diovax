<?php
class Core_View_Helper_Logo extends Zend_View_Helper_Abstract{
	public function logo( $mixed , $options = array('id' => '', 'class' => '') ){
		$_id = ''; 
		$_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : ''; 
		$_content = $mixed ?  $mixed : 'Rentis - dev - logo';
		 $_logo = '<div class=\'view-helper-logo '.$_class.'\'>'.$_content.'</div>';
		return $_logo;
	}
}
?>