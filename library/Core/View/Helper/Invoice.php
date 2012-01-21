<?php
/**
 * 
 * 
 * This helper will be used to show the report of what the user boughtr, and will be used to 
 * send messages. it might be using a cart object and/or order object. 
 * 
 * it will be used for notification puposes.
 * 
 * @author Pascal Maniraho
 * @uses Core_Util_Cart 
 *
 *
 *This view helper cannot be used with items anymore, since we are dealing with custom products 
 *
 */



class Core_View_Helper_Invoice extends Zend_View_Helper_Abstract{
	
	
	
	/**Shall we use Core_Util_Cart, or just Core_Util_Order, so that we can use it even after the cart has been distroyed?*/
	public function invoice( Core_Util_Cart $cart, $option = array('') ){
		$invoice = '';
		$items = $cart->getItems();
		if (  $items )
		{
			
			//throw new Exception( print_r($items) );
			
			foreach( $items as $k => $item ) 
			{
				$invoice .= '<div style=\'width: 530px; clear:both;\'>';
					$invoice .= '<div style=\'width: 100px; float:left;\'>Name</div><div style=\'clear: right;\'>'.$item->name.'</div>';
					$invoice .= '<div style=\'width: 100px; float:left;\'>Quantity</div><div style=\'clear: right;\'>'.$item->counter.'</div>';
					$invoice .= '<div style=\'width: 100px; float:left;\'>Price</div><div style=\'clear: right;\'>'.$item->price.'</div>';
					$invoice .= '<div style=\'width: 100px; float:left;\'>Subtotal</div><div style=\'clear: right;\'>'.($item->price * $item->counter).'</div>';
				$invoice .= '</div>';	
				$invoice .= '<hr style=\'clear:both;\'/>';
			}
			$invoice .= '<div  style=\'font-weight:bold;\' >';
				$invoice .= '<div style=\'width: 100px; float:left;\'>Shipping</div><div style=\'clear: right;\'>'.$cart->getShippingDetails()->price.'</div>';//
				$invoice .= '<div style=\'width: 100px; float:left;\'>Total</div><div style=\'clear: right;\'>'.$cart->getTotal().'</div>';
				$invoice .= $this->formatTax($cart->getTax());
				$invoice .= '<div style=\'width: 100px; float:left;\'>G. Total</div><div style=\'clear: right;\'>'.$cart->getGrandTotal().'</div>';
			$invoice .= '</div>';
			$invoice .= '<hr style=\'clear:both;\'/>';
		}
		$invoice = '<div style=\'width:100%;\' >'.$invoice.'</div>'; 
		return $invoice; 
	}/***/
	
	
	
	private function formatTax( $tax_data ){		
		$ftx = '';
		if( is_array($tax_data) ) { 
			foreach ( $tax_data as $k => $tdata ) $ftx .= '<div style=\'width: 100px; float:left;\'>'.$tdata['class'].'</div><div style=\'clear: right;\'>'.$tdata['rate'].'</div>';	
		}else{
			$ftx = '<div style=\'width: 100px; float:left;\'>Taxes</div>'.$tax_data.'</div>'; 
		}
		return  $ftx;
	}
	/**no meaning up to now, and should be deleted**/
	/*	$invoice .= '<div style=\'width: 100px; float:left;\'>Taxes</div><div style=\'clear: right;\'>'.$this->formatTax($cart->getTax()).'</div>';*/
	
	
}
?>