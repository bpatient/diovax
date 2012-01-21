<?php
/**
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0
 *
 * 
 */
class Admin_MessageController extends Core_Controller_Base
{
	
	
	
   	
    public function init()
    {
      parent::init();
       //
                $this->options = array();
                $this->options['data'] = array();
    }
    


    public function preDispatch(){
        parent::preDispatch();
    }
    
    public function indexAction(){   	
        parent::index();
        $this->view->content = "<div class='notice'><a href='http://stackoverflow.com/questions/2689284/executing-php-with-crontab'>Write a deamon</a> If some tasks requires automated triggers, <a href='http://en.wikipedia.org/wiki/Cron'> Chron Deamon </a> is an alternative</div>";
    }
    
    
    
    
    /***
     * System overall performance + 
     * web metrics + .... service to check the current version  
     */
    public function systemAction(){
        parent::index();
        // get php version
        $data['title_php_version'] = 'Php version';
        $data['content_php_version'] = phpversion();
        // get mysql version
        $data['title_mysql_version'] = 'Mysql version';
        $data['content_mysql_version'] = $this->analytics_service->return_mysql_version();
        // get nb_users
        $data['title_new_users'] = "New users";
        $data['data_content_new_users'] = $this->user_service->get_nb_users_period();
        //get nb of products
        $data['title_nb_products'] = "Nb of products";
        $data['content_nb_products'] = $this->store_service->get_nb_of_products();
        //get nb of products
        $data['title_nb_categories'] = "Nb of categories";
        $data['content_nb_categories'] = $this->store_service->get_nb_of_categories();
        // mysql info
        $data['title_mysql_size'] = "Mysql database size";
        $data['content_mysql_size'] = $this->analytics_service->return_size_database();        

        $system_data .= '<div class=\'table-row-div '.((++$odd & 1) ? 'odd' : 'even').'\' >
                                        <div class=\'table-cell-div small-cell\' >'.$data['title_php_version'].'</div>
                                        <div class=\'table-cell-div small-cell\' >'. $data['content_php_version'].'</div>
                         </div>';
        $system_data .= '<div class=\'table-row-div '.((++$odd & 1) ? 'odd' : 'even').'\' >
                                        <div class=\'table-cell-div small-cell\' >'.$data['title_mysql_version'].'</div>
                                        <div class=\'table-cell-div small-cell\' >'.$data['content_mysql_version'][0]['version()'].'</div>
                         </div>';
        $system_data .= '<div class=\'table-row-div '.((++$odd & 1) ? 'odd' : 'even').'\' >
                                        <div class=\'table-cell-div small-cell\' >'.$data['title_new_users'].'</div>
                                        <div class=\'table-cell-div small-cell\' >'.$data['data_content_new_users'][0]['users'].'</div>
                         </div>';
        $system_data .= '<div class=\'table-row-div '.((++$odd & 1) ? 'odd' : 'even').'\' >
                                        <div class=\'table-cell-div small-cell\' >'.$data['title_nb_products'].'</div>
                                        <div class=\'table-cell-div small-cell\' >'.$data['content_nb_products'][0]['total'].'</div>
                         </div>';
        $system_data .= '<div class=\'table-row-div '.((++$odd & 1) ? 'odd' : 'even').'\' >
                                        <div class=\'table-cell-div small-cell\' >'.$data['title_nb_categories'].'</div>
                                        <div class=\'table-cell-div small-cell\' >'.$data['content_nb_categories'][0]['total'].'</div>
                         </div>';

        $system_data .= '<div class=\'table-row-div '.((++$odd & 1) ? 'odd' : 'even').'\' >
                                        <div class=\'table-cell-div small-cell\' >'.$data['title_mysql_size'].'</div>
                                        <div class=\'table-cell-div small-cell\' >'.number_format($data['content_mysql_size'],2).'</div>
                         </div>';

        $this->view->content = $system_data;

    }
    
