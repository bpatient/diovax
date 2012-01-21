<?php
/**
 * This class manages user registration and authentication registration done here will redirect to customer home
 * 
 * @author Pascal Maniraho
 * @todo review authentication process, especially storing email/password pairs in a lookup
 * @todo remove app/ as defautl module
 */
class AuthController extends Core_Controller_Base{

    
    public function init()
    {
        parent::init();
        $this->user_lookup = $this->user_manager->getUserLookup();
        $this->auth = Zend_Auth::getInstance();
        $this->url = ( ($_url = $this->getRequest()->getParam("url")) )? $_url : "/app/auth/signin";
        
        $_action = $this->getRequest()->getParam("action");
        if( $_action == "confirm" ){
        	if( strlen($this->getRequest()->getParam("token")) > 0 && strlen( $this->getRequest()->getParam("from") ) > 0  ){ 
        		$this->user = $this->user_manager->getUserForVerification( new Core_Entity_User( array ( "token" => $this->getRequest()->getParam("token"), "email" =>  $this->getRequest()->getParam("from") )  ));
        		$this->_object = $this->user_manager->getAuth( new Core_Entity_Auth( array( "user_id" => $this->user->id, "service" => "system", "key" => "password" ) ));
        	}else{
        		$this->user = new Core_Entity_User();
        	}
        }else if( $_action == "signin" ){
        	
        }
    }


    public function preDiparch(){
          parent::preDispatch();          
    }


	/***
	 * Decides where to send the user to, if logged in, forward to
         * @return void
	 */
    	public function indexAction(){
            if( $this->auth->getIdentity()->user_id > 0 ){
                    if( $this->auth->getIdentity()->role != "guest" ){
                        $this->_redirect( $this->auth->getIdentity()->role."/index" );
                    }
                }
            $this->_redirect("app/auth/signin");
        }

        

