<?php
/***/
class Core_View_Helper_ImageWidget extends Core_View_Helper_Base{
	
	/**This variable will be used accross the class*/
	private $image; 
	/***/	 
	public function imageWidget( $data , $options = array() ){
		$_content = '';
		$_property = '<div class=\'property-widget-container\'  id=\'property-widget-container\' >'.$_content.'</div>';
		return  $_property;
	}
	
}
?>