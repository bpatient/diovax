<?php
/**
 * @author Pascal Maniraho 
 * @version 1.0.0 
 */

class Core_Dao_Property extends Core_Dao_Abstract {
	private $dto;
	public function __construct( Core_Entity_Property $data){
		
			parent::__construct( $data );
			
			$this->dto = $data;
		}


		
		
		
		public function save(){
			
			
			
			if(!isset($this->dto->token) ||  !(strlen($this->dto->token) > 0 ) ) {
				$this->dto->token = $this->dto->getToken();
			}
			$data = new Core_Model_Property( $this->dto );
			if( !isset($this->dto->url) || !(strlen($this->dto->url) > 0 ) ) {
				$_str = new Core_Util_String();
				$this->dto->url = $_str->slug( $this->dto->name."-".$this->dto->token, "-" );
			}
			
	
			if ( !is_numeric( $data->id) || (int)$data->id == 0 ){
				$data->insert( $this->dto->toArray() );
				$this->dto->id = $data->getAdapter()->lastInsertId($data->getPrimaryKey());
			}else{
				$_arr = $this->dto->toArray();
				unset( $_arr["id"]);
				$data->update(  $_arr, array ( "id" => $this->dto->id ) );
			}
			
			return $this->dto;
		
		}
		
		
		public function delete(){
			$data = new Core_Model_Property( $this->dto );
			if( is_numeric( $data->id) && (int)$data->id > 0) {
				$data->delete( array( "id" => $this->dto->id) );
			}
		}
		
		
		public function get(){
			$job = new Core_Model_Property( $this->dto );
			$params = array();
			if( isset($this->dto->id) &&  (int)$this->dto->id > 0){
				$params["id =? "] = (int)$this->dto->id;
			}
			if( isset($this->dto->token) &&  strlen($this->dto->token) > 0){
				$params["token =? "] = $this->dto->token;
			}
			if( isset($this->dto->url) &&  strlen($this->dto->url) > 0){
				$params["url =? "] = $this->dto->url;
			}
			
			
			$dt = array();
			if( !empty($params) ){
				
				$dt = $job->fetchAll($params)->toArray();
				if( is_array($dt) ){
					if( isset($dt[0]) && is_array($dt) ){
						$dt = $dt[0];
					}
				}
			} 
			
			return Core_Util_Factory::build($dt, Core_Util_Factory::ENTITY_PROPERTY);
		}
		
		
		public function getAll(){
			$job = new Core_Model_Property( $this->dto );
			return $job->fetchAll()->toArray();
		}

}
?>
