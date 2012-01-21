<?php
	/**
	 * 
	 * This class holds the classic authentication form.
	 * It is a good Idea to pass in an object to initialize the form to whatever sent variable 
	 * 
	 * @author Pascal Maniraho 
	 * @version 1.0.2
	 * @uses Core_Form_Base
	 * @uses Core_Form_Base
	 */
	//the form design for the user 	
	class Core_Form_Signin extends Core_Form_Base{
		
		
		public function __construct(){
			parent::__construct();
			$this->email = new Zend_Form_Element_Text('email');
			$this->email->setLabel($this->translate->_('email'))->setDecorators($this->elementDecorators)
				->addErrorMessages( array( 'isEmpty' => ' is empty ' ) )
				->setRequired(true);
									
			$this->password = new Zend_Form_Element_Password('password');
			$this->password->setLabel($this->translate->_('password'))->setDecorators($this->elementDecorators)
                                ->addErrorMessages( array( 'isEmpty' => ' is empty ' ) )
				->setRequired(true);;
			
			$this->login = new Zend_Form_Element_Submit('Login');
			$this->login->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setLabel($this->translate->_('signin') )->setAttrib('class', 'button greyishBtn submitForm');
			$this->addElements(	array($this->email,$this->password ));//setting decorators here 
		}
		
		/**
		 * all forms has this function that returns the content of the form	for persisting the content
		 */ 
		function getObject(){
			$login = new stdClass(); 
				$login->email = $this->email->getValue(); 
				$login->password = $this->password->getValue(); 
			return $login;
		}
		//validation and decorations 
	}
?>