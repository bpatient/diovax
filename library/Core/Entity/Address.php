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
							'owner' => null,
							'line_one' => null,
							'line_two' => null,
							'city' => null,
							'country' => null,
							'prs' => null,
							'latitude'=>0,
							'longitude'=>0
						);	
		public function __construct($data = array() ){			
			parent::__construct($data );
			
		}
		
		
		
		
}

?>