<?php

/**
 * This class will deal with comments from site, blog, news, store, event, lyrics,... 
 * @see Massist_CommentController
 * People may comment on rentals, the administrator can edit[ allow or block commnets]
 */ 
 
class Admin_CommentController extends Core_Controller_Base
{


	public function init()
    {
    	parent::init();
        /* Initialize action controller here */
    	$this->view->title = $this->title; 
		$this->view->sub_title = "Feed-back"; 
		$this->view->menu_items = $this->menu;
		
		
		/*variable to use with links */
    	$this->view->ctlr = $this->ctlr; 
		$this->view->mdl = $this->mdl; 
		$this->view->act = $this->act;

                 //
                $this->options = array();
                $this->options['data'] = array();
		
    	
    }
	
	
	public function preDispatch(){
		//getting comments of a section that is being commented. 
		//blog posts of this object. we should not show whatever in the session 
		//but something like  
		$this->session = new Zend_Session_Namespace("default");
		if(!$this->session->items):	
			$this->session->items = array();
		endif;
		$this->view->totalItems = sizeof($this->session->items);
		//$this->session->items = array();
	}
	
	
	
	
	
	
    public function init()
    {
        /* Initialize action controller here */
	}//init





    public function indexAction()
    {    	
		//this page will not list all posts but will show the overall activity of the blog 
    	$this->view->lower_title = "Blog::. Dashboard::.";
		$this->view->bentries = $this->session->items;
	}
	
	
	
	
	/*this action willl deal with create and update*/
	public function editAction(){
		//this area should be the dashboard of the blog.
			$this->view->lower_title = "Blog::. Edit::.";			
			$this->view->form  = new Ma_Form_CmsContent(array('id' => ( $this->view->totalItems + 1 ),'cms_category_id' => 1,'parent' => 1, 'displayed' => true, 'position' => false));	
			
			//check if there is a posted item
			if($this->getRequest()->isPost()):
				//validate the form and persist data using Form::persist(); 
				//internal form will be responsible of persisting objects. add/save 
				if($this->view->form->isValid($this->getRequest()->getPost())):
					//this will be implemented after database initialization
					//$this->view->form->persist();
					if(($id = $this->view->form->id->getValue()) > 0)
						$this->session->items[$id] = $this->view->form->mapToObject();
					else 
						$this->session->items[] = $this->view->form->mapToObject(); 
					$this->_redirect("massist/blog/index");				
				endif;
			
			//check if there is an ID or a positive parameter to load a pre-filled form 	
			elseif(($id = $this->_getParam("id", 0)) > 0):				
				$this->view->form->populate($this->session->items[$id]->toArray());
			else:	
				//nothing is done here. its better to remove this condition	
			endif;
			
				
	}//end of edition 
	
	
	public function postsAction(){		
		$this->view->lower_title = "Comment::. Comments about ::.";
		$this->view->bentries = $this->session->items;		
	}
	
	//gets the ID prompts for deletion. 
	//after deletion, redirects to the list of all posts. 
	//this method will be used as an alternative for browsers with no JS enabled  
	public function deleteAction(){		
		$this->view->lower_title = "Comment::. Delete::.";		
		//any post to delete action confirms the deletion 
		if($this->getRequest()->isPost() || $this->getRequest()->isGet()):			
			if(($id = $this->_getParam("id", 0)) > 0 || ($id = $this->getRequest()->getParam("id") > 0 )):
				unset($this->session->items[$id]);// = null;//this will be replaced by element deletion from ContentModel->delete()
				$this->_redirect("massist/blog/index");
				//the link should be sent as hidden element 
			endif;
		//prompt for confirmation 
		else:
			$this->view->content = "Delete Not posted...";
			//$this->_redirect("");
		endif;
						
	
		
	}
	
	
	public function viewAction(){
			$this->view->content = "View comment and set flags...";
	}
	




      public function postDispatch(){
        parent::postDispatch();
       $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }

	
	
	
	
}//end of the controller 
