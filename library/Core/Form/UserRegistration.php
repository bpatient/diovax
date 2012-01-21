<?php
/**This form will allow the admin to register a new user.  */
class Core_Form_UserRegistration extends Core_Form_Base{
	
		function __construct($options = array('id' => 0), $selectElements = array()){
			parent::__construct();
			$this->id = new Zend_Form_Element_Hidden('id');
			$this->id->setValue($options['id'])->setRequired(true);
			
			$this->name = new Zend_Form_Element_Hidden('name');
			$this->name->setRequired(true);
			
			$this->email = new Zend_Form_Element_Text('email');
			$this->email->setLabel('email')->setRequired(true);
						
			$this->password = new Zend_Form_Element_Text('password');
			$this->password->setLabel('Password')->setRequired(true);
						
			$this->category = new Zend_Form_Element_Select("category");
			$this->category->setLabel("Category ")->addMultiOptions($selectElements)->setDecorators($this->elementDecorators)->setRequired(true);
			
			$this->button = new Zend_Form_Element_Submit('button');			
			$this->button->setLabel('Register')->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');						
			
			
			 
			
		}
		
		//all forms has this function that returns the content of the form 
		//for persisting the content 
		function getObject(){
			return new Core_Model_User(array(
				'id' => $this->id->getValue(),
				'name' => $this->name->getValue(),				
				'email' => $this->email->getValue(),
				'birthday' => $this->password->getValue(),
				'category' => $this->category->getValue(),
				'updated' => date("Y-m-d h:i:s", time())
			));
		}	
//validation and decorations 
}
?>