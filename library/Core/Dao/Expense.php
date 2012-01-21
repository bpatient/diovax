<?php
/**
 *  This class will be used to make it possible to serialze and unseliaze the address object
 *  @author Pascal Maniraho
 */

class Core_Dao_Expense extends Core_Dao_Abstract {
	
	
	private $dto;
	public function __construct( Core_Entity_Account $data){
		parent::__construct( $data );
		$this->dto = $data;
	}
	
	
	
	public function save(){
		$model = new Core_Model_Expense( $this->dto->toArray() );
		if( is_numeric( $data->id) ) {
			if( !(strlen($this->dto->token) >0) )
			$this->dto->token = $this->dto->getToken();//
			if ( (int)$data->id == 0 ){
				$model->insert( $this->dto->toArray() );
			}else{
				$_arr = $this->dto->toArray();
				unset( $_arr["id"]);
				$model->update(  $_arr, array ( "id" => $this->dto->id ) );
			}
		}
	}
	
	
	public function delete(){
		$model = new Core_Model_Expense( $this->dto->toArray() );
		if( is_numeric( $data->id) && (int)$data->id > 0) {
			$model->delete( array( "id" => $this->dto->id) );
		}
	}
	
	
	public function getAll(){
		$model = new Core_Model_Expense( $this->dto->toArray() );
		return $model->fetchAll()->toArray();
	}
	
	
}
?>