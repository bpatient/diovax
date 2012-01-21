<?php


/**
 * @author Pascal Maniraho 
 * @version 1.0.0
 * 
 * 
 * 
 * 
 * @todo TaxTable, Zones, and countries need view helpers
 */


class Admin_TaxController extends Core_Controller_Base
{
   public function init()
    {
    	parent::init();
    	$this->view->title = $this->title; 
		$this->view->menu_items = $this->menu;
		$this->view->title = $this->title; 
		$this->view->sub_title = "mcart Dashboard";
		$this->view->ctlr = $this->ctlr; 
		$this->view->mdl = $this->mdl; 
		$this->view->act = $this->act; 
		
		$this->view->link_to_index = '<a href=\''.$this->_helper->url('index').'\'>Back</a>'; //
                $this->options = array();
                $this->options['data'] = array();
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
    		/*	
    		if ( $this->tax_service->setShippingCompanyEnabled($id, $enabled) ) 
    			$msg = ( $st > 0 ) ? 'Enabled' : 'Disabled';	
    		*/
    	}
    	echo $msg;	
    }

    
    
    /**Editing the country object*/
    public function countryAction(){    	
    	$id = $this->getRequest()->getParam('id');
    	$this->country = new Core_Model_Country();
    	$this->view->form = new Core_Form_Country();
    	$isPost = $this->getRequest()->isPost();
    	$post = $this->getRequest()->getPost();
    	if( $isPost ){
    		if( !$this->view->form->isValid($post) ){
    			$this->view->message = $this->view->form->getMessages();	
    			return false;
    		}   		
    		$this->tax_service->editCountry($this->view->form->getObject());
    		/**redirect **/
    		$this->_redirect('admin/tax/countries');
    	}
    	
    	if( $id > 0 ){
    		$arr = $this->tax_service->getCountries( array('id' => $id ) )->toArray();
    		$this->country = ($arr[0]) ? $arr[0] : $arr;			
    		$this->view->form->populate($this->country);
    	}
    	
    }
    
    
    
    
    
    
    /**
     * This section updates the zone section 
     * @todo remove Core_Model_TaxZone initialization from this function 
     */
    public function zoneAction(){    	
    	
    	$id = $this->getRequest()->getParam('id');
    	$this->zone = new Core_Model_TaxZone();/**useless. we dont need to call models from controllers, in addition it has not been used anywhere as a model, but as an array instead*/
    	
    	$sel_ctry = array();
    	$countries = $this->tax_service->getCountries();
    	foreach( $countries as $k => $country )
    		$sel_ctry[$country['id']] = $country['name']; 
    	$this->view->form = new Core_Form_TaxZone( array('countries' => $sel_ctry ) );
    	$isPost = $this->getRequest()->isPost();
    	$post = $this->getRequest()->getPost();
    	if( $isPost ){
    		if( !$this->view->form->isValid($post) ){
    			$this->view->message = $this->view->form->getMessages();	
    			return false;
    		}   		
    		$this->tax_service->editTaxZone($this->view->form->getObject());
    		$this->_redirect('admin/tax/zones');
    	}
    	
    	if( $id > 0 ){
    		$arr = $this->tax_service->getTaxZones( array('id' => $id ) )->toArray();
    		$this->zone = ($arr[0]) ? $arr[0] : $arr;			
    		$this->view->form->populate($this->zone);
    	}
    	
    	
    }
    
    
    
     /**
     * This section edits the tax class section 
     */
    public function tclassAction(){    	    	
    	
    	
    	$tax_types = array ( 'domestic' => 'Domestic', 'international' => 'International', 'other' => 'Other');
    	$id = $this->getRequest()->getParam('id');
    	$this->tclass = new Core_Model_TaxClass();
    	$this->view->form = new Core_Form_TaxClass( array('tax_types' => $tax_types) );    	
    	/**disabling rich text editor */
    	$class =  $this->view->form->description->getAttrib('class').' no-rich-text';
    	$this->view->form->description->setAttrib('class', trim($class) );
    
    	
    	$isPost = $this->getRequest()->isPost();
    	$post = $this->getRequest()->getPost();
    	if( $isPost ){
    		if( !$this->view->form->isValid($post) ){
    			$this->view->message = $this->view->form->getMessages();	
    			return false;
    		}   		
    		$this->tax_service->editTaxClass($this->view->form->getObject());
    		$this->_redirect('admin/tax/zones');
    	}
    	if( $id > 0 ){
    		$arr = $this->tax_service->getTaxClasses( array('id' => $id ) )->toArray();
    		$this->tclass = ($arr[0]) ? $arr[0] : $arr;			
    		$this->view->form->populate($this->tclass);
    	}
    	
    }
    
    
    
    
    /**
     * 
     * This rate action might have errors on redirections since, the id is supposed to be of a zone and not of a rate 
     * 
     * 
     */
    public function rateAction(){    	

    	$id = $this->getRequest()->getParam('id');
    	$this->tax_rate = new Core_Model_TaxRate();
    	$tax_zones = array(); $tax_classes = array();
    	$res = $this->tax_service->getTaxZones()->toArray();///$this->trace(print_r($res, true));
    	foreach( $res as $k => $value ) $tax_zones[$value['id']] = $value['name'];	
    	$res = $this->tax_service->getTaxClasses()->toArray(); ///$this->trace(print_r($res, true));
    	foreach( $res as $k => $value ) $tax_classes[$value['id']] = $value['name'];	

    	$this->view->form = new Core_Form_TaxRate(array('id' => $id, 'tax_zones' =>  $tax_zones, 'tax_classes' => $tax_classes ));
    	$class =  $this->view->form->description->getAttrib('class').' no-rich-text';
    	$this->view->form->description->setAttrib('class', trim($class) );
    	
    	$isPost = $this->getRequest()->isPost();
    	$post = $this->getRequest()->getPost();
    	if( $isPost ){
    		if( !$this->view->form->isValid($post) ){
    			$this->view->message = $this->view->form->getMessages();	
    			return false;
    		}   		
    		$this->tax_service->editTaxRate($this->view->form->getObject());
    		$this->_redirect('admin/tax/zones/'.$id);
    	}
    	/**/
    	if( $id > 0 ){
    		$arr = $this->tax_service->getTaxRates( array('id' => $id ) )->toArray();
    		$this->tax_rate = ($arr[0]) ? $arr[0] : $arr;	
    		$this->view->form->populate($this->tax_rate);
    	}
    	
    }
    
    
    
    
    
    
    /**
     * Displays the tax table, with all rates, countries, tax zone and tax classes.
     */
    public function indexAction(){
    		
    	/**Enhancing paging and sorting functionalities*/
    	parent::index();
    	$this->view->lower_title = "Tax Table";
		$query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
		$params = $this->_request->getParams();
		$opts = $this->options;
		
		
		/**
		 * Parameter sent to $this->tax_service->getTaxTable
		 */	
		$opts['get_all'] = true;
    	$opts['orderby'] = $query['ord'];
    	$opts['sort'] = true;
    	$this->view->baseUrl = $this->_helper->url('index');
    	if( isset($params['id']) && $params['id'] > 0 )$opts['tax_zone_id'] = $params['id'];

		$data = $this->tax_service->getTaxTable($opts);
		if ( !is_array($data) ) $data = $data->toArray();
		$data_counter = count($data);/***/
     	$options = array ('result_set' => $data, 'pg' => $this->pg , 'per_page' => $this->per_page, 'query' => $query);
			
    	
    	$this->paging = new Core_Util_Paging($options);
		$this->paging->baseUrl = $this->view->baseUrl;
		$data = $this->paging->getCurrentItems();
		$this->paged_links = $this->paging->getPagedLinks();
		$this->show_paged_links = ( is_array( $this->paged_links ) && ($this->per_page  <   $data_counter)  );

		
		/**
		 * This is a bad design since HTML makes the controller too big
		 * @var unknown_type
		 */
		$taxes = '<div id=\'admin-analytics-connected-table\' class=\'table-div  last\' >';
    	$taxes .= '
    		<div class=\'table-header-div\'>
    			<div  class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"ID", 'field' => 'id', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    			<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Tax Zone", 'field' => 'name', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    			<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Country", 'field' => 'country', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    			<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Tax", 'field' => 'class', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).' </div>
    			<div  class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Rate", 'field' => 'rate', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).' </div>
    			<div  class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Pos.", 'field' => 'position', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    			<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Modified", 'field' => 'modified', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    			<div  class=\'table-cell-div small-cell\'>Action</div>
    		</div>';	
    	
    	$url = $this->_helper->url('');
    	foreach ( $data as $k => $date ){

	   		$class = 'even';
			if ($date['connected']) $class = 'odd';
	    		$taxes .= '<div class=\'table-row-div '.$class.'\'>
	    						<div class=\'table-cell-div nano-cell num-cell\' ><a href=\'?\'>'.$date['tax_id'].'</a></div>
	    						<div class=\'table-cell-div small-cell\' ><a href=\''.$url.'index/'.$date['zone_id'].'\'>'.$date['zone'].'</a></div>
	    						<div class=\'table-cell-div small-cell\' ><a href=\''.$url.'country/'.$date['country_id'].'\'>'.$date['country'].'</a></div>	    						
	    						<div class=\'table-cell-div small-cell\' ><a href=\''.$url.'tclass/'.$date['class_id'].'\'>'.$date['class'].'</a></div>
	    						<div class=\'table-cell-div nano-cell num-cell\' ><a href=\''.$url.'rate/'.$date['tax_id'].'\'>'.$date['rate'].'</a></div>
	    						<div class=\'table-cell-div nano-cell num-cell\' >'.$date['position'].'</div>
	    						<div class=\'table-cell-div small-cell\'>'.date("Y-m-d", strtotime($date['modified'])).'</div>
	    						<div class=\'table-cell-div small-cell\' >
	    							<a href=\''.$url.'zone/'.$date['zone_id'].'\'>Ed. Zone</a> | ';
                        $taxes .= $date['tax_active'] ? '<a href=\''.$url.'rateendis/'.$date['tax_id'].'?option=0\'>Disable</a>': '<a href=\''.$url.'rateendis/'.$date['tax_id'].'?option=1\'>Enable</a>';
	    				$taxes .= '</div>
	    					 </div>';
	    	}
    	$taxes .= "</div>";
    	$taxes .= "<div class='table-footer-div'>";
		$taxes .= "<div  class='table-paging-div'>";
					$links = '';
					if ( $this->show_paged_links )
						$links = implode ( $this->paged_links, " | ");	
					$taxes .= ( $links )?' Pages '.$links : ''; 	
		$taxes .= "</div>";
    	$this->view->content = $taxes; 
    }
    
    
    
    
    
    
    
    
    /***/
    public function countriesAction(){
    	
    	parent::index();
		$this->per_page  = 50;/*50 items to list per page */
		$this->view->baseUrl = $this->_helper->url('countries');
		
		$this->ctry_url = $this->_helper->url('country');
		$this->zone_url = $this->_helper->url('zones');
		$this->rate_url = $this->_helper->url('rates');
		
		
		
		$data = ($this->options) ? $this->tax_service->getCountries( $this->options  ) : $this->tax_service->getCountries( );
		$data_counter = count($data);/***/
    	
		
		/***/
		$query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
     	$options = array ('result_set' => $data->toArray(), 'pg' => $this->pg , 'per_page' => $this->per_page, 'query' => $query);
		
		
		$this->paging = new Core_Util_Paging($options);
		$data = $this->paging->getCurrentItems();
		$this->paging->baseUrl = $this->view->baseUrl;
		$this->paged_links = $this->paging->getPagedLinks();
		$this->show_paged_links = ( is_array( $this->paged_links ) && ($this->per_page  <   $data_counter)  );
		
		$taxes = '<div id=\'admin-analytics-connected-table\' class=\'table-div\' >';
    	$taxes .= '<div class=\'table-header-div\'>
    		<div  class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"ID", 'field' => 'id', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div xl-large-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Name", 'field' => 'name', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Code", 'field' => 'code', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div large-cell\'>Action</div>
    	</div>';
    	foreach ( $data as $k => $date ){
    		$class = 'even';
    		if ($date['connected']) $class = 'odd';
    		$taxes .= '<div class=\'table-row-div '.$class.'\'>
    						<div class=\'table-cell-div nano-cell num-cell\' >'.$date['id'].'</div>
    						<div class=\'table-cell-div xl-large-cell\' ><a href=\''.$this->ctry_url.'/'.$date['id'].'\'>'.$date['name'].'</a></div>
    						<div class=\'table-cell-div small-cell\' >'.$date['code'].'</div>
    						<div class=\'table-cell-div large-cell\'><a href=\''.$this->zone_url.'/'.$date['id'].'\'>T. zone</a> | <a href=\''.$this->rate_url.'/'.$date['id'].'\'> T. Table</a> | '.($date['active'] ? '<a href=\'admin/tax/ctrendis/'.$date['id'].'?option=0\'>Disable</a>': '<a href=\'admin/tax/ctrendis/'.$date['id'].'?option=1\'>Enable</a>').'</div>
    					 </div>';
    	}
    	$taxes .= "<div class='table-footer-div clear'>";
		$taxes .= "<div  class='table-paging-div'>";
					$links = '';
					if ( $this->show_paged_links )
						$links = implode ( $this->paged_links, " | ");	
					$taxes .= ( $links )?' Pages '.$links : ''; 	
		$taxes .= "</div>";
		$taxes .= "</div>";
    	$this->view->content = $taxes; 
        	
    }
    
    
    
    
    
   	/**
    */
    public function zonesAction(){
    	
    	
    	parent::index();
    	$params = $this->_request->getParams();
		$opts = $this->options;
		if( isset($params['id']) && $params['id'] > 0 )$opts['country_id'] = $params['id'];
		
			
			
		$data = $this->tax_service->getTaxZones($opts);
		$data_counter = count($data);
                $this->ctry_url = $this->_helper->url('country');
		$this->zone_url = $this->_helper->url('zones');
		$this->rate_url = $this->_helper->url('rates');
		
		/**
		 * 
		 */
		
	
		
		
		$query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
     	$options = array ('result_set' => $data->toArray(), 'pg' => $this->pg , 'per_page' => $this->per_page, 'query' => $query);
		//$options = array ('result_set' => $data->toArray(), 'pg' => $this->pg , 'per_page' => $this->per_page);
		$this->paging = new Core_Util_Paging($options);
		$this->paging->baseUrl = $this->_helper->url('zones');//$this->view->baseUrl,
		$data = $this->paging->getCurrentItems();
		$this->paged_links = $this->paging->getPagedLinks();
		$this->show_paged_links = ( is_array( $this->paged_links ) && ($this->per_page  <   $data_counter)  );
		
		
		
    	$taxes = '<div id=\'admin-analytics-connected-table\' class=\'table-div\' >';
    	$taxes .= '<div class=\'table-header-div\'>
    		<div  class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"ID", 'field' => 'id', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div xl-large-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Name", 'field' => 'name', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Code", 'field' => 'code', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>
    		<div  class=\'table-cell-div medium-cell\'>Action</div>
    	</div>';
    	
    	$url = $this->_helper->url('');
    	
    	foreach ( $data as $k => $date ){
    		$class = 'even';
    		if ($date['connected']) $class = 'odd';
    		$taxes .= '<div class=\'table-row-div '.$class.'\'>
    						<div class=\'table-cell-div nano-cell num-cell\' >'.$date['id'].'</div>
    						<div class=\'table-cell-div xl-large-cell\' ><a href=\''.$url.'index/'.$date['id'].'\'>'.$date['name'].'</a></div>
    						<div class=\'table-cell-div small-cell\' >'.$date['code'].'</div>
    						<div class=\'table-cell-div medium-cell\'><a href=\''.$url.'zone/'.$date['id'].'\'>Edit</a> | '.($date['active'] ? '<a href=\''.$url.'zoneendis/'.$date['id'].'?option=0\'>Disable</a>': '<a href=\''.$url.'zoneendis/'.$date['id'].'?option=1\'>Enable</a>').'</div>
    					 </div>';
    	}
    	$taxes .= "</div>";
    	$taxes .= "<div class='table-footer-div'>";
		$taxes .= "<div  class='table-paging-div'>";
					$links = '';
					if ( $this->show_paged_links )
						$links = implode ( $this->paged_links, " | ");	
					$taxes .= ( $links )?' Pages '.$links : ''; 	
		$taxes .= "</div>";
    	$this->view->content = $taxes; 
        	
    }// end function
    
    
    
    
    
   	/**
   	 * 
   	 * this function is intended to display a list of all tax classes used by this application
    */
    public function classesAction(){
    	
    	
    	parent::index();
    	$params = $this->_request->getParams();
		$opts = $this->options;
		if( isset($params['id']) && $params['id'] > 0 )$opts['id'] = $params['id'];
		
			
			
		$data = $this->tax_service->getTaxClasses($opts);
		$data_counter = count($data);
        /**
		 */
		$query = array('sort'=> true ,'fld'=> $this->getRequest()->getParam('fld'),'ord'=> $this->getRequest()->getParam('ord') );
     	$options = array ('result_set' => $data->toArray(), 'pg' => $this->pg , 'per_page' => $this->per_page, 'query' => $query);
		$this->paging = new Core_Util_Paging($options);
		$this->paging->baseUrl = $this->view->baseUrl = $this->_helper->url('classes');//$this->view->baseUrl,
		$data = $this->paging->getCurrentItems();
		$this->paged_links = $this->paging->getPagedLinks();
		$this->show_paged_links = ( is_array( $this->paged_links ) && ($this->per_page  <   $data_counter)  );
		
    	$taxes = '<div id=\'admin-analytics-connected-table\' class=\'table-div\' >';
    	$taxes .= '<div class=\'table-header-div\'>';
    		$taxes .= '<div class=\'table-cell-div nano-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"ID", 'field' => 'id', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>';
    		$taxes .= '<div class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Tax Class", 'field' => 'name', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>';
    		$taxes .= '<div class=\'table-cell-div small-cell\'>'.$this->view->sortlink_helper->sortLink($this->view->baseUrl, array ( 'title'=>"Type", 'field' => 'type', 'limit' => $this->limit, 'order' => $this->view->order, 'pg' => $this->pg  )).'</div>';
    		$taxes .= '<div class=\'table-cell-div xl-large-cell\'>Description</div><div  class=\'table-cell-div medium-cell\'>Action</div>';
    	$taxes .= '</div>';
    	$url = $this->_helper->url('');
    	foreach ( $data as $k => $date ){
    	$class = 'even';
    	if ($date['connected']) $class = 'odd';
    		$taxes .= '<div class=\'table-row-div '.$class.'\'>';
    		$taxes .= '	<div class=\'table-cell-div nano-cell num-cell\' >'.$date['id'].'</div>';
    			$taxes .= '<div class=\'table-cell-div small-cell\' ><a href=\''.$url.'tclass/'.$date['id'].'\'>'.$date['name'].'</a></div>';  
    			$taxes .= '<div class=\'table-cell-div small-cell\' >'.$date['type'].'</div>';  						
    			$taxes .= '<div class=\'table-cell-div xl-large-cell\' >'.$date['description'].'</div>';    			
    			$taxes .= '<div class=\'table-cell-div medium-cell\'><a href=\''.$url.'tclass/'.$date['id'].'\'>Edit</a> | <a href=\''.$url.'delete/'.$date['id'].'?objct=tax_class\'>Delete</a></div>';
    		 $taxes .= '</div>';
    	}
    	$taxes .= "</div>";
    	$taxes .= "<div class='table-footer-div'>";
		$taxes .= "<div  class='table-paging-div'>";
					$links = '';
					if ( $this->show_paged_links )
						$links = implode ( $this->paged_links, " | ");	
					$taxes .= ( $links )?' Pages '.$links : ''; 	
		$taxes .= "</div>";
    	$this->view->content = $taxes; 
    }// end function
    /**
     * This function will enable disable a tax zone based on option
     */
    public function zoneendisAction(){
        extract($this->getRequest()->getParams());
        $this->view->id = $id;
        $this->view->option_zone = $option;
        if($this->view->id  == NULL || $this->view->id  == 0){

            $msg = "The tax zone you are trying to disable doesn't exist!";
            if($this->view->option_zone == 1) {
                $msg =  "The zone rate you are trying to enable doesn't exist!";
            }
            $this->view->message = $msg;
            return false;/**or make a redirection*/

        }
        // if is the first time we are on page we show message to disable country
        if(!$this->isPost){

            $content = "Click on button disable to confirm disable";
            if($this->view->option_zone == 1) {
                $content = "Click on button enable to confirm enable";
            }
            $this->view->content = $content;
            return false;
        }

        // here we will disable
        if($this->isPost){


            $this->view->zone = $this->tax_service->getTaxZones(array('id'=>$this->view->id))->toArray();
            $this->view->zone = $this->view->zone[0];
            $this->view->zone['active'] = 0;
            if($this->view->option_zone == 1) {
                $this->view->zone['active'] = 1;
            }
            $this->tax_service->editTaxZone($this->view->zone);            
            $msg = "Tax zone has been disabled!";
            if($this->view->option_zone == 1) {
                $msg = "Tax zone has been enabled!";
            }
            $this->view->message = $msg;
        }
    }// end function 

    /**
     * This function will enable disable a tax rate based on option
     */
    public function rateendisAction(){

        extract($this->getRequest()->getParams());
        $this->view->id = $id;
        $this->view->option_rate = $option;
        if($this->view->id  == NULL || $this->view->id  == 0){

            $msg = "The tax rate you are trying to disable doesn't exist!";
            if($this->view->option_rate == 1) {
                $msg =  "The tax rate you are trying to enable doesn't exist!";
            }
            $this->view->message = $msg;
            return false;/**or make a redirection*/

        }
        // if is the first time we are on page we show message to disable country
        if(!$this->isPost){

            $content = "Click on button disable to confirm disable";
            if($this->view->option_rate == 1) {
                $content = "Click on button enable to confirm enable";
            }
            $this->view->content = $content;
            return false;
        }

        // here we will disable
        if($this->isPost){

            $this->view->tax_rate = $this->tax_service->getTaxRates(array('id'=>$this->view->id))->toArray();
            $this->view->tax_rate = $this->view->tax_rate[0];
            $this->view->tax_rate['active'] = 0;
            if($this->view->option_rate == 1) {
                $this->view->tax_rate['active'] = 1;
            }
            
            $this->tax_service->editTaxRate($this->view->tax_rate);
            
            $msg = "Tax rate has been disabled!";
            if($this->view->option_rate == 1) {
                $msg = "Tax rate has been enabled!";
            }
            $this->view->message = $msg;
            
            
        }


    }// end function 
        



    /**
     * This function enable or disable a country based on parameter option
     */
    public function ctrendisAction(){
        
        extract($this->getRequest()->getParams());
        $this->view->id = $id;
        $this->view->option_contry = $option;
        if($this->view->id  == NULL || $this->view->id  == 0){

            $msg = "The country you are trying to disable doesn't exist!";
            if($this->view->option_contry == 1) {
                $msg = "The country you are trying to enable doesn't exist!";
            }                        
            $this->view->message = $msg;
            return false;/**or make a redirection*/

        }
        // if is the first time we are on page we show message to disable country
        if(!$this->isPost){

            $content = "Click on button disable to confirm disable";
            if($this->view->option_contry == 1) {
                $content = "Click on button enable to confirm enable";
            }                        
            $this->view->content = $content;
            return false;
        }
        
        // here we will disable
        if($this->isPost){


            $this->view->country = $this->tax_service->getCountries(array('id'=>$this->view->id) )->toArray();
            $this->view->country = $this->view->country[0];
            $this->view->country['active'] = 0;
            if($this->view->option_contry == 1) {
                $this->view->country['active'] = 1;
            }            
            $this->tax_service->editCountry($this->view->country);
            
            $msg = "Country has been disabled!";
            if($this->view->option_contry == 1) {
                $msg = "Country has been enabled!";
            }

            $this->view->message = $msg;
        }
    }// end function 



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