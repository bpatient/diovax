<?php
/**
 * This class will be used to make it possible to serialze and unseliaze the address object
 * @author Pascal Maniraho
 * @see
 * @uses
 *
 *
 *
 * this class will be used to transfer objects whenever object transfer is needed
 */
 class Core_Entity_Property extends Core_Entity_Abstract {
        protected $_data = array ( 
		'id' => 0, 	
		'parent' => -1,
		'site_id' => 0 ,	
		'unit' => 0,
		'unit_code' => "",
		'rent' => 0,
		'name' => 0,
		'description' => '',
		'built' => '0000-00-00 00:00:00',	
		'created' => '0000-00-00 00:00:00',
		'modified' => '0000-00-00 00:00:00',		
		'token' => '' 
     );
        public function __construct( $data = null ){
            parent::__construct( $data );
        }
}
?>