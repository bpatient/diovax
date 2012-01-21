<?php
/**
 * This controller will display available booking data
 * @uses should use Core_Controller_Base
 */
class Admin_BookingController extends Core_Controller_Base
{

    public function init() {
        parent::init(); //
        $this->options = array();
        
    }

    public function preDispatch(){
        parent::preDispatch();
    }
    
    

    public function indexAction(){

        $links =  $counter= 0;
        parent::index();

        /**if there is a search this should change for sure*/
        $this->data = $this->rent_service->getBookings( )->toArray();
         foreach( $this->data as $k => $booking ){
              if( is_array( $booking) ) $booking = isset( $booking[0] )? $booking[0] : $booking;
                $_o = ( object ) $booking;
                /**only services knows about caching and stuff*/
                $this->tmp[$counter]['booking'] = $_o;
                $this->tmp[$counter]['address'] = $this->rent_service->getBookingDetails(  array( 'booking_id' => $_o->id , 'key' => 'address' ) )->toArray();/*$_o->property_id*/
                $this->tmp[$counter]['property'] = $this->rent_service->getProperties( $_o->property_id )->toArray();
                $this->tmp[$counter]['location'] = $this->rent_service->getPropertyLocation( $_o->property_id )->toArray();
                $this->tmp[$counter]['customer'] = $this->user_service->getUsers( array( 'id' => $_o->user_id ) )->toArray();
                $this->tmp[$counter]['landlord'] = $this->rent_service->getPropertyLandlords( array( 'property_id' => $_o->property_id ) );
               $counter++;
            }

        //$this->per_page = $this->limit_query;
        $this->per_page = 10;/**redifine this in application settings*/
        $options = array ('result_set' => $this->tmp, 'pg' => $this->pg , 'per_page' => $this->per_page );
        $this->paging = new Core_Util_Paging($options);
        $this->view->paging = $this->paging;
        $this->view->show_paged_links = ( count( $this->tmp) > $this->per_page );
        $this->view->paged_links = $this->paging->getPagedLinks();
        if ( $this->view->show_paged_links ) $links = implode ( $this->view->paged_links, " | ");
        /**data to send to the view*/
        $this->view->data = $this->paging->getCurrentItems();
                      
    }



    /**booking per landlord. for verification purposes*/
    function lanldlordAction(){

        /**if there is a search this should change for sure*/
        $this->data = $this->rent_service->getBookings( )->toArray();
         foreach( $this->data as $k => $booking ){
              if( is_array( $booking) ) $booking = isset( $booking[0] )? $booking[0] : $booking;
                $_o = ( object ) $booking;
                /**only services knows about caching and stuff*/
                $this->tmp[$counter]['booking'] = $_o;
                $this->tmp[$counter]['address'] = $this->rent_service->getBookingDetails(  array( 'booking_id' => $_o->id , 'key' => 'address' ) )->toArray();/*$_o->property_id*/
                $this->tmp[$counter]['property'] = $this->rent_service->getProperties( $_o->property_id )->toArray();
                $this->tmp[$counter]['customer'] = $this->user_service->getUsers( array( 'id' => $_o->user_id ) )->toArray();
                $this->tmp[$counter]['landlord'] = $this->rent_service->getPropertyLandlords( array( 'property_id' => $_o->property_id ) );
               $counter++;
            }

        //$this->per_page = $this->limit_query;
        $this->per_page = 10;/**redifine this in application settings*/
        $options = array ('result_set' => $this->tmp, 'pg' => $this->pg , 'per_page' => $this->per_page );
        $this->paging = new Core_Util_Paging($options);
        $this->view->paging = $this->paging;
        $this->view->show_paged_links = ( count( $this->tmp) > $this->per_page );
        $this->view->paged_links = $this->paging->getPagedLinks();
        if ( $this->view->show_paged_links ) $links = implode ( $this->view->paged_links, " | ");
        /**data to send to the view*/
        $this->view->data = $this->paging->getCurrentItems();
    
    }

    /**
     * booking per landlord. for verification purposes
     * The report about tenants booking...
     */
    function tenantAction(){

        /**if there is a search this should change for sure*/
        $this->data = $this->rent_service->getBookings( )->toArray();
         foreach( $this->data as $k => $booking ){
              if( is_array( $booking) ) $booking = isset( $booking[0] )? $booking[0] : $booking;
                $_o = ( object ) $booking;
                /**only services knows about caching and stuff*/
                $this->tmp[$counter]['booking'] = $_o;
                $this->tmp[$counter]['address'] = $this->rent_service->getBookingDetails(  array( 'booking_id' => $_o->id , 'key' => 'address' ) )->toArray();/*$_o->property_id*/
                $this->tmp[$counter]['property'] = $this->rent_service->getProperties( $_o->property_id )->toArray();
                $this->tmp[$counter]['customer'] = $this->user_service->getUsers( array( 'id' => $_o->user_id ) )->toArray();
                $this->tmp[$counter]['landlord'] = $this->rent_service->getPropertyLandlords( array( 'property_id' => $_o->property_id ) );
               $counter++;
            }

        //$this->per_page = $this->limit_query;
        $this->per_page = 10;/**redifine this in application settings*/
        $options = array ('result_set' => $this->tmp, 'pg' => $this->pg , 'per_page' => $this->per_page );
        $this->paging = new Core_Util_Paging($options);
        $this->view->paging = $this->paging;
        $this->view->show_paged_links = ( count( $this->tmp) > $this->per_page );
        $this->view->paged_links = $this->paging->getPagedLinks();
        if ( $this->view->show_paged_links ) $links = implode ( $this->view->paged_links, " | ");
        /**data to send to the view*/
        $this->view->data = $this->paging->getCurrentItems();
    }




    /**
     * Make required modifications,
     * Gethers data about the customer, property to be booked, 
     * It will be used for checkin, checkout purposes.... accepting payment[ final + repetitive payments , ....]
     */
    public function editAction(){
        /***/
		if( ($_user = (int)$this->getRequest()->getParam('user')) > 0 ){
			$this->user = $this->user_service->getUsers( array('id' => $_user ) )->toArray();
			$this->user = isset($this->user[0]) && is_array( $this->user[0] ) ? $this->user[0] : $this->user ;
		}

		/***/
		if( ($_property = (int)$this->getRequest()->getParam('property')) > 0 ){
			$this->property = $this->rent_service->getProperties( array( 'id' => $_property ) )->toArray();
		}

		/***/
		if( ($_booking = (int)$this->getRequest()->getParam('id')) > 0 ){
			$this->booking = $this->rent_service->getBookings( array( 'id' => $_booking ) )->toArray();
                        $this->booking_id = $_booking;
		} 

                /****/
		$this->view->user = $this->user;
		$this->view->booking  = $this->booking;
		$this->view->property = $this->property;
                $this->view->lease = $this->rent_service->getLeases(  array( '' => '' ) )->toArray();
                $this->view->payments = $this->rent_service->getLeasePayments( array( '' => '' ) )->toArray();
                /**getting booking details and generate payment*/
	}


    /**booking per property. for verification purposes*/
    public function propertyAction(){  }



      public function postDispatch(){
        parent::postDispatch();
       $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }


}