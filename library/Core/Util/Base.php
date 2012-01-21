<?php
	
	/**
	 * 
	 * This class will have basic functions that are used will all utility classes.
	 * @author Pascal Maniraho
	 *  
	 */

	class Core_Util_Base {
		
		
		/**Setters and getters**/
		/***/
		public function _get( $name ){ 
			if(property_exists($this, $name)):
				return $this->$name;		
			endif; 
		}
		public function __set($name, $value){
			$this->$name = $value;
		}
		
		
		/**
		 * Initialize data in the array to properties of this class 
		 * @param $data
		 */
		function __construct( array $data = null ){
			if(!is_null($data) && is_array($data)):
				 foreach ($data as $name => $value):
				 	/**If there is any problem with this, please replace it with the name of this class*/
				 	if(property_exists($this,$name)) $this->{$name} = $value;
				 endforeach;			 		  
			endif;
		}
		
		
	 	/**Adding information to show when toString is called*/
		public function toString(){}
		/**
		 * This function will return the data representation of this objec t
		 */
		public function toArray(){}
		

		
		/**will be used before sending the object to the database*/
		public function getSerialized(){ 					
			$data = @serialize($this); /**preventing the object to get serialized two times */
			return ( $data === false )? $this : $data;	
		}
		
		
		
		
		/***/
		public function getUnserialized(){ 
			$obj = @unserialize($this);//checking if the object is serialized or not.
			return ($obj === false ) ? $this : $obj; 
		}
		
			
	static function format_price( $price = 0.00 ){
		$price = number_format($price, 2, '.', '');
		try{
			$currency = new Zend_Currency(); 
			$price = 	$currency->getSymbol().' '.$price;
			
		}catch( Exception $e ){
		}
		return $price;
	}
	
}/**End of the class */
?>