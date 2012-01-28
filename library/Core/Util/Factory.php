<?php
/**
 * @todo should be tested thourhgly
 */


class Core_Util_Factory{



	const ENTITY_ADDRESS = 101;
	const ENTITY_AUTH = 104;
	const ENTITY_AUTH_LOG = 105;
	const ENTITY_EXPENSE = 103;
	const ENTITY_LANDLORD = 118;
	const ENTITY_LEASE = 123;
	const ENTITY_MEDIA = 128;
	const ENTITY_PROPERTY = 137;
	const ENTITY_USER = 161;
	
	

	const MODEL_ADDRESS = 1012;
	const MODEL_AUTH = 1015;
	const MODEL_AUTH_LOG = 1016;
	const MODEL_EXPENSE = 1017;
	const MODEL_LANDLORD = 1039;
	const MODEL_LEASE = 1043;
	const MODEL_MEDIA = 1048;
	const MODEL_PROPERTY = 1056;
	const MODEL_USER = 1082;



	const DAO_ADDRESS = 1212;
	const DAO_AUTH = 1213;
	const DAO_AUTH_LOG = 1214;
	const DAO_LANDLORD = 1235;
	const DAO_EXPENSE = 1236;
	const DAO_LEASE = 1247;
	const DAO_MEDIA = 1248;
	const DAO_PROPERTY = 1259;
	const DAO_USER = 1289;




	public static function build( $data, $mode ){

		$_object = null;


		if( $data instanceof Core_Entity_Abstract){
			$data = $data->toArray();
		}
		if( $data instanceof Core_Dao_Abstract){
			$data = $data->toArray();
		}
		if( $data instanceof Core_Model_Abstract){
			$data = $data->toArray();
		}


		if( !isset( $data ) || !is_array($data) ){
			throw new Exception (  __CLASS__."::".__METHOD__ ." parameter data type not supported" );

		}


		switch ($mode) {

			case Core_Util_Factory::ENTITY_USER: $_object = new Core_Entity_User( $data ); break;
			case Core_Util_Factory::ENTITY_ADDRESS:  $_object = new Core_Entity_Address( $data ); break;
			case Core_Util_Factory::ENTITY_AUTH:  $_object = new Core_Entity_Auth( $data ); break;
			case Core_Util_Factory::ENTITY_AUTH_LOG:  $_object = new Core_Entity_AuthLog( $data ); break;
			case Core_Util_Factory::ENTITY_LANDLORD:  $_object = new Core_Entity_Landlord( $data );  break;
			case Core_Util_Factory::ENTITY_EXPENSE:  $_object = new Core_Entity_Expense( $data );  break;
			case Core_Util_Factory::ENTITY_LEASE:  $_object = new Core_Entity_Lease( $data );  break;
			case Core_Util_Factory::ENTITY_MEDIA:  $_object = new Core_Entity_Media( $data );  break;
			case Core_Util_Factory::ENTITY_PROPERTY:  $_object = new Core_Entity_Property( $data );  break;
			case Core_Util_Factory::ENTITY_USER:  $_object = new Core_Entity_User( $data );  break;

			case Core_Util_Factory::MODEL_ADDRESS:   $_object = new Core_Model_Address( new Core_Entity_Address($data) );   break;
			case Core_Util_Factory::MODEL_AUTH:   $_object = new Core_Model_Auth( new Core_Entity_Auth($data) );   break;
			case Core_Util_Factory::MODEL_AUTH_LOG:   $_object = new Core_Model_AuthLog( new Core_Entity_AuthLog($data) );   break;
			case Core_Util_Factory::MODEL_LANDLORD:   $_object = new Core_Model_Landlord( new Core_Entity_Landlord($data) );   break;
			case Core_Util_Factory::MODEL_EXPENSE:   $_object = new Core_Model_Expense( new Core_Entity_Expense($data) );   break;
			case Core_Util_Factory::MODEL_LEASE:   $_object = new Core_Model_Lease( new Core_Entity_Lease($data) );   break;
			case Core_Util_Factory::MODEL_MEDIA:   $_object = new Core_Model_Media( new Core_Entity_Media($data) );   break;
			case Core_Util_Factory::MODEL_PROPERTY:   $_object = new Core_Model_Property( new Core_Entity_Property($data) );   break;
			case Core_Util_Factory::MODEL_USER:   $_object = new Core_Model_User( new Core_Entity_User($data) );   break;

			case Core_Util_Factory::DAO_USER:  $_object = new Core_Dao_User( new Core_Entity_User($data) );  break;
			case Core_Util_Factory::DAO_ADDRESS:   $_object = new Core_Dao_Address( new Core_Entity_Address($data) );   break;
			case Core_Util_Factory::DAO_AUTH:   $_object = new Core_Dao_Auth( new Core_Entity_Auth($data) );   break;
			case Core_Util_Factory::DAO_AUTH_LOG:   $_object = new Core_Dao_AuthLog( new Core_Entity_AuthLog($data) );   break;
			case Core_Util_Factory::DAO_EXPENSE:   $_object = new Core_Dao_Expense( new Core_Entity_Expense($data) );   break;
			case Core_Util_Factory::DAO_LANDLORD:   $_object = new Core_Dao_Landlord( new Core_Entity_Landlord($data) );   break;
			case Core_Util_Factory::DAO_LEASE:   $_object = new Core_Dao_Lease( new Core_Entity_Lease($data) );   break;
			case Core_Util_Factory::DAO_MEDIA:   $_object = new Core_Dao_Media( new Core_Entity_Media($data) );   break;
			case Core_Util_Factory::DAO_PROPERTY: $_object = new Core_Dao_Property( new Core_Entity_Property($data) ); break;


			default:
				throw new Exception ( "Parameter not Supported @".__METHOD__."  " );
			break;
		}

		
		
		
		return $_object;
	}







	/**
	 * @internal this makes it impossible to access declare this function as a new object
	*/
	private function __construct(){
	}








	/***/
}
?>