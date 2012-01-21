<?php
/**
 * @author Pascal Maniraho 
 * @version 1.0.0
 *
 */
class Admin_AnalyticsController extends Core_Controller_Base
{
	
	
	
   	
   public function init()
    {
    	parent::init();
        $this->options = array();
        $this->options['data'] = array();
    }
    

    
    public function preDispatch(){
        parent::preDispatch();
    }
    
    
    public function indexAction(){   	
        parent::index();
        
    }
    
    
    
    
  

      public function postDispatch(){
        parent::postDispatch();
       $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }



}//end of the controller 


?>