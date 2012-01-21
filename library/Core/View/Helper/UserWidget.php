<?php


/**
 * this class will help to display one house, and should be used  either on the fron end or backend.
 * it will have editing buttons if the user is logged in from anywhere.
 * its receives a house, caches it, and extra parameters in options array section
 */
class Core_View_Helper_HouseWidget extends Core_View_Helper_Base{
	/**
	 * @param object | array |string $mixed
	 * @param object $options [optional]
	 * @return string $house;
	 */
         private $oStr, $_mdl;
	public function houseWidget( $mixed = "", $options = array(

					'edit_widget' => '','image' => '',
					'class' => 'house-widget', 'event' => 'js-events',
					'site' => '','tenant' => '', 'ticket' => '', 'landlord' => '',
					'rating' => ''
				) ){

                             $this->oStr = new Core_Util_String();
                              $this->_mdl = 'admin';
                             $_html = '<div class=\'house-widget\'>';
					$_html .= $this->_p( $mixed , $options['image'] );
					$_html .= $this->_loc( $options['site'] );
					$_html .= $this->_ed( $mixed );
				$_html .= '</div>';
				return $_html;
	}

	/**
	 * @param object $_mxd
	 * @return string $html
	 * Formats data directly from the property object
	 **/
	public function _p( $_mxd , $_img = ''){
		$_html = '';
		/***/
		if ( is_string( $_mxd ) ) return $_mxd;
		if( is_array( $_mxd ) ) $_mxd = (object) $_mxd;
		if( is_object( $_mxd ) ){
			$_html .= '<div class=\'w-param\'>';
				$_html .= '<div class=\'image\'><a href=\'/'.$this->_mdl.'/property/view/'.$_mxd->id.'\'><img src=\''.$_img.'\'/></a></div>';
				$_html .= '<div class=\'name\'><a href=\'/'.$this->_mdl.'/property/view/'.$_mxd->id.'\'>'.$_mxd->name.'</a></div>';
				$_html .= '<div class=\'unit\'>'.$_mxd->unit.'</div>';
				$_html .= '<div class=\'description\'>'.$this->oStr->cutText($_mxd->description).'</div>';
				$_html .= '<div class=\'built\'>'.$_mxd->built.'</div>';
			$_html .= '</div>';
		}
		return $_html;
		//throw new Exception( "BAD PARAMETER EXCEPTION @ " . __METHOD__ . " " . __LINE__ ." " );
	}


	/**
	 * @param object $_mxd [optional]
	 * @return string
	 * location
	 **/
	public function _loc( $_mxd = '' ){
		$_html = '';
		if( is_string( $_mxd ) ) return $_mxd;
		if( is_array($_mxd ) ) $_mxd = (object) $_mxd;
		if( is_object( $_mxd ) ){
			$_html .= '<div class=\'w-loc\'>';
				$_html .= '<div class=\'name\'>'.$_mxd->name.'</div>';
				$_html .= '<div class=\'content\'>'.$_mxd->location.'</div>';
				$_html .= '<div class=\'descr\'>'.$this->oStr->cutText($_mxd->description).'</div>';/***/
			$_html .= '</div>';
		}
		return $_html;
	}

	/***/
	public function _site(){
		$_html = '';
		return $_html;
	}
	/***/
	public function _ed( $_mxd = "" ){
            $_html = '';

            if( is_string( $_mxd ) ) return $_mxd;
            if( is_array( $_mxd ) ) $_mxd = (object) $_mxd;
            $_html = '<div  class=\'w-edit\'>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/edit/'.$_mxd->id.'\'>Edit</a></div>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/delete/'.$_mxd->id.'\'>Delete</a></div>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/locations/'.$_mxd->id.'\'>Locations</a></div>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/landlords/'.$_mxd->id.'\'>Landlords</a></div>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/photos/'.$_mxd->id.'\'>Photos</a></div>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/leases/'.$_mxd->id.'\'>Leases</a></div>'.
                        '<div><a href=\'/'.$this->_mdl.'/property/booking/'.$_mxd->id.'\'>Booking</a></div>'.
                    '</div>';
            return $_html;
        }

		
}
?>
