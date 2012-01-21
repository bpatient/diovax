<?php
/**
 * The address_key should be like telephone, email, mobile, fax, postal, ....
 * The category should be like telephone(home, office, other), postal(home,office, other) ...
 *
 *
 *
 *
 * @author Pascal Maniraho
 *
 */
class Core_Model_Expense extends Core_Model_Abstract {

	protected $_name = 'expense';
	protected $_referenceMap = array(
		"Property" => array(
						"columns" => array("property_id"),
						"refTableClass" => "Core_Model_Property",
						"refColumns" => array("id")
	)
	);




	/**
	 * @var array
	 */
	public $_data = array();
	public function __construct( Core_Entity_Expense $data ){
		parent::__construct($data);


	}

}//end of class

?>