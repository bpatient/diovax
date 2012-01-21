<?php

	/**
	 * This will be used to load translation files and change locale 
	 */
	class Core_Controller_Plugin_LanguageSwitcher extends Zend_Controller_Plugin_Abstract{
		
		/*the constructor initiates roles and ressources and assigns roles to ressources*/ 
		public function __construct(Zend_Auth $auth){
				
		}
		
		/*this function will help to detect if there is a request to suggesting to change the language*/ 
		public function preDispatch(Zend_Controller_Request_Abstract $request){
				
		}
	}
?>