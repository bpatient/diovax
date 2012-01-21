<?php
/**
 * Core_Controller_Base is the base class of all Controllers. It initializes variables that will be needed in both controllers and views
 * @author Pascal Maniraho
 * @uses
 */



class Core_Controller_Base extends Zend_Controller_Action{



	public $mdl;
	public $title;
	public $menu;
	/**
	 * This variable will be used to send base url [ module controller action ] base path
	 * @var string $baseUrl
	 */
	protected $baseUrl;
	/**
	 * This variable will be used to be the base data holder
	 * @var array | collection $data
	 */
	protected $data;


	/**
	 * This variable willallow us to access the translation object
	 * @var Object
	 */
	public $translate;
	public $auth; /**authentication object*/
	/**
	 * This data will store currently connected browser, ip,
	 * @var array | stdObject $client
	 */
	public $client;






	/**
	 * This will be a object form breadcrumb,
	 * the navigation object gives a more detailed breadcrumb
	 * @var <Core_Util_Breadcrumb>
	 */
	protected $breadcrumb;


	/**
	 * Shortcut to post and isPost functionalities
	 */
	protected $post, $isPost;

	/***/
	protected $pg, $per_page, $options;


	/**
	 * This variable will be needed by descendent controllers
	 * @var Zend_Config_Ini $config
	 */
	protected $config;
	/**
	 *This is a third part calendar class an alternative of this version is found at:
	 * @var Core_Util_Calendar $calendar
	 */
	protected $calendar;

	/**
	 * @var unknown_type
	 */
	const MISSING_OR_FILE_PERMISSION_EXCEPTION = 1000;
	const MISSING_OR_CONFIGURATION_INI_EXCEPTION = 1001;

