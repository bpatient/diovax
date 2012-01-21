<?php

 
 class Core_Dao_AuthLog extends Core_Dao_Abstract{
	private $dto;
	public function __construct( Core_Entity_Abstract $data ){
		parent::__construct( $data );
		$this->dto = $data;
	}

}
?>