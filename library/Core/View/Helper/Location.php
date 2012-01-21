<?php
/**
 * @author Pascal Maniraho 
 */
class Core_View_Helper_Location extends Zend_View_Helper_Abstract{
	/**have to use kml content from google*/
	public function location($mixed, $options = array ( 'class' => '',  'property' => '' )){


        



            $param = '';
            $_checked = "";
            
           // print_r( $mixed );
            
            if( !($mixed instanceof Core_Entity_Location) ){
            	if( is_array($mixed) ){ 
            		$mixed = Core_Util_Factory::build( $mixed , Core_Util_Factory::ENTITY_LOCATION );
            	}else{
            		$mixed = Core_Util_Factory::build(array() , Core_Util_Factory::ENTITY_LOCATION);
            	}
            }
            $this->location = $mixed;
            //check if there is the property sent to this view helper
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            /**is sent as a fomatted checkbox already*/
            $this->checkbox = ( isset($options['checkbox']) && !empty($options['checkbox']) ) ? $options['checkbox'] : '';
		
            $this->checked = 0;
            if( isset($options['property'] ) && $options['property'] != null ) $this->checked = (int)$options['property'];
			$this->property_id = $this->checked;
			if( $this->location->id == $this->checked ){ $this->checked = 'checked=\'checked\''; }
            
			
			if( isset( $options['editing'] ) && !empty( $options['editing'] ) ) $this->editing = $options['editing'];
            else $this->editing = "";
            
			
			$_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';
            
                $_html  ='<div class=\'left\'>';
                	$_html .= $this->_checkbox();
				$_html .= '</div>';
				$_html .= '<div class=\'right\'>';	
                	$_html .='<div class=\'name\'>'.$this->location->name.'</div>';
                	$_html .='<div class=\'location\'>'.$this->location->location.'</div>';
                	$_html .='<div class=\'description\'>'.$this->location->description.'</div>';
                //$_html .= $this->_geo();
				$_html .='</div>';
                $_html .= $this->_edit();
            $_html = '<div class=\'location-view-helper '.$_class.'\'>'.$_html.'</div>';  
            
            
            $_html =  $this->_n();
            
            
            return $_html;
	}



 		/***/
		private function _edit(){
           if( $this->editing )return "<div class='edit-widget'>".$this->editing."</div>";
           return "";
        }
		
		/***/
		private function _geo(){
           if( $this->location ){
           		return '<div class=\'geo\'><div class=\'longitude\'>'.$this->location->longitude.'</div><div class=\'latitude\'>'.$this->location->latitude.'</div></div>';
           }
		  return "";
        }
		
		
		
		/***/
		private function _user(){           
			$_html = "";
            if( $this->user && is_string($this->user) )$_html = '<div class=\'user\'>'.$this->user.'</div>';
            if( $this->user && is_object($this->user) ){ 
				$_html = '<div class=\'user\'>';
					$_html .= isset( $this->user->name ) ? '<div class=\'name\'>'.$this->user->name.'</div>' : "";
	                $_html .= isset( $this->user->landlord ) ? '<div class=\'landlord\'>'.$this->user->landlord.'</div>' : "";
	                $_html .= isset( $this->user->description ) ? '<div class=\'description\'>'.$this->user->description.'</div>' : "";
	        	$_html .= '</div>';
			}
        	return $_html;
        }	
		
		/***/
		private function _adr(){ 
			if(is_string( $this->address) )
				return '<div class=\'address\'>'.$this->address.'</div>';  
			return "";
		}
        
		
		/***/
		private function _img(){
			$_html = '<div class=\'image\'>';
            if( $this->image && is_string($this->image) )
                 $_html .= $this->image;
             return $_html.'</div>';
        }		
		        
	/***/
        private function _checkbox(){
                $_html ='<div class=\'checkbox\'>';
                if( $this->checkbox && is_string( $this->checkbox ) ){
                    $_html .= $this->checkbox;
                }else{
                    $_html ='<div class=\'checkbox\'><input id=\'location-'.$this->location->id.'\' class=\'location-radio\' type=\'radio\' name=\'location\' value=\''.$this->property_id.'\' '.$this->checked.' /></div>';
		}
                $_html .='</div>';
            return $_html;
        }
        
        
        
        
        private function _n(){
        	
        	$_checkbox = $this->_checkbox();
        	
        	$_html = "" ; 
        		
        			$_html =   "<div class='supTicket nobg'>
                    	<div class='issueType'>
                        	<span class='issueInfo'></span>
                            <span class='issueNum'></span>
                            <div class='fix'></div>
                        </div>
                        <div class='issueSummary'>
                       		<span class='floatleft'>$_checkbox</span>	
                            <div class='ticketInfo'>
                            	<ul>
                                	<li><a href='#' title=''>".$this->location->name."</a></li>
                                    <li class='even'><strong class='red'>".$this->location->location."</strong></li>
                                    <li>Type: <strong class='green'>".$this->location->description."</strong></li>
                                    <li class='even'>verified</li>
                                </ul>
                                <div class='fix'></div>
                            </div>
                            <div class='fix'></div>
                        </div> 
                    </div>";
        		
        	return $_html;
        	
        }


}
?>