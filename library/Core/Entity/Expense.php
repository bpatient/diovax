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

class Core_Entity_Expense extends Core_Entity_Abstract {
		public $_data = array( 'id' => 0 , 'name' => '', 'url' => '',   'enabled' => '',  'address' => '', 'logo'  => '', 'telephone'  => '',	'user_id'  => '' );
		public function __construct( $data  = array()  ){
                    parent::__construct($data);
		}
}
?>