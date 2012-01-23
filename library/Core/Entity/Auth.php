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

class Core_Entity_Auth extends Core_Entity_Abstract {
		protected $_data = array (
		'id' => 0,
		'users_id' => 0,
		'password' => null,
		'type' => 'password',
		'connected' => '000-00-00 00:00:00',
		'disconnected' => '000-00-00 00:00:00',
		'ip' => 0,
		'country' => null
	);
		public function __construct($data = array() ){			
			parent::__construct($data );
			
		}
		
}

?>