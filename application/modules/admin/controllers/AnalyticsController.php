<?php


/**
 * 
 * 
 * This controller shows health status of the application
 * it is used to give useful information about performance of the software and the store in general 
 * it will spot also some failures on system performance, and stats 
 * It will also give an insight on tax tables, shipping rates and so on. 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0
 *
 * 
 * @tutorial http://en.wikipedia.org/wiki/Internet_taxes Wikipedia entry of how Internet tax works 
 * @tutorial http://www.endless.com/help/200107190/ For Internet Tax 
 * @tutorial http://www.endless.com/help/200104820?ie=UTF8&pf_rd_r=1363X68DBFMHB3CR6T0Q&pf_rd_m=AF16NM0QF9TKW&pf_rd_t=801&pf_rd_i=200103510&pf_rd_p=253246201&pf_rd_s=center-2 helps for shipping services
 * 
 * @tutorial https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_ProfileAndTools PayPal sales tax calculation + shipping fees 
 * @tutorial http://checkout.google.com/support/sell/bin/answer.py?hl=en&answer=71391 google check out tax query service 
 * @tutorial http://checkout.google.com/support/sell/bin/answer.py?hl=en&answer=73973  google check out tax query service 
 * @tutorial http://code.google.com/apis/checkout/developer/Google_Checkout_XML_API_Merchant_Calculations_API.html
 * @tutorial http://www.strikeiron.com/Catalog/ProductDetail.aspx?pv=5.0.0&pn=Sales+and+Use+Tax+Basic tax calc. and data provider
 * @tutorial http://www.strikeiron.com/Catalog/SampleCode/
 * 
 * @tutorial http://www.tipsandtricks-hq.com/ecommerce/wp-estore-tax-calculation-916 a wordpress cart about tax calculation
 * @tutorial http://www.newrules.org/retail/rules/internet-sales-tax-fairness tax on sales   
 * 
 * 
 * @link http://tax-tables.com/zip2tax.php 
 * @link http://www.scriptlance.com/projects/1238123322.shtml similar online quote spec. 
 * @link http://stackoverflow.com/questions/302759/computing-california-sales-tax for a question about taxes and a way to solve it
 * 
 * @uses 
 * @see merchant calculations api
 * @see tax table 
 * @see shipping fees
 * @see AvaTax tax engine 
 * @see Avalara tax engine software  
 * 
 * 
 * 
 * @todo Sales overview 
 * @todo Calc Total Income/Cost of Sale/deduce the profit 
 * @todo Tax report overview/Sale period[ ability to choose dates ]
 * @todo Handling report [ overview of shipping [ price | carrier | ...] 
 * 
 * 
 * 
 * @abstract Merchant Calculations API taxe calculatation uses the default U.S. rounding rules for financial calculations. 
 * 			 So make sure that you confirm to this before using this application.  
 * 			U.S. rounding rules for financial calculations stipulates that taxes are calculated by assessing the tax rate to the total cost of all of the items and then using the HALF_EVEN rounding mode, or banker's rounding, to determine the tax for the order. 
 * 			U.K. the default behavior is to calculate tax separately for each item in the order and then apply the HALF_UP rounding mode to each calculation 
 * 			for rounding methods, use http://www.javabeat.net/tips/35-precise-rounding-of-decimals-using-rounding-m.html
 * 			and http://www.diycalculator.com/sp-round.shtml for algorithms followed to work on rounding. 
 * 			
 * 			Its better to enable those two modes, to make clients from both UK and US rounding systems happy
 * 
 */
class Admin_AnalyticsController extends Core_Controller_Base
{
	
	
	
   	
   public function init()
    {
    	parent::init();
        /*Initialize action controller here */
        $this->options = array();
        $this->options['data'] = array();

		
    }
    

    /***/
    public function preDispatch(){
        parent::preDispatch();
    }
    
    /***/
    public function indexAction(){   	
        parent::index();
        $this->view->content = $this->view->table = $this->rent_service->getAppAnalytics();
    }
    
    
    
    
    /***/
    public function systemAction(){
        parent::index();
        $this->view->content = "no content";

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
    	
    	/**
    	 * Prepare data to send to the view helper 
    	 */
    	$_header_titles = array(  'Period' ,   'Units' ,   'Sales' ,   'Tax' ,   'Shipping' ,   'Net'  );
		$_footer_titles = array(  '-' ,   '-' ,   '-' ,   '-' ,   '-' ,   '-'  );
	
    	
    	$this->view->content = $this->view->sales_table_helper->salesTable( $data , array( 'header' => $_header_titles, 'footer' => $_footer_titles ) );
    }
    
    
    
    /**
     * Tax report action will show how much to pay in taxes per month and to regions
     */
    public function treportAction(){
    	$this->view->content = "<div class='notice'> Processes tax by monthly tax report</div>";
    }
    
    
    
    
    
    /**
     * stats for users/age/region
     * + user map 
     */
    public function usersAction(){
        $this->view->content = "<div class='notice' > Stats about users,age, region. Charts talks better.</div>";
    }
    
    
    /**
     * 
     * Tax Table action, uses the tax service to display the current state of taxes, 
     * and may be used to update cached tax table file. 
     * we wont be storing this in the database for this version
     *  for the documenation us
     */
    public function ttableAction(){
    	$content = "<div class='notice'>";
    	$content .= "<div>This section will be used to export tax from dataprovider to this application</div>
    				 <div><a href='http://www.endless.com/help/200107190/'>From here</a>, the tax is calculated from the shipping address.</div>
    				 <div>The tax table has to have tax estimation from a webservice source. Synchronize button will update tax rates table with fresh data from the webservice</div>
    				 </div>";
    	$this->view->content = $content."<div><input type='button' name='synch' value='Synchronize' class='button'/></div>";
    }
    
    
    
    
    
    
    /**
     * Shipping fees action will show shipping fees for each shipping service we are using 
     * or implemented by the system.  
     */
    public function sfeesAction(){
    	
    	
    	if( $this->isPost )
    	{
    		$this->ship_service->synchronize($this->post);
    	}
   	 	$content = "<div class='notice'>Use a webservice to get shipping companies costs/costs might change monthly</div>";
    	$this->view->content = $content."<div ><input type='button' name='synch' value='Synchronize' class='button'/></div>";
    }
    
    
    
    
	/**
     * RatingAction talks to Analytics Service for statics about voting 
     */
    public function ratingAction(){
    	$data = $this->analytics_service->rating();
    	$analytics = '<div id=\'admin-analytics-rating-table\' class=\'table-div\' >';
    	$analytics .= '<div class=\'table-header-div\' >
    		<div  class=\'table-cell-div xl-large-cell\' >Item</div>
    		<div  class=\'table-cell-div small-cell\' >Voters</div>
    		<div  class=\'table-cell-div small-cell\' >Max Rate</div>
    		<div  class=\'table-cell-div small-cell\' >Max Rate Voters</div>
    	</div>';
    	foreach ( $data as $k => $datum ){
    		$analytics .= '<div class=\'table-row-div\'>
    						<div class=\'table-cell-div xl-large-cell\' ><a href=\'?pid='.$datum['product_id'].'\' >'.$datum['name'].'</a></div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['voters'].'</div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['max_rate'].'</div>
    						<div class=\'table-cell-div small-cell\' >'.$datum['max_rate_voters'].'</div>
    					 </div>';
    	}
    	$analytics .= "</div>";
    	$this->view->content = $analytics;
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


?>