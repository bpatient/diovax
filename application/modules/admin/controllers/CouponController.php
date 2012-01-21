<?php
/**
 *
 * This class will manage deals, settings about deals, creating companies that are offering deals.
 * Creating coupon code to redeem when  you buy items from companies and so on 
 *
 *
 * @author Pascal Maniraho
 * @uses 
 * 
 */


class Admin_CouponController extends Core_Controller_Base
{
    
    public function init()
    {
    	parent::init();
        $this->options = array();
        $this->options['data'] = array();
        //getting one company if there is an ID 
        $this->admin = $this->user_service->getUsers( array ('id' => $this->user_id ) )->toArray();
        $this->options['pg'] = $this->pg ;
        $this->options['per_page'] = $this->per_page;


        //objects will be assigned to this instance
        $this->_object = false;
        $this->id = $this->getRequest()->getParam('id');

    }
    
    
    
    
    public function preDispatch(){
    	parent::preDispatch();
    	$this->user_id = $this->user_id;
        //this is the administrators id 
    }

    
    
   /**
    * The user has only to his profile. 
    * on the profile we will list, addresses, login info, 
    * and payment methods he/she already uses[ credit cards,... ]
    */
    public function indexAction()
    {
        $this->data = $this->rent_service->getCoupons( array() )->toArray();
    }

    
  
    
    public function editAction(){

        $this->view->form = new Core_Form_Coupon();
        $this->view->form->meta->setAttrib( "class" , "no-rich-text" );
        $this->view->message = "";
        if( $this->isPost ){
            if( $this->view->form->isValid( $this->post ) ){
                 $this->id = $this->rent_service->editCoupon( $this->view->form->getObject() );
                  if( is_string($id) ) {
                     $this->view->message = $this->id;
                     $this->view->error = "error";
                   }else{
                       $this->_redirect("/admin/coupon/index");
                   }
            }else{
              $this->view->message = $this->view->form->getMessages();
               //edit landlord contact information
           }
         }

         //intialiazing the coupon object  
         if( is_numeric( $this->id ) && $this->id > 0 ){
             $this->_object = $this->rent_service->getCoupons( $this->id )->toArray();
             $this->_object = isset($this->_object[0]) ? $this->_object[0] : $this->_object;
         }


  }


    public function companyAction(){

        $this->view->form = new Core_Form_Company();
        $this->view->form->description->setAttrib( "class" , "no-rich-text" );
        $this->view->message = "";
        if( $this->isPost ){
            if( $this->view->form->isValid( $this->post ) ){
                 $id = $this->rent_service->editCompany( $this->view->form->getObject() );
                 if( is_string($id) ) {
                     $this->view->message = $this->id;
                     $this->view->error = "error";
                   }else{
                       $this->_redirect("/admin/coupon/companies");
                   }
           }else{
               $this->view->message = $this->view->form->getMessages();
                //edit landlord contact information
           }
         }
         //
        if( is_numeric( $this->id ) && $this->id > 0 ){
             $this->_object = $this->rent_service->getCompanies( $this->id )->toArray();
             $this->_object = isset($this->_object[0]) ? $this->_object[0] : $this->_object;
        }

  }


    public function itemAction(){
        $this->view->form = new Core_Form_Item();
        $this->view->form->description->setAttrib( "class" , "no-rich-text" );
        $this->view->message = "";
        if( $this->isPost ){
            if( $this->view->form->isValid( $this->post ) ){
                $id = $this->rent_service->editItem( $this->view->form->getObject() );
                if( !is_numeric( $id ) ) {
                     $this->view->message = $id;
                     $this->view->error = "error";
                   }else{
                       $this->_redirect("/admin/coupon/items");
                   }
           }else{
               $this->view->message = $this->view->form->getMessages();
                //edit landlord contact information
           }
         }
  }



    /**
     * This function is temporal, as I have no idea on how I will go for groups for now.
     * I Will be using the coupon control model I design and got rejected at my job 
     *
     */
    public function groupAction(){

        $this->view->form = new Core_Form_Group();
        $this->view->form->description->setAttrib( "class" , "no-rich-text" );
        $this->view->message = "";
        if( $this->isPost ){
            if( $this->view->form->isValid( $this->post ) ){
                 $id = $this->rent_service->editGroup( $this->view->form->getObject() );
                 if( is_string($id) ) {
                     $this->view->message = $this->id;
                     $this->view->error = "error";
                   }else{
                       $this->_redirect("/admin/coupon/groups");
                   }
           }else{
               $this->view->message = $this->view->form->getMessages();
                //edit landlord contact information
           }
         }
         //
        if( is_numeric( $this->id ) && $this->id > 0 ){
             $this->_object = $this->rent_service->getGroups( $this->id )->toArray();
             $this->_object = isset($this->_object[0]) ? $this->_object[0] : $this->_object;
        }
  }





   public function itemsAction()
   {
        $this->data = $this->rent_service->getItems( array() )->toArray();
   }


   public function groupsAction()
   {
        $this->data = $this->rent_service->getGroups( array() )->toArray();
   }

   //
   public function companiesAction()
   {
     $this->data = $this->rent_service->getCompanies( array() )->toArray();
   }


   


    /***
     * Delete anything 
     */
    public function deleteAction(){
        //check if there is an object to delete 
    }




      public function postDispatch(){
        parent::postDispatch();
        $this->options['result_set'] = $this->data;
        $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
        #print_r(  $this->options );


        //populating the form 
        if( $this->_object && is_array($this->_object) ){
            $this->view->form->populate( $this->_object );
        }
    }

}

