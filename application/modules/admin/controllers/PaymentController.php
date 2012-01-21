<?php
/**
 * This controller is the hospital of the application
 * it is used to give useful information about performance of the software and the store in general 
 * it will spot also some failures on system performance, and stats 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0
 * @uses 
 * @see 
 */
class Admin_PaymentController extends Core_Controller_Base
{
   public function init()
	{
		parent::init();
		 //
                $this->options = array();
                $this->options['data'] = array();
                $this->view->link_to_index = '<a href=\''.$this->_helper->url('index').'\'>Back</a>';
	}

    public function preDispatch()
    {
		parent::preDispatch(); 
    }

    /***
     * This function interracts with ajax function to enable and disable payment methods 
     */
    public function jxenableAction(){ 
    	try{  	parent::ajax(); } catch ( Exception $e){ return false; }
    	$msg = "No data";
    	$ac = $this->getRequest()->getParam('ac'); //checking the action to take [ac]
    	$id = $this->getRequest()->getParam('s_id'); 
    	$st = $this->getRequest()->getParam('st');//the status 
    	$enabled = ( $ac == 'ed' && $st > 0 )? 1 : 0 ;
    	if ( $ac == 'ed' ){
    		if ( $this->store_service->setPaymentMethodEnabled($id, $enabled) ) 
    			$msg = ( $st > 0 ) ? 'Enabled' : 'Disabled';	
    	}
    	echo $msg;	
    }
    
    public function indexAction(){
    	$this->view->items = $this->store_service->getPaymentMethods()->toArray();
    }
    
    
    public function editAction(){
    	
    	
    	$this->view->form = new Core_Form_PaymentMethods();  
		$class =  $this->view->form->note->getAttrib('class').' no-rich-text';
    	$this->view->form->note->setAttrib('class', trim($class) );
    	
    	$params =  $this->getRequest()->getParams();
    	$isPost = $this->getRequest()->isPost(); 
    	$post = $this->getRequest()->getPost();
    	
    	if ( $isPost ){
    		if ( !$this->view->form->isValid( $post )  ){
    			$this->view->message = $this->view->form->getMessages();
    			return false;
    		}
    		
    		if ( $this->store_service->editPaymentMethods( $this->view->form->getObject()->toArray() ) )
    			$this->_redirect( 'admin/payment/index');		
    		$this->view->message = "An Error Occured.";
    	}
    	
    	
    	/*populating the form if there is a positive id */
    	if ( $params['id']  > 0 ){
    		$data = $this->store_service->getPaymentMethods( array ( 'id' => $params['id'] ) )->toArray();
    		if ( ($data = $data[0]) ){
    			$this->view->form->populate( $data );
    		}
    	}
    	
    	
    }
    
    
    
    
    /***
     * 
     */
    public function deleteAction(){
    
    	$content = '';
    	/**parameters */
    	$params = $this->getRequest()->getParams();
    	if( !($params['id'] > 0) ) {
    		$this->view->message = " There is no item to delete ";
    		return false; 
    	}
    	
    		/**checking wether this payment method has been used somewhere else*/
    		$payment_method = $this->store_service->getPaymentMethods( array ('id' => $params['id'] ) )->toArray();
    		$service = $payment_method[0]['service']?$payment_method[0]['service']:'...'; 
			if ( ($times = $this->store_service->getPaymentMethodsUsage( $params['id'] )) > 0 ){
				$this->view->message = "This Payment method has been used $times. It's compulsory to disable it instead.";
				return false;
			}
			
			
			$isPost = $this->getRequest()->isPost();
			if ( $isPost ){
				$this->store_service->deletePaymentMethod ( array ( 'id' => $params['id'] ) );
    			$this->_redirect ( 'admin/payment/index');
			}
			
			
    	$this->view->content = 'Are you sure that you want to delete <strong>'.$service.'</strong> Payment Method?';
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