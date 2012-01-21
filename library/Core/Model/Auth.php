<?php
/**
 * This model references auth table 
 * auth table will be used to manage authentication and 
 * record information regarding session such as active time[ in a case a user wants to be connected for x time] 
 * connected user [ active is set as long as current session is alive: this will help the admin to know how many people are connected now ] 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Core_Model_AuthLog
 *
 */
class Core_Model_Auth extends Core_Model_Abstract {
	/*Active time should be kept in auth_log table */
		
	protected $_name = 'auth';
	protected $_referenceMap = array(
		"User" => array(
						"columns" => array("user_id"),
						"refTableClass" => "Core_Model_User",
						"refColumns" => array("id")
		)	
	);
	protected $_dependantTables = array('Core_Model_AuthLog');
	
	
	
	
	public $_data = array();	
	public function __construct(Core_Entity_Auth $data){
		parent::__construct($data);
			
	}
}//end of class

?>