<?php
/**
 * @author Pascal Maniraho 
 */
class Core_View_Helper_LocationCard extends Core_View_Helper_Base{




	/**have to use kml content from google*/
	public function locationCard($mixed, $options = array ( 'class' => '',  'property' => '' )){

            $param = '';
            $_html = $_checked = "";
            $this->location = $mixed;
            if( is_object($this->location) && !($this->location instanceof Core_Model_Location ) ) $this->location = (array)$this->location;
            if( is_array($this->location) ) $this->location = new Core_Model_Location( $this->location );
            if( !$this->location ) $this->location = new Core_Model_Location();
            /**check if there is the property sent to this view helper**/
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $this->checked = 0;

            if( isset($options['property'] ) && $options['property'] != null ) $this->checked = (int)$options['property'];
                $this->property_id = $this->checked;
                if( $this->location->id == $this->checked ){ $this->checked = 'checked=\'checked\''; }
			
            if( isset( $options['editing'] ) && !empty( $options['editing'] ) ) $this->editing = $options['editing'];
            else $this->editing = "";
			
                $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
                $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';
                $_html .='<div class=\'location\'>'.$this->location->location.'</div>';
                $_html .='<div class=\'description\'>'.$this->location->description.'</div>';
                $_html .= $this->_edit();
            $_html = '<div class=\'location-view-helper card'.$_class.'\'>'.$_html.'</div>';
           
            return $_html;
	}



 	/***/
	private function _edit(){
           if( $this->editing )return "<div class='edit-widget'>".$this->editing."</div>";
           return "";
        }
			
}
?>