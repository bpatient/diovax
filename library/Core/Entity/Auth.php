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
		'user_id' => 0,
		'service' => null,
		'key' => null,
		'value' => null,
		'modified' => 0,
		'active_time' => 0,
		'active' => false
	);
		public function __construct($data = null ){			
			parent::__construct($data );
			
		}
		
}

?>