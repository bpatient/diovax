<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.0
 * @uses
 * 
 * @todo Media service has to extend Core_Service_Abstract instead of Database. that will make all function work with DAO model instead of  legacy persistance model
 * @todo has to implement Core_Service_Abstract 
 */
class Core_Service_Media extends Core_Service_Database {




	public function __construct(){
		parent::__construct();
	}



	/**
	 * @todo switch to Medium DAO
	 **/
	public function editMedium( $data , $owner = '' ){

		$this->medium = $data;
		if ( is_array($this->medium ) ) $this->medium = Core_Util_Factory::build($this->medium , Core_Util_Factory::MODEL_MEDIA);
		if( $owner instanceof Core_Model_Base ){
			$this->medium->token = $owner->token;
		}
		try{
			$id = $this->edit( $this->medium );
			return $id;
		}catch(Exception $e ){
			return $e->getTraceAsString();
		}
	}

	public function editPropertyMedia(Core_Entity_Media $data ){
		return Core_Util_Factory::build($data->toArray() , Core_Util_Factory::DAO_MEDIA)->save();
	}


	/**
	 * returns only one Image
	 * @param Core_Entity_Media $data
	 */
	public function getImage( Core_Entity_Media $data ){
		return Core_Util_Factory::build($data->toArray() , Core_Util_Factory::DAO_MEDIA)->get();
	}




	public function deleteMedium(){
		throw new Exception ( __METHOD__ ." Not implemented. ");
	}


	public function getMedia($options = array() ){
		$this->dao = Core_Util_Factory::build($options , Core_Util_Factory::DAO_MEDIA);
		return $this->dao->getAll();
	}




	public function getPropertyPhotos( $data = ""){
		$this->property = $data;
		if ( is_array($this->property ) ) $this->property = Core_Util_Factory::build($this->property , Core_Util_Factory::MODEL_PROPERTY);
		else $this->property = Core_Util_Factory::build( array() , Core_Util_Factory::MODEL_PROPERTY);
			
		$_options = array();
		if( $this->property->id > 0 && strlen($this->property->token) >= 1 ) $_options['token'] = $this->property->token;
		$_photos = $this->getMedia( $_options, array('media_key' => 'photo') );
		return $_photos;
	}



	public function getPropertyMedia( $data , $options = array() ){
		$this->data = $data;
		$this->options = $options;
		if( !($this->data instanceof Core_Model_Property) )
		throw new Exception("Instance of Core_Model_Property required ");
		if( $this->data->token != "" ) $this->options['token'] = $this->data->token;
		$_media = $this->getMedia( $this->options );
		return $_media;
	}


	public function getSiteMedia( $data , $options ) {
		$this->data = $data;
		$this->options = $options;
		if( !($this->data instanceof Core_Model_Site) )
		throw new Exception("Instance of Core_Model_Site required ");
		$this->options['token'] = $this->data->token;
		$_media = $this->getMedia( $this->options );
	}


	public function getTaskMedia( $data , $options ) {
		$this->data = $data;
		$this->options = $options;
		if( !($this->data instanceof Core_Model_Property) )
		throw new Exception("Instance of Core_Model_Site required ");
		$this->options['token'] = $this->data->token;
		$_media = $this->getMedia( $this->options );
	}


	public function getUserMedia( $data , $options ) {
		$this->data = $data;
		$this->options = $options;
		if( !($this->data instanceof Core_Model_Property) )
		throw new Exception("Instance of Core_Model_Site required ");
		$this->options['token'] = $this->data->token;
		$_media = $this->getMedia( $this->options );
	}


	public function getPropertyMediaByUniqueToken(){
		$property = Core_Util_Factory::build( array() , Core_Util_Factory::MODEL_PROPERTY);
		$property_table = $property->getTableName();
		$media = Core_Util_Factory::build( array() , Core_Util_Factory::MODEL_MEDIA);
		$media_table = $media->getTableName();
		$sql = "SELECT * FROM $property_table LEFT JOIN $media_table ON $property_table.token = $property_table.token ";
		return $this->db->query( $sql )->fetchAll();
	}


	
	/**
	 * @todo should delete images on hard drive as well
	 * 
	 * @param Core_Entity_Media $data
	 */
	public function deleteLandlordImage( Core_Entity_User $data ){
		Core_Util_Factory::build( array( "owner" => $data->token ), Core_Util_Factory::DAO_MEDIA)->delete();
		return true;
	}
	
	public function editUserMedia(Core_Entity_Media $data ){
		return Core_Util_Factory::build($data->toArray() , Core_Util_Factory::DAO_MEDIA)->save();
	}

	public function getUserDefaultImage( Core_Entity_User $data ){
		$_params = ( array("owner" => $data->token, "media_key" => "image", "displayed" => 1, "isdefault" => 1 ) );
		return Core_Util_Factory::build($_params , Core_Util_Factory::DAO_MEDIA)->get();
	}


	public function getPropertyDefaultImage( Core_Entity_Property $data ){
		$_params = ( array("owner" => $data->token, "media_key" => "image", "displayed" => 1, "isdefault" => 1 ) );
		return Core_Util_Factory::build($_params , Core_Util_Factory::DAO_MEDIA)->get();
	}




	public function getPropertyImages( Core_Entity_Property $data ){
		$_params = ( array("owner" => $data->token, "media_key" => "image") );
		return Core_Util_Factory::build($_params , Core_Util_Factory::DAO_MEDIA)->getAll();
	}

}
?>