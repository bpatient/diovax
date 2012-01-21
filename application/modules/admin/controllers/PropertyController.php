<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 */
class Admin_PropertyController extends Core_Controller_Base
{




	/**
	 * @var unknown_type
	 */
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

		if( $_data['v'] == 1 ){
			$this->rent_service->editLandlord( array( 'property_id' => $_data['it'], 'user_id' =>  $_data['i'], 'status' => 'open', 'since' => $_date, 'created' => $_date, 'modified' => $_date ) );
		}
		if( $_data['v'] == 0 ){
			print_r($_data); $this->rent_service->deleteLandlord( array('property_id' => $_data['it'], 'user_id' =>  $_data['i'] ) );
		}
	}



	public function indexAction(){
		parent::index();
		$_edit = ""; $_html = "";
		$this->tmp = array();
		$counter = 0;
		$this->data = $this->rent_service->getProperties()->toArray();

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





	public function propertyAction(){
		$this->id = 0;
		if( !( $this->getRequest()->getParam('id') && ($this->id = (int)$this->getRequest()->getParam('id') ) >0 ) ){
			$this->view->message =$this->view->message( " Property required " , array('class' => 'error') );
			return false;
		}
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

		if( is_object( $_o ) ){
			$this->property = new Core_Model_Property( ( (array)$_o ) );
			$this->view->form->populate( ( (array)$_o ) );
		}

		$this->view->data = $_o;
		if( true === $redirect ) {
			$this->_redirect( '/admin/property/property/'.$this->id );///
		}
	}

	/**this delete function can handle a couple of objects*/
	public function deleteAction(){
		if( $this->post ){
			//if(isset($this->) )
			$this->rent_service->deleteProperty( array('id' =>  $this->id ) );
			$this->_redirect( '/admin/property');
		}
	}/**the */






	/**this function has to be deleted*/
	public function viewAction(){

		$this->view->data = $this->rent_service->getProperties( array('id' => $this->id) )->toArray();//
		$sites = $this->rent_service->getSelectSites();
		$options = array( 'location' => $sites, 'type' => array('building' => 'Building','house' => 'House','appartment' => 'Appartment','garage' => 'Garage','warehouse' => 'Warehouse','other' => 'Other', 'office' => 'Office', 'room' => 'Room' ) );
		$this->view->data = $this->view->data[0]? $this->view->data[0] : $this->view->data;
		$this->property = $this->view->property = new Core_Model_Property($this->view->data);
		$this->view->content = $this->view->widget = $this->view->propertyWidget( $this->property );//echo "Not Implemented";
	}




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


	public function photosAction(){
		$this->view->data = $this->view->content = $this->media_service->getPropertyPhotos()->toArray();
	}

	public function leasesAction(){
		$this->view->property = $this->property;
		$this->view->data = $this->view->content = $this->rent_service->getPropertyLeases()->toArray();
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
?>