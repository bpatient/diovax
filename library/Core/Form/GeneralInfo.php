<?php
    
	//the form design for the user 	
	class Core_Form_GeneralInfo extends Core_Form_Base{
		
		
		
		function __construct($options = array('user_id' => 0)){

			parent::__construct();
			$this->user_id = new Zend_Form_Element_Hidden('user_id');
			$this->user_id->setValue($options['user_id']);
			$this->removeHiddenDecorators($this->user_id);
			
			$this->profile_id = new Zend_Form_Element_Hidden('profile_id');
			$this->profile_id->setValue($options['profile_id']);
			$this->removeHiddenDecorators($this->profile_id);
			
			
			$this->auth_id = new Zend_Form_Element_Hidden('auth_id');
			$this->auth_id->setValue($options['auth_id']);
			$this->removeHiddenDecorators($this->auth_id);
			
			$this->name = new Zend_Form_Element_Text('name');
			$this->name->setLabel( ' Name ')
						->addValidator(new Zend_Validate_NotEmpty()) 
						->setDecorators($this->elementDecorators)
						->setRequired(true);
						
			$this->birthday = new Zend_Form_Element_Text('birthday');
			$this->birthday->setRequired(true)->setDecorators($this->elementDecorators)->setLabel('Birthday');
			
			$this->email = new Zend_Form_Element_Text('email');
			$this->email->setLabel( ' Email ')
						->setDecorators($this->elementDecorators)
						->addValidator(new Zend_Validate_NotEmpty()) 
			         	->addValidator('EmailAddress') 
			         	->addFilter('StringToLower')
			         	->setRequired(true);
         	/*
				$this->old_password = new Zend_Form_Element_Password('old_password');
				$this->old_password->setLabel('Old Password')->setDecorators($this->elementDecorators);
			*/
			$this->password = new Zend_Form_Element_Password('password');
			$this->password->setLabel('New Password')->setDecorators($this->elementDecorators);
			
			$this->description = new Zend_Form_Element_Textarea('description');
			$this->description->setAttrib('rows', '8')->setLabel('Description')->setDecorators($this->smallTextAreaDecorators);

			
			
			
			
			$label = 'Save';
			if ( $this->user_id->getValue() > 0 )
				$label = ' Update ';
			$this->button = new Zend_Form_Element_Submit('button');			
			$this->button->setLabel( $label )->setDecorators( $this->buttonDecorators )->setAttrib('class', 'button greyishBtn submitForm');						
			
			
			
			
			$this->addElements(
				array(
					$this->user_id, 
					$this->name, 
					$this->birthday,
					$this->email,  
					//$this->old_password,
					$this->password, 
					$this->button
				)
			);//setting decorators here 
		}
		
		
		
			/***
		 * this function will be used to get data from this the form above\
		 * and return it as key::value pair 
		 */
		public function getData(){
			return array(
				'user_id' => $this->user_id->getValue(),
				'name' => $this->name->getValue(),				
				'birthday' => $this->birthday->getValue(),				
				'email' => $this->email->getValue(),				
				//'old_password' => $this->old_password->getValue(),
				'password' => $this->password->getValue(),
				'description' => $this->description->getValue(),
			);
		}

		
		
		
		
		/**
		 */
		public function mapToObject(){
			return null;//wont be implemented as we have many objects 
		}
		
		
}//
?>