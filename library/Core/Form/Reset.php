<?php
    


	/**
	 * This form will be used to reset the password. 
	 * It has 3 fields, the first is for reset key[ This is optional, and is only displayed if the user 
	 * requested a reset key ] 
	 * 
	 * 
	 * in the case of only resetting a password, we will want to know the ancient password, 
	 * and the new password as well. 
	 *  
	 *  and new password and confirmation 
	 *  
	 *  
	 *  
	 * 
	 * @author Pascal Maniraho 
	 * @version 1.0.2
	 * @uses Core_Form_Base
	 * @uses Core_Form_Base
	 * 
	 */

	//the form design for the user 	
	class Core_Form_Reset extends Core_Form_Base{
		
		
		
		function __construct(){
			
			parent::__construct();
			
			
			
			
			$this->id = new Zend_Form_Element_Hidden('id');
			$this->id->setValue($options['id']);$this->removeHiddenDecorators($this->id);
			
			
			$this->old = new Zend_Form_Element_Password('old');
			$this->old->setLabel('Old Password')->setDecorators($this->elementDecorators)->setRequired(true);
			
			$this->password = new Zend_Form_Element_Password('password');
			$this->password->setLabel('New Password')->setDecorators($this->elementDecorators)->setRequired(true);
			
			$this->confirm = new Zend_Form_Element_Password('confirm');
			$this->confirm->setLabel('Confirm Password')->setDecorators($this->elementDecorators)->setRequired(true);
			
			$this->button = new Zend_Form_Element_Submit('Change Password');
			$this->button->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');			
			$this->addElements(	array($this->old,$this->password,$this->confirm));//setting decorators here 
			
		}
		

		
		
		/*
			all forms has this function that returns the content of the form 
			for persisting the content
		*/ 
		function getObject(){
			$login = new stdClass(); 
				$login->id = $this->id->getValue(); 
				$login->old = $this->old->getValue(); 
				$login->password = $this->password->getValue(); 
				$login->confirm = $this->confirm->getValue(); 
			return $login;
		}
		//validation and decorations 
		
	}

?>