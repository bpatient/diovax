<?php
    
	/***
	 * This form should be used to edit media information but not upload any file  
	 * Media_value will be given to be able to update media_value field in the database 
	 *
	 */ 	
	class Core_Form_Media extends Core_Form_Base{
		
	
		
		private $media_value;
		
		
		function __construct($options = array('id' => 0, 'isFile' => true  , 'media_value' => ''  ) ){
			
					
			parent::__construct();
			
			
			
			$this->id = new Zend_Form_Element_Hidden('id');
			$this->removeHiddenDecorators($this->id);
			
			$this->token = new Zend_Form_Element_Hidden('token');
			$this->removeHiddenDecorators($this->token);

			
			$this->owner = new Zend_Form_Element_Hidden('owner');
			$this->removeHiddenDecorators($this->owner);

			$this->media_key = new Zend_Form_Element_Hidden('media_key');
			$this->removeHiddenDecorators($this->media_key);
			
			$this->media_value = new Zend_Form_Element_Hidden('media_value');
			$this->removeHiddenDecorators($this->media_value);
				
			$this->title = new Zend_Form_Element_Text('title');
			$this->title->setDecorators($this->elementDecorators)->setLabel('Title')->setRequired(true);
			
			$this->caption = new Zend_Form_Element_Text('caption');
			$this->caption->setDecorators($this->elementDecorators)->setLabel('Caption')->setRequired(true);
			
			$this->media_order = new Zend_Form_Element_Text('media_order');
			$this->media_order->setDecorators($this->elementDecorators)->setLabel('Order');
				
			$this->description = new Zend_Form_Element_Textarea('description');
			$this->description->setAttrib('rows', '8')->setDecorators($this->smallTextAreaDecorators)->setLabel('Description');

			$this->displayed = new Zend_Form_Element_Checkbox('displayed');
			$this->displayed->setDecorators($this->smallElementDecorators)->setLabel('Displayed ');
				
			$this->isdefault = new Zend_Form_Element_Checkbox('isdefault');
			$this->isdefault->setDecorators($this->smallElementDecorators)->setLabel('Default');
			
			$label = ( (int)$this->getElement('id')->getValue() > 0 ) ? 'Update' : 'Save';	 
			$this->button = new Zend_Form_Element_Submit('button');				
			$this->button->setLabel( $label )->setDecorators($this->buttonDecorators)->setAttrib('class', 'button greyishBtn submitForm'); 
		
			
		}
		
		//all forms has this function that returns the content of the form 
		//for persisting the content 
		function getObject(){
			$params = array( 
				'id' => (int)$this->id->getValue(),
				'token' => $this->token->getValue(),
				'title' => $this->title->getValue(),
				'caption' => $this->caption->getValue(),									
				'media_order' => (int)$this->media_order->getValue(),									
				'media_key' => $this->media_key->getValue(),
				'media_value' => $this->media_value->getValue(),
				'displayed' => $this->displayed->isChecked() ? 1 : 0,
				'isdefault' => $this->isdefault->isChecked() ? 1 : 0,
				'owner' => $this->owner->getValue(),
			    'description' => $this->description->getValue()
			);
			
			return Core_Util_Factory::build( $params ,  Core_Util_Factory::ENTITY_MEDIA);
		}
		
		function getPropertyMediaObject(){
			return new Core_Model_ProductMedia(array(
				'id' => (int)$this->id->getValue(),
				'token' => $this->token->getValue(),
				'title' => $this->title->getValue(),
				'caption' => $this->caption->getValue(),									
				'media_order' => (int)$this->media_order->getValue(),									
				'media_key' => $this->media_key->getValue(),
				'media_value' => $this->media_value->getValue(),
				'displayed' => $this->displayed->isChecked() ? 1 : 0,
				'isdefault' => $this->isdefault->isChecked() ? 1 : 0,
				'owner' => $this->owner->getValue(),
			    'description' => $this->description->getValue()
			));
		}
		
			
		
		//validation and decorations 
		
		
		public function getMediaValue(){ return $this->media_value; }
		public function setMediaValue ( $media_value ){ $this->media_value = $media_value; }
		
	}

?>