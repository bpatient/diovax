<?php

/**
 * 
 * 
 * 
 * This controller will make it possible to add more information 
 * like address[ editing shipping/billing addresses,....] 
 * This profile has to be different from admin's since the admin 
 * will have access to customers profiles. 
 * The administrator will be using this profile also as a customer too 
 * 
 * @author Pascal Maniraho 
 * @uses 
 *
 */


class Admin_AccountController extends Core_Controller_Base
{
    
    public function init()
    {
    	parent::init();

        /* Initialize action controller here */
    	$this->view->title = "Account";
	$this->view->menu_items = $this->menu;
        $this->landlord = $this->user_service->getUsers( array ('id' => $this->user_id ) )->toArray();

        /**
         * will work with paging object
         */
        $this->options = array();
        $this->options['data'] = array();



    }
    
    
    
    
    public function preDispatch(){
    	parent::preDispatch();
    	$this->user_id = $this->user_id;
    	
    	
    	
    }

    
    
   /**
    * The user has only to his profile. 
    * on the profile we will list, addresses, login info, 
    * and payment methods he/she already uses[ credit cards,... ]
    */
    public function indexAction()
    {
    }

    
  
    
    public function editAction(){








        $this->_form = new Core_Form_LandlordContact();
        $class =  $this->_form->address->getAttrib('class').' no-rich-text';/**disabling rich text editor */
        $this->_form->address->setAttrib( 'class', trim($class) );

        $this->_message = "";
        if( $this->isPost ){

            if( !$this->_form->isValid() ){
                 $this->_message = $this->_form->getMessages(); return false;
            }

            //edit landlord contact information
            $this->user_service->editLandlordContact( $this->_form->getObject() );
        }else{
           
        }


        //transfer data to the view 
        $this->view->form = $this->_form;
        $this->view->message = $this->_message;

  }
    
    
    
    /**some items will be deleted some other not*/
    public function deleteAction(){
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

