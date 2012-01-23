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
		$this->view->form = new Core_Form_Contact();
		if( $this->isPost ){
			if( $this->view->form->isValid($this->post)  ){
				$this->message_service->sendSiteContactMessage( $this->view->form->getObject() );
			}else{
				$this->view->message = $this->view->form->getMessage();
			}
		}

	}



	/**
	 * @todo get details about one house and display it
	 */
	public function viewAction(){

	}
	/**
	* @todo get details about one house and display it
	*/
	public function policyAction(){
	
	}
	


	public function listAction(){

	}
	
	public function aboutAction(){

	}


	/**
	 * @todo send email with information from the form
	 */
	public function quoteAction(){

	}




	/**
	 * @internal following functions are used for the sole purpose of seing how the original pages looks like
	 */



	public function articleAction(){
			
	}




	public function newsAction(){

	}

	public function pageAction(){

	}


	public function searchAction(){

	}

	public function singleAction(){

	}



	//
	public function postDispatch(){
		parent::postDispatch();
	}


}//
?>