<?php


defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

set_include_path(
	implode(PATH_SEPARATOR, array(
    	realpath(APPLICATION_PATH . '/../library/'),
    	get_include_path(),
	))
);



define('MEDIA_PATH', realpath(dirname(__FILE__)).'/uploads');
define('UPLOADS_IMG_PATH', realpath(dirname(__FILE__)).'/assets/img');
define ( 'THIRD_PART_LIBRARY_PATH', realpath(APPLICATION_PATH . '/../library/Third') );
define( 'HTTP_UPLOADS_IMAGE_PATH', 'http://diovax/assets/img');//
define ('DEFAULT_PRODUCT_IMAGE_URL', 'gallery.png'); 

require_once '../library/Zend/Application.php';
require_once THIRD_PART_LIBRARY_PATH.'/ThumbLib.inc.php';
$application = new Zend_Application( APPLICATION_ENV,  APPLICATION_PATH . '/configs/application.ini');
$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(array(
		 'default' => '../application/controllers',
		 'admin'    => '../modules/admin/controllers'
  )
);
/**Resetting the allowed memory*/
try{
  	ini_set('date.timezone', 'America/New_York');
	if ( ini_get('memory_limit') != '32M' ){ini_set('memory_limit', '32M' );}
 }catch ( Exception $e ){
 	
 }
$application->bootstrap()->run();