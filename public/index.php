<?php
/**
 * check on the following site to get an idea of how the site should look  like and compete with em
 * http://www.rentroyal.com
 * http://rentified.com
 * http://cheqin.co/tour/
 * to sell the site look this seller business 
 * http://www.buybusiness.com
 * 
 * 
 * http://www.buybusiness.com/Businesses/10528/Real-Estate-Website-For-Sale-Huge-Growth-Potential
 * asks 30.000 with 300 registered members! 
 * 
 * guys in the same business( listed 11 clients, 199 euro a year, and customization on hourly basis ) 
 * http://www.vacationrentalscript.com/order
 * the script is encoded using Ioncube Encode
 * US wide rental on demand, acts a little like mine, but has no booking 
 * http://www.pickrent.com
 * compare their widget, and I need to list by region 
 * http://www.pickrent.com/widgets/template.cfm
 * 
 * http://rem.spiralaxis.com/Properties/Bed/1.aspx
 * 1,300 per annum!
 *
 * http://www.hpadesign.com/index.cfm
 * has a lot of similarities with my site 
 * http://www.novascotia.com/fr/home/accommodations/default.aspx
 *
 *
 *
 * design idea
 * http://apps.shopify.com/directed-edge-expressrex?source=facebook_ad
 * button css is found at
 * http://woork.blogspot.com/2008/06/beautiful-css-buttons-with-icon-set.html
 * pricing schema is found at
 * http://www.box.net/pricing
 *
 *
 * check out the background image over here
 * http://apps.shopify.com/directed-edge-expressrex?source=facebook_ad
 *
 *
 *
 * another competitor
 * http://www.nakedapartments.com/
 * http://www.rofo.com/market-activity/2?search%5Bc_name%5D=
 *
 *
 *
 *
 * Great ressource on mapping areas of interests
 * http://www.domain.com.au
 *
 *
 *
 * A more clean and straight forward design/data visualizer is found at:
 * http://deals.nextag.com/
 *
 *
 * BandPage has a feature to allow bands to add content to facebook.
 * Can I do the same for this app?
 *
 *
 *
 *
 * Check how light http://www.cottagecountry.com/ is, and make it for our site
 *
 *
 * what if my app looks like mint's?
 * https://www.mint.com/credit-cards/?v=1
 *
 *
 * with the simplicity of
 * http://rent.is an icelandic property listing site?
 *
 *
 *
 * ease of use and search would be much like
 * http://www.decide.com/
 * look at the way browsing items is much easier
 *
 * we should load all properties in the region and as the user selects one more filter,
 * send the request with this filter appended. it should allow users to be more engaged.
 * Say, this appartment has been leased, but the lesee wants a roomate as well!
 * 
 * 
 * the design is easy and easy to read 
 * http://bidcleangrow.com/
 * 
 * design fa
 * http://www.apollohq.com/tour/
 * http://www.highcharts.com/demo/line-basic
 * 
 * @link http://www.jimsparrow.com/idx/residential/C3495020/details.html 
 * 
 */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment, change before release 
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(
	implode(PATH_SEPARATOR, array(
    	realpath(APPLICATION_PATH . '/../library/'),
    	get_include_path(),
	))
);



define('MEDIA_PATH', realpath(dirname(__FILE__)).'/uploads');
define('UPLOADS_IMG_PATH', realpath(dirname(__FILE__)).'/assets/img');
define ( 'THIRD_PART_LIBRARY_PATH', realpath(APPLICATION_PATH . '/../library/Third') );
define( 'HTTP_UPLOADS_IMAGE_PATH', 'http://rentable/assets/img');//
/**
 * This variable will be used with functions to return a default image to display 
 * if image not found or broken 
 * @var string 
 */
define ('DEFAULT_PRODUCT_IMAGE_URL', 'gallery.png'); 
/** Zend_Application */
require_once '../library/Zend/Application.php';
/**Including libraries in third part directory */
require_once THIRD_PART_LIBRARY_PATH.'/ThumbLib.inc.php';
// Create application, bootstrap, and run
$application = new Zend_Application( APPLICATION_ENV,  APPLICATION_PATH . '/configs/application.ini');
//initialization of modules. note the default directory
$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(array(
		 'default' => '../application/controllers',
		  'agent'    => '../modules/agent/controllers',
		  'tech'    => '../modules/tech/controllers',
		  'customer'    => '../modules/customer/controllers',
		  'admin'    => '../modules/admin/controllers'
  ));
/**Resetting the allowed memory*/
try{
  	ini_set('date.timezone', 'America/New_York');
	if ( ini_get('memory_limit') != '32M' ){ini_set('memory_limit', '32M' );}
 }catch ( Exception $e ){ }
$application->bootstrap()->run();