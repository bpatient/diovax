<?php
/**
 *
 * This controller will display the dashboard
 *
 * @uses should use Core_Controller_Base
 *
 */
class Admin_IndexController extends Core_Controller_Base
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



	/*lists all users in the system */
	public function indexAction()
	{
		parent::index();
		echo "Dashboard";
		 
	}





	public function postDispatch(){
		parent::postDispatch();
		$this->view->subMenu = $this->view->adminMenu($this->user ,array("display" => Core_Util_Settings::MENU_ADMIN_CONTROLLER_INDEX) );
	}
}