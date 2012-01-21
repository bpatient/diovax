<?php
/**
 *  @author Pascal Maniraho
 *  @todo Lease DAO needs to be implemented asap
 */
class Core_Dao_Lease extends Core_Dao_Abstract{


	private $dto;
	public function __construct( Core_Entity_Lease $data){
		parent::__construct( $data );
		$this->dto = $data;
	}



	public function save(){
		$data = new Core_Model_Lease( $this->dto );
		if( !(strlen($this->dto->status) > 0 ) ) {
			$this->dto->status = "open";
		}
		if ( (int)$data->id == 0 ){
			$data->insert(  $this->dto->toArray() );
			$this->dto->id =  $data->getAdapter()->lastInsertId();
		}else{
			$_arr = $this->dto->toArray();
			unset( $_arr["id"] );
			$data->insert( $_arr, array( "id" => (int)$this->dto->id ) );
		}
		return $this->dto;
	}



	/**
	 * @param $data
	 *@todo get Lease DAO needs to take into consideration user_id | task_id and its own ID
	 */
	public function get( $data = null ){


		$params = array();
		if( $data instanceof Core_Entity_Lease ){
			$this->dto->id = $data->id;
		}
			


		if( is_numeric( $this->dto->id) && $this->dto->id > 0   ){
			$params["id"] = $this->dto->id;
		}

		if( is_numeric($this->dto->task_id) && $this->dto->task_id > 0 ){
			$params["task_id"] = $this->dto->task_id;
		}


		$data = new Core_Model_Lease( $this->dto );
		return $data->fetchAll($params )->toArray();


	}



	public function getAll(){
		$data = new Core_Model_Lease( $this->dto );
		$where = array();
		if( is_numeric($this->dto->id) && $this->dto->id > 0 ){
			$where["id"] = $this->dto->job_id;
		}
		if( is_numeric($this->dto->user_id) && $this->dto->user_id > 0 ){
			$where["user_id"] = $this->dto->user_id;
		}
		if( is_numeric($this->dto->task_id) && $this->dto->task_id > 0 ){
			$where["task_id"] = $this->dto->task_id;
		}

			
		return $data->fetchAll( $where )->toArray();
	
	}
	
}
?>