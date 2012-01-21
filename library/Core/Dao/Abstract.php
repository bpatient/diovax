<?php


class Core_Dao_Abstract implements Core_Dao_Dao{
	
	
	
	private $db, $dto, $persistance;
	public function __construct( Core_Entity_Abstract $dto ){
		$this->db =  $this->persistance = Zend_Registry::get("database");
		$this->dto = $dto;
		
	}
	
	

	
	
	
	public function save(){}
	public function getAll(){}
	public function get(){}
	public function delete(){}
	
	
	//
	public function getPersistance(){
		return $this->persistance;
	}
	
	
	
	// TODO add the right persistance instance to use in this case, deal with exception
	/**
	 * @deprecated
	 */
	public function setPersistance( $persistance ){
			$this->persistance = $persistance;
	
	}
	
	
	
	
}

