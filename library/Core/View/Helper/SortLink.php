<?php
/**
 * 
 * 
 * This will be used to show sorting links, especially in headers of tables 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Zend_View_Helper_Abstract
 * 
 * 
 * 
 *
 */
class Core_View_Helper_SortLink extends Zend_View_Helper_Abstract{
	
	/**
	 *
	 * All options are required to make this helper works better 
	 * 
	 * @param unknown_type $baseUrl
	 * @param unknown_type $options
	 */
	public function sortLink($baseUrl, $options = array ( 'pg'=> 0, 'field' => 'field', 'title' => 'title', 'order' => 'asc', 'limit' => 0 )){
		/***/  
    extract($options);
    
    $pg = isset($options['pg']) ?  $options['pg'] : 0; 
    $field =  isset($options['field']) ?  $options['field'] : 'field';
    $title =  isset($options['title']) ?  $options['title'] : 'title';
    $order =  isset($options['order']) ?  $options['order'] : 'asc';
    $limit =  isset($options['limit']) ?  $options['limit'] : 0;
    
    $link = '<a href=\''.$baseUrl.'/?pg='.$pg.'&sort&fld='.$field.'&ord='.$order.'&limit='.$limit.'\' >'.$title.'</a>';
		return $link;
	}
	
}
?>