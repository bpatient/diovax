<?php


	//Rt_Controller_Plugin_AclManager


	require_once("/var/www/mcart/test/library/Base.php");
	require_once("/var/www/mcart/library/Rt/Util/Breadcrumb.php");
	
		
	
	class BreadcrumbTestCase extends BaseLibraryUnitTest{
		
		
		private $breadcrumb;
		
		function __construct(){
			parent::__construct();
			$this->breadcrumb = new Core_Util_Breadcrumb( 
					array(), 
					array('title' => 'title', '' => '') 
				);
		}
		
		
		function testAddHome(){
			$this->breadcrumb->addStep('Home', 'customer');
			$this->breadcrumb->addStep('Profile', 'profile');
			$ul = $this->breadcrumb->toHtmlList();
			print_r( $ul );
			$this->assertNotNull( $ul );
		}
		
		
		function testAddNextTrail(){
			$this->breadcrumb->addStep('Profile', 'profile');
			$ul = $this->breadcrumb->toHtmlList();
			//print_r( $ul );
			$this->assertNotNull( $ul );
			
		}
		
		function testTrailArray(){
			//print_r( $this->breadcrumb->trail() ); 
			$this->assertNotNull( $this->breadcrumb->trail() );
		}
		
		
		
		
		
		
		
}//end of test case class 
?>