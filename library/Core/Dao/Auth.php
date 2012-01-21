<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 */
class Core_Dao_Auth extends Core_Dao_Abstract {



	private $dto;
	public function __construct( Core_Entity_Auth $data){
		
		parent::__construct( $data );
		
		$this->dto = $data;
	}



	/**
	 * TODO must return Core_Model_User or something
	 */
	public function save(){


		$data = new Core_Model_Auth( $this->dto );
		if($this->dto->service == "system"){
			if( $this->dto->value == null || $this->dto->value == "" || !( strlen($this->dto->value) > 0 ) ){
				$this->dto->value = Core_Util_Password::generate();
			}
		}

		try{
			if( is_numeric( $this->dto->id) ) {
				if ( (int)$this->dto->id <= 0 ){
					$this->dto->value = md5($this->dto->value );
					$data->insert( $this->dto->toArray() );
				}else{
					$_arr = $this->dto->toArray();
					unset( $_arr["id"]);
					unset( $_arr["key"]);
					unset( $_arr["value"]);
						
					$data->update(  $_arr, array ( "id" => $this->dto->id ,  "`key`" => $this->dto->key ,  "value" => $this->dto->value ) );
				}
			}
		}catch( Exception $e ){
			echo $e->getMessage();
			return -1;
		}

	}


	/**
	 * This function will be used to change the password.
	 * Other fields may be changed as well, but the main intention is to change the password
	 */
	public function reset(){
		$data = new Core_Model_Auth( $this->dto->toArray() );
		$where = $params = array();
		if( strlen($this->dto->password ) > 0 ){
			$params["value = ? "] = $this->dto->password;
		}


		if( (int)$this->dto->id > 0  ){
			$where["id = ?"] = (int)$this->dto->id;
		}
		try{
			$data->update(  $params , $where );
		}catch( Exception $e ){
			//TODO should log this events
			return -1;
		}

	}


	public function getAll(){
		$data = new Core_Model_User( $this->dto->toArray() );
		return $data->fetchAll()->toArray();
	}


	public function get(){
		
		
		
		$params = array();
		$data = new Core_Model_Auth( $this->dto );
		if( (int)$this->dto->user_id > 0 )
		$params["user_id = ?"] = (int)$this->dto->user_id;
		if( strlen($this->dto->service) > 0 )
		$params["service = ?"] = $this->dto->service;
		if( strlen($this->dto->key) > 0 )
		$params["`key` = ?"] = $this->dto->key;
		$_arr = $data->fetchAll($params)->toArray();
		if( is_array($_arr) ){
			if( isset($_arr[0]) && is_array( $_arr[0] ) )
			$_arr = $_arr[0];
		}
		
		return new Core_Entity_Auth($_arr);
	}


	/**
	 * TODO delete from dependent tables
	 */
	public function delete(){
		$job = new Core_Model_Job( $this->dto->toArray() );
		if( is_numeric( $job->id) && (int)$job->id > 0) {
			$job->delete( array( "id" => $this->dto->id) );
		}
	}

}//end of class
?>