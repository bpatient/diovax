<?php

require_once("/var/www/mcart/test/library/BaseLibraryUnitTest.php");
class ShopServiceTestCase  extends BaseLibraryUnitTest {

	
	
	
	/*testing objects deletion*/
	function testDeleteObjectFunctionality(){
		/*
			$item = new Core_Model_OrderItem(); 
			$item->id = 1; 		
			$this->trace("Testing delete Object ::: ");
			$condition = (false === $item->delete($item));
			$this->assertTrue(!$condition);
		*/
	}
	
	
	/**tesing basic functions that will be needed for editing information in this section*/
	/*
	function testPaymentMethodsEditFunctionality(){
		
		$payment_array = array(
		
			"id" => 0, 
			"service" => "testingpaymentme",
			"note" => "testingpaymentmethodseditfunctionalityservice",
			"allowed" => false,
			"created" => date("Y-m-d h:i:s", time()),
			"modified" => date("Y-m-d h:i:s", time())
		
		);
		$this->trace("testPaymentMethodsEditFunctionality payment...");
		$this->assertNotNull($this->shop_service->editPayment($payment_array));
	
	}
	
	
	
	function testOrderAndOrderDetailsEditFunctionality(){
	
		$order_array = array(
			"id" => 0, 
			"user_id" => 1,
			"payment_methods_id" => 1,
			"status" => "open",
			"note" => "testOrderAndOrderDetailsEditFunctionalityNoteAdded",
			"shipping_code" => "testingshippingcodevalue",
			"shipping_service" => "fedexshippingserviceunrevealed",
			"starts" => date("Y-m-d h:i:s", time()),
			"stops" => date("Y-m-d h:i:s", time())
		);
		$order_details_array = array(
			"id" => 0, 
			"customer_order_id" => 1, 
			"detail_key" => "testingdetailsarraykeyvalue",
			"detail_value" => "testingdetailsarraytestingdetailsarrayvaluevaluevalue",
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		
		
		$this->trace("testOrderAndOrderDetailsEditFunctionality oerder...");$this->assertNotNull($this->shop_service->editOrder($order_array));
		$this->trace("testOrderAndOrderDetailsEditFunctionality oerder details...");$this->assertNotNull($this->shop_service->editOrderDetails($order_details_array));
		
	
	}
	
	
	
	function testOrderItemsEditFunctionality(){
		$item_array = array(
			"id" => 2, 
			"customer_order_id" => 1,
			"product_id" => 1,
			"price" => 4564,
			"tax" => 13,
			"tax_region" => "QC",
		);
		$this->trace("testNewProductAndCommentDetailsRatingMedia product...");
		$this->assertNotNull($this->shop_service->editItem($item_array));
		//$this->trace("testOrderAndOrderDetailsEditFunctionality remove item...");$this->assertNotNull($this->shop_service->deleteItem($item_array));
	
	}
	
	*/
	
	
	function testFullOrderFunctionality(){
	
		
		$order_id = 10;
		
		$order_array = array(
			"id" => 0, 
			"user_id" => 10,
			"payment_methods_id" => 1,
			"status" => "open",
			"note" => "this is a note from test",
			"shipping_code" => "1234hkhk4353ljlk",
			"shipping_service" => "fedex",
			"starts" => date("Y-m-d h:i:s", time()),
			"stops" => date("Y-m-d h:i:s", time())
		);
		
		
		$order_details_array = array(
			"id" => 0, 
			"customer_order_id" => $order_id, 
			"detail_key" => "shipping_address",
			"detail_value" => "1001",
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		$order_details_array = array(
			"id" => 0, 
			"customer_order_id" => $order_id, 
			"detail_key" => "billing_address",
			"detail_value" => "1002",
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		
		$order_items = array ( 
		
			1 => array (
				"id" => 0, 
				"customer_order_id" =>$order_id,
				"product_id" => 10003,
				"price" => 42,
				"tax" => 11,
				"tax_region" => "QC",
			) ,
			2 =>  array (
				
				"id" => 0, 
				"customer_order_id" => $order_id,
				"product_id" => 10002,
				"price" => 45,
				"tax" => 13,
				"tax_region" => "QC",
			) 
		) ;
		
			
			
		
			//$array_res = $this->shop_service->editOrder($order_array);
			//$this->assertTrue ( ( $array_res > 0 ) );
			//$array_res = $this->shop_service->editOrderItem($order_id, $order_items, true );	
			//$this->assertEquals (2, $array_res['affected_rows']);
			//$this->assertTrue ( ( $array_res['last_inserted_id'] > 0 ) );
			
			
			
		
	}
	
	
	
	
	public function testProcessorder(){	
		
		$order_array = array(
			"id" => 0, 
			"user_id" => 10,
			"payment_methods_id" => 1,
			"status" => "open",
			"note" => "this is a note from test",
			"shipping_code" => "1234hkhk4353ljlk",
			"shipping_service" => "fedex",
			"starts" => date("Y-m-d h:i:s", time()),
			"stops" => date("Y-m-d h:i:s", time())
		);
		
		
		$order_details = array (
		
		
			0 =>  array(
			"id" => 0, 
			"customer_order_id" => $order_id, 
			"detail_key" => "shipping_address",
			"detail_value" => "1001",
			"modified" => date("Y-m-d h:i:s", time())
		), 
		
		1 =>  array(
			"id" => 0, 
			"customer_order_id" => $order_id, 
			"detail_key" => "billing_address",
			"detail_value" => "1002",
			"modified" => date("Y-m-d h:i:s", time())
		 )
		);
		
		
		
		
		$order_items = array(
				array(
				"id" => 0, 
				"customer_order_id" => 10,
				"product_id" => 1001,
				"price" => 21,
				"tax" => 12,
				"tax_region" => 'BC'
			), 
			array(
				"id" => 0, 
				"customer_order_id" => 10,
				"product_id" => 1002,
				"price" => 2000,
				"tax" => 32,
				"tax_region" => 'BC'
			),
			array(
				"id" => 0, 
				"customer_order_id" => 10,
				"product_id" => 1003,
				"price" => 200,
				"tax" => 12,
				"tax_region" => 'BC'
			)
		);
		
		
		//$order_details = new Core_Model_OrderDetails( array(	"id" => 0, 	"customer_order_id" => $order_id, 	"detail_key" => "shipping_address",	"detail_value" => "1001", "modified" => date("Y-m-d h:i:s", time())	) );
		$order_id = $this->shop_service->processOrder($order_array, $order_details , $order_items);
		$this->assertTrue( ($order_id > 0)  ) ;
	}
	
	
	
	
	/**this functyion is designed to test synchronization method between the cart and current order in the database */
	public function testSynchronize(){
	
		/**
		 * @var array of items 
		 */
		$scart = array (
		
			1 => new stdClass(),
			2 => new stdClass(),
			3 => new stdClass()
			
		
		);
	
	
	
	}
	
	
	
}