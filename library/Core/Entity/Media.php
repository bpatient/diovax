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

class Core_Entity_Media extends Core_Entity_Abstract {
		protected $_data = array (
		'id' => 0,
		'title' => null,					
		'description' => '',				
		'url' => null,
		'owner' => null,
		'displayed' => false,
		'created' => '0000-00-00 00:00:00',
		'modified' => '0000-00-00 00:00:00'			
	);
		function __construct($data = array() ){			
			parent::__construct($data );
			
		}
		
}

?>