<?php

/**
 * 
 * This Controller class will be used to upload media, and manage those.
 * By media, we mean images, video[flv files, mp4,...], and documents. 
 * Any ressource that needs to upload will be requesting its service and 
 * send where to redirect on completion. 
 * 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.2 
 * @uses Core_Controller_Base
 * 
 * 
 * 
 * @todo group banners and change banner management model  
 * @todo add controll to list flash | image | html files from the index
 * 
 * 
 * 
 * @todo add controll to list flash | image | html files from the index 
 * 
 *
 */

class Admin_MediaController extends Core_Controller_Base
{

   	
  public function init()
    {
    	parent::init();
       /***
		 * adding a sub menu to all views 
		 */
        $url = $this->_helper->url('');
		$this->view->smenu = '<div class=\'add-link link\'><a href=\''.$url.'banner\'>Add a Banner</a></div>';
        $this->view->smenu .= '<div class=\'add-link link\'><a href=\''.$url.'banners/fl\'>Flash</a></div>';
        $this->view->smenu .= '<div class=\'add-link link\'><a href=\''.$url.'banners/im\'>Carousel</a></div>';
        $this->view->smenu .= '<div class=\'add-link link\'><a href=\''.$url.'banners/ht\'>HTML</a></div>';
        $this->view->smenu .= '<div class=\'add-link link\'><a href=\''.$url.'banners\'>Back</a></div>'; //
                $this->options = array();
                $this->options['data'] = array();
    }//init

    
    
    
    
    /**
     * 
     * In this function, we do the following tasks 
     * 
     * 1. disabling the default view 
     * 2. check getting and retrieving from the database product_media details 
     * 3. if the product is already on displayed status, and the media key is a part of enabled banner, we disable the media only
     * 3. other ways, we enable the the media_key  and disable all of other items. 
     * 4. we need to refresh the page. 
     * 
     * getting the id
     * if the requested file is an image 
    	* disable all flash + html files .... if getBannerType() returns type other than image etc  
     * enable/field this field 
     * @return void 
     */
    public function ajaxAction(){
    	parent::ajax(); 
    	$params = $this->getRequest()->getParams();
    	try {
    		/**
    		 * we are sending s_id instead of id as id should match 
    		 * route /module/controller/action/id and return unexpected result
    		 */
    		$product_id = ( isset($params['s_id']) && $params['s_id'] > 0 ) ? $params['s_id']: 0;
    		$product_media = $this->store_service->getProductMedia( array('id' => $product_id ) )->toArray();
    		$product_media = isset($product_media[0])?$product_media[0]:$product_media;
    		
    		
    		$enabled_banner_type = $this->store_service->getEnabledBannerType(); 
			$this->log( 'MediaController ::   enabled banner type '.$enabled_banner_type );      		
			
			if ( $product_media['displayed'] < 1 && $product_media['media_key'] != $enabled_banner_type ){
					if ( $product_media['media_key'] == 'banner_image' ) $this->store_service->enableImageBanner();
					if ( $product_media['media_key'] == 'banner_flash' ) $this->store_service->enableFlashBanner();
					if ( $product_media['media_key'] == 'banner_html' ) $this->store_service->enableHtmlBanner();
				echo 'New banner type set to : '.$product_media['media_key'];
			}elseif ( $product_media['media_key'] == $enabled_banner_type ){
				if ( isset($params['st']) && !empty( $params['st']  ) ){
					$displayed = $params['st'] >= 1 ? 1 : 0;
					$this->store_service->displayProductMedia( array ( 'id' => $product_id ,'displayed' => $displayed ));
					echo ( $displayed ) ? " Banner item enabled " : " Banner item disabled ";
				}  
			}			
	    }catch( Exception $e ){
	    	echo " Error :: ".$e->getMessage();
    	}
    
    }
    
    
    
    /**
     * this function will be used to change the value of order in which a benner is shown
     * i ajax = input ajax   
     */
    public function iajaxAction(){
    	parent::ajax(); 
    	$params = $this->getRequest()->getParams();
    	try {
    		$product_id = ( isset($params['s_id']) && $params['s_id'] > 0 ) ? $params['s_id']: 0;
    		$order = ( isset($params['vl']) && $params['vl'] > 0 ) ? $params['vl']: 0;
    		
    		$product_media = $this->store_service->getProductMedia( array('id' => $product_id ) )->toArray();
    		$product_media = isset($product_media[0])?$product_media[0]:$product_media;
    		$msg =  "<div class='notice'>No media found</div>";
    		if ( $product_media['id'] ){
    			$product_media['media_order'] = 0;
    			if ( $order > 0 ) $product_media['media_order'] = $order;
    			$this->store_service->editProductMedia($product_media);
    			$msg =  "<div class='success'>Order changed</div>";
    		}
    		echo $msg;
        }catch( Exception $e ){
	    	echo " Error :: ".$e->getMessage();
    	}
    }
    
    
    
