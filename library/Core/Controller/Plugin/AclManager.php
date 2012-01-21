<?php
/**
 * This class has been UnitTested successfully
 * @see test/library/AclAuthTestCase.php
 * @todo change ACL Manager
 */
class Core_Controller_Plugin_AclManager extends Zend_Controller_Plugin_Abstract{


	public $acl;
	public $auth;
	public function __construct(Zend_Auth $auth){
			
			
			
		$this->auth = $auth;
		$this->acl = new Zend_Acl();
			
		//adding ressources
		$this->acl->addResource(new Zend_Acl_Resource("app"));
		$this->acl->addResource(new Zend_Acl_Resource("customer"));
		$this->acl->addResource(new Zend_Acl_Resource("landlord"));
		$this->acl->addResource(new Zend_Acl_Resource("tech"));
		$this->acl->addResource(new Zend_Acl_Resource("agent"));
		$this->acl->addResource(new Zend_Acl_Resource("admin"));
			
		//adding roles to the acl
		$this->acl->addRole(new Zend_Acl_Role("guest"));
		$this->acl->addRole(new Zend_Acl_Role("tmp"), 'guest');/***/
		$this->acl->addRole(new Zend_Acl_Role("customer"), 'guest');// customer accesses tmp role as well
		$this->acl->addRole(new Zend_Acl_Role("landlord"), 'guest');// customer accesses tmp role as well
		$this->acl->addRole(new Zend_Acl_Role("agent"), 'guest');
		$this->acl->addRole(new Zend_Acl_Role("tech"), 'guest');

		$this->acl->addRole(new Zend_Acl_Role("admin"), array( 'guest', 'tech', 'landlord', 'customer' ) );//


		//allow all users to access all ressources
		$this->acl->allow();//this allows guest/customer and admin to access all ressources

		//nobody can access admin | customer | tech | agent
		$this->acl->deny(null, "tech");
		$this->acl->deny(null, "agent");
		$this->acl->deny(null, "customer");
		$this->acl->deny(null, "landlord");
		$this->acl->deny(null, "admin");

			
		//only tmp can access customer | this allows customer to access customer ressource as he inherits from customer
		$this->acl->allow("tmp", "customer");
		$this->acl->allow("customer", "customer");
		$this->acl->allow("agent", "agent");
		$this->acl->allow("tech", "tech");
		$this->acl->allow("landlord", "landlord");
		$this->acl->allow("admin", "tech");
		$this->acl->allow("admin", "agent");
		$this->acl->allow("admin", "landlord");
		$this->acl->allow("admin", "customer");

			
		//only the admin can access to admin ressource => as admin inherits from customer => admin can access also customer section
		$this->acl->allow("admin", "admin");
	}





	//this function gets the current request and retrieves the object
	public function preDispatch(Zend_Controller_Request_Abstract $request){
			
		// getting the module
		$resource = $request->module?$request->module:"app";//
		$privilege = $request->controller?$request->controller:"index";
		$role = "guest";
		if( $this->auth->hasIdentity() && $this->auth->getIdentity()->role ){
			$role = $this->auth->getIdentity()->role;
		}

		if(!$this->acl->hasRole($role)) $role = "guest";//its not a good idea to hard code these variables
		if(!$this->acl->has($resource)) $resource = "app";//its not a good idea to hardocod these variables

		//priviledge is not necessary here as we redirect based on modules
		if(!$this->acl->isAllowed($role, $resource)):
			$request->setModuleName("app");
			$request->setControllerName(($this->auth->hasIdentity()?"index":"auth"));//
			$request->setActionName((($request->getControllerName() == "auth")?"index":"index"));
		endif;


	}



}
?>