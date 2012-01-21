<?php
/**
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Core_Model_Property
 */

class Core_Model_Location extends Core_Model_Abstract {
	protected $_name = 'site';
	protected $_dependantTables = array('Core_Model_Property');
	protected $_data = array();
	public function __construct( Core_Entity_Location $data){
		parent::__construct($data);
	}
	
}//end of class
?>
