<?php



require_once("/var/www/mcart/test/library/BaseLibraryUnitTest.php");
class LookUpDataTestCase  extends BaseLibraryUnitTest {

		
	
	
	function testLookupDataFunction(){		
		$data = $this->user_service->getUserLookup();
		$this->assertNull( $data);
	}
	
}

?>