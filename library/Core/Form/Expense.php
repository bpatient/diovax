<?php
/**
 * @author  Pascal Maniraho
 */
class Core_Form_Expense extends Core_Form_Base{



	function __construct($options = array( 'isText' => false ), $selectElements = array()){
			
		parent::__construct();
		$this->id = new Zend_Form_Element_Hidden('id');
		$this->removeHiddenDecorators($this->id);


		$this->user_id = new Zend_Form_Element_Hidden('user_id');
		$this->removeHiddenDecorators($this->user_id);

		$this->oldpassword = new Zend_Form_Element_Password('oldpassword');
		$this->oldpassword->setLabel('Old Password')->setRequired(true)->setDecorators($this->elementDecorators);
			
		$this->newpassword = new Zend_Form_Element_Password("newpassword");
		$this->newpassword->setLabel("New Password ")->setDecorators($this->elementDecorators)->setRequired(true);

		$this->password = new Zend_Form_Element_Password('password');
		$this->password->setRequired(true)->setDecorators($this->smallTextAreaDecorators)->setLabel('Confirm Password')->setRequired(true);

			

		$this->button = new Zend_Form_Element_Submit('button');
		$this->button->setLabel(" Save ")->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');


		 


	}

	/**returning the object */
	public function getObject(){
		$_data = array(
                            'id' => $this->id->getValue(),
                            'user_id' => $this->user_id->getValue(),
                            'oldpassword' => $this->oldpassword->getValue(),
                            'newpassword' => $this->newpassword->getValue(),
                            'password' => $this->password->getValue()
		);
		 



		return Core_Util_Factory::build(
			$_data,  Core_Util_Factory::ENTITY_EXPENSE
		);


	}


}




?>