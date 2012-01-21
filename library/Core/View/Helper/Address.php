<?php



/**
 * 
 * This class will be used to display any address.
 * Its role, is to make any address object looks similar accross the application 
 * 
 * @author Pascal Maniraho 
 * @param Core_Model_Address $address this is the address object to display 
 * @param array $options  
 */



class Core_View_Helper_Address extends Zend_View_Helper_Abstract{
	
	public function address( Core_Entity_Address   $address, $options = array() ){
		
		//echo "<pre>" . print_r( $address , 1 ). "</pre>";
		
		$str = "";
		extract($options);//extracting array indices into variables 
                $title = ''; $class = ''; $id = ''; 
                if( isset($options['id']) && !empty( $options['id']) ){ $id = $options['id']; }
                if( isset($options['class']) && !empty( $options['class']) ){ $class = $options['class']; }
                if( isset($options['title']) && !empty( $options['title']) ){ $title = $options['title']; }

                if ( $id ) $id = 'id=\''.$id.'\''; else $id = '';
		if ( $class )$class = ' class=\'table-div '.$class.'\' '; else $class = ' class=\'address-viewer\' ';
		if ( $title )$title = '<div class=\'table-header-div\'>'.$title.'</div>'; else $title = '<div class=\'address-title\'>Address</div>';
				$str .= '<div class=\'table-row-div\'>'.
        					'<div class=\'table-cell-div medium-cell\' id=\'address-label\'>'.$address->address_value.'</div>'.
        					'<div class=\'table-cell-div large-cell\' id=\'address-value\'>'.$address->address_type.'</div>'.
        					( isset($address->note) && strlen($address->note) > 0 ? '<div class=\'table-cell-div large-cell\' id=\'address-value\'>'.$address->note.'</div>' : "" ).
        				'</div>';
	 	$_header =  '';
		return  ( $str != '' ) ? $_header.$title.'<div '.$class.' '.$id.'>'.$str.'</div>' : '';
		
	 	
	 	//$_html = $this->_n();
	 	
		//return $_html;
	}
	
	
	
	private function _n(){
		
		$_html = "
                <div class='widget'>
                    <div class='head'><h5 class='iMoney'>Address Info</h5><div class='num'><a href='#' class='greenNum'>+245</a></div></div>
                    
                    <div class='supTicket nobg'>
                    	<div class='issueType'>
                        	<span class='issueInfo'><a href='#' title=''>VPS Basic</a></span>
                            <span class='issueNum'><a href='#' title=''>[ #21254 ]</a></span>
                            <div class='fix'></div>
                        </div>
                        
                        <div class='issueSummary'>
                       		<a href='#' title='' class='floatleft'><img src='images/user.png' alt='' /></a>	
                            <div class='ticketInfo'>
                            	<ul>
                                	<li>Current order status:</li>
                                    <li class='even'><strong class='green'>[ pending ]</strong></li>
                                    <li>User email:</li>
                                    <li class='even'><a href='#' title=''>user@company.com</a></li>
                                </ul>
                                <div class='fix'></div>
                            </div>
                            <div class='fix'></div>
                        </div> 
                    </div>
                    
                    <div class='supTicket'>
                    	<div class='issueType'>
                        	<span class='issueInfo'><a href='#' title=''>VPS Basic</a></span>
                            <span class='issueNum'><a href='#' title=''>[ #21254 ]</a></span>
                            <div class='fix'></div>
                        </div>
                        
                        <div class='issueSummary'>
                       		<a href='#' title='' class='floatleft'><img src='images/user.png' alt='' /></a>	
                            <div class='ticketInfo'>
                            	<ul>
                                	<li>Current order status:</li>
                                    <li class='even'><strong class='green'>[ pending ]</strong></li>
                                    <li>User email:</li>
                                    <li class='even'><a href='#' title=''>user@company.com</a></li>
                                </ul>
                                <div class='fix'></div>
                            </div>
                            <div class='fix'></div>
                        </div> 
                    </div> 
                    
                    <div class='supTicket'>
                    	<div class='issueType'>
                        	<span class='issueInfo'><a href='#' title=''>VPS Basic</a></span>
                            <span class='issueNum'><a href='#' title=''>[ #21254 ]</a></span>
                            <div class='fix'></div>
                        </div>
                        
                        <div class='issueSummary'>
                       		<a href='#' title='' class='floatleft'><img src='images/user.png' alt='' /></a>	
                            <div class='ticketInfo'>
                            	<ul>
                                	<li>Current order status:</li>
                                    <li class='even'><strong class='green'>[ pending ]</strong></li>
                                    <li>User email:</li>
                                    <li class='even'><a href='#' title=''>user@company.com</a></li>
                                </ul>
                                <div class='fix'></div>
                            </div>
                            <div class='fix'></div>
                        </div> 
                    </div>                    
                </div>
                
            </div>";
		
		return $_html;
		
		
	}
	
	
}
?>