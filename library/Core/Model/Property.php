<?php
/**
 * This model class will be used to crud products 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Core_Model_Task
 * @uses Core_Model_Site
 * @uses Core_Model_PropertyDetails
 * @uses Core_Model_UserProperty
 * @uses Core_Model_ProductDetails
 * @uses Core_Model_ProductCategory
 * @uses Core_Model_ProductAttribute
 * @uses Core_Model_PropertyAmenity
 */
class Core_Model_Property extends Core_Model_Abstract {
	
	protected $_name = 'property';
	protected $_dependantTables = array('Core_Model_PropertyDetails','Core_Model_Landlord',  'Core_Model_Task',  'Core_Model_Lease',  'Core_Model_Rating', 'Core_Model_PropertyAmenity');
	protected $_referenceMap = array("Site" => array("columns" => array("site_id"),"refTableClass" => "Core_Model_Site", "refColumns" => array("id")) );
  	/***/
	public $_data = array();
	
	public function __construct(Core_Entity_Property $data ){
		parent::__construct( $data );
	}
}//end of class

?>
