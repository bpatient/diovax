<?php
//this helper loads the layout of the module according the name of the module
class Core_Controller_Action_Helper_LayoutLoader extends Zend_Controller_Action_Helper_Abstract {
	
	public function preDispatch(){
		
            $bootstrap = $this->getActionController()->getInvokeArg('bootstrap');
            $config = $bootstrap->getOptions();
            $module = $this->getRequest()->getModuleName();

           


            if(isset($config[$module]['resources']['layout']['layout']) && $module):
                    $layoutScript = $config[$module]['resources']['layout']['layout'];//
                    $layoutPath = $config[$module]['resources']['layout']['layoutPath'];//
                            $this->getActionController()->getHelper('layout')->setLayoutPath($layoutPath);
                            $this->getActionController()->getHelper('layout')->setLayout($layoutScript);
            else:
                    $this->getActionController()->getHelper('layout')->setLayoutPath($config['resources']['layout']['layoutPath']);
                    $this->getActionController()->getHelper('layout')->setLayout($config['resources']['layout']['layout']);
            endif;
            //throw new Exception( print_r ( $bootstrap , 1) );
	}
	
}
?>