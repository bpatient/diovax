<?php
/**
 * This class is the top level Model class. 
 * It contains accessor methods that will be needed by any other model class 
 * It is inspired by the class found at @link 
 * @author Pascal Maniraho 
 * @version 1.0.1
 * @uses Zend_Db_Table_Abstract
 * @link http://www.survivethedeepend.com/zendframeworkbook/en/1.0/implementing.the.domain.model.entries.and.authors#zfbook.implementing.the.domain.model.entries.and.authors.the.domain.model.and.database.access.patterns
 */
class Core_Model_Abstract extends Zend_Db_Table_Abstract{
	
	
	protected $_name = "";
	protected $_data = array();
    protected $dto; 
	public function __construct($data = null ){

	
		
	if( $data == null || $data == "" ) 
		throw new Exception ( "Parameter not supported @ ".__CLASS__." ".__LINE__." " );	
		
       if( $data instanceof Core_Entity_Abstract ){
       		$data = $data->toArray();
       		$this->dto = $data;
       }
       if(!is_null($data) && is_array($data)):
			 foreach ($data as $name => $value):
			 	$this->{$name} = $value;
			 endforeach;			 		  
			 $this->dto = new Core_Entity_Abstract( $data );
		endif;
		parent::__construct();
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
	
	
	
	public function getTableName(){
		if ( $this->_name && $this->_name != "" )
			return $this->_name; 
		throw new Exception ( " NO TABLE NAME FOUND FOR ".__CLASS__." ");
	}
	
	
	/**The following proxy method, will allow us to access the primary key*/
	public function getPrimaryKey(){
		$primary = $this->info('primary');
		/*this works on row set object and not on table object return $this->_getPrimaryKey();*/
		return $primary;
	}

        public function getToken(){
		$c = "".__CLASS__."";
		$c = $c."::".time();
		$_token = md5( $c );//tiger 
		return $_token;
	}


	
	
	
}//end of the function

?>