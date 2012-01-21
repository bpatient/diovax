<?php

/**
 * 
 * This model class will do all operations regarding users of this app
 * there should be an issue, since the table name is a reserved mysql keyword 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses 	Core_Model_Address
 * @uses 	Core_Model_Profile
 * @uses	Core_Model_CustomerOrder
 * @uses	Core_Model_Auth
 */

/**
 * change current db querying model to recent version am using to query data from database 
 * */
//Core_Model_Entity
class Core_Model_User extends Core_Model_Abstract {
	/**
	 * this is the name of the table to connect to 
	 * @var string $_name
	 */
	protected $_name = 'user';
	protected $_dependantTables = array(
            'Core_Model_Address',
            'Core_Model_Profile',
            'Core_Model_UserPreference',
            'Core_Model_UserBooking',
            'Core_Model_Staff',
            'Core_Model_Contractor',
            'Core_Model_Wishlist',
            'Core_Model_Landlord',
            'Core_Model_UserPlan' );
	protected $_data = array();
	
	/**
	 * 
	 * @todo this constructor has to admit only core_entity_user 
	 * @param unknown_type $data
	 */
	public function __construct(Core_Entity_User $data ){			
		parent::__construct($data);
		
		
	}
	
}//end of class
?>