<?php


/**
 * @author Pascal Maniraho 
 * @version 1.0.0 
 */


class Admin_TaskController extends Core_Controller_Base
{
    public function init()
    {
    	parent::init();
      $this->view->task = new Core_Model_Task();
	  }    
    
    
     
    public function preDispatch()
    {
		parent::preDispatch(); 
    }
    
    
    /**
     *  
     */
    public function jxAction(){ 
    	try{  	parent::ajax(); } catch ( Exception $e){ return false; }
    	$msg = "No data";
    	$ac = $this->getRequest()->getParam('ac'); //checking the action to take [ac]
    	$id = $this->getRequest()->getParam('s_id'); 
    	$st = $this->getRequest()->getParam('st');//the status 
    	$enabled = ( $ac == 'ed' && $st > 0 )? 1 : 0 ;
    	if ( $ac == 'ed' ){
    		/**cant understand why this section has been changed/commented out**/
    	}
    	echo $msg;	
    }

    
    /***/
    public function indexAction(){    	
      		
    }
    
    
    
    
    
    
    
    
    
    /***/
    public function editAction(){    	

    	$id = $this->getRequest()->getParam('id');
    	$this->task = new Core_Model_Task();
      	$property_id = -1;
      
	  	/***/
	  	$this->property_id = (int)$this->getRequest()->getParam('property');
		$this->view->form = new Core_Form_Task(array( 'property_id' =>  $property_id ));
    	$class =  $this->view->form->description->getAttrib('class').' no-rich-text';
    	$this->view->form->description->setAttrib('class', trim($class) );
    	
    	if( $this->isPost ){
    		throw new Exception ( "I got it ");
    		if( !$this->view->form->isValid($this->post) ){
    			$this->view->message = $this->view->form->getMessages();
				$this->view->error = true; 	
    			return false;
    		}
			$this->task = $this->view->form->getObject();
			//$this->task->   		
    		$this->rent_service->editTicket( $this->task );
    	}
    	/***/
    	if( $id > 0 ){
    		$arr = $this->rent_service->getTickets( array('id' => $id ) )->toArray();
    		$this->tax_rate = ($arr[0]) ? $arr[0] : $arr;	
    		$this->view->form->populate($this->tax_rate);
    	}
    	
    }
    
    
    
	
	/**
	 * For one Property we list + add/edit/close/extend task or more tasks 
	 * @return void 
	 */
	public function propertyAction(){
		parent::index();
    	$_edit = ""; $_html = "";  $this->tmp = array();
        $this->property_id = $this->id = 0;
        if( ( $this->getRequest()->getParam('id') && ($this->id = (int)$this->getRequest()->getParam('id') ) > 0 ) ){
            $this->task = $this->rent_service->getTasks( array( 'id' => $this->id ))->toArray();
			//print_r( $this->task );
			if( is_array( $this->task ) && isset( $this->task[0] ) ){
				$this->task = ( is_array( $this->task[0] ) ) ? $this->task[0] : $this->task;	
				$this->task = new Core_Model_Task( $this->task );
			}
        }
		if( !( $this->getRequest()->getParam('property') && ($this->property_id = (int)$this->getRequest()->getParam('property') ) > 0 ) ){
            $this->view->message =$this->view->message( " Property required " , array('class' => 'error') );
             return false;
        }	
		
		/**the form*/
		$this->view->form = new Core_Form_Task();
		$class =  $this->view->form->description->getAttrib('class').' no-rich-text';/**disabling rich text editor */
        $this->view->form->description->setAttrib('class', trim($class) );
        
		/**if there is post, just add it and list it*/
		if( $this->isPost ){
			
			if( $this->view->form->isValid($this->post) ){
					$this->rent_service->editTask( $this->view->form->getObject() );				
			}else{
				$this->view->message = $this->view->form->getMessages();
				$this->view->error = true; 	
	    	}
				
		}elseif( $this->task ){
			if( $this->task  instanceof Core_Model_Task ){
				$_task = $this->task ->toArray();
				$this->view->form->populate( $_task );
			}
			
		}		
		/***/		
		$this->tmp = $this->rent_service->getTasks( array() )->toArray();
		$this->view->data = $this->tmp;
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