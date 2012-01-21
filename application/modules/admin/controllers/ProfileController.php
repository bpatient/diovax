<?php

class Admin_ProfileController extends Core_Controller_Base
{

   	
      
    	
public function init()
{
   parent::init();
   //this identity is used for user_id, and the email 
   $this->identity = Zend_Auth::getInstance()->getIdentity();
   $this->users_id = $this->identity->user_id;
   //lists initialization 
   $this->addresses = $this->user_service->getAddress($this->users_id);
   $this->profile = $this->user_service->getProfile($this->users_id);		
   $this->id = (((int)$this->_getParam("id")) > 0) ? $this->_getParam("id") : 0;//the id sent from the request url
    //
                $this->options = array();
                $this->options['data'] = array();
}//init

    
    
    /**
     * 
     * This shows information for this user. 
     * Other function are designed to edit that information 
     * 
     * @return void 
     */
    public function indexAction()
    {
     	//listing for this user 
		$this->view->addresses = $this->addresses;
		$this->view->emails = $this->emails;
		$this->view->profile_details = $this->profile;
		/**/
		$this->view->profile = $this->user_service->getProfile( $this->users_id)->toArray();
		$this->view->address = $this->user_service->getAddress( $this->users_id)->toArray();
	}
	
	
	/**
	 * will it be used for to change login info???
	 * @return unknown_type
	 */
	public function editAction(){
			$this->view->form  = new Ma_Form_UserProfile(array('id' => $this->identity->user_id));
			if($this->getRequest()->isPost() && $this->view->form->isValid($this->getRequest()->getPost())):
				
			else:
				
			endif;
		$this->view->id = $this->view->user_id = $this->user_id;//
  	}
	
	
	/**
	 * This function is used to edit the telephone 
	 * @return void
	 */
	public function telAction(){
			$this->view->lower_title = "Profile::. Telephone::. ";
			$categories = array("other" => "Other", "fax" => "Fax","mobile" => "Mobile","office" => "Office","home" => "Home");
			$this->view->form  = new Ma_Form_UserTelephone(array('id' => (($this->id > 0)?$this->id:0),'users_id' => $this->identity->user_id), $categories);
			$error_message = "A valid Telephone, and Category is required";
			$this->_addAddress($error_message);
	}
	
	
	/**
	 * This function will edit the address 
	 * @return void 
	 */
	public function addrAction(){
		
			$this->view->content = "Profile";	
			$this->view->lower_title = "Profile::. Edit::. ";
			$categories = array("other" => "Other", "home" => "Home","office" => "Office"); 
			$this->view->form  = new Ma_Form_UserAddress(array('id' => (($this->id > 0)?$this->id:0),'users_id' => $this->identity->user_id), $categories);
			$error_message = "A valid Address, and Category is required";
			$this->_addAddress($error_message);
	}
	
	
	/**
	 * This function will edit personnal info. 
	 * From the profile, ...  
	 * @return void 
	 */
	public function infoAction(){
		
		$this->view->form  = new Ma_Form_UserProfile(array('id' => $this->identity->user_id));
		if($this->getRequest()->isPost()):
				if(!$this->view->form->isValid($this->getRequest()->getPost())):
					$this->view->message = "The profile information name and content is required.";
				else:
					$this->user_service->editProfile($this->view->form->mapToObject()->toArray());
				endif;				
			else:
		endif;	
	}
	
	
	/**date("Y:m:d h:i:s", time())
	 * This function is designed to reduce code repetion while editing telephone/email
	 * @param string $error_message
	 * @return object|string|int $last_inserted
	 */
	private function _addAddress($error_message = ""){
		if($this->getRequest()->isPost()):
				if(!$this->view->form->isValid($this->getRequest()->getPost())):
					$this->view->message = $error_message;
				else:
					$this->user_service->editAddress($this->view->form->mapToObject()->toArray());
				endif;				
			else:
		endif;
	//redirect to the right place 
	//or return the last id of the inserted data
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