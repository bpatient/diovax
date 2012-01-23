<?php

class Core_View_Helper_Welcome extends Core_View_Helper_Base{

	
	
	public function welcome($comer = "", $options = array('welcome_class' => '', 'cart' => null ) ){
		

                $_html = '';/**the html container*/
                $switch_view = '';/**variable initialization*/
		$_welcome = '';/**keeps the text to return*/
		$welcome_class = (isset($options['welcome_class']) && !empty($options['welcome_class']) )? trim($options['welcome_class']):'';

		$this->auth = Zend_Auth::getInstance();
		$http = new Zend_View();
		$module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();//will be used to switch views
		$role = ($this->auth->hasIdentity() ) ? $this->auth->getIdentity()->role : 'guest';
		$name = ($this->auth->hasIdentity() )  ? $this->auth->getIdentity()->name : 'guest';

                 if( !$this->auth->hasIdentity() ){
                     $_html .= "<li><a href='/app/auth/signin'>".$this->translate->_('sign_in')."</a></li>";
                     $_html .= "<li><a href='/app/auth/signup'>".$this->translate->_('sign_up')."</a></li>";
                 }else{
                     $_html .= "<li><a href='/app/auth/signout'>".$this->translate->_('sign_out')."</a></li>";
                 }
		if( $role != 'guest' ){
                    $_html .= "<li><a href='/".$role."'>".ucfirst($role)."</a></li>";
                }

                /**search preferences*/
                if( $role == 'guest' ){
                    $_html .= "<li><a href='#' class='tmp-prefs' id='tmp-prefs' onclick='AppPrefs.init(this).run();'>Preferences</a></li>";
                }else{
                    $_html .= "<li><a href='$role/settings' class='prefs' id='prefs' onclick='return false;'>Preferences</a></li>";
                }

               //Account will lead to Account Preferences 
               $account = isset($name) && !empty($name) ? "<a href=".($role != 'guest' ? $role.'/settings/account' : '#' ).">".ucfirst($name)."</a>": "<a href=\'#\'>Account</a>";


            $_html  = '<div class=\'welcome '.$welcome_class.'\'><ul id=\'account\' class=\'account-welcome welcome\'><li>'.$account.'<ul class=\'welcome\'>'.$_html.'</ul></li></ul></div>';
	return $_html;
    }
}
?>