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
                'payment' => "",
                'lease_type_id' => 1,
                'booking_id' => 0,
                'rent' => 0.00,
                'status' => '',
                'cycle' => '',
                'movein' => '000-00-00 00:00:00',
                'moveout' => '000-00-00 00:00:00',
                'created' => '000-00-00 00:00:00',
				'modified' => '000-00-00 00:00:00'
               );
		
		
		public function __construct( $data ){
                    parent::__construct($data);
		}
		
}

?>