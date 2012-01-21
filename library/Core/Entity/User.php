
<?php 
	class Core_Entity_User extends Core_Entity_Abstract{ 
		
		
		//protected $_data = array('id' => 0,'name' => null,'email' => null,	'birthday' => null,'category' => "tmp",	'banned' => 0,	'active' => 1,'modified' => '0000-00-00 00:00:00','created' =>'0000-00-00 00:00:00','token' =>'' );
		protected $_data = array ( 'id' => 0,'name' => null,'email' => null,	'birthday' => null,'category' => "tmp",	'banned' => 0,	'active' => 1,'modified' => '0000-00-00 00:00:00','created' =>'0000-00-00 00:00:00','token' =>''  );
		
		public function __construct($data = array() ){
		parent::__construct($data );
	}
 }
?>