    /**
     * this function will display all banners and type 
     * adding pictures to a benner => showing more pictures in the carrousel 
     * if we have only one picture => no carrousel needed 
     * 
     * if we have flash, show flash and deactivate the carrousel 
     */
	public function bannersAction(){		 	
    	
		
		
		/**
		 * Getting specified king of banners to display 
		 * else display image banner 
		 * 
		 */
		$options = array(); 
		$ext = '';
		if ( ($params = $this->_request->getParams()) ){
			if ( $params['id'] == 'fl' ){
				//display only flash files 
				$ext = 'flash';
			}elseif ( $params['id'] == 'ht' ){
				//display only html files 
				$ext = 'html';
			}elseif ( $params['id'] == 'im' ){
				//display only image files 
				$ext = 'image';
			}
		}
		if ( $ext != $options['type'] ) { $options['type'] = $ext; $options['media_key'] = $options['type']; unset($options['type']);  }
		$data = $this->store_service->getBanners($options);    	
    	$this->view->items = $data;
    	$this->view->content = $banners;
    	
	}
	
	
	   
	/**
	 * 
	 * All media files for banner willb be stored in /public/uploads/img/b/ with b standing for 'banner'
	 * @todo there should be a separation of those files and not be stored under public/uploads/img
	 * 
	 * Uploads a new media file for banners
	 * @todo get validator of this form and add more file extensions as we are going to upload flash files  
	 * @todo add more extentions to upload flash files 
	 */
	public function uploadAction(){		 	
    	
    	$this->view->sub_title = "upload flash | images | html files ";
    	/*sending the current id to the view */
		$this->view->id = $this->_getParam('id');
		/**redirect to banners by default*/	
		if ( !( ($id = $this->_getParam('id')) && $id > 0 ) )
			$this->_redirect( 'admin/banners' );
			
		$this->product_media = new Core_Model_ProductMedia(); 
    	$options = array('id' => $id );
    	/**
    	 * In the following section, we need to upload both Flash Files and html files in addition to 
    	 * supported image files, therefore we need to add supported extensions
    	 */
    	$this->view->form = new Core_Form_FileUpload( $options );
    	$post = $this->getRequest()->getPost();
		$isPost = $this->getRequest()->isPost();
           if (  $isPost ){
	       	if ( !$this->view->form->isvalid($post) )
	           	{
	           		$this->view->message = $this->view->form->getMessages();
	           		return false;
	           	}
	           	/***
	           	 * continue trying to upload the form 
	           	 */
	           	try { 
	           			$file_name  = $this->view->form->banner();
	           			if ( ! ($file_name === false) ){
	           				/**
	           				 * getting the product media to edit 
	           				 */
	           				$tmp = $this->store_service->getProductMedia(array( 'id' => $id ) );
							if ( $tmp[0] ) $this->product_media = $tmp[0];		
	           				$this->product_media->media_value = $file_name;
		           			$this->store_service->editProductMedia($this->product_media->toArray());	
		           		}
	           		}catch(Exception $e){
	           			$this->view->message = $e->getMessage();
	           		}
	       }
		
	}
	
	
	
	
	
	
	/**
	 * editing one banner
	 * will upload a picture + details
	 * @todo after the user edits product media, show the link to upload a file. 
	 * and after uploading a file, return to banners 
	 *   
	 *  media_key for banners = banner_[type] { banner_image | banner_flash | banner_file } 
	 */
	public function bannerAction(){
		
		
		
		
		/***
		 *@var $mid this variable is the id of the media 
		 */		
		$mid = 0;  
		$options = array ( 'isFile' => false, 'product_id' => -1 ,'media_value' => '');		
		
		/***/
		$this->view->form = new Core_Form_Media($options);
		$this->banner = new Core_Model_ProductMedia();
		$this->view->upload_link = '';	
		$this->view->image = '';	
		
		
		
		
		
		/**
		 * Handle posts 
		 */
		
		//ini_set('display_errors', 'on');
		$post = $this->getRequest()->getPost();
		$isPost = $this->getRequest()->isPost();
		if (  $isPost ){
			if ( !$this->view->form->isValid($post) ){
				$this->view->message = $this->view->form->getMessages();
				return false;
			}
			/**process form*/
			$media_key = $this->view->form->getElement('media_key')->getValue();
				$this->view->form->getElement('media_key')->setValue( 'banner_' . $media_key );
			$this->banner = $this->view->form->getObject();
			/**
			 * preventing the the media value to be lost. 
			 * @var 
			 */
			$this->_banner = $this->store_service->getProductMedia( array( 'id' => $this->banner->id) )->toArray();
			$this->_banner = $this->_banner[0] ? $this->_banner[0] : $this->_banner; 
			$this->banner->media_value = $this->_banner['media_value'];
				
			$mid = $this->store_service->editProductMedia($this->banner );
				if ( $mid > 0 )
				{  
					$this->view->form->getElement('id')->setValue( $mid );
				}
			
			
		}
		
		/**$params['id']
		 * Initialization of Core_Model_ProductMedia and the form if there is a positif id 
		 */
		//{
			if ( $mid > 0 || ($mid = $this->_request->getParam('id')) > 0 ){
				$tmp = $this->store_service->getProductMedia(array( 'id' => $mid ) );
				if ( $tmp[0] ) $this->banner = $tmp[0];
				$this->view->form->setMediaValue($this->banner->media_value );
				$this->view->form->populate( $this->banner->toArray() );
				/*setting the selected value **/				
				$tmp_media_key = split('_', $this->banner->media_key);
				$media_key =  ($tmp_media_key[1]) ? $tmp_media_key[1] : 'image' ; 
				$this->view->form->getElement('media_key')->setValue( $media_key );
				$url = $this->_helper->url('upload/').$mid;
				$this->view->upload_link = '<a href=\''.$url.'\' >Upload Media</a>';
				
        /**
         * The following should prompt the user to upload a media file if the current ProductMedia has none.
         * We should be able to show the message if there is no error message to make it visible and to avoid the confusion.
         */
        if ( !$this->view->message &&  ( $this->banner->media_value == '' || $this->banner->media_value == null ) ){
            $this->view->notification = $this->view->message_helper->message(" Upload Media Files", array('class' => 'success'));
        }else{
            $this->view->image = $this->view->image_helper->image( $this->banner->media_value );	//image_helper
        }
			
			}
		//}
	}
    
	
	