     public function signinAction(){

            parent::index();
            $this->view->form  = new Core_Form_Signin();
            $this->view->form->login->setAttrib('class', 'button');
            
          /**
           * This view variable will not be used anymore. we have loginIssue already registered with the view object
           */
          if($this->isPost ){

            if( !$this->view->form->isValid( $this->post )  )
                $this->_redirect( $this->url );

           //email and passoword 
           $email = $this->view->form->getObject()->email;
           $password = $this->view->form->getObject()->password;
             
           $adapter = new Core_Auth_Adapter_Database($email, $password, $this->user_lookup);
          
           
              try{
                    
                    $result = $this->auth->authenticate($adapter);
                    
                    #verifiying authenticity
                    if($result->isValid() ){
                        $this->url = "/app/site/";
                        if( $this->auth->getIdentity()->role != "guest" )
                            $this->url = ( $this->auth->getIdentity()->role == "artist" ? "artist" : "site") ."/index";
                    }

                    #this section is not used here, but can be used to update database status
                    $options = array();
                    $options['user_id'] = $this->auth->getIdentity()->user_id;
                    $options['sessionid'] = Zend_Session::getId();
                    $options['auth_id'] = $this->auth->getIdentity()->auth_id;
                    
                    #should be at least set connected 
                    #activating the user
                    $this->auth_service->setActive( $this->auth->getIdentity()->auth_id );
                   

                 }catch ( Exception $e ){
                    if ( $e->getMessage() == Core_Auth_Adapter_Database::AUTH_FAILS)
                            $this->view->message = "Please enter valid email and password ";
                    if ( $e->getMessage() == Core_Auth_Adapter_Database::EMPTY_LOOKUP)
                            $this->view->message = "System Error. ";
                    if ( $e->getMessage() == Core_Auth_Adapter_Database::NOT_ACTIVE)
                            $this->view->message = "Your account is not activated. See your e-mail for more instructions";
                            $this->view->error = "notice";
                    $this->url = "/app/site/index";//we return in the same place 
                }



          }
            /**I dont think that this line is useful**/
            if( $this->isPost && ($message = $this->view->form->getMessages() ) )
                $this->view->message = $message;
            
            #$this->_redirect( $this->url );

        }


        
    /**
     * @todo refactor to use user_manager instead of user_service 
     * @todo use auth dao, and user dao, to edit from UserManager 
     * @todo should be sent to email, the user provided, therefore verify if email really exists 
     * @todo change add edit auth, to this registration page 
     * 
     */    
	public function signupAction(){
		
            $this->view->form = new Core_Form_Signup();
            //checking if there is no other user with the same email
            if( true === $this->isPost ){
                    if( !$this->view->form->isValid($this->post) ){
                            $this->view->form->populate( $this->post );
                            $this->view->message = $this->view->form->getMessages();
                       return 1;
               }
            }
            
            //
            if ( $this->isPost ){
            	$this->post['password'] = Core_Util_Password::generate();
                     $user = $this->user_service->getUserByemail($this->view->form->getObject()->email );
                    if ( false === $user  && $this->view->form->isValid($this->post) ){
                        $user = $this->user_manager->editUser( $this->view->form->getObject() );
                        if( $user->id > 0 && strlen($user->token) ){
                        	$_edit_auth = array ( 
                        		"id" => 0,"user_id" => $user->id,
                        	     "service" => "system", "key" => 'password',
                        	     "value" => $this->post['password'], "modified" => date("Y-m-d H:i:s", time() ),
                        	      "active_time" => 0, "active" => 0 );
                        	$_tauth = Core_Util_Factory::build( $_edit_auth , Core_Util_Factory::ENTITY_AUTH);
                        	$this->user_manager->editAuth( $_tauth );
                        }
                    	$url = $this->config->system->app->base->url;
                    	$email = $this->view->form->email->getValue();
                    	$this->message_service->confirm($user->email, array('email'=>$user->email,'name'=>$user->name,'object'=>'Account confirmation message. ', 'link'=>'<a href="'.$url.'/app/auth/confirm?from='.$this->post['email'].'&token='.$user->token.'">Activate my account</a> your Password is <b>'.$this->post['password'].'</b>'));
                    	//$this->message_service->confirm($this->view->form->email->getValue(), array('email'=>$email,'name'=>$this->view->form->name->getValue(),'object'=>'Account confirmation message. ', 'link'=>'<a href="'.$url.'/app/auth/confirm?from='.$email.'&token='.$user->token.'">Activate my account</a> your Password is <b>'.$this->post['password'].'</b>'));
                        $this->user_lookup = $this->user_manager->getUserLookup();//renew the list of registered right now
                        $this->view->message = "Your Password is sent to your account, and you can change it anytime.";
                        $this->view->error = "success";
                        $this->view->form = "";
                    }else{
                        $this->view->message = "The Email you are trying to use is not available";
                    }
            }
    }



