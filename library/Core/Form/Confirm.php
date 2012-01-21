<?php
    /**
	 * @author Pascal Maniraho
	 * @version 1.0.2
	 * @todo should have a description on top, and a link to cancel, just in case the connected guy is not our guy 
	 */
	class Core_Form_Confirm extends Core_Form_Base{




            public function __construct(){

                    parent::__construct();
  					$this->id = new Zend_Form_Element_Hidden('id');
                    $this->removeHiddenDecorators($this->id);
                    $this->user_id = new Zend_Form_Element_Hidden('user_id');
                    $this->removeHiddenDecorators($this->user_id);
                    $this->token = new Zend_Form_Element_Hidden('token');
                    $this->removeHiddenDecorators($this->token);
                    $this->service = new Zend_Form_Element_Hidden('service');
                    $this->removeHiddenDecorators($this->service);
                    $this->key = new Zend_Form_Element_Hidden('key');
                    $this->removeHiddenDecorators($this->key);
                    $this->ip = new Zend_Form_Element_Hidden('ip');
                    $this->removeHiddenDecorators($this->ip);
                     
                    
                    $strlenValidator = new Zend_Validate_StringLength(6, 20);
                    $this->value = new Zend_Form_Element_Password("value");
                    $this->value->setAttribs(array("class" => "text"))->setLabel("Choose a Password")
	                    ->addValidator($strlenValidator, false ,array('messages' => array('shortPassword' => 'The password should be from 6-20 long')))
	                    ->setRequired(true)->setDecorators($this->elementDecorators)->setRequired(true);

                    $this->password = new Zend_Form_Element_Password("password");
                    $this->password->setAttribs(array("class" => "text"))->setLabel("Confirm Password")->setDecorators($this->elementDecorators)->setRequired(true);

                    $this->save = new Zend_Form_Element_Submit( "Save" );
                    $this->save->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setValue("save")->setAttrib('class', 'button greyishBtn submitForm');
                    
                    if( isset($_POST['value']) ){
                    	$identicalValidator = new Zend_Validate_Identical($_POST['value']);//I used $_POST as this->_request was not working
                    	$identicalValidator->setMessages(array('notSame' => 'Value doesn\'t match!','missingToken' => 'Value doesn\'t match!'));
                    	$this->password->addValidator($identicalValidator);
                    }
                    
            
            }

		public function getObject(){
			
			
			$_array = array(
                        'id' => (int)$this->id->getValue(),
                        'user_id' => (int)$this->user_id->getValue(),
                        'service' => $this->service->getValue(),
                        'key' => $this->key->getValue(),
						'value' => (int)$this->value->getValue()
                    );
			$_object  = Core_Util_Factory::build($_array, Core_Util_Factory::ENTITY_AUTH);
			 return $_object;
		}/*validation and decorations*/

	}
?>