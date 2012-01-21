<?php
/**
 * @todo move all landlord relate functions to rent_service.
 * @author pascal
 * @deprecated  User service is discouraged to use, use UserManager instead
 */
class Core_Service_User extends Core_Service_Database{

	
	const USER_ID_NOT_FOUND_EXCEPTION = 1000;
	const PARAMETER_NOT_SUPPORTED_EXCEPTION = 1002;
	const EMPTY_USER_LOOKUP_EXCEPTION = 1003;
	const USER_ID_NOT_SPECIFIED_EXCEPTION = 1004;
	const SYSTEM_AUTHENTICATION_NOT_FOUND_EXCEPTION = 1005;
	const EMAIL_HAS_BEEN_USED_EXCEPTION= 1006;


	protected $user;
	public function __construct(){
		parent::__construct();
	}



	/**
	 * Edit works in two modes, if there is a user who updates his data.
	 * or in a case we have a new user
	 * @param array $data
	 * @return int edited ID
	 */
	public function editUser($data){


		//throw new Exception ( print_r( $data, 1) );


		$this->user = $data;
		if ( is_array  ($this->user) ) $this->user = Core_Util_Factory::build( $data, Core_Util_Factory::MODEL_USER );
		if( !( $this->user instanceof Core_Model_User) ) throw new Exception( self::PARAMETER_NOT_SUPPORTED_EXCEPTION );

		$this->user_adapter = $this->user->getAdapter();

		if($this->user->id > 0):
		$where =  $this->user_adapter->quoteInto(" id = ? ", $this->user->id);
		$data = $this->user->toArray();
		unset($data['id']);
		$this->user->update( $data , $where );
		return $this->user->id;//
		endif;


		$this->user->insert($this->user->toArray());
		return $this->user_adapter->lastInsertId();
	}


	/**
	 * This function uses other function to edit data from customer
	 *
	 * @param array $data this array contains values to be edited by the customer
	 *
	 * @uses User::editUser()
	 * @uses User::editProfile()
	 * @uses User::editAuth()
	 * @uses User::editPassword()
	 *
	 *
	 * and getters
	 *
	 * @uses User::getUsers()
	 * @uses User::getProfile()
	 * @uses User::getAuth()
	 */
	public function editCustomerProfile( $data ){



		if ( $data['user_id'] > 0 ) {
			$user = $this->getUsers(array('id'  => $data['user_id'] ))->toArray();
		}else{
			throw new Exception( self::USER_ID_NOT_SPECIFIED_EXCEPTION );
		}

		
		if ( $data['password'] != '' ){
			if ( $data['auth_id'] > 0  )
			$this->editPassword(array("user_id" => $data['user_id'],"password" => $data["password"]));
			else
			throw new Exception ( self::SYSTEM_AUTHENTICATION_NOT_FOUND_EXCEPTION );
		}

		if ( $data['name'] != '' && $data['email']!='' ){
			$user = $user[0];
			$user_by_email = $this->getUserByemail( $data['email'] );
			if ( (false === $user_by_email)  || $user_by_email->id == $data['user_id'] ){
				$user['name'] = $data['name'];
				$user['email'] = $data['email'];
				$user['birthday'] = date('Y-m-d h:i:s', strtotime($data['birthday']) );
				$this->editUser($user);
			}else
			throw new Exception ( self::EMAIL_HAS_BEEN_USED_EXCEPTION );
				
		}


		
		if ( $data['description'] != ''){
			$this->editProfile(
			array(
						'id' => ( $data['user_id'] > 0  ? $data['user_id'] : 0 ),
						'profile_key' => 'customer_info',
						'profile_value' => $data['description'],
						'displayed' => 1,
						'user_id' => $data['user_id'], 
						'modified' => date( 'Y-m-d h:i:s', time() ) 
			)
			);
		}
		return true;
	}


	/**
	 * This function checks if the given Id exists in the user lookup
	 * @param $user_id
	 * @throws EMPTY_USER_LOOKUP_EXCEPTION
	 */
	public function isUser($user_id, $user_lookup = array() ){
		if ( !$user_lookup || empty($user_lookup) ) throw new Exception (self::EMPTY_USER_LOOKUP_EXCEPTION);
		return array_key_exists ( $user_id , $user_lookup) ;

	}

