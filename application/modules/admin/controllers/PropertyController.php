<?php
/**
 * @author Pascal Maniraho 
 * @version 1.0.0
 */
class Admin_PropertyController extends Core_Controller_Base
{
	




   private $property, $collection;
	
   	
   public function init()
   {
	   parent::init();
	   $this->id = $this->_getParam( 'id' );
       $this->view->property = new Core_Model_Property( array( 'id' => $this->id));
       $this->options = array();
       $this->options['data'] = array();
       
       
       
   }
    


    public function preDispatch(){
        parent::preDispatch();

        #search initialization	
        $params = array();
    	if( is_string($this->getRequest()->getParam('id')) ){
        	$this->getRequest()->setParam("url", $this->getRequest()->getParam("id") );
        	$params["url"] = $this->getRequest()->getParam('id');
        }
        
        
        if( is_string($this->getRequest()->getParam('token')) ){
        	$this->getRequest()->setParam("token", $this->getRequest()->getParam("token") );
        	$params["token"] = $this->getRequest()->getParam('token');
        }
        
        $this->id = ( $this->getRequest()->getParam('id') )? (int)$this->getRequest()->getParam('id') : 0;
        $this->id = ( $this->getRequest()->getParam('property') )? (int)$this->getRequest()->getParam('property') : $this->id;
        //
        if( is_numeric($this->id) && $this->id > 0 ){
        	$params["id"] = $this->id;
        }
        
       
       	#searching using params 
        if( !empty($params) && sizeof($params) >= 1 ){
        	throw new Exception ( print_r( $params, 1 ) );
        	$property = $this->rent_service->getProperties( $params )->toArray();
        	if( is_array( $property) ) 
        		$property = isset( $property[0] )? $property[0] : $property;
        	$this->property = $_o = ( object ) $property;
        }
        
        if(  $this->id > 0 && ( isset($_o) && is_a($_o) ) ){
             /**gettting one property*/
                /**only services knows about caching and stuff*/
                $this->collection['property'] = $_o;
                $this->collection['details'] = $this->rent_service->getPropertyDetails( array( 'property_id' => $_o->id ) )->toArray();
                $this->collection['media'] = $this->media_service->getMedia( array( 'token' => $_o->token ) )->toArray();
                $this->collection['ratings'] = $this->rent_service->getRatings( array( 'property_id' => $_o->id ) )->toArray();
                $this->collection['site'] = $this->rent_service->getSites( array( 'id' => $_o->site_id ) )->toArray();
                $this->collection['landlords'] = $this->rent_service->getPropertyLandlords( $_o );
                $this->collection['leases'] = $this->rent_service->getLeases( array( 'property_id' => $_o->id ) )->toArray();
                $this->collection['tasks'] = $this->rent_service->getTasks( array( 'property_id' => $_o->id ) )->toArray();
                $this->collection['tenants'] = $this->rent_service->getPropertyTenants( $_o );
                $this->collection['booking'] = $this->rent_service->getPropertyBooking( $_o )->toArray();
               /**sending data to view helper**/
        }else{
            $this->property = new Core_Model_Property();
        }

    }


   /**This function will enable and disable property landlords*/
   public function jxenAction(){
        parent::ajax();
        $data = array();
        $_data  = $this->getRequest()->getParams();
        $_date = date( 'Y-m-d h:i:s', time() );
        
        if( $_data['v'] == 1 ){ $this->rent_service->editLandlord( array( 'property_id' => $_data['it'], 'user_id' =>  $_data['i'], 'status' => 'open', 'since' => $_date, 'created' => $_date, 'modified' => $_date ) ); }
        if( $_data['v'] == 0 ){  print_r($_data); $this->rent_service->deleteLandlord( array('property_id' => $_data['it'], 'user_id' =>  $_data['i'] ) ); }
        /**[module] => admin    [controller] => property    [action] => jxen    [id] => 0   [ajx] => true    [ac] => ajax-checkable   [v] => 1    [it] => on    **/
   }



