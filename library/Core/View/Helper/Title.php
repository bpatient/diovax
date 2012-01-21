<?php


/**
 * 
 * This view helper will be used to display error titles
 * 
 * @author Pascal Maniraho 
 *
 */

class Core_View_Helper_Title extends Zend_View_Helper_Abstract{
	function title ( $title, $options = array ('class' => '', 'id' => '', 'style' => '')  ){
			$style = isset($options['style']) && $options['style'] ?' style=\''.$options['style'].'\' ':'';			
			$class = isset($options['class']) && $options['class'] ?' class=\''.$options['class'].'\' ':' class=\'title\' ';			
			$id = isset($options['id']) && $options['id']? ' id=\''.$options['id'].'\' ' :' id=\'title\' ';
			$div = '<div '.$class.'=\'title\' '.$id.' ><strong>'.$title.'</strong></div>';
		return $div; 
	}
	
}


?>