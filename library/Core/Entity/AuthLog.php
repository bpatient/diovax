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

class Core_Entity_AuthLog extends Core_Entity_Abstract {
	
	
		protected $_data = array (
		'id' => 0,
		'auth_id' => "",
		'sessionid' => "",
		'bag' => "",
		'agent' => "",
		'ip' => '000.000.000.000', 
		'starts' => '0000-00-00 00:00:00', 
		'stops' => '0000-00-00 00:00:00', 
		'location' => null, 
		'modified' =>'0000-00-00 00:00:00'
	);
		public function __construct($data = array() ){			
			parent::__construct($data );
			
		}
		
}

?>