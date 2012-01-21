<?php
/**
 * This class holds details about session logs 
 * this will help to detect identity theft, allow the user to know where an when he/she has been logged in
 * this will allow also to know where the client has more customers. 
 * will serve for analytics, and geo marketing 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0
 * @uses Core_Model_Auth
 */
class Core_Model_AuthLog extends Core_Model_Abstract {
	
	protected $_name = 'auth_log';
	protected $_referenceMap = array("Auth" => array("columns" => array("auth_id"),"refTableClass" => "Core_Model_Auth","refColumns" => array("id") ));
	public $_data = array();	
	
	
	public function __construct( Core_Entity_AuthLog $data){
		parent::__construct($data);
			
	}
	
	
}//end of class
?>