	/**
	 * this function deletes the banner and not the whole section 
	 * @return void 
	 * delete files on the hard disk too. 
	 * these are images but ot should work the same way for flash content too. sice we are deleting files  
	 * regardless the extension
	 *  
	 */
	public function deleteAction(){
		
			$params = $this->getRequest()->getParams();
    		$product_media_id = ( isset($params['id']) && $params['id'] > 0 )? $params['id'] : 0 ; 		
    		
    		$product_media = $this->store_service->getProductMedia( array('id' => $product_media_id ) )->toArray();
    		$product_media = isset($product_media[0])?$product_media[0]:0;
    		$isPost = $this->getRequest()->isPost();
    		
			if( $product_media && $isPost ){
				if ( $params['andFiles'] == 'on' ){
					try { 
					$this->_delete_image_files($product_media['media_value']); 
					}catch ( Exception $e ) { $this->view->message = ' Error '.$e->getMessage();}
				}
				
				$this->store_service->deleteProductMedia( $product_media_id );
				$this->_redirect ( $this->mdl.'/'.$this->ctlr.'/banners');
			}
    		
			/***/
    		if ($product_media ) {
    			$this->view->content = '<div class=\'notice\' >Please confirm if you want to delete <strong>'.$product_media['caption'].'</strong></div>';
			}else{
				$this->view->message = '<div class=\'error\'>There is no media files to delete</div>';
			}
			$this->view->link_to_media = '<a href=\''.$this->_helper->url( 'banners').'\' >Back</a>';
	
	}
    
	
	
	
    /***
     * Default landing page.
     * @todo replace the content of this with the content of banners 
     */
    public function indexAction()
    {
   	$this->view->content = "Media";
    }
	
	
    
    
    
    
    public function videosAction()
    {
        // action body
		$this->view->content = "videosAction";
    }
	
	public function albumsAction()
    {
        // action body
		$this->view->content = "albumsAction";
    }
	
	public function photosAction()
    {
        // action body
		$this->view->content = "photosAction";
    }




      public function postDispatch(){
        parent::postDispatch();
       $this->view->paging = new Core_Util_Paging($this->options);
        $this->paging->baseUrl = $this->baseUrl;
        $this->view->data = $this->view->items = $this->view->paging->getCurrentItems();
        $this->view->paged_links = $this->view->paging->getPagedLinks();
        $this->view->show_paged_links = ( is_array( $this->view->paged_links ) && count($this->data) > $this->per_page );
    }
	
	

}