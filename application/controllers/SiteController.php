<?php
class SiteController extends Core_Controller_Base
{

	
	/***/
	public function init(){
		parent::init();
		$this->_identity = Zend_Auth::getInstance()->getIdentity();
		$this->view->identity = $this->_identity;
		
		
	}


	//predispatch checks only if there some variables set or set them otherways
	public function preDispatch(){
		parent::preDispatch();
	}

	public function indexAction(){
		parent::index();
	}

	/**
	 * @todo redirect after sending a successful message 
	 */
	public function contactAction(){
		$this->view->form = new Core_Form_SiteContact();
		if( $this->isPost ){
			if( $this->view->form->isValid($this->post)  ){
				$this->message_service->sendSiteContactMessage( $this->view->form->getObject() );
			}else{
				$this->view->message = $this->view->form->getMessage();
			}			
		}
		
	}
	
	
	
	//
	public function postDispatch(){
		parent::postDispatch();
	}
	 
	 
}//
?>