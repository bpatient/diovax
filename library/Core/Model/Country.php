<?php

/**
 * @author Pascal Maniraho 
 * @version 1.0.0 
 */


class Core_Model_Country extends Core_Model_Abstract {
	protected $_name = 'country';
	protected $_dependantTables = array('Core_Model_TaxZone');
	public $_data = array();	
	
	
	public function __construct(Core_Entity_Country $data){
		parent::__construct($data);
			
	}
	
	
}//end of class

?>