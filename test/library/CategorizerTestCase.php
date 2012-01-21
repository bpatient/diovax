<?php


	//Rt_Controller_Plugin_AclManager


	require_once("/var/www/mcart/test/library/Base.php");
	require_once("/var/www/mcart/library/Rt/Util/Categorizer.php");
	
		
	
	class CategorizerTestCase extends BaseLibraryUnitTest{
		
		
		
		
		
		
		private $cat;
		private $categories; 
		
		
		function __construct(){
			parent::__construct();
			
			
			
			$this->categories = array (
				1 => array ( 'id' => 1,'parent' => -1, 'category' => 'root' ), 
				2 => array ( 'id' => 2,'parent' => 1, 'category' => 'books' ), 
				3 => array ( 'id' => 3,'parent' => 1, 'category' => 'electronics' ), 
				4 => array ( 'id' => 4,'parent' => 1, 'category' => 'wear' ), 
				5 => array ( 'id' => 5,'parent' => 2, 'category' => 'fiction' ), 
				6 => array ( 'id' => 6,'parent' => 2, 'category' => 'science' ), 
				7 => array ( 'id' => 7,'parent' => 2, 'category' => 'cooking' ), 
				8 => array ( 'id' => 8,'parent' => 3, 'category' => 'computers' ), 
				9 => array ( 'id' => 9,'parent' => 3, 'category' => 'television sets' ), 
				10 => array ( 'id' => 10,'parent' => 4, 'category' => 'men\'s wear' ), 
				11 => array ( 'id' => 11,'parent' => 4, 'category' => 'womens\' wear' ) 
				 
			);
			$this->cat = new Core_Util_Categorizer($this->categories
			,array('id' => 'id', 'parent' => 'parent', 'category' => 'category') );
			
			
			
			
			
			
			
		}
		
		
	
		
		
		
		
		function testEncoded(){
			//$this->cat->encoded();
			print_r($this->cat->_sel_elts);
		}
		
		
		function testToArray(){
			//echo $this->cat->toArray();
		}
		
		
		function testToHtml(){
			//echo '<pre>'.print_r($this->cat->toHtmlList(), true).'</pre>';
			echo print_r($this->cat->toHtmlOption(), true);
		}
		
		
		
		function testRenderHtml(){
			//$html = $this->cat->render();
			//print_r($html);
			//$this->assertNotNull($html);
		}
		
		
		function testCategoriesNotEmpty(){
			$this->assertNotNull ( $this->categories );
			
			//print_r($this->cat->_list) ;
			$this->assertNotNull ( $this->cat->_list );
			
			
		}
		function testCategorizerInstance(){
			$this->assertNotNull( ($this->cat) );
		}
		
		
		
		
		
	}


?>