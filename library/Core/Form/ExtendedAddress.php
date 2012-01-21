<?php


	/**
	 * 
	 * 
	 * 
	 * 
	 * This form will be used for phone addresses, and extended addresses.
	 * in both cases we will be using the same form. 
	 * for this reason isText flag has to be set if we need to get a text area, else we will be displaying 
	 * an input field 
	 * 
	 * 
	 * 
	 * The address_type is filled with<?php
 categories in which this address should classified
	 * the address_key is pre-set [ this should be telephone, street-city-postal-address string ] 
	 * 
	 * 
	 * 
	 * and for extended address string the isText has to be set.  
	 * 
	 * @author Pascal Maniraho
	 * @uses 
	 * @version 
	 * 
	 */


	class Core_Form_ExtendedAddress extends Core_Form_Base{
		
		
		private $label;//set it to the value of address_key  
		private $elements = array ("default"=>"Default", "billing" => "billing", "shipping" => "Shipping");
		function __construct($options = array('id' => 0,'user_id' => 0)){
			
			parent::__construct();
			
			$this->id = new Zend_Form_Element_Hidden('id');
			$this->id->setValue($options['id']);
			$this->removeHiddenDecorators($this->id);
			
			$this->user_id = new Zend_Form_Element_Hidden('user_id');
			$this->user_id->setValue($options['user_id']);
			$this->removeHiddenDecorators($this->user_id);
			
			
			if(isset($options['address_key']) && is_array($options['address_key'])) $this->elements = $options['address_key'];
			$this->address_key = new Zend_Form_Element_Select("address_key");
			$this->address_key->setLabel("Category")->addMultiOptions($this->elements)->setDecorators($this->elementDecorators)->setRequired(true);
			
			
			$this->name = new Zend_Form_Element_Text('name');
				$this->name->setLabel('Full Name ')->setDecorators($this->elementDecorators);
			$this->street = new Zend_Form_Element_Text('street');
				$this->street->setLabel('Street')->setDecorators($this->elementDecorators);
			$this->city = new Zend_Form_Element_Text('city');
				$this->city->setLabel('City')->setDecorators($this->elementDecorators);
			$this->country = new Zend_Form_Element_Text('country');
				$this->country->setLabel('Country')->setDecorators($this->elementDecorators);
			$this->prs = new Zend_Form_Element_Text('prs');
				$this->prs->setLabel('Province/State/Region')->setDecorators($this->elementDecorators);
			$this->postal = new Zend_Form_Element_Text('postal');
				$this->postal->setLabel('Zip/Postal Code')->setDecorators($this->elementDecorators);
			$this->telephone = new Zend_Form_Element_Text('telephone');
				$this->telephone->setLabel('Telephone')->setDecorators($this->elementDecorators);
				
			$this->button = new Zend_Form_Element_Submit('button');
			$label = ( $this->id->getValue() > 0 )? "Update" : "Save";
			$this->button->setLabel($label)->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');				
			
			
				
		
		}
		
		
		
		function getObject(){
			return new Models_Address(array(
				'name' => $this->name->getValue() , 
			 	'street' => $this->street->getValue() , 
			 	'city' => $this->city->getValue() , 
			 	'country' => $this->country->getValue() , 
			 	'prs' => $this->prs->getValue() , 
				'postal' => $this->postal->getValue() , 
			 	'telephone' => $this->telephone->getValue()  
			 	
			));
		}

		
	}//end of the form 
	

?>