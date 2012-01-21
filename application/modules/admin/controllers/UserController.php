<?php



/**
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @uses Rt_Service::* 
 * 
 *
 */
class Admin_UserController extends Core_Controller_Base 
{

	
	
	public function init()
    {
    	parent::init();    
        $this->user_lookup = $this->user_service->getUserLookup();
        $this->view->user = new Core_Model_User();  //
        $this->options = array();
        $this->options['data'] = array();
  
    }//init


    /**
     */
    public function preDispatch(){
    	parent::preDispatch();
    }
    
    
    
    /***
     * this action will handle ajax request to set/reset some statuses. 
     *  
     */
    public function ajaxAction(){
    	/**
    	 * this variable will be used to print the message 
    	 * @var string $msg 
    	 */
    	$msg = 'No action';
    	/**
    	 * action = ac[dl|ed ] for delete, and delete.   
    	 */
    	//to check if we have an ajax request
    	parent::ajax();  
    	/**
    	 * cheking if we are banning [bn] or activate [ac] a user 
    	 */
    	$ac = $this->getRequest()->getParam('ac'); //checking the action to take [ac]
    	$id = $this->getRequest()->getParam('s_id'); 
    	$st = $this->getRequest()->getParam('st');//the status 
    	$active = ($ac == 'ac' && $st > 0  ) ? true : false ; 
    	$banned = ($ac == 'ba' && $st  > 0 ) ?  true : false ;
    	/**
    	 * action [ac] is activated [ac] according to status [ st ]
    	 */
    	if ( ($ac == 'ac' ) ){
    		if ( $this->user_service->setActive($id, $active) ) $msg = ( $st > 0 ) ? 'Activated' : 'De-activated'; 
    	}
    	
    	/**
    	 * action [ac] is banned [ba] according to status [ st ]
    	 */
    	if( $ac == 'ba' ){
    		if ( $this->user_service->setBanned($id, $banned ) )  $msg = ( $st > 0 ) ? 'Banned' : 'Enabled';
    	} 	
    	
    	echo $msg;
    	
    	
    }
    
    
    
    
    private function _index(){
      
    parent::index(); 
    
    $this->options['sort'] = false; $this->options['get_all'] = true;
    $this->items = ( empty($this->options) )? $this->user_service->getUsers() : $this->user_service->getUsers( $this->options );//  
    $this->items = $this->items->toArray();
    
    $query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
    $options = array ('result_set' => $this->items, 'pg' => $this->pg , 'per_page' => $this->per_page, 'query' => $query);
    
    

    
    $this->view->items = $this->items;
    $this->paging = new Core_Util_Paging($options);
    $this->paging->baseUrl = $this->view->baseUrl;
    $this->view->paging = $this->paging;
    $this->view->items = $this->paging->getCurrentItems();
    $this->view->paged_links = $this->paging->getPagedLinks();
    $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->items) > $this->per_page );
      
      
    }
    
    /*lists all users in the system */
    public function indexAction()
    {
    	/**Initialization of sorting and paging data*/
    	
      $this->_index();
    }




      /*lists all users in the system */
    public function landlordsAction()
    {
      /**Initialization of sorting and paging data*/
      $this->options['category'] = 'landlord';
      $this->_index();
    }
  
  
  
  
