<?php 
	class Core_Entity_User extends Core_Entity_Abstract{ 
		
		protected $_data = array ( 'id' => 0,'name' => null,'email' => null,'created' =>'0000-00-00 00:00:00','approved' => false );
		public function __construct($data = array() ){
		parent::__construct($data );
	}
 }
?>