<?php
/**
 *This view helper will be displaying the content of a ProductDetails instance
 */
class Core_View_Helper_Feature extends Core_View_Helper_Base{

	
	
	
	/**
	 * This variable will be used accross the class
	 */
	private $property, $oStr, $description;
	
	/**
	 * @param object $mixed
	 * edit param will be sent as link to edit /delete/ or view
	 * @param object $options [optional]
	 * @return 
	 */
public function feature( $mixed , $options = array('image' =>  null, 'site' =>  null, 'rating' =>  null, 'css_class' =>  null, 'editing' =>  null,	'social' =>  ''	 ) )
{


   
    $this->oStr = new Core_Util_String();
    $_title = '';   $_editing = '';


    if( $mixed instanceof Core_Model_PropertyDetails ) $this->property_details = $mixed;
    elseif( is_array($mixed) ) $this->property_details = new Core_Model_PropertyDetails( $mixed );
    elseif( is_object($mixed) ) $this->property_details = new Core_Model_PropertyDetails( ((array)$mixed) );
    else $this->property_details = new Core_Model_PropertyDetails();
    $_class = ( isset($options['class']) && $options['class'] != null  ) ? ' '.$options['class'] : '';
    /**editing*/
    $this->description = "";
    if( isset($options['strip']) && $options['strip'] == true ) {
        $this->description = $this->oStr->cutText( $this->property_details->details_value ,  array( 'words' => 40) );
      }

    if( isset($options['editing']) &&  is_string($options['editing']) ){ $_editing = $options['editing'];  }else{ $_editing = 'edit supports array'; }
    $this->editing = $_editing;

        $_html = "";
        $_html .= $this->_ttl( );
        $_html .= $this->_dsc( );
        if( isset( $options['long'] ) && !empty($options['long']) ) $_class .= ' long';
        if( isset( $options['editing'] ) && strlen($this->editing) >= 1 ){ $_html .= $this->_edt($_editing); }
	return '<div class=\'feature-view-helper' .$_class. '\'>'.$_html.'</div>';
    }

       
    /**returns the string to edit an instance of a property*/
    private function _ttl( ){ return '<div class=\'title\'>'.$this->property_details->detail_key.'</div>'; }
    private function _dsc( ){ return '<div class=\'description\'>'.( ( $this->description ) ? $this->description : $this->property_details->detail_value ).'</div>'; }
    private function _edt(){ return '<div class=\'edit-widget\'>'.$this->editing.'</div>'; }

}
?>