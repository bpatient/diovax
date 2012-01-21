<?php
/**
 * Provides small extended display mode.
 * the default should be the small one
 */
class Core_View_Helper_Property extends Core_View_Helper_Base{




	/**
	 * This variable will be used accross the class
	 */
	private $property, $oStr, $description, $carousel, $header, $contact, $base_url, $url;

	/**
	 * @param object $mixed
	 * edit param will be sent as link to edit /delete/ or view
	 * @param object $options [optional]
	 * @return
	 */
	public function property( $mixed , $options = array('image' =>  null, 'site' =>  null, 'rating' =>  null, 'css_class' =>  null, 'editing' =>  null,	'social' =>  '',	'base_url' =>  ''	 ) )
	{





		$this->oStr = new Core_Util_String();

		$this->_image = "<img src='/assets/images/img.png' alt = 'Image not available'/>";
		$_rating = ''; $_social = '';  $_title = '';   $_site = ''; $_editing = ''; $_words = 40;/**max of 40 words*/


		if( $mixed instanceof Core_Entity_Property ) $this->property = $mixed;
		elseif( is_array($mixed) ) $this->property =  Core_Util_Factory::build( $mixed, Core_Util_Factory::MODEL_PROPERTY);//new Core_Model_Property( $mixed )
		elseif( is_object($mixed) ) $this->property =  Core_Util_Factory::build(((array)$mixed), Core_Util_Factory::MODEL_PROPERTY);//new Core_Model_Property( ((array)$mixed) )
		else $this->property = Core_Util_Factory::build( array(), Core_Util_Factory::MODEL_PROPERTY);//new Core_Model_Property()



		$_booking = '/app/a/rental/'.$this->property->id.'';
		$_class = ( isset($options['class']) && $options['class'] != null  ) ? ' '.$options['class'] : '';
		$this->carousel = ( isset($options['carousel']) && $options['carousel'] != null && is_string($options['carousel']) ) ? ' '.$options['carousel'] : false;

		if( isset( $options['image'] ) && $options['image'] != null  ) $this->_image = "<img src='".$options['image']."' alt = 'Image not available'/>";
		if( isset( $options['rating'] ) && $options['rating'] != null ) $_rating = $options['rating'];
		if( isset( $options['booking']) && $options['booking'] != null ) $_booking = $options['booking'];/**should be a url to start booking process*/
		/**checking if booking is a link*/
		if( is_string($_booking) ) $_booking = '<a href=\''.$_booking.'\'>Booking</a>';
		if( isset( $options['name'] ) && $options['name'] != null ) $_title = $options['name']; else  $_title = $this->property->name;
		if( isset( $options['site'] ) && $options['site'] != null ) $_site = $options['site'];
		if( isset( $options['words'] ) && $options['words'] != null ) $_words = $options['words'];
		if( isset( $options['base_url'] ) && $options['base_url'] != null ) $this->base_url = $options['base_url'];


		/**checking if there is a header sent*/
		if( isset( $options['header'] ) && $options['header'] != null ) $this->header = $options['header'];
		if( isset( $options['contact'] ) && $options['contact'] != null ) $this->contact = $options['contact'];

		/**editing*/
		$_site = is_array( $_site ) ? ((object) $_site) : $_site ;


		$this->description = $this->property->description;
		if( isset($options['strip']) && $options['strip'] == true ) {
			$this->description = $this->oStr->cutText( $this->description ,  array( 'words' => $_words ) );
		}
			
		if( isset($options['editing']) &&  is_string($options['editing']) ){
			$_editing = $options['editing'];
		}else{ $_editing = 'edit supports array';
		}
		$this->editing = $_editing;

		//the url to be used
		if( $this->base_url ){
			$_base = $this->base_url;
		}else{
			$_base = '/app/a/rental/';
		}
		/**checking if this property has a link or an id*/
		if( $this->property->url ){
			$this->url = $_base.$this->property->url;
		}
		else{ $this->url = $_base.$this->property->id;
		}




		$_html = "";

		if( isset($this->options["display"]) && $this->options["display"] == Core_Util_Settings::FULL_SIZE_DISPLAY ){
			$_html =  $this->_main();
		}elseif( isset($this->options["display"]) && $this->options["display"] == Core_Util_Settings::MIDDLE_SIZE_DISPLAY ) {
			$_html =  $this->_sub();
		}else{
			if($this->carousel) {
				$_html .= $this->carousel;
			}else {
				$_html .= $this->_img( $this->_image );
			}
			
			$_html .= "<div class='right'>".$this->_ttl( );
			$_html .= $this->_prc( );
			$_html .= $this->_dsc( );
			$_html .= "</div>";
			if( isset( $options['long'] ) && !empty($options['long']) ) $_class .= ' long';
			if( isset( $this->contact) &&  isset($options['contact']) ) $_html .= $this->_ct();/***/
			if( isset( $options['editing'] ) && strlen($this->editing) >= 1 ){
				$_html .= $this->_edt($_editing);
			}
			
			
			
		}



		$_html  = $this->_h()." ".$_html;

		//return '<div class=\'property-view-helper' .$_class. '\'>'.$_html.'</div>';
		
		
		return $this->_n();
	}


	/**returns the string to edit an instance of a property*/
	private function _h(){
		return $this->header ? '<div class=\'header-widget\'>'.$this->header.'</div>' : "";
	}
	private function _ct(){
		return $this->contact ? '<div class=\'contact\'>'.$this->contact.'</div>' : "";
	}
	private function _edt(){
		return '<div class=\'edit-widget\'>'.$this->editing.'</div>';
	}
	private function _ttl( ){
		$_title = '<div class=\'title\'><a href=\''.$this->url.'\' rel=\''.$this->url.'\'>'.$this->property->name.'</a></div>';
		return $_title;/**the title*/
	}
	private function _scl( $_social ){
		return '<div class=\'social\'>'.$_social.'</div>';
	}
	private function _img( $im ){
		return '<div class=\'image\'><a href=\''.$this->url.'\'>'.$im.'</a></div>';
	}
	private function _prc( ){
		return  '<div class=\'price\'>'.$this->property->rent.'</div>';
	}
	private function _dsc( ){
		return '<div class=\'description\'>'.$this->description.'</div>';
	}
	private  function _rt( $rt ){
		return '<div class=\'rating\'><a class=\'rating\' href=\'/app/index/jxrating/'.$this->property->id.'?obj=property\'>'.$rt.'</a></div>';
	}
	private  function _bkg( $bkg ){
		return '<div class=\'booking\'>'.$bkg.'</div>'; }
    
		
		//n : new 
	private function _n(){
		$_html  = "<div class='supTicket nobg'>
						<div class='issueType'>
						<span class='issueInfo'><a href='".$this->url."' rel='".$this->url."'>".$this->property->name."</a></span>
						 	<span class='issueNum'>[ $ ".$this->property->rent." ]</span>
						<div class='fix'></div>
						</div>
					<div class='issueSummary'>
						<a href='".$this->url."' title='' class='floatleft'>".$this->_image."</a>
					<div class='propertyInfo'>
						<ul>
							<li><a href='#' title=''>".$this->property->unit."</a></li>
							<li >Status: <strong class='green'>[ not/available ]</strong></li>
							<li class='even'>".( isset($this->property->built) ? " Built ". date("M d, Y",  strtotime( $this->property->built ) ): " " )."</li>
						</ul>
						<p >".$this->description."</p>
						<div class='fix'></div>
					</div>
					<div class='fix'></div>
					</div> 
					</div>";
		
		return $_html;
		
	}

}
?>