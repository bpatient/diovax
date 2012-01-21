<?php
/**
 */ 
class Admin_LocationController extends Core_Controller_Base
{


	/***/
    public function init(){ parent::init();
 //
            $this->options = array();
            $this->options['data'] = array();

                }
	/***/
    public function preDispatch(){ parent::preDispatch(); }
	/***/
    public function indexAction()
    {
		/**querying*/
		$this->view->data =  $this->rent_service->getSites()->toArray();  
	}
	
	/*this action willl deal with create and update*/
	public function editAction(){
				
		$_id = $this->_getParam('id');	
		$redirect  = false;
		if( $this->id > 0){	
	     	$this->view->data = $this->view->content = $this->rent_service->getSites( array('id' => $this->id ) )->toArray();
		}		
		$this->view->form = new Core_Form_Site();		
		$class = $this->view->form->description->getAttrib('class').' no-rich-text';
		$this->view->form->location->setAttrib('class', trim($class) );
		$this->view->form->description->setAttrib('class', trim($class) );
		
		if( $this->view->form->id->getValue() > 0 ){
			$this->view->form->populate($this->view->data);/***/ 
		}
		/**disabling rich text editor */
    	$class =  $this->view->form->description->getAttrib('class').' no-rich-text';
    	$this->view->form->description->setAttrib('class', trim($class) );
    	if( $this->isPost ){    		
			if( !$this->view->form->isValid($this->post) ){
				$this->view->message = $this->view->form->getMessages();
			}else{ 				 
				$id = $this->rent_service->editSite($this->view->form->getObject()->toArray());
				if( !is_numeric($id) )$this->view->message = $id;
			}
		}		
		/***/
		$this->view->data = $this->view->data[0]? $this->view->data[0] : $this->view->data;
		if( $this->view->data ){
			$this->view->form->populate( $this->view->data );
		}	
		echo "<div class='notice'>location controller</div>";
		if( true === $redirect ) $this->_redirect('admin/property/location/'.$id);/// 
	    	    	
	}//end of edition 
	
	
	/***/ 
	public function deleteAction(){		
			
	}
	
	
	public function viewAction(){
		$this->view->content = "View comment and set flags...";
	}




      public function postDispatch(){
        parent::postDispatch();
       $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }
/***/
}
?>