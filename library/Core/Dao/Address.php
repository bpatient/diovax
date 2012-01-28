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
		if ( (int)$data->id == 0 || !(strlen($this->dto->owner) > 0 ) ){
			$data->insert( $this->dto->toArray() );
			$this->dto->id = $data->getAdapter()->lastInsertId();
		}else{
			$_arr = $this->dto->toArray();
			$params = array();
			if(  (int)$this->dto->id > 0 ) $params["id"]  = $this->dto->id; 
			if(  strlen($this->dto->owner) > 0 ) $params["owner"]  = $this->dto->owner; 
			unset( $_arr["id"]);
			if(count($params) > 0 ) { 
				$data->update(  $_arr, $params );
			}
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
	 * @todo Can be mis-leading if the array is empty
	 */
	public function get(){
		$model = new Core_Model_Address( $this->dto );
		$params = array();
		if( $this->dto->id > 0 ) $params["id = ? "] = $this->dto->id;
		if( isset($this->dto->owner) && strlen($this->dto->owner) > 0 ) $params["owner = ? "] = $this->dto->owner;
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