        /**
         * This function will activate a user
         * @todo allows users to confirm and login at the same time 
         * @todo auth object should be initialized here, and login the user, if save succedes 
         * @todo this section needs a form for authentication that is slightly different from signin
         * @todo check if the user sent the tocken and token corresponds to email 
         */
         public function confirmAction(){
         	$this->view->form = new Core_Form_Confirm();
         	$this->view->form->token->setValue($this->user->token);
         	$this->view->error = "error";
         	
            if(   !empty($this->user) && false !== $this->user && $this->user->active == 1 ){
                $this->view->message = "User already activated!";
                $this->view->error = "notice";
            }else if ( false !== $this->user){
            	
            	 	if( $this->isPost ){
            	          if( $this->view->form->isValid($this->post) ){
            	            	
            	 			if( !( trim($this->_object->value) == md5( trim($this->view->form->password->getValue()) ) ) ){
            	 				$this->view->message = "Please copy password sent to your email, as it was sent";
            	 				return;//
            	 			}
            	 			
            	 			$this->user->active = 1;//
            	 			$res = $this->user_manager->editAuth( $auth = $this->view->form->getObject() );
            	 			$this->user_manager->activateUser($this->user);
            	 			if( $res ){
            	 				try{ 
            	 					print_r( $this->post );
            	 					$message = "Congratulations, your account has been activated successfully.";
            	 					$this->message_service->register( $this->user->email, array('email'=> $this->user->email,'name'=>$this->user->name,  'object'=>$message, 'message'=> "Thanks, we will make sure you enjoy our services." ));
            	 					$this->view->message = "Congratulations, Your account has been activated.";
            	 					$this->view->error = "notice";
            	 				}catch(Exception $e ){
            	 					$this->view->message = "Error Happened :: " . $e->getMessage() ;
            	 					$this->view->error = "notice";
            	 				}
            	 			}
            	 		}else{
            	 			$this->view->message = $this->view->form->getMessages();
            	 		}
            	 	}
            	  
            }else{
                $this->view->message = "User not found !";
            }
            
            if( $this->user->active == 1 ){
            	$this->view->message = "Your account is already active";
            }
            
        }// end function confirmAction



	/**
	 * @todo implement this function and corresponding DAO
	 */
	public function forgotAction(){
		$this->view->form = new Core_Form_Forgot();
		/**check if it valid before going anyhwere*/
		if ( $this->isPost && !$this->view->form->isValid($this->post) ){
			$this->view->message = $this->view->form->getMessages();
			return false;
		}
		/**double check is not required*/
		if ( $this->isPost && $this->view->form->isValid($this->post) ){
			//check if there is such a email in the database, if yes send an email and return back to
			//notify a user that an email with key has been sent
			$npassword = Core_Util_Password::generate();
			$user = $this->user_service->getUserByemail($this->post['email']);
            if ( false === $user ){
				$this->view->message = "The email address is not recognized";
               }else{
                    try{
                            /**Zend_Auth::isValid
                             * 1. get the user id, and goto auth table, change key[ = password] ' value to generated one,
                             * 2. set the timer, the time from now to the end
                             * 3. if the user logs in, check if there is a timer set, and urge him/her to change the password
                             * 4. after changing the password, reset the timer back to 0.
                             */
                            $this->user_service->editPassword(array("user_id" => $user->id,"password" => $npassword));
                            $this->message_service->password( array( 'email' => $this->post['email'], 'email' =>  $this->post['email'], 'name' => $user->name ) , $npassword, true );
                            $this->view->message = "A new password has been sent to your email.";
                            $this->view->error = "success";
                            }catch ( Exception $e ){
                                    $this->view->message = "Implementation Exception ".$e->getMessage();
                            }
                    }
		}
        }

	/***
	 * resetting password
	 */
	public function resetAction(){
		//check if the user is logged in before allowing him/her to reset the password
                //this is done from the index controller 
		$this->view->form = new Core_Form_Reset();
		if ( $this->auth->hasIdentity() && $this->auth->getIdentity()->user_id > 0 ){
			$this->view->form->getElement('id')->setValue($this->auth->getIdentity()->user_id);//
			$post = $this->getRequest()->getPost(); //
			if ( $this->getRequest()->isPost() && $this->view->form->isValid($this->post) ){
                            $this->user_service->editPassword(array("user_id" => $this->auth->getIdentity()->user_id,"password" => $this->post["password"],"" => ""));
                            $this->_redirect('customer/profile/index');
			}
		}else{
			$this->view->message = "Please logout before you reset your password.";
		}
	}//


        /**
         * This function cleans the identity 
         */
	public function signoutAction(){
	    $this->session->initialized = false;
		$this->auth_service->resetActive($this->auth->getIdentity()->auth_id);
		$this->auth->clearIdentity();
		$this->_redirect('app/site/index');
		
	}



	
	
	public function postDispatch(){
		parent::postDispatch();
	}



	
}
?>