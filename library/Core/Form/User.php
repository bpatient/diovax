<?php
    


	/**
	 * Since this form is for one kind of Object, its good to pass in an object, 
	 * and have a method getObject() method to retrieve it from the form. 
	 * It d be better if we move to code to the Base.  therefore reduce attachment to this form 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * Register Form can allow the user to register from the from end.
	 * there is no reason to keep similar forms 
	 * 
	 * 
	 * 
	 * this User from willbe used by the administrator to register quickly a new user. 
	 * details will be added to profile page of the user. 
	 * After saving a new user, this form should redirect to profile and adding more values 
	 * 
	 * 
	 * 
	 * such as generating a email, adding more authentication methods,... 
	 * 
	 * 
	 * 
	 * 
	 */		

	//the form design for the user 	
	class Core_Form_User extends Core_Form_Base{
		
		
		function __construct($options = array('id' => 0), $selectElements = array( 'admin' => "Administrator",  'customer' => "Customer", 'tmp' => "Temporaly", 'other' => "Other")){
			parent::__construct();
			$this->id = new Zend_Form_Element_Hidden('id');
			$this->id->setValue($options['id']);
			
			$this->name = new Zend_Form_Element_Text('name');
			$this->name->setDecorators($this->elementDecorators)->setLabel('Full Name ');
			$this->name->setRequired(true);
			
			$this->email = new Zend_Form_Element_Text('email');
			$this->email->setRequired(true)->setDecorators($this->smallTextAreaDecorators)->setLabel('Primary Email');
						
			$this->birthday = new Zend_Form_Element_Text('birthday');
			$this->birthday->setRequired(true)->setDecorators($this->elementDecorators)->setLabel('Birthday')->setRequired(true);
						
			$this->category = new Zend_Form_Element_Select("category");
			$this->category->setLabel("Category ")->addMultiOptions($selectElements)->setDecorators($this->elementDecorators)->setRequired(true);
			
			$this->button = new Zend_Form_Element_Submit('button');			
			$this->button->setLabel('Register')->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');						
			
			
			
			
		}
		

		
		
		
		
		function getObject(){
			return new Core_Model_User(array(
				'id' => $this->id->getValue(),
				'name' => $this->name->getValue(),				
				'email' => $this->email->getValue(),
				'birthday' => $this->birthday->getValue(),
				'category' => $this->category->getValue(),
				'active' => true,
				'banned' => false,
				'modified' => date("Y-m-d h:i:s", time())
			));
		}	
		
		
		//validation and decorations 
		
	}

?>