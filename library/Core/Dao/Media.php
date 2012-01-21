<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 */
class Core_Dao_Media extends Core_Dao_Abstract {


	private $dto;
	public function __construct( Core_Entity_Media $data){
		parent::__construct( $data );
		$this->dto = $data;
	}//end of class



	public function save(){
		$data = new Core_Model_Media( $this->dto );


		try{
				
				
			if(  !isset($this->dto->isdefault) || $this->dto->isdefault == false || $this->dto->isdefault != 1 ){
				$this->dto->isdefault = 0;
			}else{
				$this->dto->isdefault = 1;
			}
				

			if(  !isset($this->dto->media_order) || !( (int)$this->dto->media_order >= 1 )  ){
				$this->dto->media_order = 0;
			}else{
				$this->dto->media_order = (int)$this->dto->media_order;
			}


			if( !(strlen($this->dto->token) >0) )
			$this->dto->token = $this->dto->getToken();//
			$this->dto->displayed = (boolean)$this->dto->displayed == true || ($this->dto->displayed == 1) ? 1 : 0;
			if ( (int)$data->id == 0 ){
				$data->insert( $this->dto->toArray() );
				$this->dto->id = $data->getAdapter()->lastInsertId();
			}else{
				$_arr = $this->dto->toArray();
				unset( $_arr["id"]);
				unset( $_arr["token"]);
				unset( $_arr["owner"]);
				unset( $_arr["media_value"]);
				$data->update(  $_arr, array ( "id = ? " => $this->dto->id, "token = ? " => $this->dto->token ) );
			}

		}catch( Exception $e ){
			echo " ".$e->getMessage();
			throw new Exception ( print_r( $e, 1 ) );
		}
		//TODO check if this dto is not empty

		return $this->dto;
	}



	public function getAll(){
		$data = new Core_Model_Media( $this->dto );
		$params = array();
		if( (int)$this->dto->id > 0 ) $params["id = ? "] = (int)$this->dto->id;
		if( strlen($this->dto->token) > 0 ) $params["token = ? "] = $this->dto->token;
		if( strlen($this->dto->owner) > 0 ) $params["owner = ? "] = $this->dto->owner;
		if( isset($this->dto->isdefault)  ) $params["isdefault = ? "] = (int)$this->dto->isdefault >= 1 ? 1 : 0 ;
		if( isset($this->dto->displayed) > 0 ) $params["displayed = ? "] = (int)$this->dto->displayed >= 1 ? 1 : 0 ;
		if( strlen($this->dto->media_key) > 0 ) $params["media_key = ? "] = $this->dto->media_key;
		return $data->fetchAll( $params )->toArray();
	}

	public function get(){
		$params = array();
		$data = new Core_Model_Media( $this->dto );
		if( (int)$this->dto->id > 0 ) $params["id = ? "] = (int)$this->dto->id;
		if( strlen($this->dto->token) > 0 ) $params["token = ? "] = $this->dto->token;
		if( strlen($this->dto->owner) > 0 ) $params["owner = ? "] = $this->dto->owner;
		if( isset($this->dto->isdefault)  ) $params["isdefault = ? "] = (int)$this->dto->isdefault >= 1 ? 1 : 0 ;
		if( isset($this->dto->displayed) > 0 ) $params["displayed = ? "] = (int)$this->dto->displayed >= 1 ? 1 : 0 ;
		if( strlen($this->dto->media_key) > 0 ) $params["media_key = ? "] = $this->dto->media_key;
		$_arr = $data->fetchAll($params)->toArray();
		if( is_array($_arr) ){
			if( isset($_arr[0]) && is_array( $_arr[0] ) ){
				$_arr = $_arr[0];
			}
		}


		return new Core_Entity_Media( $_arr );
	}



	public function getUserImage(){
		$params = array();
		$data = new Core_Model_Media( $this->dto );
		$image= array(); //should be an object
		$params["media_key = ? "] = "image";
		$params["displayed = ? "] = 1;
		if( (int)$this->dto->id > 0 ) $params["id = ? "] = (int)$this->dto->id;
		if( isset( $this->dto->token ) && strlen($this->dto->token) > 0 ) $params["token = ? "] = $this->dto->token;
		$_arr = $data->fetchAll($params)->toArray();
		if( is_array($_arr) ){
			if( isset($_arr[0]) && is_array( $_arr[0] ) )
			$_arr = $_arr[0];
			$image = new Core_Entity_Media( $_arr );
		}

		if( !( $image instanceof Core_Entity_Media ) )
		$image = new Core_Entity_Media( array() );
		return $image;
	}

	
	
	/**
	 * 
	 * @param Core_Entity_Media $data
	 */
	public function editUserMedia( Core_Entity_Media $data ){
		return Core_Util_Factory::build( $data->toArray(), Core_Util_Factory::DAO_MEDIA )->save();
	}
	

	//TODO all media for one user, should return an array instead of one image
	public function getUserMedia(){
		$params = array();
		$data = new Core_Model_Media( $this->dto );

		$params["media_key = ? "] = "image";
		if( (int)$this->dto->id > 0 ) $params["id = ? "] = (int)$this->dto->id;
		if( strlen($this->dto->token) > 0 ) $params["token = ? "] = $this->dto->token;
		$_arr = $data->fetchAll($params)->toArray();
		if( is_array($_arr) ){
			if( isset($_arr[0]) && is_array( $_arr[0] ) )
			$_arr = $_arr[0];
		}
		return new Core_Entity_Media( $_arr );
	}


	public function delete(){
		$data = new Core_Model_Media( $this->dto );
		$_params = array();
		
		if( is_numeric( $data->id) && (int)$data->id > 0) {
			$_params["id = ?"] = (int)$this->dto->id;
		}

		//
		if( isset($this->dto->token) && strlen( $this->dto->token ) > 0 ) {
			$_params["token = ?"] = $this->dto->id;
		}
		
		if( isset($this->dto->owner) && strlen( $this->dto->owner ) > 0 ) {
			$_params["owner = ?"] = $this->dto->owner;
		}
		
		
		
		if( !empty($_params ) ){
			$data->delete( $_params );
			return true;
		}
		
		return false;
	}
	
	
}
?>