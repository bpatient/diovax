<?php

/*
 * 
 *  This class does a lot of job as its clone
 * @author Pascal Maniraho 
 * @version 1.0.1
 * @uses Zend_Db_Table_Abstract
 *
 */
class Models_Base {
	
	
	protected $_data = array();	
	public function __construct(array $data = null){		
		if(!is_null($data) && is_array($data)):
			 foreach ($data as $name => $value):
			 	$this->{$name} = $value;
			 endforeach;			 		  
		endif;
	}
	
	
	
	/*function to array returns the content of this class to formatted as an array*/
	public function toArray(){		
		return $this->_data;
	}
	/**
	 * 
	 * @param $name
	 * @return unknown_type
	 */
	public function __get($name){
		if(array_key_exists($name, $this->_data)):
			return $this->_data[$name];		
		endif;
		
	}
	
	/**
	 * 
	 * @param unknown_type $name
	 * @param unknown_type $value
	 * @return unknown_type
	 */
	public function __set($name, $value){
		$this->_data[$name] = $value;		
		
	}
	
	/**
	 * 
	 * @param unknown_type $name
	 * @return unknown_type
	 */
	 public function __isset($name){ 
	        return isset($this->_data[$name]);    
	}     
	
	/**
	 * 
	 * @param unknown_type $name
	 * @return unknown_type
	 */
	public function __unset($name){        
		if (isset($this->_data[$name])):          
			unset($this->_data[$name]);        
		endif;    
	}//end of the function
	
}//end of the function

?>