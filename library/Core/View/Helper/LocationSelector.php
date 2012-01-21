<?php
/**
 * @author Pascal Maniraho 
 * @param string $img_url 
 * @param sting $width [ large | small | thumbnail | large ]  
 */

class Core_View_Helper_LocationSelector extends Zend_View_Helper_Abstract{
	/**have to use kml content from google*/
	public function locationSelector($kml, $options = array ( 'class' => '',  'id' => '' , 'rel' => '')){
		$param = ''; 
		$_class = ( isset($options['class']) && !empty($options['class']) ) ? ' class =\''.$options['class'].'\' ' : ''; 
		$_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : ''; 
		$content ="Location Selector";
		$div = '<div class=\'location-selector '.$_class.'\'>'.$content.'</div>'; 
		return $div; 
	}	
}
?>