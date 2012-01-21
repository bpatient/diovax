<?php
/**
 * Inject dabatase instance in DAO so that we can save something
 * @author murindwaz
 */

class Core_Service_UserManager extends Core_Service_Abstract{


	/**
	 * Should give access to database and allow to persist/retrive data
	 */
	private $dao;
	public function __construct(){

	}




	/**
	 * @todo implement this function
	 * @todo uses only email and token
	 */
	public function getUserForVerification( Core_Entity_User $data ){
		$this->dao = new Core_Dao_User( $data );
		$_user = $this->dao->get();
		return $_user;
	}


	/**
	 *
	 */
	public function getUser(Core_Entity_User $data ){
		$this->dao = new Core_Dao_User($data);
		return $this->dao->get();
	}

	/**
	 * Edit works in two modes, if there is a user who updates his data.
	 * or in a case we have a new user
	 * @param array $data
	 * @return int edited ID
	 *
	 *  @todo should be moved to dao @done
	 *

	 * @param Core_Entity_Job $job
	 */
	public function editUser(Core_Entity_User $user ){
		$this->dao = new Core_Dao_User( $user );
		return  $this->dao->save();
	}


	public function deleteUser(Core_Entity_User $user ){
		$this->dao = new Core_Dao_User( $user );
		return  $this->dao->save();
	}



	/**
	 * @todo it works, but can be revamped to use DAO

	 */
	public function getUserLookup(){
		$this->db = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_USER );
		$sql  = "select user.id as id, name, user.category,user.active, email as email, auth.id as auth_id, auth.value as password
	 					 from user join auth on user.id = auth.user_id
	    					where auth.`key` = 'password' and auth.service = 'system'";
		$assoc = $this->db->getAdapter()->fetchAssoc($sql);
		return ( $assoc)? $assoc : false ;
	}







	/**
	 * This function is crutial as it have to check authentication data, apply encryption algorithm and saves data.
	 *
	 * @todo some data are missing, so its better to initialize it from here, and leave controlller free
	 * @param array $data
	 */
	public function editAuth( Core_Entity_Auth $data ){
		$this->dao = new Core_Dao_Auth( $data );
		//TODO sanitization should be moved to DAO
		//$this->dao->connected = isset($this->dao->connected) && ( $this->dao->connected == 1 || $this->dao->connected == true )? 1 : 0 ;
		$this->dao->validated = isset($this->dao->validated) && ( $this->dao->validated != 1 || $this->dao->validated !== true ) ? 0 : 1 ;
		$this->dao->user_id = isset($this->dao->user_id) ? (int)$this->dao->user_id : 0 ;
		return  $this->dao->save();
	}

	/**
	 * @param Core_Entity_Auth $data
	 */
	public function getAuth( Core_Entity_Auth $data  ){
		$this->dao = new Core_Dao_Auth( $data );
		return $this->dao->get();
	}

	public function  activateUser( Core_Entity_User $data ){
		$this->dao = new Core_Dao_User( $data );
		$this->dao->active = 1;
		return $this->dao->save();
	}

	//
	public function getUserAuth( Core_Entity_User $data  ){
		//TODO
	}



	

	

	/** 
	 * @todo check if this use a customer of passed in landlord 
	 */
	public function getLandlordCustomer( Core_Entity_Landlord $landlord, Core_Entity_User $user ){
		$this->dao = Core_Util_Factory::build(  array( "id" => $user->id,  "token" => $user->token ), Core_Util_Factory::DAO_USER);
		return $this->dao->get();
	}
	
	
	
	


	





	/**
	 * @return Core_Entity_Media $image
	 * @param Core_Entity_User $user
	 */
	public function getUserImage( Core_Entity_User $user ){
		$this->dao = new Core_Dao_Media( new Core_Entity_Media( ) );
		return $this->dao->getUserImage();
	}

	

}