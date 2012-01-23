<?php
/**
 *
 * Remember to work on approved and leased in the future as
 * They are Checkbox but with out initial values
 *
 *
 *
 * @author Pascal Maniraho
 * @version 1.0.2
 */
class Core_Form_Property extends Core_Form_Base{



	public function __construct( $options = array ( 'id' => 0 ) ){

		parent::__construct();
	
			
		$this->id = new Zend_Form_Element_Hidden('id');
		$this->removeHiddenDecorators($this->id);

		$this->created = new Zend_Form_Element_Hidden('created');
		$this->removeHiddenDecorators($this->created);

		$this->modified = new Zend_Form_Element_Hidden('modified');
		$this->removeHiddenDecorators($this->modified);
		
		$this->url = new Zend_Form_Element_Hidden('url');
		$this->removeHiddenDecorators($this->url);
		
		$this->unitcode = new Zend_Form_Element_Text('unitcode');
		$this->unitcode->setDecorators($this->elementDecorators)
			->setRequired(true);
		
		$this->name = new Zend_Form_Element_Text('name');
		$this->name->setDecorators($this->elementDecorators)
			->setRequired(true);
			
		$this->title = new Zend_Form_Element_Text('title');
		$this->title->setDecorators($this->elementDecorators)
			->setRequired(true);
			
		$this->token = new Zend_Form_Element_Text('token');
		$this->token->setDecorators($this->elementDecorators)
			->setRequired(true);
		
		$this->description = new Zend_Form_Element_Text('description');
		$this->description->setDecorators($this->elementDecorators)
			->setRequired(true);

		$this->approved = new Zend_Form_Element_Checkbox("approved");
		$this->approved->setLabel("approved");
		
		$this->leased = new Zend_Form_Element_Checkbox("leased");
		$this->leased->setLabel("leased");

		$label = ( $this->getElement('id')->getValue() > 0 )? 'Save': 'Update';
		$this->button = new Zend_Form_Element_Submit( $label );
		$this->button->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');

		//value initialization
		//$_time = date('Y-m-d h:i:s', time());
		//if( !$this->modified->getValue() )$this->modified->setValue($_time);
		//if( !$this->created->getValue() )$this->created->setValue($_time);
		

	}



	/**
	 */
	public function getObject(){
	
		//value initialization
		$_time = date('Y-m-d h:i:s', time());
		if( !$this->modified->getValue() )$this->modified->setValue($_time);
		if( !$this->created->getValue() )$this->created->setValue($_time);
		
		
			$params = array ( 
					'id' => (int)$this->id->getValue(), 	
					'unitcode' => $this->unitcode->getValue(),
					'name' => $this->name->getValue() ,	
					'title' => $this->title->getValue(),
					'url' => $this->url->getValue(),
					'token' => $this->token->getValue(),
					'description' => $this->description->getValue(),	
					'created' => $this->created->getValue(),
					'modified' => $this->modified->getValue(),		
					'approved' => $this->approved->getValue(),
					'leased' => $this->leased->getValue() 
			     );
			
		return  Core_Util_Factory::build($params, Core_Util_Factory::ENTITY_PROPERTY);
	}/*validation and decorations*/
		
	}

?>