    /**same queries d be used to get the content for landlords properties except connected user id*/
    public function indexAction(){    
	    parent::index();
	    $_edit = ""; $_html = "";
            /**tmp data to use*/
            $this->tmp = array();
            $counter = 0;
            $this->data = $this->rent_service->getProperties()->toArray();
            /**each property might have data associated to it, its better to get that kind of data and make it available to the view*/
            foreach( $this->data as $k => $property ){

                if( is_array( $property) ) $property = isset( $property[0] )? $property[0] : $property;
                $_o = ( object ) $property;
                /**only services knows about caching and stuff*/
                $this->tmp[$counter]['property'] = $_o;
                $this->tmp[$counter]['details'] = $this->rent_service->getPropertyDetails( array( 'property_id' => $_o->id ) )->toArray();
                $this->tmp[$counter]['media'] = $this->media_service->getMedia( array( 'token' => $_o->token ) )->toArray();
                $this->tmp[$counter]['ratings'] = $this->rent_service->getRatings( array( 'property_id' => $_o->id ) )->toArray();
                $this->tmp[$counter]['site'] = $this->rent_service->getSites( array( 'id' => $_o->site_id ) )->toArray();
                $this->tmp[$counter]['landlords'] = $this->rent_service->getPropertyLandlords( $_o );
                $this->tmp[$counter]['leases'] = $this->rent_service->getLeases( array( 'property_id' => $_o->id ) )->toArray();
                $this->tmp[$counter]['tasks'] = $this->rent_service->getTasks( array( 'property_id' => $_o->id ) )->toArray();
                $this->tmp[$counter]['tenants'] = $this->rent_service->getPropertyTenants( $_o, array( 'property_id' => $_o->id ) );
                /**$this->tmp[$counter]['payments'] = $this->rent_service->getLeasePayments( array( 'id' => $_o->id, 'token' => $_o->token ) )->toArray();*/
                $this->tmp[$counter]['booking'] = $this->rent_service->getPropertyBooking( $_o )->toArray();
                $counter++;
            }

            /***data to send to view files*/
            $this->view->data = $this->tmp;/**defragmentation**/
       }
   




    /**view details about one property as it will appear on the front page + editing buttons*/
    public function propertyAction(){

                $this->id = 0;
                if( !( $this->getRequest()->getParam('id') && ($this->id = (int)$this->getRequest()->getParam('id') ) >0 ) ){
                    $this->view->message =$this->view->message( " Property required " , array('class' => 'error') );
                    return false;
                }

                /**is from pre dispatch*/
                $this->view->data = $this->collection;

}

    
	
                /**Edit one instance of an property*/
		public function editAction(){		


                /**getting the id*/
                $this->id = 0; $_o = new stdClass(); $redirect = false;
                if( $this->getRequest()->getParam('id') && ($this->id = (int)$this->getRequest()->getParam('id') ) >0  ){
                     $property = $this->rent_service->getProperties( array( 'id' => $this->id) )->toArray();
                     if( is_array($property) ) $property = is_array( $property[0] ) ? $property[0]: $property;
                     $_o = ( object )$property;
                 }

		/***/
		$options = array( 'type' => array('building' => 'Building','house' => 'House','appartment' => 'Appartment','garage' => 'Garage','warehouse' => 'Warehouse','other' => 'Other', 'office' => 'Office', 'room' => 'Room' ) ); 
		$this->view->form = new Core_Form_Property($options);
		$class =  $this->view->form->description->getAttrib('class').' no-rich-text';/**disabling rich text editor */
                $this->view->form->description->setAttrib('class', trim($class) );
                if( $this->isPost ){
                    if( !$this->view->form->isValid($this->post) ){
                         $this->view->message = $this->view->form->getMessages();
                         return false;
                    }
                    $this->id = $this->rent_service->editProperty($this->view->form->getObject()->toArray());
                    if( !is_numeric($this->id) )$this->view->message = $this->id;
                    else $this->id = ( int )$this->id;
                    $redirect = ( $this->id > 0 ) ? true : false;
                }
		
		/**view data should not be*/
		//$this->data = $this->data[0]? $this->view->data[0] : $this->data;
		if( is_object( $_o ) ){
                    $this->property = new Core_Model_Property( ( (array)$_o ) );
                    $this->view->form->populate( ( (array)$_o ) );
                }
		
		/**preparing data to send to view*/
	 	$this->view->data = $_o;
		//echo "<div class='notice'>property media should be sent to property media controller</div>";
		if( true === $redirect ) $this->_redirect( '/admin/property/property/'.$this->id );///
	}
    
