<?php


class Core_Service_Abstract implements Core_Service_Manager{
	
	
	
	
	protected $db, $logger;//
	public function  __construct( ){
		$this->db = $this->getDb();
		//$this->logger = Zend_Registry::get("logger");
		$writter = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/configs/logger.txt');
		$this->logger = new Zend_Log( $writter );
		
	}

	
	
	
	/**
	 * (non-PHPdoc)
	 * @see Core_Service_Manager::getDb()
	 */
	public function getDb(){
		$database = Zend_Registry::get("database");
		//Zend_Db_Table_Abstract::setDefaultAdapter( $_adapter );
		return $database;
	}
	
	
	
	


	
	
	
}


