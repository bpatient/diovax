<?php
/**
 * This class will be used to generate passwords   
 * @todo the length of password should be initialized following database storage capabilities 
 */
class Core_Util_Password{
	public static function generate(){
		$len = 8; 
		$seed = md5(time());
		return substr( $seed, 0, $len );
	}
}
?>