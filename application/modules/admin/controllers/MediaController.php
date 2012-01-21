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
		$this->view->id = $this->_getParam('id');
		if ( !( ($id = $this->_getParam('id')) && $id > 0 ) )
		$this->_redirect( 'admin/banners' );
			
		$this->product_media = new Core_Model_ProductMedia();
		$options = array('id' => $id );

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
				}catch ( Exception $e ) {
					$this->view->message = ' Error '.$e->getMessage();
				}
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
		parent::index();
		
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