<?php
/**	<script type="text/javascript" src="/static/js/jquery.tinycarousel.js"></script>

 */

class Core_View_Helper_PropertyWidget extends Core_View_Helper_Base{

	
	
	
	/**
	 * This variable will be used accross the class
	 */
	private $property; 	
	
	/***/	 
	public function propertyWidget( $mixed , $options = array(
		'image' =>  null,
		'social' =>  null,
		'site' =>  null,
		'rating' =>  null	
	 ) ){
		
		
		$_social = '';
		$_site = '';
		$_image = '';
		$_rating = '';
		
		$this->property = $mixed;
		/**initialization*/
		if( !($this->property instanceof Core_Entity_Property) ) {  
			if( is_array($this->property) )
			$this->property = Core_Util_Factory::build($this->property, Core_Util_Factory::ENTITY_PROPERTY ); 
		}

		
		if( !($this->property instanceof Core_Entity_Property) ) { 
			throw new Exception(" ".__METHOD__." :: Parameter not supported " );
		}
	
		$_content = '';
		$_util_string = new Core_Util_String(); 
		if( isset($options['social']) && $options['social'] != null ) $_social = $options['social'];
		if( isset($options['image']) && $options['image'] != null ) $_image = $options['image'];
		if( isset($options['site']) && $options['site'] != null ) $_site = $options['site'];
		if( isset($options['rating']) && $options['rating'] != null ) $_rating = $options['rating'];
		
		$_social = '<div class=\'social-bookmarklet\'>'.$_social.'</div>'; 
		$_title = '<div class=\'title\'>'.$this->property->name.'</div>';
		$_description = '<div class=\'description\'>'.$_util_string->cutText( $this->property->description ).'</div>';
		$_site = '<div class=\'site\'>'.$_site.'</div>'; 
		$_rating = '<div class=\'rating\'>'.$_rating.'</div>'; 
		$_image = '<div class=\'image\'>'.$_image.'</div>';
		$_property = '<div class=\'property-widget\'>'.$_image.$_title.$_description.$_rating.$_social.'</div>';

		return  $_property;
	}
	
}
?>