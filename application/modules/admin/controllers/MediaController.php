<?php

/**
 *
 * This Controller class will be used to upload media, and manage those.
 * By media, we mean images, video[flv files, mp4,...], and documents.
 * Any ressource that needs to upload will be requesting its service and
 * send where to redirect on completion.
 *
 *
 *
 *
 * @author Pascal Maniraho
 * @version 1.0.2
 * @uses Core_Controller_Base
 *
 *
 *
 * @todo group banners and change banner management model
 * @todo add controll to list flash | image | html files from the index
 *
 *
 *
 * @todo add controll to list flash | image | html files from the index
 *
 *
 */

class Admin_MediaController extends Core_Controller_Base
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
	public function uploadAction()
	{
		 
	}


	/*lists all users in the system */
	public function deleteAction()
	{
		 
	}



	public function postDispatch(){
		parent::postDispatch();
		$this->view->subMenu = $this->view->adminMenu($this->media ,array("display" => Core_Util_Settings::MENU_ADMIN_CONTROLLER_MEDIA) );
	}


}