<?php
/**
 * This class will be used to make it possible to serialze and unseliaze the address object
 *  @author Pascal Maniraho
 *  @see
 *  @uses
 */

class Models_Address extends Models_Base {
		protected $_data = array ('name' => '', 'street' => '',  'city' => '',  'country' => '',  'prs' => '',
				'longitude' => '', 'latitude' => '', 'verified' => '',				'postal'  => '',
				'telephone'  => '');
		
		
		public function __construct($data){			
			parent::__construct($data);
			
		}
		
}

?>