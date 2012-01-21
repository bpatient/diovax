<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 */

class Core_Dao_Address extends Core_Dao_Abstract {
	private $dto;
	public function __construct( Core_Entity_Address $data){
		parent::__construct( $data );
		$this->dto = $data;
	}





	public function save(){
		$data = new Core_Model_Address( $this->dto );
		if ( (int)$data->id == 0 ){
			$data->insert( $this->dto->toArray() );
			$this->dto->id = $data->getAdapter()->lastInsertId();
		}else{
			$_arr = $this->dto->toArray();
			unset( $_arr["id"]);
			$data->update(  $_arr, array ( "id" => $this->dto->id ) );
		}
		return $this->dto;
	}


	public function delete(){
		$data = new Core_Model_Address( $this->dto );
		if( is_numeric( $data->id) && (int)$data->id > 0) {
			$data->delete( array( "id" => $this->dto->id) );
		}
	}


	public function getAll(){
		$address = new Core_Model_Address( $this->dto );
		return $address->fetchAll()->toArray();
	}


	/**
	 * @todo should use get() and set some variables instead of doing it this way
	 */
	public function getLandlordContactInfo(){
		$contactInfo = new Core_Model_Address( $this->dto );
		$params = array();
		if( isset( $this->dto->id ) && (int)$this->dto->id > 0 ){
			$params["id = ?"] = (int)$this->dto->id;
		}
		if( isset( $this->dto->displayed )  ){
			$params["displayed = ?"] = $this->dto->displayed;
		}
		if( isset( $this->dto->user_id ) && (int)$this->dto->user_id > 0 ){
			$params["user_id = ?"] = (int)$this->dto->user_id;
		}
		if( isset( $this->dto->address_type ) && strlen( $this->dto->address_type ) > 0 ){
			$params["address_type = ?"] = (int)$this->dto->address_type;
		}
		if( isset( $this->dto->address_key ) && strlen( $this->dto->address_key ) > 0 ){
			$params["address_key = ?"] = (int)$this->dto->address_key;
		}
		return $contactInfo->fetchAll($params)->toArray();
	}



	/**
	 * @todo Can be mis-leading if the array is empty
	 */
	public function get(){
		$model = new Core_Model_Address( $this->dto );
		$params = array();
		if( $this->dto->id > 0 ) $params["id = ? "] = $this->dto->id;
		if( (int)$this->dto->user_id > 0 ) $params["user_id = ? "] = $this->dto->user_id;
		if( isset($this->dto->displayed) && $this->dto->displayed >= 0 ) $params["displayed = ? "] = $this->dto->displayed;
		if( isset($this->dto->address_type) && strlen($this->dto->address_type >= 1 ) ) $params["address_type = ? "] = $this->dto->address_type;
		if( isset($this->dto->address_key) && strlen($this->dto->address_key >= 1 ) ) $params["address_key = ? "] = $this->dto->address_key;
		//
		$_arr  = $model->fetchAll($params)->toArray();
		if( is_array($_arr) ){
			if( isset($_arr[0]) && is_array( $_arr[0] ) ) {
				$_arr = $_arr[0];
			}
		}else{
			$_arr = array();
		}
		return new Core_Entity_Address( $_arr );
	}
	
		
}
?>
