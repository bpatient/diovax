<?php


/**
 * 
 * This Helper will be displaying the image based on this app configs 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @param string $img_url 
 * @param sting $width [ large | small | thumbnail | large ]  
 * this is the size the user wants to show 
 *
 */

class Core_View_Helper_Media extends Zend_View_Helper_Abstract{

	
	const EMBED_CODE_NOT_FOUND_EXCEPTION = 1000; 
  
  //giving full path to the image //HTTP_UPLOADS_IMAGE_PATH
  private $medium, $upload_path; 
  
  
	
	public function media($medium, $options = array ( 'player' => 'youtube', 'class' => 'video-link',  'id' => '' , 'rel' => 'product-video')){
		
    $this->upload_path = '/assets';
    
    
    
    
		$param = ''; 
		$param .= isset($options['class'] ) && !empty($options['class'])  ? ' class =\''.$options['class'].'\' ' : ''; 
		$param .= isset($options['id'] ) && !empty($options['id'])  ? ' id =\''.$options['id'].'\' ' : ''; 
		$param .= isset( $options['rel'] ) && !empty($options['rel']) ? ' rel =\''.$options['rel'].'\' ' : ''; 
    
    /***/
    $width = isset( $options['width'] ) && !empty( $options['width'] ) ?  $options['width'] : 'medium'; 
    
    /**assets*/
		$player = isset( $options['player'] ) && !empty( $options['player'] ) ? $options['player'] : 'image';
		$title = isset( $options['title'] ) && !empty( $options['title'] ) ?  $options['title'] : ' '; 
    //$title = 'Play Video';
		//what to do in case of array or object 
		
		//
		
		
		
		if ( !is_object( $medium ) ){
		      if(!is_array( $medium )  )throw new Exception( "String Url required in  ".__METHOD__."" ); 
		     
		 $medium = (object)$medium;
    }/***/
    
    
     $this->medium = $medium;      
     $url = $this->medium->media_value;
        
    $method = '';
    switch ( $player ):
			case 'vimeo': 
			       $method = '_getVimeoCaption'; 
			       $content = $this->_getVimeoCaption($url); break; //
			case 'mp4':  
			       $method = '_getMp4Caption'; 
			       $content = $this->_getMp4Caption($url); break; //
      case 'youtube':  
            $method = '_getYouTubeCaption'; 
            $content = $this->_getYouTubeCaption($url); break; //
      case 'image':  
            $method = '_showImage'; 
            $content = $this->_showImage( $url, $width ); break;//
      default:
				$content = ''; //getting player specs and replace them 
			break;
			endswitch;
      //
			if( $this->_isHttpLink( $content ) )
				  $content = " <a href='".$content."' ".$param."  >".$title."</a>";		
    return '<div class=\'medium-view-helper\'>'.$content.$this->_details().$this->_edit().'</div>'; 
	}
	
	
	/***/
	private function _getMp4Caption($link){
		if (!$this->_isHttpLink($link) ) 
			return '<div class=\'video-div mpv4-video\'>'.$link.'</div>';
		return $link;
    /**use embedded code here.*/
	}
	
  
    
  /***/
  private function _getVimeoCaption($link){
    if (!$this->_isHttpLink($link) ) 
      return '<div class=\'video-div vimeo-video\'>'.$link.'</div>';//use embedded code here.
    return $link;
  }
  
  
    
  /***/
  private function _getYouTubeCaption($link){
    if (!$this->_isHttpLink($link) ) 
      return '<div class=\'video-div youtube-video\'>'.$link.'</div>';//use embedded code here.
    return $link;
  }
  
	
	
	/***
   * This function cheks if the passed in is a link or content 
	 * @param string $link 
   * check https too 
	 */
	private function _isHttpLink($link){
		if (  preg_match('/^http/',$link) ) return true;
		return false;
	} 
  
  
  
  /**this function will be used to style and show image div*/
  private function _showImage( $medium, $width = ''){
      switch ( $width ):
        case 'large': $dir = 'l'; break;
        case 'thumbnail':
        case 'small': $dir = 't'; break;
        case 'medium': $dir = 'm'; break;
        case 'banner': $dir = 'b'; break;
        default:
           $dir = 'm'; break;
      endswitch;
    $div = '<div class=\'image-box\'><img src=\''.$this->upload_path.'/img/'.$dir.'/'.$medium.'\' /></div>';
    return $div; 
  }
  
  
  /***/
  //  id  title caption description media_order media_key media_value displayed
  private function _details( ){
    if( !$this->medium ) return '';
    $_details = '<div class=\'title\'>'.$this->medium->title.'</div>'.
            '<div class=\'caption\'>'.$this->medium->caption.'</div>'.
            '<div class=\'description\'>'.$this->medium->description.'</div>';
    return $_details;
  }
  
  /**
   * use this function to embed editing buttons displayed should a checkable checkbox
   */
  private function _edit(){
      $_edit = '<div class=\'edit-div\'><a href=\'/jxdelmed/'.$this->medium->id.'\'  rel=\'/jxdelmed/'.$this->medium->id.'\' class=\'jxmedia-delete\'>Delete</a>';
      $_edit .= '<a href=\'/jxedit/'.$this->medium->id.'\' rel=\'/jxedit/'.$this->medium->id.'\'  class=\'jxmedia-edit\'>Edit</a></div>';
    return $_edit;
  }
}
?>