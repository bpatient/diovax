<?php


	//Rt_Controller_Plugin_AclManager


	require_once("/var/www/mcart/test/library/Base.php");
	require_once("/var/www/mcart/library/Rt/Util/Cart.php");
	
		
	
	class CartTestCase extends BaseLibraryUnitTest{
		
		
		
		
		
		
		private $cart;
		
		
		
		function __construct(){
			parent::__construct();
			$this->cart = Core_Util_Cart::getInstance();
			
			$item = new stdClass();
				
			
			$items = array ();			
			$item = new stdClass();$item->id = 100;			
			$items [$item->id] = $item;	
					
			$item = new stdClass();$item->id = 101;			
			$items [$item->id] = $item;	
					
			$item = new stdClass();$item->id = 102;
			$items [$item->id] = $item;
			
			
			$this->cart->addItems ( $items );
			
		}
		
		
	function testCartMergeAndAppendToThisObject(){

			$counter = count($this->cart->getItems());
		
			$items = array ();	
			$item = new stdClass();
			$item->id = 103;
			$items[$item->id] = $item;
			
			$item = new stdClass();
			$item->id = 104;
			$items[$item->id] = $item;
			
			$item = new stdClass();
			$item->id = 105;
			$items[$item->id] = $item;
			
			$this->cart->addItems ( $items );
			$fcounter = count($this->cart->getItems());
			
			//print_r($this->cart->getItems());
			//echo "final count = $fcounter first count = $counter";
		$this->assertEquals( ( $counter + 3) , $fcounter );
		}
		
		
		
		
		
		function testDeleteItemWorks(){
			$item = new stdClass(); 
			$item->id = 108;
			
			$this->cart->addItem($item);
			$items = $this->cart->getItems();
			$this->cart->deleteItem($item);
			$this->assertFalse ( $this->cart->getItem($item->id) );
		}
		
		
		
		
		function testGetItemWorks(){
			$item = new stdClass(); 
			$item->id = 108;
			$this->cart->addItem($item);
			$this->assertTrue ( ( $this->cart->getItem($item->id ) instanceof stdClass ) );
		}
		
		
		
		
		/***/
		function testAddItemWorks(){
			$counter = count($this->cart->getItems());
			$item = new stdClass(); $item->id = 109;
			$this->cart->addItem($item);
			$fcounter = count($this->cart->getItems());
			$this->assertEquals ( ($counter + 1) , $fcounter );
		}
		
		
		
		function testCartPopulated(){
			$this->assertTrue( ( count($this->cart->getItems()) > 0) );
		}
		
		
		function testCartConstructorInitalized(){
			$this->assertNotNull( ($this->cart) );
		}
		
		
		
		
		
	}


?>