    /**
     * shows connected users + [popup map]
     * can be used for sec reasons.
     */
    public function connectedAction(){
    	
    	/**Enhancing paging and sorting functionalities*/
    	parent::index();
		$this->per_page  = 50;/*50 items to list per page */
		$this->view->baseUrl = $this->_helper->url('connected');
		
		
		
		//$this->options['auth.active'] = '1';
		$this->options['sort'] = true;
		$this->options['get_all'] = true;
		
		
		$data = ($this->options) ? $this->analytics_service->connected( $this->options ):$this->analytics_service->connected();
		$data_counter = count($data);/***/
    	
		$query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
		$options = array ('result_set' => $data, 'pg' => $this->pg , 'per_page' => $this->per_page, 'query' => $query);
		
		$this->paging = new Core_Util_Paging($options);
		$this->paging->baseUrl = 'admin/analytics/connected/?';
		$data = $this->paging->getCurrentItems();
		$this->paged_links = $this->paging->getPagedLinks();
		$this->show_paged_links = ( is_array( $this->paged_links ) && ($this->per_page  <   $data_counter)  );
	
		
		
		
		
    	
    	$analytics = '<div id=\'admin-analytics-connected-table\' class=\'table-div span-24 last\'>';
    	$analytics .= '<div class=\'table-header-div\'>
    		<div  class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"ID", 'field' => 'id', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Customer", 'field' => 'name', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Category", 'field' => 'category', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Banned", 'field' => 'banned', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Active", 'field' => 'active', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"IP", 'field' => 'ip', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Service", 'field' => 'service', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Location", 'field' => 'location', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    	</div>';
    	
    	
    	/**
    	 * Remove duplication using double chekc 
    	 * 
    	 */
    	$listed = array( );
    	foreach ( $data as $k => $datum ){
    		
    		$class = 'even';
    		if ( $datum['connected'] ) $class = 'odd';
    		if( !in_array($datum['id'], $listed)  ){
    			array_push( $listed, $datum['id'] ); 
    			$analytics .= '<div class=\'table-row-div '.$class.'\'>
    						<div class=\'table-cell-div nano-cell num-cell\' >'.$datum['auth_log_id'].'</div>
    						<div class=\'table-cell-div small-cell\' ><a href=\'?user_id='.$datum['id'].'\' >'.$datum['name'].'</a></div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['category'].'</div>
    						<div class=\'table-cell-div num-cell\' >'.$datum['banned'].'</div>
    						<div class=\'table-cell-div num-cell\' >'.$datum['active'].'</div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['ip'].'</div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['service'].'</div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['location'].'</div>
    					 </div>';
    		}
    	}
    	$analytics .= "</div>";
    	$analytics .= "<div class='table-footer-div'>";
		$analytics .= "<div  class='table-paging-div'>";
					$links = '';
					if ( $this->show_paged_links )
						$links = implode ( $this->paged_links, " | ");	
					$analytics .= ( $links )?' Pages '.$links : ''; 	
		$analytics .= "</div>";
    	/*append pagging */
    	$this->view->content = $analytics; 

    }
    
    
    
    /**
     * Orders  overview + period + customers
     * completed orders + under process + empty bags  
     */
    public function ordersAction(){
    	$this->view->content = "<div class='notice'>Show monthtly/weekly/ order stats. Fields ( processed/pending/...). Charts talks better than numbers</div>";
    	
    }
    
    
    
    
    
