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
 * The address_type is filled with categories in which this address should classified
 * the address_key is pre-set [ this should be telephone, street-city-postal-address string ]
 *
 *
 * and for extended address string the isText has to be set.
 *
 * @author Pascal Maniraho
 * @uses
 * @version
 *
 */


class Core_Form_Address extends Core_Form_Base{


	private $label;//set it to the value of address_key

	public function __construct($options = array('id' => 0,'user_id' => 1, 'isText' => false), $selectElements = array()){



		parent::__construct();
			
		$this->addDecorator('Description', array('tag' => 'p', 'class' => 'description'));
		$this->id = new Zend_Form_Element_Hidden('id');
		$this->removeHiddenDecorators($this->id);
			
		$this->address_key = new Zend_Form_Element_Hidden('address_key');
		$this->removeHiddenDecorators($this->address_key);
			
		$this->user_id = new Zend_Form_Element_Hidden('user_id');
		$this->removeHiddenDecorators($this->user_id);
			
		$this->address_type = new Zend_Form_Element_Hidden("address_type");
		$this->removeHiddenDecorators($this->address_type);
			
		if(true === $options['isText']){
			$this->address_value = new Zend_Form_Element_Textarea('address_value');
			$this->address_value->setDecorators($this->smallTextAreaDecorators)->setAttrib('rows', '8')
			->setRequired(true);
		}else{
			$this->address_value = new Zend_Form_Element_Text('address_value');
			$this->address_value->setDecorators($this->elementDecorators)
			->setRequired(true);

		}
			
		$this->address_value->setLabel("Address");
			
		$this->note = new Zend_Form_Element_Textarea('note');
		$this->note->setLabel('Short note')->setAttrib('rows', '8')
		->setDecorators($this->smallTextAreaDecorators);//not requird
			
		$this->displayed = new Zend_Form_Element_Checkbox('displayed');
		$this->displayed->setLabel('Displayed')
		->setDecorators($this->elementDecorators);


		$this->button = new Zend_Form_Element_Submit('button');
		$this->button->setLabel("Register")->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');
		
}
		
		
		
		function getObject(){
			
			$params = array(
				'id' => (int)$this->id->getValue(),
				'user_id' => (int)$this->user_id->getValue(),				
				'displayed' => $this->displayed->getValue(),
				'address_type' => $this->address_type->getValue(),
				'address_key' => $this->address_key->getValue(),
				'address_value' => $this->address_value->getValue(),
				'note' => $this->note->getValue(),
				'modified' => date("Y-d-m h:i:s", time()) 		
				);
			
			return  Core_Util_Factory::build($params, Core_Util_Factory::ENTITY_ADDRESS); //Core_Model_Address();
		}	
				
	}

	
	

?>