<?php
/**
 * @author Pascal Maniraho 
 */
class Core_View_Helper_Landlord extends Zend_View_Helper_Abstract{
	
	
	
	/**have to use kml content from google*/
	public function landlord($mixed, $options = array ( 'class' => '',  'property' => '' )){

            $param = '';

            $this->user = $mixed;

            if( is_object($this->user)  && !($this->user instanceof Core_Model_Landlord)) $this->user = (array)$this->user;
            if( is_array($this->user) ) $this->user = new Core_Model_Landlord( $this->user );
            if( !($this->user instanceof Core_Model_Landlord) )$this->user = new Core_Model_Landlord();
            
			
            /**is sent as a fomatted checkbox already*/
            $this->checkbox = ( isset($options['checkbox']) && !empty($options['checkbox']) ) ? $options['checkbox'] : '';


            $this->image = ( isset($options['image']) && !empty($options['image']) ) ? $options['image'] : '';
            /**if this landlords is listed with this property id, then we check the checkbox*/
			$this->checked = 0;
            if( isset($options['property']) && $options['property'] != null ) $this->checked = (int)$options['property'];
            $this->property_id = $this->checked;
			
			
			$_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            if( isset($options['user']) && $options['user'] != null ) $this->user = $options['user'];
            $this->user = ( object ) $this->user;
            
			if( isset( $options['editing'] ) && !empty( $options['editing'] ) ) $this->editing = $options['editing'];
            else $this->editing = "";
            
			
			$_checked = "";
            if( $this->user->id == $this->checked ){ $this->checked = 'checked=\'checked\''; }else{ $this->checked = ""; }
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';
            
			
			$_html = '<div class=\'right\'>';
				$_html .= $this->_checkbox();	
				$_html .= $this->_img(); 
			$_html .= '</div>';		
            $_html .= '<div class=\'left\'>';
				$_html .= $this->_user();				
	            $_html .= $this->_edit();
            $_html .= '</div>';
			$_html = '<div class=\'landlord-view-helper '.$_class.'\'>'.$_html.'</div>';
            return $_html;
	}

        /***/
		private function _edit(){
           if( $this->editing )return "<div class='edit-widget'>".$this->editing."</div>";
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
			/**<a href=\'/app/a/rental/\'></a>*/
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
                	$_html .='<input type=\'checkbox\' name=\'landlord['.$this->user->id.']\' value=\''.$this->property_id.'\' '.$this->checked.' />';
                    }
                    $_html .='</div>';
		return $_html;
        }		
}
?>