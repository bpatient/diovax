<?php
/**
 * 
 * This controller will display the dashboard
 * 
 * @uses should use Core_Controller_Base
 *
 */
class Admin_IndexController extends Core_Controller_Base
{

    var $orders;
    var $limit_query = 26;
    
   	public function init() {	parent::init();  //
                $this->options = array();
                $this->options['data'] = array(); }
    public function preDispatch(){ parent::preDispatch();}
    
    

    public function indexAction(){

        $links = '';
        parent::index();
        if( isset($data) && is_array( $data ) ){
        
	$this->per_page = $this->limit_query;
        $options = array ('result_set' => $data['content_orders'], 'pg' => $this->pg , 'per_page' => $this->per_page );
        $this->paging = new Core_Util_Paging($options);
        $this->paging->baseUrl = $this->view->baseUrl.'?period='.$all_get_parameters['period']."&";
        $this->view->paging = $this->paging;
        $this->view->show_paged_links = ( count( $data['content_orders']) > $this->per_page );

        $data['items'] = $this->paging->getCurrentItems();
        $this->view->paged_links = $this->paging->getPagedLinks();
        
        if ( $this->view->show_paged_links ) $links = implode ( $this->view->paged_links, " | ");
        $data['links'] .=  ( $links )?' Pages '.$links : '';
        $this->view->content = "";
                  		
       }              
                      
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