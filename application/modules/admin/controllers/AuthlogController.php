<?php


/**
 * 
 *This controller will be used for cleanup purposes. 
 *it will handle auth_log bags  
 * 
 * 
 * @todo clean the database from bags users wont buy, or lost bags 
 * @todo may be depreacate this controller to include all of other sec purposes.
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0
 * @uses 
 * @see 
 * 
 *
 */
class Admin_AuthlogController extends Core_Controller_Base
{
   public function init()
    {
    	parent::init();
    	$this->view->title = $this->title; 
		$this->view->menu_items = $this->menu;
		$this->view->title = $this->title; 
		$this->view->sub_title = "mcart Dashboard";
		/*variable to use with links */
    	$this->view->ctrl = $this->ctrl; 
		$this->view->mdl = $this->mdl; 
		$this->view->act = $this->act; 		
		
		$this->view->link_to_index = '<a href=\''.$this->_helper->url('index').'\'>Back</a>';
                //
                $this->options = array();
                $this->options['data'] = array();

	}

	
	
	
	public function preDispatch()
    {
		parent::preDispatch(); 
    }
    
    
    
    /**
     * This function will be used to delete entries in this controller
     * if many items are selected, run the mass deletion 
     */
    public function jxdelAction(){ 
    	
    	
    	parent::ajax();
    	
    	//try{  	parent::ajax(); } catch ( Exception $e){ return false; }
    	$msg = "No data";
    	$ac = $this->getRequest()->getParam('ac'); //checking the action to take [ac]
    	$id = $this->getRequest()->getParam('s_id'); 
    	$st = $this->getRequest()->getParam('st');//the status 
    	$enabled = ( $ac == 'ed' && $st > 0 )? 1 : 0 ;
    	if ( $ac == 'dl' ){
    		try{
    			$this->auth_service->delete( $id, new Core_Model_AuthLog() ); 
    			$msg = 'Deleted';
    		}catch( Exception $e){
    			$msg = 'Not Deleted. An error Occured '.$e->getMessage();	
    		} 
    	}
    	echo $msg;	
    }
    
    
    
        /**
     * This function will be used to delete entries in this controller
     * if many items are selected, run the mass deletion 
     */
    public function jxviewAction(){


       
    	try{  	parent::ajax(); } catch ( Exception $e){ $this->_redirect('/');return false; }
    	$msg = "No data";
    	$ac = $this->getRequest()->getParam('ac'); //checking the action to take [ac]
    	$id = $this->getRequest()->getParam('s_id'); 
    	$st = $this->getRequest()->getParam('st');//the status 
    	$enabled = ( $ac == 'ed' && $st > 0 )? 1 : 0 ;
    	if ( $ac == 'vw' ){

            $msg = ' here we go ';


        }
    	echo $msg;	
    }
    

    
    
    
    
    /***/
    public function indexAction(){
    	/**identify users either by ip/location/agent/ and looking like the same guy, give then the same color. 
    	 * and if the guy is supposed to change, just switch color : odd/even can do it for us. 
    	 */
    	parent::index();
    	$this->items = $this->auth_service->getAuthLog()->toArray();    	
    	//$this->view->items = $this->auth_service->getAuthLog()->toArray();    	
    	
    	
    		
    	/***
    	echo $this->per_page;
    	echo '...'.$this->pg; ***/
    	
    	$options = array ('result_set' => $this->items, 'pg' => $this->pg , 'per_page' => $this->per_page);
		$this->view->items = $this->items;
		$this->paging = new Core_Util_Paging($options);
		$this->paging->baseUrl = $this->view->baseUrl;
		$this->view->paging = $this->paging;
		$this->view->items = $this->paging->getCurrentItems();
		$this->view->paged_links = $this->paging->getPagedLinks();
		$this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->items) > $this->per_page );
	
		/******/
    
    }

    
    
    
    
    
     /***
     * This function will run cleanup task
     */
    public function deleteAction(){
    
    	$content = '';
    	/**parameters */
    	$params = $this->getRequest()->getParams();
    	
    	
    	
    	
    	if( !($params['authid']) ) {
    		$this->view->message = " There are no items to delete ";
    		return false; 
    	}
    	
    	
			
			$isPost = $this->getRequest()->isPost();
			if ( $isPost ){
				$mau =  new Core_Model_AuthLog(); 
		    	/**Mass deletion if we have id[]*/
				if ( is_array($params['authid']) ){
					foreach ($params['authid'] as $k => $value){
						try { $this->auth_service->delete($value, $mau);}catch ( Exception $e){ };
					}
				}	
    			$this->_redirect ( 'admin/authlog');
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