    /**
     * Total products 
     * queries about this product +..
     * Is it really important this thing??
     */
    public function productAction(){         

        /***/
        parent::index();
        // we will generate a list of products first
        $all_get_parameters = $this->_getAllParams();

        // if no post means we will display time from 24 ago to now
        $start_time = $all_get_parameters['period'] ?date("Y-m-d H:i:s",mktime(date('H')-$all_get_parameters['period'], date('i'), date('s'), date('m'), date('d'), date('Y'))) :date("Y-m-d H:i:s",mktime(date('H')-24, date('i'), date('s'), date('m'), date('d'), date('Y')));
        $end_time = date("Y-m-d H:i:s");

        $start_time_all_time = date("Y-m-d H:i:s",mktime(date('H')-175680, date('i'), date('s'), date('m'), date('d'), date('Y')));
        
        $option['period'] = $all_get_parameters['period'];
        //get_sells_for_product_by_period($product_id, $start_time, $end_time, $is_to_count = true)
        $all_products = array('orderby' => ' asc ', 'sort'=> true);
        
        $products = $this->store_service->getProducts($all_products);
        $data = array();
        foreach($products as $k => $row ){

            /**
             * @todo : check this function in future, version 2
             */
            //for some reason we have do push manually
            $data[$k]['id'] = $row['id'];
            $data[$k]['name'] = $row['name'];
            // first we get sells from all time in units
            $temp = $this->store_service->get_sales_for_product_by_period($row['id'], $start_time_all_time, $end_time, true);
            $data[$k]['sales_all_time'] = $temp[0]['total'];
            // second sales in $
            $temp = $this->store_service->get_sales_for_product_by_period($row['id'], $start_time_all_time, $end_time, false);            
            $data[$k]['sales_all_time_money'] = $temp[0]['total'];
            // third we get sales from range
            $temp = $this->store_service->get_sales_for_product_by_period($row['id'], $start_time, $end_time, true);
            $data[$k]['sales_range'] = $temp[0]['total'];
            //fourth
            $temp = $this->store_service->get_sales_for_product_by_period($row['id'], $start_time, $end_time, false);
            $data[$k]['sales_range_money'] = $temp[0]['total'];

        }/**End for*/

        //now let's do paging
        $this->per_page = 20;
        $options = array ('result_set' => $data, 'pg' => $this->pg , 'per_page' => $this->per_page );
        $this->paging = new Core_Util_Paging($options);
        $this->paging->baseUrl = $this->view->baseUrl.'?'.($all_get_parameters['period'] ? 'period='.$all_get_parameters['period'].'&' : '');
        
        
        
        $this->view->paging = $this->paging;
        $this->view->show_paged_links = ( count( $data) > $this->per_page );

        $data = $this->paging->getCurrentItems();
        $this->view->paged_links = $this->paging->getPagedLinks();        
        $links = '';

        
        if ( $this->view->show_paged_links ) $links = implode ( $this->view->paged_links, " | ");
        $option['links'] =  ( $links )?' Pages '.$links : '';
        $this->view->content = $this->view->product_table_helper->productTable( $data, $option);//_display_analytics();
    }
    
    
    
    
    /***
     * Sales per one product 
     */
    public function saleAction(){
    	
    	$data = array(); 
    	$options = array();    	
    	//$this->view->content = $this->view->sales_table_helper->salesTable(  );
   		$this->view->content = "<div class='notice'>This function has to show Sales per product by time ( month, week, days, years ). Charts needed. Product ID needed.</div>";
    }
    
    /**
     * Sales overview dashboard
     */
    public function salesAction(){
    	$data = array(); 
    	$options = array(); 
    	
    	
    	/**
    	 * 
    	 * @var unknown_type
    	 */
    	$data = $this->analytics_service->sales( $options );/**returns an array */
    	/**report about the resoult about tax calculations based on the following SQL */
    	/**Prepare data to send to the view helper*/
    	$_header_titles = array(  'Period' ,   'Units' ,   'Sales' ,   'Tax' ,   'Shipping' ,   'Net'  );
		  $_footer_titles = array(  '-' ,   '-' ,   '-' ,   '-' ,   '-' ,   '-'  );
	
    	
    	$this->view->content = $this->view->sales_table_helper->salesTable( $data , array( 'header' => $_header_titles, 'footer' => $_footer_titles ) );
      }
    
    
    
    /***/
    public function treportAction(){
    }
    
    
    
    
    
    /***/
    public function usersAction(){
    }
    
    
    /***/
    public function sfeesAction(){
    }
    
    
    
    
	  /***/
    public function ratingAction(){
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