	/**
	 * This function have to be called in the children to generate menus and access variable
	 * herein initialized
	 */
	public function init(){


		//
		$this->config = Zend_Registry::get('config');/****/





		//initialization
		$this->_entities();
		$this->_services();

		$this->auth = Zend_Auth::getInstance();
		$this->user_id = ( $this->auth->hasIdentity() ) ? $this->auth->getIdentity()->user_id : 0 ;
		if ( $this->auth->hasIdentity()  && $this->auth->getIdentity()->role == 'admin' ) {
			if( $this->_getParam('user_id') > 0 ) $this->user_id = $this->_getParam('user_id');
		}



		/**Attaching translation to the view object**/
		$this->view->translate = Zend_Registry::get('language');//system_powered_by
		$this->translate = $this->view->translate;/**translate to be used in this object*/


		$this->view->mdl = $this->mdl = ( !($this->getRequest()->getModuleName() ) ) ?"default":$this->getRequest()->getModuleName();
		$this->view->ctlr = $this->ctlr = ( !($this->getRequest()->getControllerName() ) ) ?"index":$this->getRequest()->getControllerName();
		$this->view->act = $this->act = ( !($this->getRequest()->getActionName() ) ) ?"index":$this->getRequest()->getActionName();
			
		$this->view->title = $this->title;
		$this->view->menu_items = $this->menu;

		//the string object will help to reduce the size of text to display in views
		$this->strObj = new Core_Util_String();/*to make it available in the current children and views */
		$this->view->strObj = $this->strObj;

		//
		$this->categorizer = new Core_Util_Categorizer();
		$this->view->baseUrl = '/'.$this->mdl.'/'.$this->ctlr.'/'.$this->act;

		$this->title = '';
		if ( $this->mdl != 'index'  && $this->ctlr != 'default'   && $this->ctlr != 'store'  ) $this->title = ( $this->title )? $this->title.' :: '.ucfirst($this->mdl ): ucfirst( $this->mdl );
		if ( $this->ctlr != 'default' && $this->ctlr != 'index'  ) $this->title = ucfirst( $this->ctlr );
		if ( $this->act != 'index' ) $this->title = ( $this->title )? $this->title.' :: '.ucfirst($this->act ): ucfirst( $this->act );



		$this->view->title = $this->view->translate->_($this->title);//sending the title to all files
		$this->view->module_title = $this->config->system->app->name;//sending the title to all files
		$menu_items = array(); //local variable initialization
		$this->view->limit = 0;
		$this->view->order = 'asc';
			
		/***
		 * Paging variable to show in views
		*/
		$this->view->paging = "Paging Object";/**this should be Paging object instead, but its better to initialize it on each index view */
		$vh = new Zend_View_Helper_Url();
		$this->baseUrl = "/".$this->getRequest()->getModuleName()."/".
		$this->getRequest()->getControllerName()."/".
		$this->getRequest()->getActionName()."/";


		$this->data = array();



		switch($this->mdl):
		case "admin":
			$_menu = Zend_Registry::get('admin_navigation');
		$this->view->navigation($_menu)->setTranslator($this->translate);
		$this->view->menu = $this->view->navigation();
		break;
		case "customer":
			$_menu = Zend_Registry::get('customer_navigation');
			$this->view->navigation($_menu)->setTranslator($this->translate);
			$this->view->menu = $this->view->navigation();
			break;
		default:
			$_menu = Zend_Registry::get('navigation');
		$this->view->navigation($_menu)->setTranslator($this->translate);
		$this->view->menu = $this->view->navigation();
		break;
		endswitch;


		//
		$this->logger = Zend_Registry::get("logger");//logging events


		/**if the user logs out, check session::cart and synchronize again */
		$this->client = new stdClass();
		$this->client->ip = $this->getRequest()->getServer("REMOTE_ADDR");
		if ( $this->getRequest()->getServer("HTTP_VIA") )$this->client->ip = $this->getRequest()->getServer("HTTP_X_FORWARDED_FOR");
		$this->client->user_agent = $this->getRequest()->getServer("HTTP_USER_AGENT");
		$this->client->proxy = $this->getRequest()->getServer("HTTP_VIA");
		$this->client->location = $this->auth_service->ipToGeolocation( $this->client->ip );

			
		$options = array ();
		$options['client'] = $this->client;
		$options['sessionid'] = Zend_Session::getId();
		/**This step allows the synch function to add a new record in the database*/
		$options['step'] = 'connect';

		/**
		 * initilization of session
		 */
		$this->session = new Zend_Session_Namespace('default');
		if ( !$this->session->initialized ){
			Zend_Session::regenerateId();
			$sessionid_cookie = $this->getRequest()->getCookie('sessionid');
			if (  $sessionid_cookie ) $options['cookie'] = $sessionid_cookie;//this will help to initialize the previous cart to current operation
			$this->session->sessionid = Zend_Session::getId();
			$cookie  = new Zend_Http_Cookie('sessionid', $this->session->sessionid,	$this->config->system->app->base->url , time() + 7200, "/" );
			$this->session->initialized = true;
		}
		if( !$this->session->memo){
			$this->session->memo = new Core_Util_Cart();/**stores anything related to houses, booking and so on*/
		}




		$this->view->header = $this->config->system->app->name;
		$this->per_page = $this->config->system->backend->page->perpage;
		$this->calendar = new Core_Util_Calendar();





		/**Initialiazation of paging object  to be used while listing items*/
		$this->options = array(); /**to be sent to options*/
		$this->data = array();/**data to be used with paging*/

		/**will be used with to populate data in the form*/
		$this->_object = false;
		$this->view->form = new Core_Form_Base();

		/**
		 * @var unknown_type
		 */
		$this->user = $this->user_manager->getUser( Core_Util_Factory::build(array( 'id' => $this->user_id ), Core_Util_Factory::ENTITY_USER ) );
		$this->id = $this->getRequest()->getParam("id");
		if ( $this->auth->hasIdentity() && $this->auth->getIdentity()->user_id > 0 ){
			$this->user_id = $this->auth->getIdentity()->user_id;
			$_usr = Core_Util_Factory::build(array( 'id' => $this->user_id ), Core_Util_Factory::ENTITY_USER );
			$this->user = $this->user_manager->getUser( $_usr );
		}



		$this->view->analytics  = $this->analytics = array();

	}/*End of init() */










