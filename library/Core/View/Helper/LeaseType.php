<?php
/**
 * @author Pascal Maniraho 
 */
class Core_View_Helper_LeaseType extends Core_View_Helper_Base{
	
	


        private $leaseTYpe;


	/**have to use kml content from google*/
	public function leaseType($mixed, $options = array ( 'class' => '',  'property' => '' )){

            $param = '';
            $this->leaseType = $mixed;

            
            if( is_object($this->leaseType)  && !($this->leaseType instanceof Core_Entity_LeaseType)) $this->leaseType = (array)$this->leaseType;
            if( is_array($this->leaseType) ) $this->leaseType = new Core_Entity_LeaseType( $this->leaseType );
            if( !($this->leaseType instanceof Core_Entity_LeaseType) )$this->leaseType = new Core_Entity_LeaseType();

            /**is sent as a fomatted checkbox already*/
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            if( isset( $options['user'] ) && $options['user'] != null ) $this->leaseType = $options['user'];
            $this->leaseType = ( object ) $this->leaseType;
            if( isset( $options['editing'] ) && !empty( $options['editing'] ) ) $this->editing = $options['editing'];
            else $this->editing = "";
            		
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';

            $_html = $this->_render();
           if( isset( $options['editing'] ) && strlen($this->editing) >= 1 ){ $_html .= $this->_edit(); }
           $_html = '<div class=\'lease-type-view-helper plan'.$_class.'\'>'.$_html.'</div>';
            return $_html;
	}

        /***/
	private function _edit(){
           if( $this->editing )return "<div class='edit-widget'>".$this->editing."</div>";
           return "";
        }


        /**
         * Rendering plan information
         * @return <type> 
         */
	private function _render(){
            $_html = "<div class='name'>".$this->leaseType->type."</div>";
            $_html .= "<div class='description'>".$this->leaseType->note."</div>";
           return $_html;
        }


        
		


}
?>