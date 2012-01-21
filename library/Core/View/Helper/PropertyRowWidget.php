<?php
/**
 * 
 * 
 * this view helper will be used to display a property.
 * it will show edit controls if we are in backend, and 
 * we should retrieve edit widget content from passed options
 * 
 */

class Core_View_Helper_PropertyRowWidget extends Core_View_Helper_Base{

	
	
	
	/**
	 * This variable will be used accross the class
	 */
	private $property; 	
	
	/**
	 * 
	 *
	 * @param object $mixed
	 * edit param will be sent as link to edit /delete/ or view
	 * @param object $options [optional]
	 * @return 
	 */	 
	public function propertyRowWidget( $mixed , 
		$options = array(
			'image' =>  null,
			'rating' =>  null,
			'edit' =>  null,
			'share_bookmarklets' =>  ''	
		 ) )
	
	{
		
		$_rating = '';
		$_image = '';
		
		if( isset($options['image']) && $options['image'] != null ) $_image = $options['image'];
		if( isset($options['rating']) && $options['rating'] != null ) $_rating = $options['rating'];
		
		
		
		/**editing*/
		$_edit = '';
		if(isset($options['edit']) && ( !is_array($options['edit']) || is_object($options['edit']) ) ) {
			$_edit = 'edit supports array';
		}else{
			$o_arr = $options['edit'];
			foreach( $o_arr as $key => $value ){
				$_edit .= $this->_edit( "title", "link" ) ;
			}
		}
		
		/**initialization*/
		if( $mixed instanceof Core_Model_Property ) $this->property = $mixed; 
		elseif( is_array($mixed) ) $this->property = new Core_Model_Property( $mixed );
		else $this->property = new Core_Model_Property();
		
		$_util_string = Core_Util_String(); 
		
		$_share_bookmarklets = '<div class=\'share-bookmarklet\'>'.$_share_bookmarklets.'</div>'; 
		$_title = '<div class=\'title\'>'.$_title.'</div>';
		$_description = '<div class=\'description\'>'.$_util_string->cutText( $this->property->description ).'</div>';
		$_rating = '<div class=\'rating\'>'.$_rating.'</div>'; 
		$_edit = '<div class=\'edit-widget\'>'.$_edit.'</div>';
		$_img = '<div class=\'image\'>'.$_img.'</div>';
		
		/*order matters*/ 
		$_content = $_img.
					$_title.
					$_description.
					$_rating.
					$_share_bookmarklets;
		
		
		
		
		
		$_property = '<div class=\'view-helper-property-widget\'>'.$_content.'</div>';
		return  $_property;
	}
	
	//returns the string to edit an instance of a property
	private function _edit($tilte, $link){
		return '<a href=\''.$link.'\'><div class=\'edit\'>'.$title.'</div></a>';
	}
	
	
}
?>