	/**
	 * This function may be used to check some common tasks before rendering requested ressource
	 * @return void
	 */
	public function preDispatch(){
		parent::preDispatch();
		$this->isPost = $this->getRequest()->isPost();
		$this->post =  $this->getRequest()->getPost();
	}/***/


	/**
	 * this function will disable view rendering on its call.
	 * @todo check security features to check where the request is coming from :::
	 */
	protected function ajax(){
		if ( !($this->getRequest()->isXmlHttpRequest() ) ){
			if ( !($this->getRequest()->getQuery('ajx')) )
			throw new Exception('No Ajax request found ');//or return false simply
		}
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}









	/**
	 *@internal this function is needed to disable the default view. in most cases whenever we need to use ajax
	 */
	function disableRender(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}








	/**
	 * This function will be called to initialize sorting parameters on index pages
	 * that have tabular data.
	 * the same thing applyies for index tables that have paged data.
	 */
	public function index(){


		/**Paging variable*/
		$this->view->baseUrl = '/'.$this->mdl.'/'.$this->ctlr.'/index';



		$params = $this->getRequest()->getParams();
		if( array_key_exists( "sort", $params ) ){
			$this->options = array();
			$this->options['sort'] = true;
			if(isset($params['fld'])  && $params['fld']){
				$this->options['field'] = $params['fld'];
			}
			if(isset($params['limit'])  && $params['limit']){
				$this->options['limit'] = $params['limit'];
			}
			if(isset($params['ord'])  && $params['ord']){
				$this->options['orderby'] = $params['ord'];
			}
		}
			
		/*for categories on store/index*/
		if ($params['id'] &&  $params['id'] > 0 && ( $params['controller'] == 'store') ) {
			$this->options['parent'] = $params['id'];
		}
		if ( isset($params['ord']) && strtolower($params['ord']) == 'asc' ) $this->view->order = "desc";
		if ( isset($params['ord']) && strtolower($params['ord']) == 'desc' ) $this->view->order = "asc";

		/**if there is a search query */
		if( $this->view->search_query ){
			$this->options['q'] = $params['q'];
			$this->options['category'] = $params['ctg'];
		}
		/**paging variable */
		$this->per_page = $this->per_page ? $this->per_page :20;
		$this->pg = ( isset($params['pg']) && $params['pg'] > 0 )? $params['pg']: 0 ;/*page */
		$this->view->pg = $this->pg;



	}/*end of index function */




	public function postDispatch(){
		parent::postDispatch();



		#initialization of minimal options for paging object
		$this->options['result_set'] = $this->data;
		$this->options['pg'] = $this->pg ;
		$this->options['per_page'] = $this->per_page;
		$this->paging = new Core_Util_Paging($this->options);
		$this->paging->baseUrl = $this->view->baseUrl;
		$this->view->paging = $this->paging;
		$this->view->data = $this->view->items = $this->paging->getCurrentItems();
		$this->view->paged_links = $this->paging->getPagedLinks();



		//
		if( $this->_object instanceof Core_Entity_Abstract ){
			$this->_object = $this->_object->toArray();
			if( isset($this->_object[0]) && is_array($this->_object[0])  ){
				$this->_object = $this->_object[0];
			}
		}
			

		if( isset($this->_object) && is_array($this->_object) ){
			$this->view->form->populate( $this->_object );
		}

		#checking if we have a message
		if( ( isset($this->view->form) && ( $this->view->form instanceof Core_Form_Base) ) && ($_message = $this->view->form->getMessages()) ){
			$this->view->message = $_message;
		}


		$this->entityToView();
		$this->view->data = $this->data;

	}#end of post dispatch





