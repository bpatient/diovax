<?php

require_once("/var/www/mcart/test/library/BaseLibraryUnitTest.php");
class UserServiceTestCase extends BaseLibraryUnitTest {	
	
	
	
	function testAddUserAndUserProfileAddressAuthAuthDetails(){
		
		/**this fictitious user has 30 years old from now */
		$user_array = array(
			"id" => 0, 
			"name" => "testinuserfullname",
			"email" => "testinguseremail",
			"birthday" => date("Y-m-d", (time() - (30*360*24*60*60))),
			"category" => "tmp",
			"banned" => false,
			"active" => true,
			"created" => date("Y-m-d h:i:s", time()),
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		
		$profile_array = array(
			"id" => 0, 
			"profile_key" => 1,
			"profile_value" => "forratingtestingvalue",
			"displayed" => true,
			"user_id" => 1,
			"modified" => date("Y-m-d h:i:s", time())
		
		);
		
		/*Active time should be kept in auth_log table */
		$auth_array = array(
			"id" => 0, 
			"service" => "system",
			"key" => "username_password",
			"value" => "[username:password]",
			"active_time" => 12000,
			"active" => true,
			"user_id" => 1,
			"modified" => date("Y-m-d h:i:s", time())
		
		
		);
		
		
		$auth_log_array = array(
			"id" => 0, 
			"agent" => "moz....",
			"ip" => '127.0.0.1',
			"starts" => 'NOW()',
			"stops" => null,
			"location" => true,
			"auth_id" => 1,
			"modified" => date("Y-m-d h:i:s", time())
		
		
		);
		
		
		$address_array = array(
			"id" => 0, 
			"user_id" => 1,
			"displayed" => true,
			"address_type" => "home",
			"address_key" => "telephone",
			"address_value" => "testingaddresseditfromUserServiceTestCase::testAddUserAndUserProfileAddressAuthAuthDetails",
			"note" => "notetestingfromUserServiceTestCase::testAddUserAndUserProfileAddressAuthAuthDetails",
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		
		
			
		$this->trace("testAddUserAndUserProfileAddressAuthAuthDetails user...");$this->assertNotNull($this->user_service->editUser($user_array));
		$this->trace("testAddUserAndUserProfileAddressAuthAuthDetails auth...");$this->assertNotNull($this->user_service->editAuth($auth_array));
		$this->trace("testAddUserAndUserProfileAddressAuthAuthDetails auth log...");$this->assertNotNull($this->user_service->editAuthLog($auth_log_array));
		$this->trace("testAddUserAndUserProfileAddressAuthAuthDetails profile...");$this->assertNotNull($this->user_service->editProfile($profile_array));
		$this->trace("testAddUserAndUserProfileAddressAuthAuthDetails address...");$this->assertNotNull($this->user_service->editAddress($address_array));
		
		
		
		
	}//end of the function 
	
	
}	
?>	
	
	