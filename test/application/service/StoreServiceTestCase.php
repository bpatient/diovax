<?php

require_once("/var/www/mcart/test/library/BaseLibraryUnitTest.php");
class StoreServiceTestCase extends BaseLibraryUnitTest {	
	
function testNewProductAndCommentDetailsRatingMedia(){
	
	
		$product_array = array(
			"id" => 1, 
			"product_category_id" => -1,
			"sku" => "testingskunumber",
			"name" => "TestNewProductAndCommentDetailsRatingMedia",
			"price" => 100.21,
			"dimension" => "{w:1, h:23, z:112}",
			"note" => "TestNewProductAndCommentDetailsRatingMedia",
			"status" => false,
			"onsale" => false,
			"created" => date("Y-m-d h:i:s", time()),
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		$product_media_array = array(
			"id" => 0, 
			"title" => "testingmediatitle",
			"caption" => "testingskunumber",
			"description" => "TestNewProductAndCommentDetailsRatingMedia",
			"media_order" => 11,
			"media_key" => "{w:1, h:23, z:112}",
			"media_value" => "TestNewProductAndCommentDetailsRatingMedia",
			"displayed" => false,
			"product_id" => 1,
		);
		

		
		
		$product_details_array = array(
			"id" => 0, 
			"product_id" => 1,
			"detail_key" => "testingskunumber",
			"detail_value" => "TestNewProductAndCommentDetailsRatingMedia",
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		
		
		$product_comment_array = array(
			"id" => 1, 
			"product_id" => 1,
			"title" => "testingskunumber",
			"content" => "TestNewProductAndCommentDetailsRatingMedia",
			"displayed" => true,
			"author" => 1,
			"status" => "open",
			"rating" => "{a:0,f:120,r:10}",
			"modified" => date("Y-m-d h:i:s", time())
		);
		
		
		
		
		$product_rating_array = array(
			"id" => 0, 
			"product_id" => 1,
			"rate_key" => "forratingtestingvalue",
			"rate_value" => 12310,
			"modified" => date("Y-m-d h:i:s", time())
		
		);
		
		
	
		
		$this->trace("testNewProductAndCommentDetailsRatingMedia product...");$this->assertNotNull($this->store_service->editProduct($product_array));
		$this->trace("testNewProductAndCommentDetailsRatingMedia product details...");$this->assertNotNull($this->store_service->editProductDetails($product_details_array));
		$this->trace("testNewProductAndCommentDetailsRatingMedia product comment...");$this->assertNotNull($this->store_service->editProductComment($product_comment_array));
		$this->trace("testNewProductAndCommentDetailsRatingMedia product rating...");$this->assertNotNull($this->store_service->editProductRating($product_rating_array));
		$this->trace("testNewProductAndCommentDetailsRatingMedia product media...");$this->assertNotNull($this->store_service->editProductMedia($product_media_array));
		
	}
	
	
	
	
	
	
function testRegisterNewProductCategory(){
		$product_category_array = array(
			"id" => 1, 
			"parent" => -1,
			"name" => "TestCaseStoreProductCategoryName",
			"note" => "TestCaseStoreProductCategoryNote",
			"modified" => date("Y-m-d h:i:s", time())
		);
		$this->trace("testRegisterNewStoreAndAddDetails new product category...");$this->assertNotNull($this->store_service->editProductCategory($product_category_array));
		
	}
	
	
	function testStoreServiceAvailable(){
		$this->trace("StoreServiceAvailable ... ");
		$this->assertNotNull($this->store_service);
	} 
	
	
	
	
	
	function testRegisterNewStoreAndAddDetails(){
		$store_array = array(
			"id" => 1, 
			"name" => "TestCaseStore",
			"url" => "http://mcart",
			"created" => date("YYYY-mm-dd h:i:s", time())
		);
		
		
		$store_details_array = array(
			"id" => 1, 
			"store_id" => 1,
			"detail_key" => "testcasestorekey",
			"detail_value" => "testcasestoredeailvalue", 
			"note" => "testcasenote", 
			"modified" => date("Y-m-d h:i:s", time())
			
			
		);
		


		
		
		$this->trace("testRegisterNewStoreAndAddDetails new store ");$this->assertNotNull($this->store_service->editStore($store_array));
		$this->trace("testRegisterNewStoreAndAddDetails new store details ");$this->assertNotNull($this->store_service->editStoreDetails($store_details_array));
		
	}
	
}
?>