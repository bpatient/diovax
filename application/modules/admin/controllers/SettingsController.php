<?php



class Admin_SettingsController extends Core_Controller_Base
{
	
	


   private $_amenity,  $_amenities,  $_property_amenities,  $_message, $_plans, $_plan;
   public function init()
    {
    	parent::init();


        $this->_message = "";
        /* Initialize action controller here */
       $this->id = (int)$this->getRequest()->getParam("id");
       $this->_amenity = $this->rent_service->getAmenities( array ( "id" => $this->id ) )->toArray();
       if( isset( $this->_amenity[0] ) && is_array($this->_amenity[0]) ) $this->_amenity = $this->_amenity[0];
       $this->_amenities  = $this->rent_service->getAmenities()->toArray();

       #plan initialization
       $this->_plan = $this->rent_service->getPlans( array( "id" => $this->id ) )->toArray();
       if( isset( $this->_plan[0] ) && is_array($this->_plan[0]) ) $this->_plan = $this->_plan[0];

       $this->_plans = $this->rent_service->getPlans( array() )->toArray();
        //
                $this->options = array();
                $this->options['data'] = array();




        $this->data = $this->options = array();
        $this->options['data'] = array();
        //getting one company if there is an ID
        $this->admin = $this->user_service->getUsers( array ('id' => $this->user_id ) )->toArray();
        $this->options['pg'] = $this->pg ;
        $this->options['per_page'] = $this->per_page;
        //objects will be assigned to this instance
        $this->_object = false;
        $this->id = $this->getRequest()->getParam('id');
    	
    }
    
    
    public function preDispatch()
    {
        parent::preDispatch();
    }
    
    public function indexAction(){

    }

    /**
     * listing available amenities
     */
    public function amenitiesAction(){
       /***/

       /***/
       $this->view->amenities = $this->_amenities;
    }

    /**
     * Add/edit property amenity
     */
    public function amenityAction(){




           $this->view->form = new Core_Form_Amenity();
           $class =  $this->view->form->description->getAttrib('class').' no-rich-text';/**disabling rich text editor */
           $this->view->form->description->setAttrib('class', trim($class) );

           if( $this->isPost ){
               if( $this->view->form->isValid($this->post) ){
                    $this->_amenity = $this->rent_service->editAmenity( $this->view->form->getObject() );
                    $this->_amenity->toArray();
               }else{
                   $this->_message = $this->view->form->getMessages();
               }
           }
           if( isset($this->_amenity)  && is_array( $this->_amenity ) ){
               $this->view->form->populate( $this->_amenity );
           }
           $this->view->message = $this->_message;

    }



     /**
     * @internal I used lease name, but the action edits lease types 
     */
    public function leaseAction(){

           $this->view->form = new Core_Form_LeaseType();
           $class =  $this->view->form->note->getAttrib('class').' no-rich-text';/**disabling rich text editor */
           $this->view->form->note->setAttrib('class', trim($class) );
           if( $this->isPost ){
               if( $this->view->form->isValid($this->post) ){
                    $this->_lease = $this->rent_service->editLeaseType( $this->view->form->getObject() );
                    if( is_string( $this->_lease) ){
                        $this->view->message = $this->_lease;
                    }else{
                        $this->_redirect("/admin/settings/leases");
                    }
               }else{
                   $this->view->message = $this->view->form->getMessages();
               }
              
           }

           //
           if( $this->id > 0 ) {
               $this->_lease = $this->rent_service->getLeaseType( array( "id" => $this->id) )->toArray();
               $this->_lease = is_array( $this->_lease[0] ) ? $this->_lease[0] : $this->_lease;
               $this->_object = $this->_lease;
           }
           
    }




    /**
     * listing available amenities
     */
    public function plansAction(){
       $this->view->plans = $this->_plans;
    }

    /**
     * listing available amenities
     */
    public function leasesAction(){
       $this->data = $this->rent_service->getLeaseType()->toArray();

    }
    /**
     * Add/edit property amenity
     */
    public function planAction(){

           $this->view->form = new Core_Form_Plan();
           $class =  $this->view->form->description->getAttrib('class').' no-rich-text';/**disabling rich text editor */
           $this->view->form->description->setAttrib('class', trim($class) );

           if( $this->isPost ){
               if( $this->view->form->isValid($this->post) ){
                    $this->_plan = $this->rent_service->editPlan( $this->view->form->getObject() );
                    $this->_plan->toArray();
               }else{
                   $this->_message = $this->view->form->getMessages();
               }
           }
           if( isset($this->_plan)  && is_array( $this->_plan ) ){
               $this->view->form->populate( $this->_amenity );
           }
           $this->view->message = $this->_message;

    }


      public function postDispatch(){
        parent::postDispatch();
        $this->options['result_set'] = $this->data;
        $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );


        //populating forms if any
          //populating the form
        if( $this->_object && is_array($this->_object) ){
            $this->view->form->populate( $this->_object );
        }

    }

    
    
}//end of the controller 


?>