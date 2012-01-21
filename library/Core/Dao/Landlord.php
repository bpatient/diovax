<?php
/**
 *  @author Pascal Maniraho
 */
class Core_Dao_Landlord extends Core_Dao_Abstract{

	private $dto;
	public function __construct( Core_Entity_Landlord $data){
		parent::__construct( $data );
		$this->dto = $data;
	}
	
	public function save(){
		$landlord= new Core_Model_Landlord( $this->dto );
		try{ 
			$landlord->insert( $this->dto->toArray() );
		}catch(Exception $e ){
			$_arr = $this->dto->toArray();
			unset( $_arr["user_id"]);
			unset( $_arr["property_id"]);
			$landlord->update(  $_arr, array ( "user_id" => $this->dto->user_id , "property_id" => $this->dto->property_id ) );
		}
		return $this->dto;
	}
	
	
	/**
	 * TODO delete from dependent tables
	*/
	public function delete(){
		$landlord= new Core_Model_Landlord( $this->dto );
		if( is_numeric( $company->id) && (int)$company->id > 0) {
			$company->delete( array( "id" => $this->dto->id) );
			}
	}

	
	public function getAll(){
		$landlord= new Core_Model_Landlord( $this->dto );
		return $company->fetchAll()->toArray();
	}
	
	public function get(){
		$landlord= new Core_Model_Landlord( $this->dto );
		$params = array();
		if( (int)$this->dto->id >0 )$params["id =? "] = (int)$this->dto->id;
		if( (int)$this->dto->user_id >0 )$params["user_id =? "] = (int)$this->dto->user_id;
		if( isset($this->dto->token) && strlen($this->dto->token) >0 )$params["token =? "] = (int)$this->dto->token;
		
		$_landlord = $landlord->fetchAll($params)->toArray();
		if( is_array($_landlord) ){
			if( isset($_landlord[0]) && is_array($_landlord[0]) ){
				$_landlord = $_landlord[0];
			}
			$landlord= new Core_Entity_Landlord( $_landlord );
		}
		
		/**
		 * @todo should use throw an exception, to tell the application that there is now value associated to this lanlord 
		 */
		if( !($landlord instanceof Core_Entity_Landlord) ){
			$landlord = new Core_Entity_Landlord();
		}
		return $landlord;
	}
	
	

	
	
	/**
	 * @internal will be used in cases we want to get LandlordProperty
	 * @return Core_Entity_Property $property
	 */
	public function getProperty(){
		return Core_Util_Factory::build( array( 'id' => $this->dto->property_id ) , Core_Util_Factory::DAO_PROPERTY )->get();//
	}
	
	
	
	public function getContact(){
		return Core_Util_Factory::build( array( 'user_id' => $this->dto->user_id ) , Core_Util_Factory::DAO_ADDRESS )->get();//
	}
	
	
	/**
	 * @todo getProperties is not yet done 
	 */
public function getProperties(){
			$pdao= Core_Util_Factory::build( array( 'id' => $this->dto->property_id ) , Core_Util_Factory::DAO_PROPERTY )->get();
		return $pdao;
	}
	
	/**
	 * @todo is not complete
	 */
	public function getTenants(){
			$pdao = Core_Util_Factory::build( array( 'category' => "tenant" ) , Core_Util_Factory::DAO_USER )->getAll();
		return $pdao;
	}	
	
	/**
	 * @todo the logic to get the landlord technicians  is not done yet
	 */
	public function getTechnicians(){
			$pdao = Core_Util_Factory::build( array( 'category' => "tech" ) , Core_Util_Factory::DAO_USER )->getAll();
		return $pdao;
	}
	
	
	
	
}
?>