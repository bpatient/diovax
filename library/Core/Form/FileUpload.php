<?php



/**
 * 
 * 
 * 
 * 
 * This class, needs either Imagick, or GD library to be installed 
 * In addition to those libraries, ThumbLib.inc.php needs to be in library/Third 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @uses ThumbLib::PhpThumbFactory::create, save 
 * @tutorial  ThumbLib.inc.php	
 * 
 * 
 * @todo enhance uploading flash|html|video files
 * @todo If ThumbLib::PhpThumbFactory fails to  load, it throws fatal error message, which may bring down the application.
 * 		To handle this, check if this library is loaded, or redirect to error   
 */

class Core_Form_FileUpload extends Core_Form_Base{
	
	
	
	
	/*paths*/
	private $large;//for large files
	private $medium;//for medium 
	private $small;//for thumbnail
	private $banner;//for thumbnail
	
	/*file size. 
	 * Pay attention to naming convention here. 
	 * In some other classes, the naming convention stipulates that '_' will be used for private function/properties only, 
	 * in this case we have $large[private] and $_large[private] because we are running out of names to use in case of size
	 * the proper way to do it was size->medium->height and width but we removed size for matter of simplicity*/
	private $_small_file, $_medium_file, $_large_file; 
	
	
	/**/
	const NO_UPLOAD_DIR_EXCEPTION = 1000; 
	/**
	 * 
	 * 
	 * t
	 * 
	 */
	public function __construct ( $options = array() ){
		
		
		
		
			
			
		parent::__construct();

		/*checking if there is a directory */ //!defined(UPLOADS_IMG_PATH) || 
		if ( !is_dir (UPLOADS_IMG_PATH) ) throw new Exception ( self::NO_UPLOAD_DIR_EXCEPTION );
				
		if ( !isset($options [ 'l']) )	$this->large = UPLOADS_IMG_PATH."/l";//for large files
		if ( !isset($options [ 'm']) )	$this->medium = UPLOADS_IMG_PATH."/m/";//for medium 
		if ( !isset($options [ 't']) )	$this->small = UPLOADS_IMG_PATH."/t/";//for thumbnail
		if ( !isset($options [ 'b']) )	$this->banner = UPLOADS_IMG_PATH."/b/";//contains all files to be included in the banner
		
		
		/*initalization of form variables */
	   	$this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('method', 'post');//setting the methods
     	
		$this->file = new Zend_Form_Element_File('file');//
		/**it should be allowed to upload up to 10mb large*/
		$this->file->addValidator('Count', false, 2)->addValidator('Size', false, 10485760);//->addValidator('Size', false, 10485760) 10mb crash server!!!
		$this->file->addValidator('Extension', false, 'jpg,jpeg,png,gif,html,phtml,flv,swf');
        $this->file->setRequired(true);//
		
        
        $this->button = new Zend_Form_Element_Submit('button');
		$this->button->setLabel(" Upload ")->setAttrib('class', 'button greyishBtn submitForm'); 
		 
		 
			$this->addElements(
				array(
					$this->file,			
					$this->button
				)
			);
			
			
		//initialization of file size configurations 
		//300, 300 //50, 50
        try{
			$this->_small_file = new stdClass();
			$this->_medium_file = new stdClass();
			//$config = Zend_Registry::get('config');
			/***/
        	if( !($config = Zend_Registry::get('config')) ){
        		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        		
        	}
        	/**will allow initialization to default values*/
        	if( !( $config ) ) throw new Exception("Config file not found");
        	/***/
        	$_image = $config->system->app->media->image;  
        	$this->_small_file->width = $_image->small->width;
        	$this->_small_file->height = $_image->small->height;
        	$this->_medium_file->width = $_image->medium->width;
        	$this->_medium_file->height = $_image->medium->height;
        	
        }catch( Exception $e ){
        	
        	$this->_small_file->width = 50; 
        	$this->_small_file->height = 50; 
        	$this->_medium_file->width = 300; 
        	$this->_medium_file->height = 300;        	
        }
		
	}
	
	
	
	/**
	 * this function uploads the file, and if save flag is set, it saves returned name in the database 
	 * to make the app flexible,
	 */
	public function process(){		
	$this->file->setDestination($this->large);
    if ( $this->file->receive()  ):
        $file_path = $this->file->getFileName();
        $file_name = $this->file->getValue();
         try {         	
            $thumb = PhpThumbFactory::create($file_path);   
            $thumb->resize($this->_medium_file->width, $this->_medium_file->height)->save($this->medium.$file_name);             
            $thumb->resize($this->_small_file->width, $this->_small_file->height)->save($this->small.$file_name);
            return $file_name;
        }catch(Exception $e){
            throw new Exception ( ' FileUpload Trace error :: '.print_r( $e, 1 )." </br>" . print_r( $_image, 1 ) );
        }
    endif;    
	return false; 
  }
  
  
  
  
  
  /**
   * This function will be used to upload banner files. 
   * No resize is done here, we just upload the file as it is!
   */
  public function banner(){  	
  	/**the transfer adapter used with zend form file class*/
  	$this->file->setDestination($this->banner);
    if ( $this->file->getTransferAdapter()->receive() ){
  		return $this->file->getValue();
  	}
  	return false;
  }
	
	
	
	/**
	 * 
	 */
	public function getObject(){
			return new stdClass();
	}
	
	
	
	
}


?>