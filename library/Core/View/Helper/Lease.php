<?php
/**
 * This helper will be used to display leases with ajaxed checkobx to update lease's table.
 * @author Pascal Maniraho 
 */
class Core_View_Helper_Lease extends Zend_View_Helper_Url{
	



        /***/
        public function lease( $mixed , $options = array('display') ){

            $param = '';
            $this->lease = $mixed; 
            if( is_array($this->lease) ){
            	if( isset($this->lease[0]) && is_array($this->lease[0]) ){
            		$this->lease =  $this->lease[0];
            	}
            }
           
            $this->lease = Core_Util_Factory::build($this->lease, Core_Util_Factory::ENTITY_LEASE);
            
            //check if there is the property sent to this view helper
            $this->selected = 0;/***/
            if( isset($options['property']) && $options['property'] != null ) $this->selected = (int)$options['property'];
            //$_booking = '/app/a/rental/'.$this->property->id.'';
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $_checked = "";
            if( $this->lease->id == $this->selected ){ $_checked = 'checked=\'checked\''; }
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? ' class =\''.$options['class'].'\' ' : '';
            $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';
            $_html ="Lease Selector";

            $this->display = isset($options['display']) ?  $options['display'] : Core_Util_Settings::FULL_SIZE_DISPLAY;
            $this->property = $this->getProperty($mixed);
            $this->user = $this->getCustomer($mixed);
            
            if( $this->display == Core_Util_Settings::ONE_LINE_DISPLAY ){
            	$_html = $this->_n();//
            }else{ 
            	$_html ='<div class=\'lease\'>';
            	$_html .='<div class=\'checkbox\'><input type=\'radio\' name=\'lease\' value=\''.$this->lease->id.'\' '.$_checked.' /></div>';
            	$_html .='<div class=\'user\'><div class=\'user\'>'.$this->user->name.'</div></div>';
            	$_html .='<div class=\'starts\'>Starts  '.$this->lease->starts.'</div>';
            	$_html .='<div class=\'stops\'>Stops  '.$this->lease->stops.'</div>';
            	$_html .= $this->_edit();
            	$_html .='</div>';
            	$_html = '<div class=\'helper-lease '.$_class.'\'>'.$_html.'</div>';
            	 
            }
            
            
            
            return $_html;
	}

	     
    /**returns the string to edit an instance of a property*/
    private function _edt(){ return '<div class=\'edit-widget\'>'.$this->editing.'</div>'; }
    private function _ttl( ){ return '<div class=\'title\'>'.$this->task->title.'</div>'; /**<a href=\'/app/a/rental/'.$this->task->id.'\' rel=\'/app/a/rental/'.$this->task->id.'\'></a>*/}
    private function _dsc( ){ return '<div class=\'description\'>'.$this->description.'</div>'; }
    
    
    /**
     * @todo use this function to clean 
     */
    private function _n(){
    	//echo "<pre/>";
    	//print_r(  $this->lease );
    	
    	return "<div class='supTicket nobg'>
                    	<div class='issueType'>
                        	<span class='issueInfo'>".( $this->property->unit_code )."</span>
                            <span class='issueNum'>[ #".( $this->lease->id )." ]</span>
                            <div class='fix'></div>
                        </div>
                        
                        <div class='issueSummary'>
                       		<a href='#' title='' class='floatleft'><img src='/assets/images/user.png' alt='' /></a>	
                            <div class='ticketInfo'>
                            	<ul>
                                	<li><a href='#' title=''>".($this->user->name)."</a></li>
                                	<li><a href='#' title=''>".($this->user->email)."</a></li>
                                    <li><strong class='red'>Payment: [ ".($this->lease->payment)." ]</strong></li>
                                    <li>Status: <strong class='green'>[".($this->lease->status)." ]</strong></li>
                                    <li>".( date( 'Y/m', strtotime($this->lease->starts) ) ). '<strong>-</strong>' .( date( 'Y/m', strtotime($this->lease->ends) ) ). "</li>
                                </ul>
                                <div class='fix'></div>
                            </div> 
                            <div class='ticketInfo'>
                            	<ul>
                                	<li></li>
                                	<li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                                <div class='fix'></div>
                            </div>
                            <div class='fix'></div>
                        </div> 
                    </div>";
    	
    }
    
    
    /**
     * @todo needs adjustments
     * @param unknown_type $data
     */
    private function getAddress($data){
    	$data = (object)$data;
    	return Core_Util_Factory::build ( array (
    			'id' => $data->id,
    			'title' => $data->title,
    			'note' => $data->note,
    			'created' => $data->created,
    			'modified' => $data->modified,
    			'starts' => $data->starts,
    			'ends' => $data->ends,
    			'status' => $data->status,
    			'reason' => $data->reason,
    			'type' => $data->type,
    			'reference' => $data->reference
    	), Core_Util_Factory::ENTITY_BOOKING );
    }
    
    private function getProperty($data){
    	$data = (object)$data;
    	return Core_Util_Factory::build ( array (
    				'id' => (int)$data->property_id, 	
    				'parent' => isset( $data->parent ) ? $data->parent : $data->property_parent,
    				'site_id' =>  (int)$data->site_id ,	
    				'unit' => $data->unit,
    				'unit_code' => $data->unit_code,
    				'rent' => $data->rent,
    				'name' => $data->name,
    				'description' => $data->description,
    				'built' => $data->built,	
    				'created' => $data->created,
    				'modified' => $data->modified,		
    				'token' => isset( $data->property_token ) ? $data->property_token : $data->token,
    				'url' => isset(  $data->property_url ) ? $data->property_url: $data->url
    	), Core_Util_Factory::ENTITY_PROPERTY );
    
    
    }
    
    private function getCustomer($data){
    	$data = (object)$data;
    	$_dt = Core_Util_Factory::build ( array (
    		'id' => isset( $data->user_id ) ? (int)$data->user_id : 0,
    		'name' => isset( $data->user_name ) ? $data->user_name : "-",
    		'email' => isset( $data->email ) ? $data->email : "-",
    		'birthday' => isset( $data->birthday ) ?  $data->birthday : "",
    		'category' => isset( $data->category ) ?  $data->category : "",
    		'banned' => isset( $data->banned ) ?  $data->banned : "",
    		'active' => isset( $data->active ) ?  $data->active : "",
    		'modified' => isset( $data->modified ) ?  $data->modified : "",
    		'created' => isset( $data->created ) ?  $data->created : "",
    		'token' => isset( $data->user_token ) ?  $data->user_token : ""
    	), Core_Util_Factory::ENTITY_USER );
    	//print_r( $_dt );
    	//throw new Exception( "<pre>".print_r( $data, 1 )."</pre>" );
    	return $_dt;
    }
    
  
}
?>