/*lists all users in the system */
public function agentsAction()
{
      /**Initialization of sorting and paging data*/
      $this->options['category'] = 'agent';
      $this->_index();
    
  }
  
      /*lists all users in the system */
    public function tenantsAction()
    {
      /**Initialization of sorting and paging data*/
      $this->options['category'] = 'tenant';
      $this->_index();

  }
  
      /*lists all users in the system */
    public function techniciansAction()
    {
      /**Initialization of sorting and paging data*/
      $this->options['category'] = 'technician';
      $this->_index();
    }
  

	
	
	
	
	/**
	 * Edits a user from Admin perspective. 
	 * @return void 
	 */
	public function editAction(){				
			
		$redirect = false; 
		$this->id = 0;
		$this->view->form  = new Core_Form_User(array('id' => $this->id));
		
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if( !$this->view->form->isValid( $this->post ) ){
				$this->view->message = $this->view->form->getMessages();
				return false;
			}
				$this->id = $this->user_service->editUser( $this->view->form->getObject() );
				if ($this->id > 0) $this->_redirect('admin/user/profile/'.$this->id); 
			
		}else if ( ($request = $this->getRequest()->getParams()) && ((int) $request["id"]) > 0){
			$this->id = $request["id"];
		
		}
		
		
		
		//pre-fill user form in a rrayArrayArrayArraybecause we edit an existing user 
		if($this->id > 0 ){
			$user = $this->user_service->getUsers(array("id" => $this->id))->toArray();
			if( $user ) $user = $user[0]; 
			$this->view->form->getElement('id')->setValue($this->id); 
			$this->view->form->getElement('name')->setValue($user['name']); 
			$this->view->form->getElement('email')->setValue($user['email']); 
			$this->view->form->getElement('birthday')->setValue($user['birthday']); 
			$this->view->form->getElement('category')->setValue($user['category']); 
			$this->view->form->getElement('button')->setValue("Update");			 
		}
		
		//it should be good to redirect to users profile to add address/telephone, generate password, 
		if( true === $redirect );//make redirection  
		
		
		$this->view->user_id = $this->id;
			
	}
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * editing the user profilt
	 * the user should be able to access his/her profile
	 * 
	*/ 
	public function profileAction(){
		
		//if there is no id sent, admin section shows currently connected user 
		if ( !( $id = $this->_getParam("id")) || !($id > 0) ){
			$id = $this->user_id; 
		}	
		
		$this->view->totals = array();/**/
		$this->view->user = $this->user_service->getUserInfo(array('id'=>$id));
		//$this->view->orders = $this->shop_service->getOrder(array ( 'user_id' => $id));
		//$this->view->totals = 0.00;
		//if ( $this->view->orders ) $this->view->totals = $this->tax_service->getOrderTotals($this->view->orders->toArray());
		//print_r( $this->view->orders->toArray() );
		//this function is live, and if there is any change in tax calculations, it wont reflect the same tax 
		$this->view->auth = $this->auth_service->getAuth(array('user_id' => $id) );	
		/**if a user has no authentication password, or openid | fb |, 
		 * generate one for him and send it to him/her */
		$this->view->hasAuth = (  (count($this->view->auth->toArray() )  > 0 )  );
		$this->view->user_id = $id;//
	}
	
	
	
	/**a function to regenerate the password for this client */
	public function pswdAction(){
			
		if ( !( $id = $this->_getParam("id")) || !($id > 0) )
			$this->_redirect('admin/user/index');//	
		/*
		 * it should be better to set active time so that we ask the user to change the 
		 * password once he connects 
		 * 
		 */
		$this->view->form = new Core_Form_GenPassword();
		$post = $this->getRequest()->getPost();		
		if ( $this->getRequest()->isPost() ){
			if ( $this->view->form->isValid($post) ){
				
				$auth_id = 0;	
				$verif_auth = $this->auth_service->getAuth(array( 'user_id'=> $id, 'service'=> 'system', 'key'=> 'password' ))->toArray();
				$user = $this->user_service->getUsers(array( 'id'=> $id ) )->toArray();
				
				
				$this->trace( $user[0]['email'] );
				
				if ( isset($verif_auth[0]['id']) && $verif_auth[0]['id']  > 0 ){
					$auth_id = $verif_auth[0]['id'] ;
				}
				
				$pswd = $this->view->form->getElement('password')->getValue();
				$auth = $this->user_service->editAuth(
						array (	"id" => $auth_id, "user_id" => $id, "service" => "system",	"key" => 'password',
							"value" => $pswd,	"modified" => date("Y-m-d h:i:s", time() ),
							"active_time" => 3600 ,	"active" => 1
						)
					);
					
					
				/*notifify the user via email */
				try {	
				$this->message_service->password( array ('name' => $user[0]['name'] , 'email' => $user[0]['email'] ), $pswd, true );		
				}catch ( Exception $e ){
					$this->view->message = $e->getTraceAsString();
				}	
					
					
					
			}else{
				$this->view->message = $this->view->form->getMessages();	
			}
		}
		
		$this->view->user_id = $id;//
	
	}
	/**
	 * the user should not be deleted 
	 */
	public function deleteAction(){
		throw new Exception ( " UserControlle::deleteAction not Implemented ... ");
		//$this->view->content = "Delete User";
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