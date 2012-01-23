<?php



/**
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @uses Rt_Service::* 
 * 
 *
 */
class Admin_UserController extends Core_Controller_Base 
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
    public function deleteAction()
    {
     
    }

	

      public function postDispatch(){
       parent::postDispatch();
       $this->view->subMenu = $this->view->adminMenu($this->user ,array("display" => Core_Util_Settings::MENU_ADMIN_CONTROLLER_USER) );
    }

}


?>