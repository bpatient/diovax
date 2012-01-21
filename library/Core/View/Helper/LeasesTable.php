<?php
/**
 * 
 * @author Pascal Maniraho 
 * @todo list sales overview 
 */
class Core_View_Helper_LeasesTable extends Zend_View_Helper_Abstract{
	
	
	
	
	
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $_class, $_id; 
	private $_header_titles, $_footer_titles; 
	
	
	public function __construct(){
		$this->_header_titles = array(  'Id' ,   'Parent' ,   'Customer' ,   'Category' ,   'Term' ,   'Price' ,   'Status' ,   'Starts' ,   'Stops' );
		$this->_footer_titles = array(  'period' => 'p' ,   'product' => 'p' ,   'Units' => 'sum(Units)'  ,   'Sales' => 'sum(sales)' , 'Tax' => 'sum(tax)' ,   'Shipping' =>'sum(Shipping)' ,  'Net' => 'sum(net)' );
		
		$this->_class = '';
		$this->_id = '';
	}
	
	
	
	
	/**Add more logic after design of rating system */
	public function leasesTable($data = array(), $options = array() ){

				
		if( isset($options['header']) && is_array(($options['header'])) ) $this->_header_titles = $options['header'];
		if( isset($options['footer']) &&  is_array(($options['footer'])) ) $this->_footer_titles = $options['footer'];
		
		/***get the header */
		$_header = $this->_header_div();
		/**get the footer */
		$_footer = $this->_footer_div();
		/**get rows */
		$_data  = ''; 
    $counter = 0;
    
   
    
		foreach( $data as $k => $date ){
			$_alt_class = 'even';
			if( (++$counter) & 1 ) $_alt_class = 'odd';
			$_data  .= '<div id=\'\' class=\'table-row-div '.$_alt_class.'\'>'; 	
				if(isset($date['period'])) $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.$date['period'].'</div>';
				if(isset($date['product'])) $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.$date['product'].'</div>';
				
				
				if(isset($date['units'])) $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.$date['units'].'</div>';
				elseif(isset($date['counter'])) $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.$date['counter'].'</div>';
				
				if(isset($date['sales'])) $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.number_format( $date['sales'], 2 ).'</div>';
				elseif(isset($date['price'])) $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.number_format( $date['price'], 2).'</div>';

				
				if(!isset($date['tax'])) $date['tax'] = 0; $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>'.number_format( $date['tax'], 2).'</div>';
				
				 
					$_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>cell</div>';
          $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>cell</div>';
          $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>cell</div>';
          $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>cell</div>';
				  $_data .= '<div id=\'\' class=\'table-cell-div small-cell\'>cell</div>';
			$_data .= '</div>';
      
     
		}
		
		
		
		$_data  ='<div id=\''.$this->_id.'\' class=\'table-div sales-overview-table-div '.$this->_class.' \'>'.$_header.$_data.$_footer.'</div>';
		
		
		 //print_r( $_data);
		return $_data;
		
	}
	
	
	/**
	 * @return string
	 */
	private function _header_div( ){
		$_hd = '<div class=\'table-header-div\' >';
		foreach ( $this->_header_titles as $k => $title ) $_hd .= '<div class=\'table-cell-div small-cell\' id=\'\'>' . (is_string($title) ? $title : $k ) .'</div>';
		return $_hd.'</div>';
	}
	
	
	/**
	 * @return string
	 */
	private function _footer_div( ){
		$_ft = '<div class=\'table-footer-div\'>';
		foreach ( $this->_footer_titles as $k => $title ) $_ft .= '<div class=\'table-cell-div small-cell\' id=\'\' >' . (is_string($title) ? $title : $k ) .'</div>';
		return $_ft.'</div>';
	}
	
}


?>