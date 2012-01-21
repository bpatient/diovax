<?php

/**
 *Lookup 
 *checks the directories of users and checks if a given user exists   
 * @author pascal
 *
 */
class Core_Auth_Lookup {
	
	
	
	/**
	 * 
	 * @param string $email
	 * @return object 
	 * 
	 */	
	public static function getUserByemail($email){
		
		$user = new stdClass(); 
			switch($email):		
				case "business":
				case "admin":
					$user->name = $email;
					$user->password = $email;
				break;				
				default: 
					$user->name = null;
					$user->password = null;
				break;			
			endswitch;
		return $user;//or return false based on email
		
	}
}
?>