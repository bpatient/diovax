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

class Core_Entity_Country extends Core_Entity_Abstract {
		protected $_data = array (
		'id' => 0,
		'name' => null,
		'code' => null,
        'active' => null
	);
		public function __construct($data = array() ){			
			parent::__construct($data );
			
		}
		
}

?>