	 /**this delete function can handle a couple of objects*/
	 public function deleteAction(){
	  if( $this->post ){
	  		//if(isset($this->) )
	      $this->rent_service->deleteProperty( array('id' =>  $this->id ) );
		  $this->_redirect( '/admin/property');      
	  }     
	}/**the */
	
	
	/**the media action has nothing to do here, unless it lists all media for this product*/
	public function mediaAction(){
		$options = array();
		$data = $this->media_service->getBanners($options);    	
		$this->view->content = $this->view->items = $data;
   }
	
	
	/***/
	public function uploadAction(){
	  
     	
		$this->view->id = $this->_getParam('id');
		if ( !( ($id = $this->_getParam('id')) && $id > 0 ) )
			$this->_redirect( 'admin/property/media/' );
		$this->property = $this->rent_service->getProperties( array( 'id' => $this->id ) )->toArray();
		$this->property = $this->view->property = ( $this->property[0] ) ? new Core_Model_Property($this->property[0]) :  new Core_Model_Property($this->property);  
		$this->medium = new Core_Model_Media(); 
                $options = array('id' => $id );
    	/**
    	 * In the following section, we need to upload both Flash Files and html files in addition to 
    	 * supported image files, therefore we need to add supported extensions
    	 */
    	   $this->view->form = new Core_Form_FileUpload( $options );
    	   if(  $this->isPost ){
	       	if( !$this->view->form->isvalid($this->post) ){
                    $this->view->message = $this->view->form->getMessages();
                    return false;
                 }
                    /**continue trying to upload the form*/
                    try {
                    $file_name  = $this->view->form->process();
                    if ( ! ($file_name === false) ){
                        $tmp = $this->media_service->getPropertyMedia($this->property );
                        if ( is_array($tmp[0]) ) $this->medium = new Core_Model_Media($tmp[0]);
                        $this->medium->token = $this->property->token;
                        $this->medium->media_value = $file_name; $this->medium->media_key = "image";
                        $this->media_service->editMedium($this->medium,  $this->property);
                       }
                    }catch(Exception $e){
                       $this->view->message = $e->getMessage();
                    }
	       }
      /**displaying media for this property**/
      $_buffer = '';
      if( $this->property->token != '' ){
         $this->view->media = $this->media_service->getPropertyMedia( $this->property )->toArray();
         if( is_array( $this->view->media) ){
             foreach( $this->view->media as $key => $value ){
               $_buffer .= $this->view->media( ((object)$value), array( 'width' => 'medium') );//
             }
         }
         /***/
         if( is_string($this->view->media) ) $_buffer = $this->view->media( $this->view->media );//
            $this->view->media = $_buffer;
         }
}
	
	
	/**this action will add landlords to a property*/
	public function landlordAction(){
		$msg = 'Property needed to add landlords to';
		if( !($this->id > 0) ) $this->view->message = $this->view->message( $msg ,array('class' => 'error') );
		$this->view->property = $this->property;
		$this->view->data = $this->user_service->getLandlordsByProperty( array('id' => $this->property->id) );//
		if( !is_array($this->view->data) && is_object($this->view->data) ){
			$this->view->data = $this->view->data->toArray();	
		}
		$this->view->content = $this->view->property( $this->view->property );//echo "Not Implemented";
		//$this->view->content .= $this->view->landlords( $this->view->data );


                if( $this->isPost ){
                        /**ajax is handling*/
                }




	}	
	

	/**
         * Displays and update a landlords for this property[via checkboxes ]
         * the list has basic information about this landlord, and link important links [ edit, profile, customers and so on ]
         *
         *
         *
         * @todo how to add more landlords to this property
         */
	public function landlordsAction(){


            parent::index();
	    $_edit = ""; $_html = "";  $this->tmp = array();
            $this->property_id = $this->id = 0;
            if( !( $this->getRequest()->getParam('property') && ($this->property_id = (int)$this->getRequest()->getParam('property') ) > 0 ) ){
                $this->view->message =$this->view->message( " Property required " , array('class' => 'error') );
                 return false;
            }
            
            /**property initialization**/
            $this->tmp['landlords'] = $this->user_service->getLandlords()->toArray();
            $this->_tmp =  array();
            $counter = 0;
            foreach( $this->tmp['landlords'] as $k => $_o ){
                $_o = (object)$_o;
                $this->_tmp[$counter]['landlord'] = $_o;
                $_property = $this->rent_service->getLandlords( array( 'user_id' => $_o->id, 'property_id' => $this->property->id ) )->toArray();
                $_property = ( isset($_property[0]) && !empty($_property[0]) && is_array($_property[0]) )? (object)$_property[0] : false;
                $this->_tmp[$counter]['owner'] = ( is_object($_property) && isset($_property->user_id) && ($_property->user_id == $_o->id) ) ? true : false ;
                $counter++;
            }

            //$this->view->data = $this->tmp;
            $this->view->page_data = $this->_tmp;
            $this->view->property_id = $this->property->id;
            $this->view->property = $this->property;
            $this->view->data = $this->collection;

	}



