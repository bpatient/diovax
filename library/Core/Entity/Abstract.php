<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Core_Entity_Abstract implements Core_Entity_Dto{








        protected $_name = "";
	protected $data = array();
	public function __construct( array $data = null ){
            if(!is_null($data) && is_array($data)):
                     foreach ($data as $name => $value ):
                         $this->{$name} = $value;
                     endforeach;
            endif;
	}


        #
         public function getTableName(){
               return $this->name;
         }


        //we need a toArray function
         public function toArray(){
               return $this->data;
         }


        


	/**
	 *
	 * @param $name
	 * @return unknown_type
	 */
	public function __get($name){
		if(array_key_exists($name, $this->data)):
			return $this->data[$name];
		endif;

	}

	/**
	 *
	 * @param unknown_type $name
	 * @param unknown_type $value
	 * @return unknown_type
	 */
	public function __set($name, $value){
		$this->data[$name] = $value;
	}

	/**
	 *
	 * @param unknown_type $name
	 * @return unknown_type
	 */
	 public function __isset($name){
	        return isset($this->data[$name]);
	}

	/**
	 *
	 * @param unknown_type $name
	 * @return unknown_type
	 */
	public function __unset($name){
		if (isset($this->data[$name])):
			unset($this->data[$name]);
		endif;
	}//end of the function


         public function getToken(){
		$c = "".__CLASS__."";
		$c = $c."::".time();
		$_token = md5( $c );
		return $_token;
	}
	
        

}
?>

