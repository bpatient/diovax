<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 */
class Admin_PropertyController extends Core_Controller_Base
{



	public function init()
	{
		parent::init();
	
	
	}//init
	
	
	/**
	 */
	public function preDispatch(){
	parent::preDispatch();
	}
	
	
	
	/***
	* this action will handle ajax request to set/reset some statuses.
	 *
	*/
	public function ajaxAction(){
	
	 
	}
	
	
	
	
	
	
	/*lists all users in the system */
		public function indexAction()
	{
	parent::index();
	  
	}
	
	
	/**
	 * @internal to stick on specs, the form has to have both the property and the property address. 
	 * @todo there should be the scroll down to designate the owner of this property as well 
	 */
	public function editAction()
	{
		
		$_combo = array();
		$this->property = Core_Util_Factory::build(array(), Core_Util_Factory::ENTITY_PROPERTY);
		$this->address = Core_Util_Factory::build(array(), Core_Util_Factory::ENTITY_ADDRESS);
	 	$this->view->form  = new Core_Form_Property();
	 	if( $this->isPost ){
	 		if( $this->view->form->isValid($this->post) ){
	 			$this->property = $this->view->form->getPropertyObject();
	 			$this->address = $this->view->form->getAddressObject();
	 			//@todo add a user as well 
	 			$_combo = array ( "property" => $this->property , "address" => $this->address );
	 			$this->view->property = $this->property_manager->editPropertyAndAddress( $_combo );
	 		}else{
	 			$this->view->message = $this->view->form->getMessages();
	 		}
	 	}
	 	//
	 	if( isset($_combo) ){
	 		$this->view->form->populate( $_combo );
	 	}
		
	}
	
	
	/*lists all users in the system */
	public function operationAction()
	{
	 
	}
	
	
	
	public function postDispatch(){
	parent::postDispatch();
	 $this->view->subMenu = $this->view->adminMenu($this->property ,array("display" => Core_Util_Settings::MENU_ADMIN_CONTROLLER_PROPERTY) );
	}

}
?>