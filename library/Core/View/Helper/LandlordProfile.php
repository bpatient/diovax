<?php
/**
 * @author Pascal Maniraho 
 */
class Core_View_Helper_LandlordProfile extends Core_View_Helper_Base{
	
	


        private $contact, $url, $token;


	/**have to use kml content from google*/
	public function landlordProfile($mixed, $options = array ( 'class' => '',  'property' => '' )){

            $param = '';
            $this->profile = $mixed;
            if( is_object($this->profile)  && !($this->profile instanceof Core_Entity_LandlordProfile)) $this->profile = (array)$this->profile;
            if( is_array($this->profile) ) $this->profile = new Core_Entity_LandlordProfile( $this->profile );
            if( !($this->profile instanceof Core_Entity_LandlordProfile) )$this->profile = new Core_Entity_LandlordProfile();
			
            /**
            $this->user = $mixed;
            if( is_object($this->user)  && !($this->user instanceof Core_Entity_Landlord)) $this->user = (array)$this->user;
            if( is_array($this->user) ) $this->user = new Core_Entity_Landlord( $this->user );
            if( !($this->user instanceof Core_Entity_Landlord) )$this->user = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_LANDLORD);
            **/
            
            
            $this->url = isset($options["url"]) && strlen($options["url"]) > 0 ? $options["url"] : ""; 
            $this->token = isset($options["token"]) && strlen($options["token"]) > 0 ? $options["token"] : ""; 
            
            
            /**is sent as a fomatted checkbox already*/
            $this->address = ( isset($options['address']) && !empty($options['address']) ) ? $options['address'] : '';
            $this->image = ( isset($options['image']) && !empty($options['image']) ) ? $options['image'] : '';
            /**if this landlords is listed with this property id, then we check the checkbox*/
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            if( isset( $options['user'] ) && $options['user'] != null ) $this->profile = $options['user'];
            $this->profile = ( object ) $this->profile;
            if( isset( $options['editing'] ) && !empty( $options['editing'] ) ) $this->editing = $options['editing'];
            else $this->editing = "";
            		
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';



           $_html = '<div class=\'landlord-contact-view-helper contact'.$_class.'\'>'.$this->_render().'</div>';
            return $_html;
	}

        /***/
	private function _edit(){
           if( $this->editing )return "<div class='edit-widget'>".$this->editing."</div>";
           return "";
        }


        /**
         * Rendering contact information
         * @return <type> 
         */
	private function _render(){
		  $_html = "";
          if(isset($this->profile->logo) && strlen($this->profile->logo) > 0 ) { 
          	//$_html .= "<div class='logo'><img class='' src='".$this->profile->logo."' width=''  height='' /></div>";
          }
          $_html .= "<div class='name'>";
          if( isset($this->url) && strlen($this->url) > 0  ){
            	$_html .= "<a href='".$this->url."?token=".$this->token."&lid=".$this->profile->user_id."'>".$this->profile->name."</a>";//
            }else{
            	$_html .= $this->profile->name;
            }
            $_html .= "</div>";
            
            $_html .= "<div class='address'>".$this->profile->location."</div>";
            $_html .= "<div class='telephone'>".$this->profile->telephone."</div>";
            $_html .= "<div class='website'>".$this->profile->website."</div>";
            $_html .= "<div class='company'>".$this->profile->company."</div>";
           return $_html;
        }


        
		


}
?>