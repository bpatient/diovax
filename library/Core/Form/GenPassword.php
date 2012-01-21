<?php



	/**
	 *
	 * This form will be used to create a password for a new costumer using admin panel
	 * Before we re-used Core_Form_Forgot but in this case is better to user a new one
	 * @author Pascal Maniraho
	 * @version 1.0.0
	 * @uses Core_Form_Base
	 *
	 */

	//the form design for the user
	class Core_Form_GenPassword extends Core_Form_Base{



		function __construct(){

			parent::__construct();
            $this->password = new Zend_Form_Element_Text('password');
			$this->password->setLabel('password')->setDecorators($this->elementDecorators)->setRequired(true);

			$this->button = new Zend_Form_Element_Submit('Login');
			$this->button->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');
			$this->addElements(	array($this->password) );//setting decorators here

		}




		/*
			all forms has this function that returns the content of the form
			for persisting the content
		*/
		function getObject(){
			$login = new stdClass();
			$login->password = $this->password->getValue();
			return $login;
		}
		//validation and decorations

	}

?>