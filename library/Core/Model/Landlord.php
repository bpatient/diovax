<?php
/**
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses 	Core_Model_Property
 * @uses 	Core_Model_User
 */


class Core_Model_Landlord extends Core_Model_Abstract {
	/**
	 * this is the name of the table to connect to 
	 * @var string $_name
	 */
	protected $_name = 'landlord';
        protected $_primary = array( 'property_id', 'user_id');
        protected $_referenceMap = array(
	          "User" => array("columns" => array("user_id"),"refTableClass" => "Core_Model_User", "refColumns" => array("id")),
                  "Property" => array("columns" => array("property_id"),"refTableClass" => "Core_Model_Property", "refColumns" => array("id"))
        );
  
	public $_data = array();
	public function __construct(Core_Entity_Landlord $data ){			
		parent::__construct($data);
	}
	
}//end of class

?>