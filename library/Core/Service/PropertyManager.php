<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 * @todo add methods as needed on front end.
 *
 */
class Core_Service_PropertyManager extends Core_Service_Database {


	public function __construct(){
		parent::__construct();

	}


	/**
	 * @internal needs a refactory in future
	 * @param unknown_type $_property_and_address
	 */
	public function editPropertyAndAddress( array $_property_and_address ){
		$_property_and_address['property'] = Core_Util_Factory::build($_property_and_address['property'], Core_Util_Factory::DAO_PROPERTY)->save();
		if( !(strlen($_property_and_address['property']->owner) > 0) ){
			$_property_and_address['address']->owner = $_property_and_address['property']->token;
		}
		$_property_and_address['address'] = Core_Util_Factory::build($_property_and_address['address'], Core_Util_Factory::DAO_ADDRESS)->save();
		return $_property_and_address;

	}



}
?>