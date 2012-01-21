<?php
/**
 * Auth Service manages authentication related tasks. 
 * @author Pascal Maniraho 
 * @todo refactoring 
 */
class Core_Service_Auth extends Core_Service_Database {	
	
	
	
	
	
	
	const UN_SUPPORTED_PARAMETER_EXCEPTION = 1000; //
	
	private $logger;
	
	
	public function __construct(){
		parent::__construct();
		$this->logger = false;
	}
	/**
	 * @param array $options
	 */
	public function getAuth($data = array () ){
		
		$where = "";
		$this->auth = Core_Util_Factory::build(array(), Core_Util_Factory::MODEL_AUTH);
		$this->auth_adapter = $this->auth->getAdapter();
		$fields = $this->auth->info(); 
		$counter = null;
		$data_counter = count($data);
		foreach($data as $k => $v ):
		 if ( in_array($k, $fields['cols'] ) ){
			if ( !$counter ) $where =  $this->auth_adapter->quoteInto(" `$k` = ? ", $v);
			if($counter > 0 && $counter < $data_counter )
				$where .=  $this->auth_adapter->quoteInto(" AND `$k` = ? ", $v);
			$counter += 1;
		}
		endforeach; 
		return ($where != "")? $this->auth->fetchAll($where):$this->auth->fetchAll();
	} 
	
	
	
	
	/**
	 * This function will be used to set active status after the user logs in 
	 * @param int $auth_id 
	 * @return void 
	 */
	public function setActive( $auth_id = 0 ){ 
		if( !($auth_id > 0 ) ) return false;
		$auth = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_AUTH );
		$this->setField('active', 1, $options = array ('table' =>  $auth->getTableName(), 'id_field' => 'id' , 'id_value' => $auth_id )  );	

	}
	
	/**
	 * @param int $auth_id
	 */
	public function resetActive( $auth_id = 0 ){
		if( !($auth_id > 0 ) ) return false;
		$auth = Core_Util_Factory::build(array(), Core_Util_Factory::MODEL_AUTH);
		$this->setField('active', 0, $options = array ('table' =>  $auth->getTableName(), 'id_field' => 'id' , 'id_value' => $auth_id )  );	
	}
	
	
	

	/**
	 * This function will be used to de-activate the user after he/she logs-out  
	 * @param array $data
	 * @return void 
	 */
	public function editAuth($data){
		
		
	
		$this->auth =  $data;
		if ( is_array ( $this->auth ) )  $this->auth = Core_Util_Factory::build($data, Core_Util_Factory::MODEL_AUTH);//data for matter of simplicity 
		$this->auth_adapter = $this->auth->getAdapter();

		
		if ( !($this->auth instanceof Core_Model_Auth) ) throw new Exception ( self::UN_SUPPORTED_PARAMETER_EXCEPTION ); 	
		
		if($this->auth->id > 0):
			$where =  $this->auth_adapter->quoteInto(" id = ? ", $this->auth->id); 
			$data = $this->auth->toArray(); unset($data['id']);		
			$this->auth->update($data, $where);
			return $this->auth->id; 
		endif;	
		$this->auth->insert($this->auth->toArray());
		return $this->auth_adapter->lastInsertId();
	} 
	
	
	
	
	
	
	
	/**
	 * 
	 * @param array|Object  $data
	 */
	public function editAuthLog($data){
		
			
		$this->auth_log =  $data;
		if ( is_array ( $this->auth_log ) )  $this->auth_log = Core_Util_Factory::build($data, Core_Util_Factory::MODEL_AUTH_LOG);//();//data for matter of simplicity 
		$this->auth_log_adapter = $this->auth_log->getAdapter();
		if ( !($this->auth_log instanceof Core_Model_AuthLog) ) throw new Exception ( self::UN_SUPPORTED_PARAMETER_EXCEPTION );		
		if($this->auth_log->id > 0):
			$where =  $this->auth_log_adapter->quoteInto(" id = ? ", $this->auth_log->id); 
			$data = $this->auth_log->toArray(); unset($data['id']);		
			$this->auth_log->update($data, $where);
			return $this->auth_log->id; 
		endif;	
		
		$this->auth_log->insert($this->auth_log->toArray());
		return $this->auth_log_adapter->lastInsertId();
		/**return 0;*/
	}

	
	
	/**
	 * 
	 * we can delete this auth using user_id, or auth id 
	 * 
	 * @param array $options
	 */
	public function deleteAuth($options = array('id') ){
		$obj = Core_Util_Factory::build(array(), Core_Util_Factory::MODEL_AUTH);
		$this->delete( $options['id'],  $obj );
	}

	
	/**
	 * We can delete this authDetails using id 
	 * @param array $options
	 */
	public function deleteAuthLog($options = array('id') ){
		$obj = Core_Util_Factory::build(array(), Core_Util_Factory::MODEL_AUTH_LOG);
		$this->delete( $options['id'], $obj );
	} 
	 
	
	/**
	 * 
	 * 
	 * @param $id
	 * @param Zend_Db_Table_Abstract $obj
	 */
	function delete($id, $obj ) {
		if ( !($obj instanceof Zend_Db_Table_Abstract) ) throw new Exception ( self::UN_SUPPORTED_PARAMETER_EXCEPTION );
		
		if ( !($id > 0)  ) return false; 
			$where = $obj->getAdapter()->quoteInto(' id = ?', $id);			
			$obj->delete( $where );
		return true;
		
	}
	
	
	/**
	 * @param array $options
	 */
	public function getAuthLog( $options = array() ){
		$where = "";
		$this->auth_log =  Core_Util_Factory::build(array(), Core_Util_Factory::MODEL_AUTH_LOG);
		$this->auth_log_adapter = $this->auth_log->getAdapter();
		$auth_id = isset($options['auth_id']) ? $options['auth_id'] : '';
		$id = isset($options['id']) ? $options['id'] : '';
		
		if($auth_id > 0 && $id  > 0 ):
			$where = $this->auth_log_adapter->quoteInto(" id = ?", $id)
					.$this->auth_log_adapter->quoteInto(" AND auth_id = ? ", $auth_id);
					return $this->auth_log->fetchRow($where);
		elseif( $auth_id > 0):
			$where = $this->auth_log_adapter->quoteInto(" auth_id = ? ", $auth_id);
		elseif( $id > 0):
			$where = $this->auth_log_adapter->quoteInto(" id = ? ", $id);
		endif;
		return ($where != "")? $this->auth_log->fetchAll($where,'id DESC'):$this->auth_log->fetchAll();
		
	} 
	
		
		
		
		
		
		
		
		
		/**
		 * 
		 * 
		 * @param array $options 
		 * @return Core_Model_User | array $user 
		 * 
		 */		
		public function getUserAuthLog( $options = array() ){
			
			if ( $options['cookie'] ) $cookie = $options['cookie'];
			if ( $options['sessionid'] ) $sessionid = $options['sessionid'];
			if ( $options['user_id'] ) $user_id = $options['user_id'];
			if ( $user_id > 0 );
			if ( $cookie != $sessionid ) throw new Exception ( "Session and Cookie are different " );
			$sql = 'SELECT DISTINCT auth_log.id as id, auth_id, sessionid, bag, ip, user.id as user_id, user.name as name 
					FROM auth_log, auth, user  
					WHERE user.id = auth.user_id AND user.id = ? AND sessionid =  ? ';
			$assoc = $this->db->fetchAssoc($sql, array ($user_id, $sessionid) ); 
			return ( $assoc)? $assoc : false ;	
		}
		
		
		
	
		
		
		
		/**
		 * 
		 * @param string $sessionid
		 * @param integer $auth_id
		 * @return void 
		 */
		public function updateAuthLogAuthId($sessionid, $auth_id){
			$sql = 'UPDATE auth_log SET auth_id = ? WHERE ( auth_id = -1 AND sessionid = ? )';
			$stmt = $this->db->query( $sql, array($auth_id, $sessionid) );
		}
		
		
		
	
		
		
		

		
		
		/**
		 * This function will return auth_id  
		 * @param integer $user_id
		 * @return false | array  $assoc | false 
		 */
		public function getUserAuthId ( $user_id ){
			$assoc = $this->db->fetchAssoc( 'SELECT distinct auth.id as auth_id FROM auth, user  WHERE user.id = auth.user_id AND user.id = ? ', $user_id ); 
			return ( $assoc)? $assoc : false ;	
		}
		
	
		
		
		
     

}


?>