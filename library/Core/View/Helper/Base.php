<?php

class Core_View_Helper_Base extends Zend_View_Helper_Abstract {
    protected  $translate;
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
