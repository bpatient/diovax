<?php
/**
 * This helper will be used in all helper to help access translate
 * @todo make the cart in the session accessed from this helper. it will allow us to access the object from anywehre in the application
 */
class Core_View_Helper_Base extends Zend_View_Helper_Abstract {
    protected  $translate;
    /**
     * allows to access the cart with minimal cost. there is no need to change things in layout files 
     * @var unknown_type
     */
    protected $cart; /**this cart may be used to store houses the user chose to */
    protected $module, $controller, $request, $router;



	public function  __construct(){



        $this->request = Zend_Controller_Front::getInstance()->getRequest();
        $this->router = Zend_Controller_Front::getInstance()->getRouter();
        /****/
        $this->module = $this->request->getModuleName();
        $this->controller = $this->request->getControllerName();
                
      if( !($this->translate = Zend_Registry::get('language'))){
        try{
                $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
                $config = $config->system->translation;
                $this->translate = new Zend_Translate( $config->adapter, $config->path,  $config->language);
            }catch (Exception $e ){
                throw  new Exception("Translation Object init fails at " .__CLASS__." :: " .__METHOD__."::" .__LINE__." ", "1000" );
            }
        }
        
      
   
    }
    
}
?>
