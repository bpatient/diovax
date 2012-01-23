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

class Core_Entity_Lease extends Core_Entity_Abstract {
		protected $_data =  array (
                'id' => 0,
                'property_id' => 0,
                'start' => '000-00-00 00:00:00',
                'ends' => '000-00-00 00:00:00',
                'started' => false,
                'owner' => null
               );
		
		
		public function __construct( $data = array() ){
                    parent::__construct($data);
		}
		
}

?>