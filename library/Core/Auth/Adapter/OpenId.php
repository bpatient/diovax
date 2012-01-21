<?php



/**
 * 
 * This class doesnt need a look up data, but authenticates a user after successful return 
 * from openId provider . 
 * 
 * 
 * in the identity, it'd be better to add ID so that we can know who is connected 
 * 
 * 
 * 
 * 
 * @author pascal
 * 
 * check first the documentation at before coding   
 * http://framework.zend.com/manual/en/zend.openid.consumer.html
 *
 */
class Core_Auth_Adapter_OpenId implements Zend_Auth_Adapter_Interface{
	
	
	
	/**
	 * Authentication result code 
	 * @var $code boolean 
	 */
	protected $code = false; 
	/**Authenticated guy 
	 * this identity should be checked from the database 
	 * we dont have a name from the openId 
	 * @var $identity string 
	 */
	protected $identity; 
	/**
	 * the message to send back
	 * @var $msg   
	 */
	protected $id;
	protected $msg;
	
	
	/**
	 * The constructor takes the list of users in the system 
	 * @param $lookup_data
	 * @return void
	 */
	public function __construct($email, $password, $lookup_data){
		$this->identity = $email;
		$this->password = $password;
		$this->lookup_data  = $lookup_data;		
		
	}
	
	
	/**
	 * Performs the authentication
	 * @return Zend_Auth_Result 
	 * @throws Zend_Auth_Adapter_Exception
	 * (non-PHPdoc)
	 * @see library/Zend/Auth/Adapter/Zend_Auth_Adapter_Interface#authenticate()
	 */
	public function authenticate(){
		return new Zend_Auth_Result($this->code, $this->identity, array("message" => $this->msg));
	}

}
?>