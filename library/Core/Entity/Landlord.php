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

class Core_Entity_Landlord extends Core_Entity_Abstract {
		protected $_data = array( 'property_id' => 0, 'user_id' => 0, 'status' => '', 'since' => '0000-00-00 00:00:00', 'created' => '0000-00-00 00:00:00', 'modified' => '0000-00-00 00:00:00' );
		public function __construct( $data = array() ){
                    parent::__construct($data);
		}
}
?>