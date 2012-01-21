<?php
/**
 */

class Core_View_Helper_LeaseWidget extends Core_View_Helper_Base{

	
	
	
	/**
	 * This variable will be used accross the class
	 */
	private $lease; 
	
	
	
	
	
	/**
	 * 
	 * @param $lease
	 */
	public function __construct( $lease = null ){
    parent::__construct();
		$this->lease = $lease;
		if( $this->lease == null ){ $this->lease = new Core_Util_lease();}
	}
	
	
	
	/***/	 
	public function leaseWidget( $data , $options = array() ){
		
		$this->data = isset($data) ? $data : '';		
		if( empty($this->data)  ) return "";
			
		$this->lease = ( $this->data instanceof Core_Model_lease ) ? ; 
		$this->selected = $this->lease->selected ? $this->lease->selected : $this->selected;
	   
		/***/
    return  '<div class=\'lease-widget-container\'  id=\'lease-widget-container-'.(str_replace(' +','-',strtolower($this->lease->name))).'\' >'.$content.'</div>';
	}
	
	
	
	
	
}
?>