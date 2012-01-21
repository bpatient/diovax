<?php
    /**
	 * 
	 */		
	class Core_Form_Site extends Core_Form_Base{
		
		
		function __construct($options = array('id' => 0)){
			
			
			parent::__construct();
			$this->id = new Zend_Form_Element_Hidden('id');
			
			$this->name = new Zend_Form_Element_Text('name');
			$this->name->setDecorators($this->elementDecorators)->setLabel(' Site name ');
			$this->name->setRequired(true);
			
			$this->location = new Zend_Form_Element_Textarea("location");
			$this->location->setAttrib('rows', '8')->setLabel("Location")->setDecorators($this->smallTextAreaDecorators)->setRequired(true);
			
			$this->description = new Zend_Form_Element_Textarea("description");
			$this->description->setAttrib('rows', '8')->setLabel("Description")->setDecorators($this->smallTextAreaDecorators)->setRequired(true);
			
			$this->button = new Zend_Form_Element_Submit('button');			
			$label = 'Save';
			if ( $this->id->getValue() > 0 )
					$label = "Update";
				
			$this->button->setLabel($label)->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm');						
			
			
			
		}
		

		
		
		
		
		public function getObject(){
			
			return Core_Util_Factory::build( 
				array(
								'id' => ((int)$this->id->getValue()),
								'name' => $this->name->getValue(),				
								'location' => $this->location->getValue(),
								'description' => $this->description->getValue(),
								'modified' => date('Y-m-d h:i:s', time() )
				),  Core_Util_Factory::ENTITY_SITE
			);
			
			
		}	
		
		
		//validation and decorations 
		
	}

?>