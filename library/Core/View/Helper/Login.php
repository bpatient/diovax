<?php

class Core_View_Helper_Login extends Zend_View_Helper_Abstract{

	
	
	
	
	public function login(){
		
		echo "<div class='form'>";
		 	echo "<br/>email <br/><input type='text' name='email'/>";
		 	echo "<br/>Password <br/><input type='text' name='email'/>";
		 	echo "<input type='submit' name='submit'/><br/>";
		echo "</div>";
		
		
		
	}
	
}


?>