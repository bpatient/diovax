<?php


/**
 * 
 * This Helper will be displaying the image based on this app configs 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * this is the size the user wants to show 
 *
 */

class Core_View_Helper_Image extends Zend_View_Helper_Abstract{

	

	
	/**
	 * @param string $img_url 
	 * @param sting $width [ large | small | thumbnail | large ]  
	 * @uses HTTP_UPLOADS_IMAGE_PATH variable 
	 * @throws Exception
	 */
	public function image($img_url, $width = 'medium' ){
		
		
		if ( !is_string  ($img_url ) ) throw new Exception (" String Url required in Core_View_Helper_Image::image( ) ");		
		switch ( $width ):
			case 'large': $dir = 'l'; break;
			case 'thumbnail':
			case 'small': $dir = 't'; break;
			case 'medium': $dir = 'm'; break;
			case 'banner': $dir = 'b'; break;
			default:
				 $dir = 'm'; break;
			endswitch;
		$div = '<div class=\'image-box\'><img src=\'/assets/img/'.$dir.'/'.$img_url.'\' /></div>';
		return $div; 
		
	}
	
}


?>