	/**this function has to be deleted*/
	public function viewAction(){	 	
		
		$this->view->data = $this->rent_service->getProperties( array('id' => $this->id) )->toArray();//
	 	$sites = $this->rent_service->getSelectSites();		
		$options = array( 'location' => $sites, 'type' => array('building' => 'Building','house' => 'House','appartment' => 'Appartment','garage' => 'Garage','warehouse' => 'Warehouse','other' => 'Other', 'office' => 'Office', 'room' => 'Room' ) ); 
		$this->view->data = $this->view->data[0]? $this->view->data[0] : $this->view->data;
	 	$this->property = $this->view->property = new Core_Model_Property($this->view->data); 
		$this->view->content = $this->view->widget = $this->view->propertyWidget( $this->property );//echo "Not Implemented";
	}	
	


        /**
         * Thsi function lists current property features, and handles post as well
         * Is playing an all in one function, edit, listing and deletion
         */
        public function featuresAction(){

            parent::index();
	    $_edit = ""; $_html = "";  $this->tmp = array();
            $this->form = new Core_Form_PropertyDetails();
                  $class =  $this->form->detail_value->getAttrib('class').' no-rich-text';/**disabling rich text editor */
                   $this->form->detail_value->setAttrib('class', trim($class) );

            $this->property_details =  new Core_Model_PropertyDetails();             
            $this->property_id = $this->id = 0;
            if( !( $this->getRequest()->getParam('property') && ($this->property_id = (int)$this->getRequest()->getParam('property') ) > 0 ) ){
                $this->view->message =$this->view->message( " Property required " , array('class' => 'error') );
                 
                return false;
            }
            /**property initialization**/
            $this->property = $this->rent_service->getProperties( array( 'id' => $this->property_id ) )->toArray();
            $this->tmp['property_details'] = $this->rent_service->getPropertyDetails( array('property_id' => $this->property_id ) )->toArray();


            if( is_array( $this->property ) ) $this->property = isset( $this->property[0] )? $this->property[0] : $this->property;
            $_o = ( object ) $this->property;

            if( ( $this->getRequest()->getParam('id') && ($this->id = (int)$this->getRequest()->getParam('id') ) > 0 ) ){
              $this->property_details =  $this->rent_service->getPropertyDetails( array('id' => $this->id ) )->toArray();
              $this->property_details = isset( $this->property_details[0] )? $this->property_details[0] : $this->property_details;
              $this->form->populate( $this->property_details );              
            }

            /**handling any post **/
            if( $this->isPost ){ 
                 if($this->form->isValid( $this->post ) ){
                    $this->rent_service->editPropertyDetails( $this->form->getObject() );
                 }else{
                     $this->view->message = $thi;
                 }
             }
             /**deleting*/
             if( $this->property_id && $this->id && ( $this->getRequest()->getParam('act')  &&  $this->getRequest()->getParam('act') == 'dlt' ) ) {
                  $this->rent_service->deletePropertyDetails( $this->id  );
                 $this->_redirect("/admin/property/features/?property=$this->property_id");
             }
             /**refreshs the list of available property details*/
             $this->property_details =  $this->rent_service->getPropertyDetails( array('id' => $this->id ) )->toArray();
            /***/
            $this->tmp['property'] = $_o;
            $this->tmp['property_detail'] = $this->property_details;
            /**this section will send data to the view helper**/
            $this->view->data = $this->tmp;
            //this one has to be added in all cases
            $this->form->property_id->setValue($this->property_id);
            $this->view->form = $this->form;


            $this->view->data = $this->collection;

        }



	/***/
	public function detailAction(){
		
		
		$this->pd = 0;//product details id 
		if( ($pd = $this->_getParam('pd')) > 0 ) {
			$this->pd = $pd;				
		}
		$this->view->property = $this->property;
		$this->view->form = new Core_Form_PropertyDetails( array('id' => $this->pd , 'property_id' => $this->property->id ) );
		$class = $this->view->form->detail_value->getAttrib('class').' no-rich-text';
		$this->view->form->detail_value->setAttrib('class', trim($class) );
   
   		if( $this->isPost ){
   			if( $this->view->form->isValid($this->post) ){
   				$this->pd = $this->rent_service->editPropertyDetails(  $this->view->form->getObject()  );
   			}else{
   				$this->view->message = $this->view->message( 
						$this->view->form->getMessages(), 
						array( 'class' => 'error' )
					);
   			}
   		}
		
		/**initialization of the product details*/
		if( $this->pd > 0 ){
			$this->product_details = $this->rent_service->getPropertyDetails( array('id' => $this->pd ) )->toArray();
			if( is_array($this->product_details[0]) ) $this->product_details = $this->product_details[0];
			if( $this->product_details ) $this->view->form->populate( $this->product_details );
		}
   }
	
