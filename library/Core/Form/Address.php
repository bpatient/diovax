<?php


/**
 *
 *
 *
 * This form will be used for phone addresses, and extended addresses.
 * in both cases we will be using the same form.
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


class Core_Form_Address extends Core_Form_Base{


	private $label;//set it to the value of address_key

	public function __construct($options = array('id' => 0)){



		parent::__construct();
			
		//$this->addDecorator('Description', array('tag' => 'p', 'class' => 'description'));
		$this->id = new Zend_Form_Element_Hidden('id');
		$this->removeHiddenDecorators($this->id);
			
		$this->owner= new Zend_Form_Element_Hidden('owner');
		$this->removeHiddenDecorators($this->owner);
		
		$this->latitude= new Zend_Form_Element_Hidden('latitude');
		$this->removeHiddenDecorators($this->latitude);
		
		$this->longitude= new Zend_Form_Element_Hidden('longitude');
		$this->removeHiddenDecorators($this->longitude);
			
		$this->line_one = new Zend_Form_Element_Text('line_one');
		$this->line_one->setDecorators($this->elementDecorators)
			->setRequired(true);
			
		$this->line_two = new Zend_Form_Element_Text('line_two');
		$this->line_two->setDecorators($this->elementDecorators)
			->setRequired(true);	
		
		$this->city = new Zend_Form_Element_Text('city');
		$this->city->setDecorators($this->elementDecorators)
			->setRequired(true);
		
		$this->country = new Zend_Form_Element_Text('country');
		$this->country->setDecorators($this->elementDecorators)
			->setRequired(true);
	
		$this->prs = new Zend_Form_Element_Text('prs');
		$this->prs->setDecorators($this->elementDecorators)
			->setRequired(true);		
		

		$this->button = new Zend_Form_Element_Submit('button');
		$this->button->setLabel("Register")->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');
		
}
		
		
		
		public function getObject(){
			
			$params =	array (	
						'id' => (int)$this->id->getValue(),
						'owner' => $this->owner->getValue(),
						'line_one' => $this->line_one->getValue(),
						'line_two' => $this->line_two->getValue(),
						'city' => $this->city->getValue(),
						'country' => $this->country->getValue(),
						'prs' => $this->prs->getValue(),
						'latitude'=>$this->latitude->getValue(),
						'longitude'=>$this->longitude->getValue()
					);
								
			return  Core_Util_Factory::build($params, Core_Util_Factory::ENTITY_ADDRESS); //Core_Model_Address();
		}	
				
	}

	
	

?>