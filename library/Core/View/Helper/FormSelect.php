<?php

/**
 * 
 * this class is an attempt to change forms behaviour. 
 * I need row html text to be included in the select box \
 * 
 *@param 
 *@author Pascal Maniraho  
 *@version 1.0.0  
 * 
 */
class Rt_Veiw_Helper_FormHelper extends Zend_View_Helper_FormSelect{


	function __construct(){
		parent::__construct();
	}
	
	
	
	public function formSelect($htmlText){
		return $htmlText;
	}
}
?>