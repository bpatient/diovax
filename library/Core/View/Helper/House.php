<?php 

  /**
   * this view helper will display the house.
   * it will be used in any view file => admin/front-end/agent && tech 
   * */
  class Core_View_Helper_House extends Core_View_Helper_Base{
    /***/
    public function house( $mixed = "", $options = array( 
					'edit_widget' => '','image' => '',
					'class' => 'house-widget', 'event' => 'js-events', 
					'site' => '','tenant' => '', 'ticket' => '', 'landlord' => '', 
					'rating' => ''  
			) ){ 
		$_html = '';
			
		return $_html;
	}
	
	
	
	
	
  }  
?>