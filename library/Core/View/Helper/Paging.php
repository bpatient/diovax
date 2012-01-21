<?php
/**
 * 
 * this class will help to build paged results. 
 * there is a problem to change already built methods and adapt this one in the existing system. 
 *  
 * 
 * think about processing resulsts and send them to the view, or automate all tables 
 * via a helper. 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses Zend_View_Helper_Abstract
 *
 *
 *
 * 
 *
 */
class Core_View_Helper_Paging extends Core_View_Helper_Base{
	
	/**
	 * All options are required to make this helper works better 
	 * @param array $options
	 */
	public function paging( $mixed, $options = array ('result_set'=> array(), 'pg' => 0, 'per_page' => 25, '' => 0, 'partial'=> 'user.phtml')	)
	{
                $this->mixed = $mixed;
                $_class = "";
                if( isset($options['class']) && !empty($options['class']) ) $_class = $options['class'];
                if( !($this->mixed instanceof Core_Util_Paging) ) throw new Exception( "Instance of Core_Util_Paging required " );
                $this->links = $this->mixed->getPagedLinks();
                $_tmp = "";
                foreach( $this->links as $k => $v ){
                    $_tmp .= "<li>".$v."</li>";
                }
                
                /*dont return only links, but the content in a table*/
                return ( $_tmp == "" ) ? "" : "<div class='pg pagination $_class'><ul class='pages'>".$_tmp."</ul></div>";
	}


        /**
         */
        public function render() { }
}
?>