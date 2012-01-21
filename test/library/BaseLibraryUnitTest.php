<?php
	


	/*
	 * This file will include required files to run test case
	 * to test a new class, add the class path and all dependencies here. 
	 * 
	
	 * */


	// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment, change before release 
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../../library/'),
    get_include_path(),
)));


	require_once("/usr/share/php/PHPUnit/Framework.php");
	
	/***
	 * classes to test and dependencies 
	 * we need services to test our models 
	 */
	require_once ('/var/www/mcart/library/Zend/Loader.php');
	require_once ('/var/www/mcart/library/Zend/Loader/Autoloader.php');
	require_once ('/var/www/mcart/library/Zend/Loader/Autoloader/Interface.php');
	
	
	/**loading dababase classes*/
	require_once ('/var/www/mcart/library/Zend/Db.php');
	require_once ('/var/www/mcart/library/Zend/Db/Table/Abstract.php');
	
	
	/*Loadin services*/
	require_once ('/var/www/mcart/library/Rt/Service/Database.php');
	require_once ('/var/www/mcart/library/Rt/Service/Store.php');
	require_once ('/var/www/mcart/library/Rt/Service/User.php');
	require_once ('/var/www/mcart/library/Rt/Service/Shop.php');
	
	
	
	require_once ('/var/www/mcart/library/Rt/Model/Entity.php');	
	require_once ('/var/www/mcart/library/Rt/Model/User.php');
	require_once ('/var/www/mcart/library/Rt/Model/Address.php');
	require_once ('/var/www/mcart/library/Rt/Model/Profile.php');	
	require_once ('/var/www/mcart/library/Rt/Model/Auth.php');	
	require_once ('/var/www/mcart/library/Rt/Model/AuthLog.php');	
	
	require_once ('/var/www/mcart/library/Rt/Model/OrderItem.php');	
	require_once ('/var/www/mcart/library/Rt/Model/OrderDetails.php');	
	require_once ('/var/www/mcart/library/Rt/Model/CustomerOrder.php');	
	require_once ('/var/www/mcart/library/Rt/Model/PaymentMethods.php');	
	
	
	require_once ('/var/www/mcart/library/Rt/Model/Product.php');	
	require_once ('/var/www/mcart/library/Rt/Model/ProductDetails.php');	
	require_once ('/var/www/mcart/library/Rt/Model/ProductComment.php');	
	require_once ('/var/www/mcart/library/Rt/Model/ProductRating.php');	
	require_once ('/var/www/mcart/library/Rt/Model/ProductCategory.php');	
	require_once ('/var/www/mcart/library/Rt/Model/ProductMedia.php');	
	
	require_once ('/var/www/mcart/library/Rt/Model/Store.php');	
	require_once ('/var/www/mcart/library/Rt/Model/StoreDetails.php');	
	
	
	//require_once ('/var/www/mcart/library/Rt/Model/ProductRating.php');	
	//require_once ('/var/www/mcart/library/Rt/Model/ProductCategory.php');	
	
	
	
	
	class BaseLibraryUnitTest extends PHPUnit_Framework_TestCase {

		
		//protected $db = new Core_Service_Database();
		//$db->config = array("host" => "localhost","username"=>"","password"=>"","dbname"=>""); 

		
		public function __construct(){
			
			$this->db_service = new Core_Service_Database();
			$this->db = $this->db_service->db;
			
			/*not requered to make sure that the database connected successfully */
			$this->db->config = array("host" => "localhost","username"=>"","password"=>"","dbname"=>""); 
			$this->user_service = new Core_Service_User(); 
			$this->store_service = new Core_Service_Store(); 
			$this->shop_service = new Core_Service_Shop(); 
			
			
			
			$this->user = new Core_Model_User(); 	
			$this->address = new Core_Model_Address();		
			$this->profile = new Core_Model_Profile();		
			
			
			$this->auth = new Core_Model_Auth();		
			$this->authLog = new Core_Model_AuthLog();		
			$this->customerOrder = new Core_Model_CustomerOrder();		
			$this->orderDetails = new Core_Model_OrderDetails();		
			$this->orderItem = new Core_Model_OrderItem();		
			$this->paymentMethods = new Core_Model_PaymentMethods();		
			
			$this->product = new Core_Model_Product();		
			$this->productDetails = new Core_Model_ProductDetails();		
			$this->productComment = new Core_Model_ProductComment();		
			$this->productCategory = new Core_Model_ProductCategory();		
			$this->productMedia = new Core_Model_ProductMedia();		
			$this->productRating = new Core_Model_ProductRating();		
			
			$this->store = new Core_Model_Store();		
			$this->storeDetails = new Core_Model_StoreDetails();		
			
		}
		
		
		
		/**/
		function testServiceInitialization(){
			/*
			$this->trace("Database Object..."); $this->assertNotNull($this->db);
			$this->trace("Database Config..."); $this->assertNotNull($this->db->config);
			$this->trace("User service ..."); $this->assertNotNull($this->user_service);
			*/
		}
		
		
		
		
		
		
		function testModelInitialization(){
			
			/*
			$this->trace("User Model...");$this->assertNotNull($this->user);	
			$this->trace("Address Model...");$this->assertNotNull($this->address);	
			$this->trace("Profile Model...");$this->assertNotNull($this->profile);	
			
			$this->trace("auth Model...");$this->assertNotNull($this->auth);	
			$this->trace("authLog Model...");$this->assertNotNull($this->authLog);	
			$this->trace("customerOrder Model...");$this->assertNotNull($this->customerOrder);	
			$this->trace("orderDetails Model...");$this->assertNotNull($this->orderDetails);	
			$this->trace("orderItem Model...");$this->assertNotNull($this->orderItem);	
			$this->trace("paymentMethods Model...");$this->assertNotNull($this->paymentMethods);	
			
			$this->trace("product Model...");$this->assertNotNull($this->product);	
			$this->trace("productDetails Model...");$this->assertNotNull($this->productDetails);	
			$this->trace("productComment Model...");$this->assertNotNull($this->productComment);	
			$this->trace("productCategory Model...");$this->assertNotNull($this->productCategory);	
			$this->trace("productMedia Model...");$this->assertNotNull($this->productMedia);	
			$this->trace("productRating Model...");$this->assertNotNull($this->productRating);	
			
			$this->trace("store Model...");$this->assertNotNull($this->store);	
			$this->trace("storeDetails Model...");$this->assertNotNull($this->storeDetails);
			*/
			//$this->trace("DB Object ... ");
			//$this->dbg($this->db->query("describe user "));
		}//

		
		
		
		
		public function trace($msg){
			print $msg."\n"; 
		}
		
		function dbg($msg){			
			print_r($msg);
			print "\n";
		}
		
	}