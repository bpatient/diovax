<?php
/**
 * @author Pascal Maniraho 
 * @version 1.0.0 
 */
class Core_Dao_User extends Core_Dao_Abstract {

	
	
	private $dto;
	public function __construct( Core_Entity_User $data){
		parent::__construct( $data );
		$this->dto = $data;
	}
	
	
	
	/**
	* TODO must return Core_Model_User or something 
	*/
	public function save(){
		$data = new Core_Model_User( $this->dto );
		try{ 

				if ( (int)$data->id == 0 ){
					if( !(strlen($this->dto->token) >0) ){
						$this->dto->token = $this->dto->getToken();//
					}
					$this->dto->active = (boolean)$this->dto->active == true || ($this->dto->active == 1) ? 1 : 0;
					$data->insert( $this->dto->toArray() );
					$this->dto->id = $data->getAdapter()->lastInsertId();
				}else{
					$this->dto->active = (boolean)$this->dto->active == true || ($this->dto->active == 1) ? 1 : 0;
					$_arr = $this->dto->toArray();
					unset( $_arr["id"]);unset( $_arr["email"]);unset( $_arr["token"]);
					$data->update(  $_arr, array ( "id = ? " => $this->dto->id ,  "email = ? " => $this->dto->email,   "token = ? " => $this->dto->token ) );
				}
		
		}catch( Exception $e ){
			return -1;
		}
		//TODO check if this dto is not empty
		return $this->dto;
 }
	
	
	public function getAll(){
		$data = new Core_Model_User( $this->dto );
		$params = array();
		if( isset($this->dto->category) && strlen($this->dto->category) > 0 ){
			$params["category = ? "] = $this->dto->category;
		}
		return $data->fetchAll($params)->toArray();
	}
	
	public function get(){
		$params = array();
		$data = new Core_Model_User( $this->dto );
		if( (int)$this->dto->id > 0 ) $params["id = ? "] = (int)$this->dto->id;
		if( strlen($this->dto->email) > 0 ) $params["email = ? "] = $this->dto->email;
		if( strlen($this->dto->category) > 0 ) $params["category = ? "] = $this->dto->category;
		if( strlen($this->dto->token) > 0 ) $params["token = ? "] = $this->dto->token;		
		$_arr = $data->fetchAll($params)->toArray();
		
		
		//throw new Exception( print_r( $this->d , 1 ) );
		
		if( is_array($_arr) ){
			if( isset($_arr[0]) && is_array( $_arr[0] ) ) $_arr = $_arr[0];
		}
		return new Core_Entity_User($_arr);
	}
	
	
	
	/***/
	public function delete(){
		$job = new Core_Model_Job( $this->dto->toArray() );
		if( is_numeric( $job->id) && (int)$job->id > 0) {
			$job->delete( array( "id" => $this->dto->id) );
		}
	}
	
}//end of class
?>