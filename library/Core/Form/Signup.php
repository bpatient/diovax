<?php

//the form design for the user
class Core_Form_Signup extends Core_Form_Base{





	private $_categories;
	public function __construct(){


		parent::__construct();
		$this->_categories = array ( 'customer' => "Tenant",  'agent' => "Mortagage Agent",  'tech' => "Handyman",  'landlord' => "Landlord" );
		$this->id = new Zend_Form_Element_Hidden('id');
		$this->removeHiddenDecorators($this->id);

		$this->token = new Zend_Form_Element_Hidden('token');
		$this->removeHiddenDecorators($this->token);
		
		
		$this->name = new Zend_Form_Element_Text('name');
		$this->name->setLabel( "Full name" )
			->setDecorators($this->elementDecorators)->setAttribs(array("class" => "text"))->setRequired(true);
		
		$this->email = new Zend_Form_Element_Text('email');
		$this->email->setAttribs(array("class" => "text"))->setLabel($this->translate->_('email'))->setDecorators($this->elementDecorators)->setRequired(true)->addValidator(new Zend_Validate_EmailAddress());
		
		$this->button = new Zend_Form_Element_Submit('button');
		$this->button->setLabel($this->translate->_('signup'))->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');
			
		$this->removeDecorator('label');
		$this->removeDecorator('tag');
			
	}


	public function getObject(){
		return new Core_Entity_User(
		array(
				'id' => (int)$this->id->getValue(),
				'name' => $this->name->getValue(),				
				'email' => $this->email->getValue(),
				'category' => 'admin',
			    'token' => (string)$this->token->getValue()
		));
	}

}
?>

<?php 

/**	$this->password = new Zend_Form_Element_Password('password');
		$this->password->setLabel($this->translate->_('password'))->setDecorators($this->elementDecorators)->setRequired(true);

		//identical field validator with custom messages. Thanks to stakoverflow I got this comparison working

		$strlenValidator = new Zend_Validate_StringLength(6, 20);

		$this->passwordv = new Zend_Form_Element_Password('passwordv');
		$this->passwordv->setLabel($this->translate->_('confirm_password') )
		->setDecorators($this->elementDecorators)
		->addValidator($strlenValidator, false ,array('messages' => array('shortPassword' => 'The password should be from 6-20 long')))
		->setRequired(true);

		if( isset($_POST['password']) ){
			$identicalValidator = new Zend_Validate_Identical($_POST['password']);//I used $_POST as this->_request was not working
			$identicalValidator->setMessages(array('notSame' => 'Value doesn\'t match!','missingToken' => 'Value doesn\'t match!'));
			$this->passwordv->addValidator($identicalValidator);
		}
**/
?>