<?php
/**
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Core_Model_Property
 */

class Core_Model_Address extends Core_Model_Abstract {
	protected $_name = 'address';
	public function __construct( Core_Entity_Address $data){
		parent::__construct($data);
	}
	
}//end of class
?>
