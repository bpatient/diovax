<?php


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


	
	
	public $session;
	
	/**
	* Initialization of session variable
	* enables each page to have each page enhanced with session facility.
	* This function works on dev/deployment but leads to an output before initialization session bug.
	* comment session initialization when unit testing, and enable those after unit testing
	*/
	protected function _initSession(){
	Zend_Session::start();
	Zend_Session::setOptions( array ('strict'=> true) ); //reducing overhead by enhancing the session functionality for only pages that needs a session /
	if(!Zend_Registry::isRegistered('session'))
			{
				$this->session = new Zend_Session_Namespace('default');
				Zend_Registry::set('session', $this->session);
	}
	
	}
	

	protected function _initAutoload(){



		
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Core_');
		$moduleAutoloader = new Zend_Application_Module_Autoloader(
		array(
                                'namespace' => '',
                                'basePath' => APPLICATION_PATH,
                                'namespace' => 'Admin'
			)
		);

		$resourceLoader = new Zend_Loader_Autoloader_Resource(array( 'basePath'  => APPLICATION_PATH, 'namespace' => '' ) );
		$resourceLoader->addResourceTypes( array( 'model' => array( 'path' => 'models', 'namespace' => 'Models')) );
		return $moduleAutoloader;

	}//



	/***/
	protected function _initConfig(){
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
		Zend_Registry::set("config", $config);
		define('BASE_URL', $config->system->app->base->url);


	}


	/**
	 * @todo bootstrap database from config file
	 **/
	protected function _initDatabase(){
		$resource = $this->getPluginResource('db');
		$database = $db = $resource->getDbAdapter();
		Zend_Registry::set( 'database', $database );
		Zend_Registry::set( 'db', $db );


	}





	protected function _initViewHelpers(){
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = Zend_Layout::getMvcInstance()->getView();
		$view->addHelperPath('Core/View/Helper/','Core_View_Helper');


	}




	protected function _initLayoutHelper(){
		$this->bootstrap('frontController'); //instead of this, use the following
		$layout = Zend_Controller_Action_HelperBroker::addHelper(
		new Core_Controller_Action_Helper_LayoutLoader());
	}



	protected function _initTranslation(){
		$config = Zend_Registry::get("config");
		$language = $config->system->translate->language;/***/
		if( $language && strlen($language) == 2 ) $language = $language;
		else $language = 'en';
		$translate = new Zend_Translate('tmx', APPLICATION_PATH.'/languages/language.tmx', $language );
		Zend_Registry::set('language', $translate);
	}



	/**improve this function in future to make it work with all local dependent objects*/
	protected function _initLocale(){
		$config = Zend_Registry::get( 'config' );
		$locale = new Zend_Locale( $config->system->translate->locale );
		Zend_Registry::set( 'Zend_Locale', $locale );
	}


	//
	protected function _initView(){


		$front = Zend_Controller_Front::getInstance();
		$view = new Zend_View();
		$view->doctype('XHTML1_STRICT');
		$config =  Zend_Registry::get("config");
		$view->setBasePath($config->system->app->base->url);
		$view->headTitle($config->system->app->title);
		$view->headMeta()->setName('keywords', 'php application')
		->appendHttpEquiv('Cache-control', 'no-cache')
		->appendHttpEquiv('Content-Type', 'text/html;charset=UTF-8')
		->appendHttpEquiv('Expires', date( DATE_RFC822, mktime(0,0,0,date("m"),date("d"),date("Y")+10 )) )
		->appendHttpEquiv('Accept-Encoding', 'gzip, deflate');

		$view->headMeta()->appendName('keywords', $config->system->keywords);
		$view->headMeta()->appendName('description', $config->system->description);


		$view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js')->appendFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');///js/jquery-ui-custom-combined-min.js
		$view->headScript()->appendFile('/js/fancybox/jquery.fancybox-1.3.1.pack.js');
		$view->headScript()->appendFile('/js/superfish.js')->appendFile('/js/jquery.json-2.2.min.js')->appendFile('/js/yui-min.js');
		
		$view->headLink()->appendStylesheet("/css/main.css")->appendStylesheet("http://fonts.googleapis.com/css?family=Cuprum");
		$view->env = APPLICATION_ENV;
		return $view;


	}//





	/**
	 * The default configuration is such as default has been replaced by app, IndexController replaced by SiteController
	 */
	protected function _initRouters(){
		$front = Zend_Controller_Front::getInstance();
		$front->getRouter()->addRoute('id',new Zend_Controller_Router_Route(':id', array("module" => "app", "controller"=>"site", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('actionid',new Zend_Controller_Router_Route(':action/:id', array("module" => "app", "controller"=>"site", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('controlleractionid',new Zend_Controller_Router_Route(':controller/:action/:id', array("module" => "app", "controller"=>"site", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('modulecontrolleractionid',new Zend_Controller_Router_Route(':module/:controller/:action/:id', array("module" => "app", "controller"=>"site", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('iid',new Zend_Controller_Router_Route(':id', array("module" => "app", "controller"=>"index", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('iactionid',new Zend_Controller_Router_Route(':action/:id', array("module" => "app", "controller"=>"index", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('icontrolleractionid',new Zend_Controller_Router_Route(':controller/:action/:id', array("module" => "app", "controller"=>"index", "action"=>"index","id"=>"0")));
		$front->getRouter()->addRoute('imodulecontrolleractionid',new Zend_Controller_Router_Route(':module/:controller/:action/:id', array("module" => "app", "controller"=>"index", "action"=>"index","id"=>"0")));
	}





	/**Plugin registration */
	protected function _initControllerPlugins(){
		$front = Zend_Controller_Front::getInstance();
		$auth = Zend_Auth::getInstance();//once initialized, it becomes available thought the application and might be changed at any stage
		
		
		
		$front->registerPlugin(new Core_Controller_Plugin_AclManager($auth));
	}




	protected function _initServices(){

		
		Zend_Registry::set('database_service', new Core_Service_Database());
		Zend_Registry::set('auth_service',new Core_Service_Auth() );
		Zend_Registry::set('media_service',new Core_Service_Media() );
		Zend_Registry::set('user_service', new Core_Service_User());
		Zend_Registry::set('user_manager', new Core_Service_UserManager() );
		Zend_Registry::set('message_service', new Core_Service_Message());
		Zend_Registry::set('analytics_service', new Core_Service_Analytics());
		Zend_Registry::set('property_manager_service',  new Core_Service_PropertyManager());
			
		try{
			$writter = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/configs/logger.txt');
			$logger = new Zend_Log( $writter );
			Zend_Registry::set( 'logger', $logger );
		}catch(Exception $e ){

		}



	}




	/**This object creates the navigation menu**/
	protected function _initNavigation(){

		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view   = $this->getResource('layout')->getView();

		/**XML element | config ini if requested to use it too*/
		$config = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml', 'navigation' );
		$navigation = new Zend_Navigation($config);
		Zend_Registry::set('navigation',$navigation);

		/**registering the navigation with the view*/
		$translator = Zend_Registry::get('language');
		$view->navigation( $navigation)->setTranslator($translator) ;

		/***modules navigations*/
		$config = new Zend_Config_Xml(APPLICATION_PATH.'/modules/admin/configs/navigation.xml', 'navigation' );
		$admin_navigation = new Zend_Navigation($config);
		Zend_Registry::set('admin_navigation',$admin_navigation);



	}

}
?>