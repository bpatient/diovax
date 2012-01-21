<?php

class Core_View_Helper_AddLink extends Zend_View_Helper_Abstract{
	
	function addlink(){
		echo "<div class='link'>";
		 	echo "<br/>email <br/><input type='text' name='email'/>";
		 	echo "<br/>Password <br/><input type='text' name='email'/>";
		 	echo "<input type='submit' name='submit'/><br/>";
		echo "</div>";
		
		
		
	}
	
}


?>