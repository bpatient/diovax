<?php
/**
 * 
 * This utility class will break data into small paged resultset.
 * It will be used with View helper class to display the result  
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Zend_View_Helper_Abstract
 * @tutorial http://devzone.zend.com/article/11462
 *
 */



class Core_Util_Paging {
	
	
	
  
  public $resultset, $pageCount, $previous, $next;
  
	const RESULT_SET_MISSING_EXCEPTION = 1000;
	const CONTENT_MISSING_EXCEPTION = 1001;
	const RESULT_SET_DATATYPE_EXCEPTION = 1003;
	
	
	
	/**
	 * this is the array of data that will be displayed with the class 
	 */
	private $resultSet = null;
	public function setResultSet ( $resultSet ) { $this->resultSet = $resultSet; }
	public function getResultSet () { if ($this->resultSet) return $this->resultSet;  return false;}
	
	/**
	 * this variable will be used to print on screen paged datasets 
	 * @var $content 
	 */
	private $content = null; 
	public function setContent( $content ) { $this->content = $content;}
	public function getContent() { if ( $this->content ) return $this->content; return false; }

	
	
	
	private $currentItems = null; 
	public function setCurrentItems( $currentItems ){ $this->currentItems = $currentItems; }
	public function getCurrentItems(){ return $this->currentItems; } 
	
	
	public $baseUrl = '.';
	
	
	/**
	 * This function will be used to append whatever the query we have on address bar
	 * @var array $query
	 */
	private $query;
	
	
	/*I am not sure if this is done this way. the constructor should take some other variables */
	public function __construct ( $data  = array ( 'result_set'=> array(), 'pg' => 0, 'per_page' => 25, 'query' => array()  ) ){
		
		$this->query = array();
		if( isset($data['query']) && is_array($data['query']) ) $this->query = $data['query']; 
		
		
		$this->current = isset($data['pg']) ? $data['pg'] : 0;
		$this->perPage = isset($data['per_page']) ? $data['per_page'] : 20;
		$this->resultSet = isset($data['result_set']) ? $data['result_set'] : array();
		if ( false === $this->resultset ) throw new Exception ( self::RESULT_SET_DATATYPE_EXCEPTION); 
		$this->pager = new Zend_Paginator( new Zend_Paginator_Adapter_Array($this->resultSet) );
		 	  $this->pager->setCurrentPageNumber( $this->current );
              $this->pager->setItemCountPerPage( $this->perPage );
         $pages = $this->pager->getPages( 'sliding' );
         $this->setContent( $pages );  	
         $this->setCurrentItems( $this->pager->getCurrentItems() );
         
    }
	
	
	
	
	
	
	/**
	 * this notifier has not been used anyways 
	 */
	private function _notify(){
		throw new Exception ( $this->_missing );
	} 
	
	
	
	
	
	
	
	
	
	
	/**
	 *
	 * All options are required to make this helper works better 
	 * 
	 * @param array $options
	 *
	 */
	public function paging( $options =  array (	'result_set'=>'', 'pg' => 0, 'per_page' => 25 )	)
	{
            return $this->getPagedLinks(  );
	}
	
	
	
	
	
		/**
		 * this function processes the content to display. 
		 * It will be using decorators to customize some tables 
		 */
		public function getPagedContent (  ) {
			
			
			$data = $this->pager->getCurrentItems();
			/*here we need to know which object has been sent */
			foreach ( $data as $k => $obj ){
				echo "<pre>".print_r($obj)."<pre>";	
			}
			$this->content = $data; 
		}
		
		
		
		
		/***
		 * this function returns  paged links from current pager object  
		 */
		public function getPagedLinks ( ) {
		 	
		   $pages = $this->pager->getPages('sliding');/**its better to change this parameter with a generatl variable */
		   $pageLinks[] = $this->_getLink($pages->first, $this->pageCount, "first");
           if ( isset($pages->previous) && $pages->previous  ) 
           	  $pageLinks[] = $this->_getLink($pages->previous, $this->pageCount, "prev.");
              foreach ( $pages->pagesInRange  as $counter ):
                      if ( $pages->current == $counter ):
                                  $pageLinks[] = "<span class='a'>".$counter."</span>";
                      else:
                              $pageLinks[] = $this->_getLink($counter, $this->pageCount, $counter);
                      endif;
              endforeach;
            if ( isset($pages->next) && $pages->next ) $pageLinks[] = $this->_getLink($pages->next, $this->pageCount, "next");
               $pageLinks[] = $this->_getLink($pages->last, $this->pageCount, "last");
			
			return $pageLinks;//."<ul class='pages'></ul>";/**/
		}
		
		
		
	
	   /**
	    * 
	    * this function will be used to show the link of the current paging object 
	    * @param integer $page
	    * @param integer $perPage
	    * @param string $label
	    * @param array $options
	    */
      public function _getLink($page, $perPage, $label, $options = array() ){
      		if( !$options ) $options = $this->query; 
       		   $url =  ( !$this->baseUrl ) ? '' : $this->baseUrl  ; 
       		   $tmp_query = array_merge ( array('pg' => $page, 'pp' => $perPage), $options );
                   $url = ( preg_match('/\?/', $url ) ) ?  $url.http_build_query($tmp_query) : $url.'?'.http_build_query($tmp_query);
       	       return '<a href=\''.$url.'\'>'.$label.'</a>';
       }
	
}
?>