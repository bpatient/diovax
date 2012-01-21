<?php

/**
 * 
 * @author pascal
 *
 *
 *
 *@
 *@throws 
 */ 
class Core_Auth_Adapter_Database implements Zend_Auth_Adapter_Interface{
	
	
	
	/**		

	 * Authentication result code 
	 * @var $code boolean 
	 */
	protected $code = false; 
	/**Authenticated guy 
	 * @var $identity string 
	 */
	protected $identity; 
	/**
	 * the message to send back
	 * @var $msg   
	 */
	protected $password;
	protected $msg;
	protected $lookup_data;


        //if we have more than one role
	protected $roles ;
	
	const AUTH_FAILS = 100; //to give it a range outside Zend error ranges 
	const EMPTY_LOOKUP = 110; //to give it a range outside Zend error ranges
        const NOT_ACTIVE = 120; //to give it a range outside Zend error ranges
	
	
	/**
	 * The constructor takes the list of users in the system 
	 * 
	 * @param $lookup_data
	 * @return void
	 */
	public function __construct($email, $password, $lookup_data){
		$this->identity = $email;
		$this->password = md5($password);
		$this->lookup_data  = $lookup_data;	
		$this->roles = array("admin","customer","agent","landlord","tenant","tech");
		 
	}
	
	
	/**
	 * Performs the authentication
	 * @return Zend_Auth_Result 
	 * @throws Zend_Auth_Adapter_Exception
	 * (non-PHPdoc)
	 * @see library/Zend/Auth/Adapter/Zend_Auth_Adapter_Interface#authenticate()
	 	1. checks if the email exists in lookup_data
		2. if yes, encrypt and compare the passwords 
		3. on success return set $code to true and return Zend_Auth_Result
		This is O(n) algo, modifications are required to make it at least O(logn)*/
	public function authenticate(){		
		
		if ( !is_array($this->lookup_data) || empty($this->lookup_data) ) throw new Zend_Auth_Adapter_Exception(self::EMPTY_LOOKUP);

		foreach($this->lookup_data as $k => $v ):
		if($this->identity == $v["email"] && $this->password == $v["password"] ):

                            if ( $v['active'] == 0 ) throw new Zend_Auth_Adapter_Exception(self::NOT_ACTIVE);
                            $this->code = true;
                            $this->identity = new stdClass();/*Use User() from row object instead*/
                            $this->identity->identity = $v["email"];
                            $this->identity->name = $v["name"];
                            $this->identity->user_id = $v["id"];
                            $this->identity->auth_id = $v["auth_id"];
                            /*we have more than one role in this application**/
                            //$this->identity->role = ( $v["category"] != "admin" && $v["category"] != "customer"  && $v["category"] != "tmp" )?"guest":$v["category"];//get it from the look up
                            $this->identity->role = ( !in_array( $v["category"], $this->roles ) )?"guest":$v["category"];//get it from the look up

                            if ( $v["category"] == 'tmp') $v["category"] = 'guest';//with acl we only have 3 categories
                            return new Zend_Auth_Result($this->code, $this->identity, array("message" => $this->msg));
                    endif;
		endforeach;		
		throw new Zend_Auth_Adapter_Exception(self::AUTH_FAILS);
	}
	
}

?>