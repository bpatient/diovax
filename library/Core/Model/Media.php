<?php

/**
 *
 * 
 *
 * @author Pascal Maniraho 
 * @version 1.0.0
 * @uses Core_Model_Product
 */

class Core_Model_Media extends Core_Model_Abstract {

	protected $_name = 'media';
	
	/**we can use displayed as the order in which the video is displayed, and set it to negative if we dont want to display it*/
	public $_data = array();	
	
	public function __construct( Core_Entity_Media $data){
		parent::__construct($data );
			
	}
	
	
}//end of class

?>