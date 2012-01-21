<?php
/**
 *
 * @author Pascal Maniraho
 * @version 1.0.0
 *
 *
 */
class Admin_LeaseController extends Core_Controller_Base
{




	public function init(){
		parent::init();
		$this->view->lease = new Core_Model_Lease();
		//
		$this->options = array();
		$this->options['data'] = array();
	}



	public function preDispatch(){
		parent::preDispatch();
	}


	/***/
	public function indexAction(){
		parent::index();
		$_header_titles = array(  'Period' ,   'Units' ,   'Sales' ,   'Tax' ,   'Shipping' ,   'Net'  );
		$_footer_titles = array(  '-' ,   '-' ,   '-' ,   '-' ,   '-' ,   '-'  );
		$data = $this->rent_service->getLeases()->toArray();
		$this->view->content = $this->view->table = $this->view->leasesTable( $data , array( 'header' => $_header_titles, 'footer' => $_footer_titles ) );
	}


	/**
	 * This function will show specific tasks for a a particular property, and should be able to show how its being handled
	 * @return void
	 */
	public function propertyAction(){

		$this->tmp = $this->rent_service->getTasks( array() )->toArray();

		$this->view->data = $this->tmp;
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