	protected function _delete_image_files ($image_name,  $options = array ()){
		$file_path = UPLOADS_IMG_PATH;
		if ( $image_name ){
			if ( !$options['l'] ){
				if (file_exists($file_path."/l".$image_name )){
					unlink($file_path."/l".$image_name);
				}
			}
			if ( !$options['m'] ){
				if (file_exists($file_path."/m/".$image_name )){
					unlink($file_path."/m/".$image_name);
				}
			}
			if ( !$options['t'] ){
				if (file_exists($file_path."/t/".$image_name )){
					unlink($file_path."/t/".$image_name);
				}
			}

		}
	}




	/***have not been used as it takes time to figure out**/

	/**
	 * @todo I am not sure if I can use it in a call back
	 * @todo implement this functin in children
	 * @return array
	 */
	function sort_media( $dim_picture_array ){
		$array = usort( $dim_picture_array, array('Rt_Controller_Base','media_sort_callback') );
		return $dim_picture_array;
	}

	/**
	 * @param unknown_type $f
	 * @param unknown_type $s
	 * @return number|unknown
	 */
	static function media_sort_callback($f, $s){
		if ( $f['media_order'] == $s['media_order']) return 0;
		return ( $f['media_order'] < $s['media_order']) ? $f : $s;
	}





	/**
	 * @param $msg
	 * @param $flag
	 */
	function trace ( $msg , $flag = false){
		$tmp_msg = "";
		if ( is_array ( $msg )  ){
			foreach ( $msg as $k => $v ){
				$tmp_msg .= print_r( $v, true);
			}
			$msg = $tmp_msg;
		}
		if (true === $flag )
		var_dump( $msg );
		else
		echo "<pre>".print_r( $msg, true)."</pre>";
	}

	/***
	 * This function will write to logger.txt file.
	* make sure its disabled in production.
	*/
	public function log( $msg ){
		if ( $this->logger ) $this->logger->log ( $msg , Zend_Log::DEBUG );
	}






	/**
	 * Initialization of services
	 */
	private function _services(){

		/**
		 * 
		 * @todo move all functions and links from user service to user manager 
		 * @var unknown_type
		 */
		$this->user_service = Zend_Registry::get("user_service");
		$this->user_manager = Zend_Registry::get("user_manager");
		$this->auth_service = Zend_Registry::get("auth_service");//for authentication
		$this->message_service = Zend_Registry::get("message_service");//sending emails
		$this->analytics_service = Zend_Registry::get("analytics_service");//for authentication
		$this->media_service = Zend_Registry::get("media_service");
		$this->property_manager_service = Zend_Registry::get("property_manager_service");


	}

	/**
	 * Initiazation of entities
	 */
	private function _entities(){

		$this->address = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_ADDRESS);
		$this->auth = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_AUTH);
		$this->auht_log = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_AUTH_LOG);
		$this->landlord = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_LANDLORD);
		$this->lease = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_LEASE);
		$this->media = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_MEDIA);
		$this->property = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_PROPERTY);
		$this->user = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_USER);
		$this->expense = Core_Util_Factory::build( array(), Core_Util_Factory::ENTITY_EXPENSE);

	}




	private function entityToView(){

		if( isset($this->property) ){
			$this->view->property = $this->property;
		}
		if( isset($this->properties) ){
			$this->view->properties = $this->properties;
		}
		if( isset($this->address) ){
			$this->view->address = $this->address;
		}
		if( isset($this->addresses) ){
			$this->view->addresses = $this->addresses;
		}
		if( isset($this->landlord) ){
			$this->view->landlord = $this->landlord;
		}
		if( isset($this->landlords) ){
			$this->view->landlords = $this->landlords;
		}
		if( isset($this->user) ){
			$this->view->user = $this->user;
		}
		if( isset($this->users) ){
			$this->view->users = $this->users;
		}

	}
}

?>