	/***/
	public function videoAction(){
		
		$this->view->data = $this->rent_service->getProperties( array('id' => $this->id) )->toArray();//
	 	$this->view->data = $this->view->data[0]? $this->view->data[0] : $this->view->data;
	 	$this->property = $this->view->property = new Core_Model_Property($this->view->data); 
		
		
		//initialization of the media id
		if( !( $med_id =  $this->_getParam('med') ) || empty($med_id) ){
			$med_id = 0;
		}
		
		//don't display anything if the there is no property id 
		if( !$this->property )	$this->_redirect( 'admin/product/index' );	
		
		/**
		 * since the video should belong to any object, we should pass the object to which this video belongs to via a token, 
		 * if there is no tocken, just create it from the name of the object calling it or 
		 */	
		$this->view->form = new Core_Form_Video();
		$class = $this->view->form->description->getAttrib('class').' no-rich-text';
		$this->view->form->description->setAttrib('class', trim($class) );
   		/***/
		if ( $this->isPost && $this->view->form->isvalid($this->post) ){
       		$med_id = $this->media_service->editMedium($this->view->form->getObject(), $this->property );	
       	}else{
   			if ( $this->view->form->getMessages() )
   				$this->view->message = $this->view->message( $this->view->form->getMessages(), array( 'class' => 'error') );
       	}
		
		
		
		
		/****/
		$options = array (); 
       	$options['token'] = $this->property->token; 
		$options['media_key'] = "video"; 
	   	$this->view->media = $this->media_service->getPropertyMedia( $this->property );
       	if ( $med_id > 0 ){
       		$options['id'] = $med_id;
       		$media = $this->media_service->getPropertyMedia( $this->property, $options )->toArray();
           	if ( is_array ($media[0])  && !empty($media[0]) )
           			$this->view->form->populate($media[0]);
        }

   
 }
   
   
   
   
 





	/**
         * Displays and update a location for this property
         */
	public function locationsAction(){
        parent::index();
	 	$this->collection['locations'] = $this->rent_service->getSites()->toArray();
                $this->view->data = $this->collection;
        }


	/**
         * Displays and update a location for this property
         */
	public function photosAction(){
            $this->view->data = $this->view->content = $this->media_service->getPropertyPhotos()->toArray();
            



        }

	/**
         * Shows requests and allows quick edit, such as checkin- checkout, cancel
         */
	public function bookingAction(){


            parent::index();
	    $_edit = ""; $_html = "";  $this->tmp = array();
             if( !$this->id){
                    $this->view->message =$this->view->message( " Property required " , array('class' => 'error') );
             }

            //if a landlord is specified.
             if( ( $this->getRequest()->getParam('id') && ($this->id = (int)$this->getRequest()->getParam('id') ) > 0 ) ){
             }
            /**there will be a problem between property as an ID and booking Id that is sent right after this action*/
            /**property initialization**/
            $this->tmp = array();
            /**visit each booking */
            $counter = 0;
            /**
             * Its better to have one function that fetches users data and show it as 
             *
             */
            foreach ( $this->collection['booking'] as $k => $_o  ){
                    $_o = (object)$_o;
                    $this->tmp[$counter]['booking'] = $_o;/**'bookings'*/
                    $this->tmp[$counter]['details'] = $this->rent_service->getBookingDetails( array( 'booking_id' =>$_o->id) )->toArray();/**'bookings'*/
                    $_user = $this->user_service->getUsers( array( 'id' => $_o->user_id) )->toArray();/**'bookings'*/
                            $_user = isset( $_user[0]) && is_array($_user[0]) ? $_user[0] : $_user;
                    $this->tmp[$counter]['user'] = (object)$_user ;
                    $counter++;
            }
            /***/
            $this->view->booking =  $this->tmp;
            $this->view->data = $this->collection;
}

		/**
         * Displays and update a location for this property
         */
	public function leasesAction(){
            $this->view->property = $this->property;
             $this->view->data = $this->view->content = $this->rent_service->getPropertyLeases()->toArray();
        }

	
	   
        /**editing is not here anymore**/
	public function locationAction(){
            
        }
	/**end of the controller*/



      public function postDispatch(){
        parent::postDispatch();
        $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }

}
?>