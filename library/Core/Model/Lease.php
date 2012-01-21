<?php
/**
 * This model class will be used to crud products 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Core_Model_Task
 * @uses Core_Model_Site
 * @uses Core_Model_PropertyDetails
 * @uses Core_Model_UserProperty
 * @uses Core_Model_ProductDetails
 * @uses Core_Model_ProductCategory
 * @uses Core_Model_ProductAttribute
 * 
 * 
 * what happens if a lease is cosigned???? adding an extension of cosigner??? or add it in lease details???
 * 
 */

class Core_Model_Lease extends Core_Model_Abstract {
	
	protected $_name = 'lease';
	protected $_dependantTables = array(
            'Core_Model_LeaseDetails',
            'Core_Model_Billing');
	protected $_referenceMap = array(
	     "Booking" => array("columns" => array("booking_id"),"refTableClass" => "Core_Model_Booking", "refColumns" => array("id")),
              "LeaseType" => array("columns" => array("lease_type_id"),"refTableClass" => "Core_Model_LeaseType", "refColumns" => array("id"))
       );
	/***/
	public $_data = array();

	
	
	public function __construct( Core_Entity_Lease $data){
		parent::__construct($data);
	}
	
	
}//end of class
?>
