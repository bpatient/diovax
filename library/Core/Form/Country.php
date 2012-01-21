<?php
    /**
	 * 
	 * @author Pascal Maniraho 
	 * @version 1.0.2
	 * @uses Core_Form_Base
	 * 
	 */
	class Core_Form_Country extends Core_Form_Base{
		
		
		public function __construct( $options = array ( 'id' => 0 ) ){
			
			parent::__construct();
						
			$this->id = new Zend_Form_Element_Hidden('id');
			$this->id->setValue($options['id']);
			$this->removeHiddenDecorators($this->id);
			
			$this->name = new Zend_Form_Element_Text('name');
			$this->name->setLabel('Name')->setDecorators($this->elementDecorators)->setRequired(true);
									
			$this->code = new Zend_Form_Element_Text('code');
			$this->code->setLabel('Code ')
				->setDecorators($this->elementDecorators)
				->setAttrib('maxlength',3)
				->setRequired(true)
				->addValidator('Alpha');						
			$label = ( $this->getElement('id')->getValue() > 0 )? 'Save': 'Update'; 
			
			$this->button = new Zend_Form_Element_Submit( $label );
			$this->button->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');
			
			$this->addElements(	array($this->id,$this->name,$this->code ));//setting decorators here 
		}
		
		
		
		/**
		 * 
		 */
		public function getObject(){
			return new Core_Model_Country(
				array( 'id' => $this->id->getValue(),'name' => $this->name->getValue(),'code' => $this->code->getValue(), 'active' => true )
			); 
		}
		//validation and decorations 
		
	}

?>