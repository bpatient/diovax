<?php
/**
 * This class will be used to make it possible to serialze and unseliaze the address object
 *  @author Pascal Maniraho
 *  @see
 *  @uses
 *
 *
 *
 * this class will be used to transfer objects whenever object transfer is needed
 */

class Core_Entity_Address extends Core_Entity_Abstract {
		
	
		protected $_data =	array (	
							'id' => 0,
							'user_id' => 0,
							'displayed' => true,
							'address_type' => null,
							'address_key' => null,
							'address_value' => null,
							'note' => null,
							'modified' =>'0000-00-00 00:00:00'	
						);	
		public function __construct($data = array() ){			
			parent::__construct($data );
			
		}
		
		
		
		
}

?>