	/**
	 * Authentication service is separated from User, therefore we dont edit auth by applying encryption in a case of system authentication
	 * @param array $data
	 * @return int $id
	 */
	public function register($data){
		$data["password"] = md5($data["password"]);
		$this->user = Core_Util_Factory::build( $data, Core_Util_Factory::MODEL_USER ); 
		return $this->user->insert($this->user->toArray());
	}





	/**
	 * @param Mc_Entity_Entity $_object Usese
	 */
	public function editLandlordContact( Core_Entity_Contact $_object ){
		$_data = $_object->toArray();
		if( !((int)$_data['id'] > 0 ) ) unset($_data['id']);
		$_id = $this->edit( Core_Util_Factory::build( $_data, Core_Util_Factory::MODEL_LANDLORD_CONTACT ) );
		if( (int)$_id > 0  ){
			$_object->id = (int)$_id;
			return $_object;
		}
		return false;
	}


	public function getLandlordContact( $_mixed ){
		$_landlord_contact = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_LANDLORD_CONTACT ); 
		if( is_numeric( $_mixed ) ){
			$_tmp = $this->get($_landlord_contact, array( 'user_id' => $_mixed ) );
		}
		if( !isset($_tmp) ) throw new Exception( "Object needed @ ".__LINE__." " );
		return $_tmp;

	}



	 


	public function setBanned( $id, $banned = true ){
		$banned = ( $banned ) ? 1 : 0;
		$this->setField('banned', $banned, array ('table' => 'user', 'id_field' => 'id' , 'id_value' => $id )  );
		return true;
	}





	public function setActive( $id, $active = true ){
		$active = ( $active ) ? true : false;
		$this->setField('active', $active, array ('table' => 'user', 'id_field' => 'id' , 'id_value' => $id )  );
		return true;
	}


	public function editProfile($data){
		
		if ( $data instanceof Core_Model_Profile) $this->profile = $data;
		else $this->profile = Core_Util_Factory::build( $_data, Core_Util_Factory::MODEL_PROFILE );
		if($this->profile->user_id > 0 &&  $this->profile->profile_key != ""):
		try{
			$this->profile->insert($this->profile->toArray());
			return $this->profile->getAdapter()->lastInsertId();
		}catch(Exception $e){
			$this->profile_adapter = $this->profile->getAdapter();
			$where = $this->profile_adapter->quoteInto(" user_id = ? ",$this->profile->user_id);
			$where .= $this->profile_adapter->quoteInto(" AND profile_key = ? ",$this->profile->profile_key);
			$data = $this->profile->toArray();
			unset( $data['profile_key']);unset( $data['id']);
			
			$this->profile->update($data, $where );
			return $this->profile->user_id;
		}
		else:
			throw new Exception ( " EditProfile Exception " );
		endif;

	}




	function editAddress($data){
		if ( $data instanceof Core_Model_Address) $data = $data->toArray();
		$this->address = Core_Util_Factory::build( $data, Core_Util_Factory::MODEL_ADDRESS );
		if($this->address->id > 0):
		$this->address_adapter = $this->address->getAdapter();
		$this->address->update($this->address->toArray(), $this->address_adapter->quoteInto(" id = ? ", $this->address->id));
		return $this->address->id;
		else:
		$this->address->insert($this->address->toArray());
		return $this->address->getAdapter()->lastInsertId();
		endif;

	}


	/**
	 * @todo implement this function 
	 * @param integer $id
	 */
	function canDeleteAddress( $id = 0 ){
		return true;
	}




	/**
	 * @param array $data
	 */
	public function editAuth($data){
		$this->auth = $data;


		if ( !( $data instanceof Core_Model_Auth ) )
		$this->auth = Core_Util_Factory::build( $data, Core_Util_Factory::MODEL_AUTH ); 
		if( !($this->auth->user_id > 0) ) return false;


		if($this->auth->service == "system"):
			$this->auth->value = md5($this->auth->value);
		endif;

		if($this->auth->id > 0):
		$this->auth_adapter = $this->auth->getAdapter();
		return $this->auth->update($this->auth->toArray(), $this->auth_adapter->quoteInto(" id = ? ", $this->auth->id));
		else:
		return $this->auth->insert($this->auth->toArray());
		endif;
	}



	public function editAuthLog($data){
		
		$this->auth_log = $data;
		if ( ! ($data instanceof Core_Model_AuthLog) )
		$this->auth_log = Core_Util_Factory::build( $data, Core_Util_Factory::MODEL_AUTH_LOG );
	
		if($this->auth_log->id > 0):
		$this->auth_log_adapter = $this->auth_log->getAdapter();
		return $this->auth_log->update($this->auth_log->toArray(), $this->auth_log_adapter->quoteInto(" id = ? ", $this->auth_log->id));
		else:
		return $this->auth_log->insert($this->auth_log->toArray());
		endif;
	}






	/**
	 *
	 * @param array $data
	 * @return boolean | void
	 */
	public function editPassword($data ){
		$sql = "update auth set value = ? where ( user_id = ? and `key` = 'password' and service = 'system' )";
		$stmt = $this->db->query($sql, array(md5($data['password']), $data['user_id']));
	}


	/**
	 * Retuns the content of staff table.
	 * staff will be used to record staff members of a landlord.
	 * Staff members will be exenteded to either to agents, or to the staff through staff module
	 * @param array $options
	 * @return Collection | array
	 */
	public function getStaff( $options = array() ){
		$this->staff = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_STAFF );
		return $this->get( $this->staff, $options );
	}


	/**
	 * Editing a staff member
	 * @param array | object | Core_Model_Staff | Core_Entity_Staff  $mixed
	 * @return <type>
	 */
	public function editStaff( $mixed ){
		$this->staff = $mixed;
		if( $this->staff instanceof Core_Entity_Staff ) $this->staff = $this->staff->toArray();
		if( is_object($this->staff) && !($this->staff instanceof Core_Model_Staff ) ) $this->staff = (array)$this->staff;
		if( is_array( $this->staff ) ) $this->staff = Core_Util_Factory::build( $this->staff, Core_Util_Factory::MODEL_STAFF );
		if( !( $this->staff instanceof Core_Model_Staff ) ) throw new Exception( " Staff Model Parameter is required @ " .__LINE__ . "" );
		$this->staff->id = $this->edit( $this->staff );
		return ( is_string( $this->staff->id) ) ? $this->staff->id : $this->staff;
	}



	public function getUsers($options = array()){
		$sort = array ( 'field', 'limit', 'orderby', 'pg','pp', 'per_page', 'get_all', 'sort');
		$where = ""; $counter = 0;
		$this->user = Core_Util_Factory::build( $options, Core_Util_Factory::MODEL_USER);
		$this->user_adapter = $this->user->getAdapter();
		foreach($options as $k => $v ):
		if ( !in_array($k, $sort ) ){
			if($counter > 0 && $counter < count($options)):
			$where .=  $this->user_adapter->quoteInto(" AND `$k` = ? ", $v);
			elseif($counter == 0):
			$where =  $this->user_adapter->quoteInto(" `$k` = ? ", $v);
			endif;
			$counter ++;
		}
		endforeach;


		if ( isset($options['sort']) && !( true === $options['sort']  ) )
		return ($where != "")? $this->user->fetchAll($where):$this->user->fetchAll();
			
			

		$field = isset($options['field'])? $options['field'] : 'id';
		$limit = isset($options['limit'])? $options['limit'] : 0;
		$order = isset($options['orderby'])? $options['orderby']: 'ASC';
			

		if(isset($options['get_all']) && (true === $options['get_all']) ){
			$fetch_from = $this->user->select()->order($field.' '.$order);
		}else{
			$fetch_from = $this->user->select()->order($field.' '.$order)->limit( 20 , $limit);
		}
		$users = $this->user->fetchAll($fetch_from);
		return $users;

	}




	/**
	 *
	* @uses Core_Service_User::getUsers ()
	 *@return array | Core_Model_Customer
	 *
	 */

	public function getCustomer(){
		$customer = array();
		$tmp = $this->getUsers();
		foreach ( $tmp as $k => $user ){
			$customer [$user['id']] = $user;//
		}
		return $customer;//as array or a single object
	}

	/**
	 * @param string $email
	 */
	public function getUserByemail( $email ){
		$where = "";
		$this->user = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_USER );
		$this->user_adapter = $this->user->getAdapter();
		$where =  $this->user_adapter->quoteInto("  email = ? ", $email );
		$row = $this->user->fetchRow($where);
		return ( isset($row->id) && $row->id > 0 )? $row : false;
	}



	public function getUserLookup(){
		$sql  = "select user.id as id, name, user.category,user.active, email as email, auth.id as auth_id, auth.value as password
 					 from user join auth on user.id = auth.user_id
    					where auth.`key` = 'password' and auth.service = 'system'";
		$assoc = $this->db->fetchAssoc($sql);
		return ( $assoc)? $assoc : false ;
	}

	



	public function getProfile( $options = array() ){
		$_profile = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_PROFILE );
		return $this->get( $_profile, $options );


	}


	public function getContact( $options = array() ){
		$_profile = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_CONTACT );
		return $this->get( $_profile, $options );


	}



	/**
	 * this function is to edit TaxRate object
	 */
	public function editContact( $data ){
		$this->contact = $data;
		if ( is_array($this->contact) ) $this->contact = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_CONTACT );
		try{
			$id = $this->edit($this->contact);
			return $id;
		}catch(Exception $e ){
			return $e->getTraceAsString();
		}
	}





	/**
	 *
	 * @param integer $users_id
	 * @param integer $id
	 * @return array addresses
	 */
	function getAddress( $user_id = 0, $id = 0 ){

		$where = "";
		$this->address = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_ADDRESS );
		$this->address_adapter = $this->address->getAdapter();
		if($user_id > 0 && $id  > 0 ):
		$where = $this->address_adapter->quoteInto(" id = ?", $id)
		.$this->address_adapter->quoteInto(" AND user_id = ? ", $user_id);
		return $this->address->fetchRow($where);
		elseif( $user_id > 0):
		$where = $this->address_adapter->quoteInto(" user_id = ? ", $user_id);
		elseif( $id > 0):
		$where = $this->address_adapter->quoteInto(" id = ? ", $id);
		return $this->address->fetchRow($where);
		endif;
		return ($where != "")? $this->address->fetchAll($where):$this->address->fetchAll();
	}





	public function getUserInfo($options = array () ){

		if ( !$options['id']) throw new Exception ( self::USER_ID_NOT_FOUND_EXCEPTION );

		$user_id = $options['id'];
		return array (
			'profile' => $this->getProfile($user_id)->toArray(), 
			'address' => $this->getAddress($user_id)->toArray(), 
			'user' => $this->getUsers(array('id' => $user_id))->toArray(), 
			'address_shopping' => $this->getShoppingAddress($user_id)->toArray() 
		);

	}//end of function






	public function getLandlords( $options = array() ){
		$this->user = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_USER );
		$options['category'] = 'landlord';
		return $this->get( $this->user, $options );
	}
	 

	
	public function getLandlordsByProperty( $mixed = '' , $options = array() ){
		$this->property = $mixed;
		if( is_numeric($this->property)){
			$this->property = $this->get( Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_PROPERTY ), array( 'id' => $this->property) )->toArray();
			if( is_array($this->property[0]) ) $this->property = $this->property[0];
		}
		if( is_array( $this->property )) 
			$this->property = Core_Util_Factory::build( $this->property, Core_Util_Factory::MODEL_PROPERTY );
		$this->user = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_USER );	
		$this->user_table = $this->user->getTableName();
		$this->landlord = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_LANDLORD);	
		$this->landlord_table = $this->landlord->getTableName();
		$_sql = "SELECT *, `".$this->user_table."`.id as user  FROM `".$this->user_table."` LEFT JOIN `".$this->landlord_table."` ON ".$this->landlord_table.".property_id = ".$this->property->id." WHERE `".$this->user_table."`.category = 'landlord' ";
		return $this->db->query($_sql)->fetchAll();
	}


	public function get_nb_users_period($start_time = "", $end_time = ""){
		$data = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_USER );
		$table_name = $data->getTableName();
		if($start_time != ""){
			$sql = "select count(id) as users from $table_name where created between '$start_time' and '$end_time'";
		}
		else{
                $sql = "select count(id) as users from $table_name";
             }
             return $this->db->query($sql)->fetchAll();
             
        }// end function 
	
	
}
?>