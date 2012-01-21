<?php
/**
 * 
 * This helper will show images as a list of items. 
 * JavaScript snipped will [ be appended ] | displaying image after 
 * on Image click, will popup the image and display the gallery using lighbox 
 * 
 * this carrousel will be used with Lightbox Plugin for JQuery 
 * 
 * This carrousel, serves for 2 purposes : 
 * 	1. show carrousel with navigation. 
 *  2. enable or disable popup images with lightbox 
 * This carrousel should be possible to show related products, as well as images of the same category  
 * 
 * @author Pascal Maniraho 
 * this is the size the user wants to show 
 *
 */

class Core_View_Helper_Carousel extends Zend_View_Helper_Abstract{
	
	/**
	 * @param array $media the array of images or videos 
	 * @param array $options parameters to apply to rendered html section 
	 * @return string
	 */
	public function carousel($media, $options = array( 'list' => true, 'compound_list' => false,	'class' =>  'carousel', 'id' => 'carousel', 'param'  => '', 'envelope' => 'a', 'alt' => '', 'width' => 'medium', 'url' => false ) ){
	
		if ( !is_array ( $media ) ) return "<div class='empty-carousel'></div>";
		$id = ( isset($options['id'] ) && !empty($options['id']) )? ' id =\''.$options['id'].'\'' : ' id =\'carousel\'';
		$class = ( isset($options['class'] ) && !empty($options['class']) )? ' class = \''.$options['class'].'\' ' :  ' class = \'carousel\' '  ;
		$style = ( isset($options['style'] ) && !empty($options['style']) )? ' style = \''.$options['style'].'\'': '';
		$param = ( isset($options['param'] ) && !empty($options['param']) )? ' rel=\'rel-'.$options['param'].'\' ' : ' rel=\'rel-carousel\' ';
		$enable_list =  ( isset($options['list'] ) && !empty($options['list']) && $options['list'] === false ) ? false : true ;/**/
		$display = ( isset($options ['display'] ) && !empty($options['display']) )? $options ['display'] : 'carousel';
		$url =  ( isset($options['url'] )  && !empty($options['url']) ) ? $options['url'] : '' ;
		$compound_list = ( ($enable_list === false) && ( $options['compound_list'] === true) ) ? true : false;
		
		$envelope = ( isset( $options['envelope']) && !empty($options['envelope']) )? $options['envelope']: 'a';
		$alt = ( isset($options['alt']) && !empty($options['alt']) )?  ' alt=\''.$param.'\' ': ' alt=\'\' ';
		$width = ( isset( $options['width']) && !empty($options['width']) )  ?  $options['width']: 'medium';
		
		
		 /**
		  * can also be li, dt, div, or
		  */ 
		switch ( trim($width) ):
			case 'large': $dir = 'l'; break;
			case 'thumbnail':
			case 'small': 
					$dir = 't'; 
				break;
			case 'medium': 
					$dir = 'm'; 
				break;
			default:
				 $dir = 'm'; break;
		endswitch;

		
		
		$gallery = ''; 
		$li = '';
		foreach ($media as $k => $medium )
		{
                    $href = $url = '';
                    if( isset($medium['href']) && !empty( $medium['href'] ) ) $href = $medium['href'];
                    if( isset($medium['url']) && !empty( $medium['url'] ) ) $url = $medium['url'];
                    if( !$url && isset($medium['media_value']) && !empty( $medium['media_value'] ) ) $url = $medium['media_value'];
                    if( !$url || $medium['media_key'] != 'image' ) continue;
                    //if ( (!isset($medium['url']) ||  empty( $medium['url'] ) ) && ( (!isset( $medium['media_value'] ) ||  empty($medium['media_value'])) ) )continue;
                        $tmp = '';
                        $src = '/assets/img/'.$dir.'/'.$url.'';
                        if ( $envelope == 'a' ) {$href = ' href =\'/assets/img/l/'.$url.'\' '; } /*changing the url if we have a product url sent, we need to figure out how a picture can link to a rental item its better to use either 'linl' | or anything else */
                        if ( !$href ) $href = ' href =\''.$href.'\'';

                       $tmp = '<'.$envelope.' '.$href.' '.$param.' '.$class.' '.$style.' ><img src=\''.$src.'\' '.$alt.' /></'.$envelope.'>';
                        if ( $enable_list ) $gallery .= '<li>'.$tmp.'</li>';
                        else  $gallery .= $tmp;
		}
			
                    $div = '<div class=\''.$display.'\' id=\''.$display.'-div\'>';
                    if ( $enable_list ) $div .= '<ul '.$class.' '.$id.'  '.$style.' >'.$gallery.'</ul>';
                    elseif( $compound_list )  $div .= '<ul '.$class.' '.$id.'  '.$style.' ><li>'.$gallery.'<li></ul>';
                    else  $div .= $gallery;
                    $div .= '</div>';
			
		return $div;
	}
	
	
	
	/**
	 * this function will be used later, or removed compeletly 
	 */
	
	private function _getMediaUrl( $id, $lookup){
		if ( array_key_exists( 'product_id',  $lookup )){
			$mdv = end($lookup);
			return $mdv['media_key'];
		} 
		return false;
	}
	
}


?>