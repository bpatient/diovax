<?php


	//Rt_Controller_Plugin_AclManager


	require_once("/var/www/mcart/test/library/BaseControllerTestCase.php");
	
	require_once ('/var/www/mcart/library/Zend/Acl.php');//Zend_Auth
	require_once ('/var/www/mcart/library/Zend/Auth.php');//Zend_Auth
	require_once ('/var/www/mcart/library/Zend/Acl/Role.php');//Zend_Auth
	require_once ('/var/www/mcart/library/Zend/Acl/Resource.php');//Zend_Auth
	require_once ('/var/www/mcart/library/Zend/Controller/Plugin/Abstract.php');
	require_once("/var/www/mcart/library/Rt/Controller/Plugin/AclManager.php");
	
	
	require_once("/var/www/mcart/library/Zend/Auth/Adapter/Interface.php");
	require_once("/var/www/mcart/library/Rt/Auth/Adapter/Database.php");
	require_once("/var/www/mcart/library/Zend/Auth/Adapter/Exception.php");
	require_once("/var/www/mcart/library/Rt/Auth/Adapter/Database.php");
	//
	
	
	class AclAuthTestCase extends BaseControllerTestCase{
		
		
		
		
		//public Core_Controller_Plugin_AclManager
		public function setUp(){
			parent::setUp();			
			$this->password = md5( 'pascal'); 
			$this->user_lookup = array ( 
				0 => array ( 'id' => 0, 'username' => 'pascal', 'password' => $this->password, 'category' => 'guest'),
				1 => array ( 'id' => 1, 'username' => 'pascal', 'password' => $this->password, 'category' => 'tmp'),
				2 => array ( 'id' => 2, 'username' => 'pascal', 'password' => $this->password, 'category' => 'customer'),
				3 => array ( 'id' => 3, 'username' => 'pascal', 'password' => $this->password, 'category' => 'admin'),
			);
			
			$this->auth = Zend_Auth::getInstance();
			
			
			try{

				$this->adapter = new Core_Auth_Adapter_Database("pascal", "pascal", $this->user_lookup);			
				$this->result = $this->auth->authenticate($this->adapter);
			}catch(Zend_Session_Exception $e){
				echo 'An Error occured -> '.$e->getMessage();
			}
			
			
		
			
			
		}
		
	
	
		function testGuestAcces(){
			$this->mcpa = new Core_Controller_Plugin_AclManager($this->auth);
				$this->acl = $this->mcpa->acl;
				$this->assertTrue( ($this->mcpa->acl->isAllowed('guest', 'default')) );
				$this->assertFalse( ($this->mcpa->acl->isAllowed('guest', 'customer')) );
				$this->assertFalse( ($this->mcpa->acl->isAllowed('guest', 'admin')) );
		}
	
	
	
	
		function testTmpAcces(){
			$this->mcpa = new Core_Controller_Plugin_AclManager($this->auth);
				$this->acl = $this->mcpa->acl;
				$this->assertTrue( ($this->mcpa->acl->isAllowed('tmp', 'default')) );
				$this->assertTrue( ($this->mcpa->acl->isAllowed('tmp', 'customer')) );
				$this->assertFalse( ($this->mcpa->acl->isAllowed('tmp', 'admin')) );
		}
		
		
		function testCustomerAcces(){
			$this->mcpa = new Core_Controller_Plugin_AclManager($this->auth);
				$this->acl = $this->mcpa->acl;
				$this->assertTrue( ($this->mcpa->acl->isAllowed('customer', 'default')) );
				$this->assertTrue( ($this->mcpa->acl->isAllowed('customer', 'customer')) );
				$this->assertFalse( ($this->mcpa->acl->isAllowed('customer', 'admin')) );
		}
		
		
		function testAdminAcces(){
			$this->mcpa = new Core_Controller_Plugin_AclManager($this->auth);
				$this->acl = $this->mcpa->acl;
				$this->assertTrue( ($this->mcpa->acl->isAllowed('admin', 'default')) );
				$this->assertTrue( ($this->mcpa->acl->isAllowed('admin', 'customer')) );
				$this->assertTrue( ($this->mcpa->acl->isAllowed('admin', 'admin')) );
		}
	
	}


?>