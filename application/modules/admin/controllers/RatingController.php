<?php



/**
 * 
 * 
 * This controller will be used with Ajax, to update and display rating, 
 * comment widgets 
 * 
 * 
 * lists all ratings 
 * 
 * 
 * 
 * 
 * 
 * @author Pascal manirahop 
 * 
 * 
 * T
 *
 */
class RatingController extends Core_Controller_Base{

	
	/**list polling results in this area */
	public function indexAction(){
		throw new Exception("RatingController not yet implemented");
	}
	
	
	
	

      public function postDispatch(){
        parent::postDispatch();
       $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }
	
	
	
	
}