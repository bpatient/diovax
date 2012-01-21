<?php
    


	/**
	 * 
	 * This form will be used to grab user email, and sends a password reset password 
	 * which will be validated before the user loggs in again  
	 * @author Pascal Maniraho 
	 * @version 1.0.2
	 * @uses Core_Form_Base
	 * @uses Core_Form_Base
	 * 
	 */

	//the form design for the user 	
	class Core_Form_Forgot extends Core_Form_Base{
		
		
		
		function __construct(){
			
			parent::__construct();			
                        $this->email = new Zend_Form_Element_Text('email');
			$this->email->setLabel($this->translate->_(' My E-mail address is: '))->setDecorators($this->elementDecorators)->setRequired(true);

			$this->button = new Zend_Form_Element_Submit('Login');
			$this->button->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setLabel(' Send me a new Password ')->setAttrib('class', 'button greyishBtn submitForm');
			$this->addElements(	array($this->email) );//setting decorators here                        
			
		}
		

		
		
		/*
			all forms has this function that returns the content of the form 
			for persisting the content
		*/ 
		function getObject(){
			$login = new stdClass(); 
				$login->email = $this->email->getValue(); 
			return $login;
		}
		//validation and decorations 
		
	}

?>