<?php

class Core_View_Helper_Welcome extends Core_View_Helper_Base{





	public function welcome( Core_Entity_User $user , $options = array('welcome_class' => '' ) ){
			//
		
		
		$this->user = $user;
		$this->auth = Zend_Auth::getInstance();
		$this->identity = $this->auth->hasIdentity() ? $this->auth->getIdentity() : null; 


		$_html = '';
		$switch_view = '';
		$_welcome = '';
		$welcome_class = (isset($options['welcome_class']) && !empty($options['welcome_class']) )? trim($options['welcome_class']):'';

		
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
		if( $this->auth->hasIdentity() && $role != 'guest' ){
			$_html .= "<li><a href='/".$role."'>".ucfirst($role)."</a></li>";
		}

		/**search preferences*/
		if( !$this->auth->hasIdentity() || $role == 'guest' ){
			$_html .= "<li><a href='#' class='tmp-prefs' id='tmp-prefs' onclick='AppPrefs.init(this).run();'>Preferences</a></li>";
		}else{
			$_html .= "<li><a href='$role/settings' class='prefs' id='prefs' onclick='return false;'>Preferences</a></li>";
		}

		//Account will lead to Account Preferences
		$account = isset($name) && !empty($name) ? "<a href=".($role != 'guest' ? $role.'/settings/account' : '#' ).">".ucfirst($name)."</a>": "<a href=\'#\'>Account</a>";
		$_html = ""; 
		if( $this->auth->hasIdentity() ){
			$_html .= "<div class='welcome'>
								<a href='". ( $this->identity != null && $this->identity->role && $this->identity->role != "guest" ? $this->identity->role : "#" )."' title=''><img src='/assets/images/userPic.png' alt='' />
								</a><span>". ( $this->user->name ? $this->user->name : "Guest!" )."</span>
							</div>";
			
				
		}
		
		$_html .= "<div class='userNav'>";
			$_html .= "<ul>";
			
			
			$_html .= "<li>
						".( $this->identity != null && $this->identity->role && $this->identity->role != "guest" ?  "<a href='/".($this->identity->role)."/settings/account' title=''><img src='/assets/icons/topnav/profile.png' alt='' /><span>Profile</span></a>" : "" ). " 
					  </li>";
	
				$_html .= "
					<li>
						".( $this->identity != null && $this->identity->role && $this->identity->role != "guest" ?  "<a href='/".($this->identity->role)."/settings/index' title=''><img src='/assets/icons/topnav/settings.png' alt='' /><span>Settings</span></a>" : "" ). " 
					</li>";
				
				
				
				if(  $this->identity != null && $this->identity->user_id && $this->identity->user_id > 0   ){
					$_html .= "<li><a href='/app/auth/signout' title=''><img src='/assets/icons/topnav/logout.png' alt='' /><span>Logout</span></a></li>";
				}else{
					$_html .= "<li><a href='/app/auth/index' title=''><img src='/assets/icons/topnav/logout.png' alt='' /><span>Signin</span></a></li>";
					$_html .= "<li><a href='/app/auth/signup' title=''><img src='/assets/icons/topnav/logout.png' alt='' /><span>Signup</span></a></li>";
				}
				
				$_html .= "
						</ul>
					</div>"; 
		return $_html;
		
		
		
	


	


}

}
?>