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
	
	
	/*lists all users in the system */
	public function editAction()
	{
	 
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