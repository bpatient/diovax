<?php

class Core_Auth_Authenticator {
	/**
	 * authenticate 
	 * this function uses the Lookup object to check the user in the list of all of system users
	 * the lookup might use the database, ldap, or any other source of users 
	 * in a case of other services, a 3rd parameter will be added if needed 
	 * 
	 * @param string $email
	 * @param string $password
	 * @return bool
	 */
	public function authenticate($email, $password){		
		if(($user = Core_Auth_Lookup::getUserByemail($email)) && ($user->password == $password)):
			return true;
		endif;
                return false;
	}//end of function 
}


?>