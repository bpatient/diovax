<?php


/**
 * 
 * This controller will be listing all Orders customers have done.
 * There will be an interface to add orders if the customer didn't use 
 * the website[ this feature is not in the milestone though ] 
 * 
 * 
 * @author Pascal Maniraho 
 * @uses Core_Controller_Base
 * @uses Core_Controller_Base
 * @uses Core_Controller_Base
 * @uses Core_Controller_Base
 * @version 1.0.0 
 *
 */


class Admin_OrderController extends Core_Controller_Base
{

    	
   public function init()
    {
    	parent::init();
        /* Initialize action controller here */
    	$this->view->title = $this->title; 
		$this->view->menu_items = $this->menu;
		$this->view->title = $this->title; 
		$this->view->sub_title = "order"; 
		
		
		//variable to use with links 
    	$this->view->ctlr = $this->ctlr; 
		$this->view->mdl = $this->mdl; 
		$this->view->act = $this->act; 
		
		 //
                $this->options = array();
                $this->options['data'] = array();
		
		//this will not change if there is a new change. 
		
		$this->view->payment_methods = $this->store_service->getPaymentMethods(); 
		$this->view->customers = $this->user_service->getCustomer(); 
		
		
   	 
    }//init

    
   
 
    
    public function preDispatch()
    {
    	parent::preDispatch();	
    }
 
    
    public function indexAction()
    {
    	//items have been retrieved on top, may be we should check whether there is another request 
    	/**
    	 * Initialization of sorting and paging data 
    	 */
    	parent::index();
        
    	/*This option tells the service to get all regarless the limit*/
    	$this->options['get_all'] = true;
    	$this->options['sort'] = true;
    	$this->items = ( empty($this->options) )? $this->shop_service->getOrder(): $this->shop_service->getOrder($this->options);//
    	$this->items = $this->items->toArray();

    	
    	$query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
     	$options = array ('result_set' => $this->items, 'pg' => $this->getRequest()->getParam('pg') , 'per_page' => $this->per_page, 'query' => $query );
	 	/**
     	 * Apply page to start from, while sorting and sliding data 
     	 */
     	$this->paging = new Core_Util_Paging($options);
		$this->paging->baseUrl = $this->view->baseUrl;
        $this->view->paging = $this->paging;
		$this->view->items = $this->paging->getCurrentItems();
		$this->view->paged_links = $this->paging->getPagedLinks();
		$this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->items) > $this->per_page );
	
    }

	
	
		/**
		 * 
		 * Pay attention to the use of service, company, type since I mixed names.
		 * this anomaly will be corrected in the second version. 
		 * 
		 */
		public function editAction(){
			
			/**scroll down initialization */
			$company =  ( $this->_getParam('service'))? $this->_getParam('service'):'fedex';
    		$service = '';
			$redirect = false; 
			
			
			if ( !( ( $id = $this->_getParam('id')) > 0) ){
				$this->_redirect('admin/order');///
			}
			
			/*checking first if the request is for updating dropdown menus */
			if ( $this->_getParam('upsrv') ){ 					
				//add lines of code here to allow the ajax to access this section
			}
			
			//retrieving the order to edit
			$order = $this->shop_service->getOrder(array( 'id' => $id))->toArray();
			if ( $order[0] ) $order = $order[0];
			
			//
			$order_details = $this->shop_service->getOrderDetails(array( 'customer_order_id' => $id));
			$order_items = $this->shop_service->getOrderItems(array( 'customer_order_id' => $id));
			
			//
			$options = array (); 
			$options['status'] = $this->shop_service->getStatusLookup();
			$options['service'] = $this->ship_service->getCompany();
			
			/***/
			if ( $order['shipping_service']){
				//try to unserialize  
				$shipping = @unserialize( $order['shipping_service'] );
				if ( is_object( $shipping )  ) {
					$service = $shipping->service;//	
					$company = $shipping->company;//default it, if saved value is unserializable 
					
				}
				
			}
			
			
			
			$options['type'] = $this->ship_service->getCompanyServices($company);
			$options['starts'] = date('Y-m-d');
			$options['stops'] = date('Y-m-d');			

			
			$this->view->form = new Core_Form_Order($options);
			$post = $this->getRequest()->getPost();
			if ( $this->getRequest()->isPost() ){
				$order['status']  = $this->_getParam('status'); 
				$order['note']  =  $this->_getParam('note');
				$order['shipping_code']  =  $this->_getParam('shipping_code');
				$this->shop_service->editOrder($order);
				$redirect = true ;
			}
			
			
			
			$this->view->form->populate($order);	
			if ( $order['id'] > 0 )	
			{
				$this->view->form->getElement('button')->setLabel("Update ");
				$id = $order['id'];
			} 

				$this->view->form->getElement('status')->setValue($order['status']); 
				$this->view->form->getElement('service')->setValue($company)->setAttrib('disabled', 'disabled');
				$this->view->form->getElement('type')->setValue($service)->setAttrib('disabled', 'disabled');
			$this->view->order_id = $id;//to be used in the view	
			if ( $redirect == true )
				$this->_redirect('admin/order/view/'.$id);/// 
		}//
		
		
		
		/**
		 * This function shows the an order 
		 * 
		 * */
		public function viewAction(){                    
			if ( !(  ( $id = $this->_getParam('id')) > 0 ) ){
					$this->_redirect();
				}
				
				$this->view->lower_title = $this->lower_title;
				$this->view->id = $id;
				$order = $this->shop_service->getOrder(array ('id' => $id ) );
				
				$user = $this->user_service->getUsers(array( 'id' => $order[0]['user_id']) )->toArray(); 
				$user = $user[0];
				
				
				/**address formatting*/
				$order_details = $this->shop_service->getOrderDetails($id);
				
				
				/**
				 * This is the shipping address as the billing and shipping address are treated as the same entity
				 * at least for this version 
				 */
				$this->address = '';
				foreach ( $order_details as $k => $od ){
					if ( $od['detail_key'] == 'billing_address' || $od['detail_key'] == 'shipping_address' || $od['detail_key'] == 'shopping_address' ){
						$address = $this->user_service->getAddress(0, $od['detail_value']);
						if($address) $this->address .= $this->view->address_helper->address( new Core_Model_Address($address->toArray()), array('class' => 'span-12', 'id' => 'address-box-'.$k.'' ));
					} 
				}
				
				
				
				 $taxation = $this->tax_service->getTaxationByQuery(array ('customer_order_id' =>  $id));
				 if( !is_array($taxation) ) $taxation = $taxation->toArray(); 
				 
				 //print_r($taxation);
				 
				/**'amount' => $this->shop_service->getOrderAmount($id, array ('order_id' =>  $id) ),*/ 					
				$data = array (
					'customer' =>$user,
					'customer_order' => $order->toArray(),
					'items' => $this->shop_service->getFullOrderItems($id, array ('order_id' =>  $id) ),
					'payment' => $this->shop_service->getFullOrderItems($id, array ('order_id' =>  $id) ),
					'shipping' => $this->address,
					'billing' => '',
					'carrier' => @unserialize($order[0]['shipping_service']),
					'taxation' => $taxation
				);
				
				
				$order = new Core_Util_Order( $data );
				$this->view->order_content =  $this->view->order_helper->order( $order );
			
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