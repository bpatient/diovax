<?php
/**
 * 
 * This class will be used to display categories 
 * if the passed argument is a list, options or divs.
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Zend_View_Helper_Abstract
 * 
 *
 */
class Core_View_Helper_Category extends Zend_View_Helper_Abstract{
	
	
	
	
	
	/**
	 * options are may be formatted data, ready to display  
	 * @param array $options
	 */
	public function category( $options = array ( 'nav-class' => '') ) 
	{ 	
		
		$category = '';
		$nav_class = isset($options['nav-class'])?$options['nav-class']: 'category-nav';
		$category = isset($options [ 'categories' ])?$options [ 'categories' ]:'';
		return '<div class=\''.$nav_class.'\'>'.$category.'</div>'; 
	}
	
	
		

}
?>