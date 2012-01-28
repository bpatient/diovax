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
		
		$this->token = new Zend_Form_Element_Hidden('token');
		$this->token->setDecorators($this->elementDecorators);
		
		$this->unitcode = new Zend_Form_Element_Text('unitcode');
		$this->unitcode->setDecorators($this->elementDecorators)
			->setRequired(true)->setLabel("Unit code");
		
		$this->name = new Zend_Form_Element_Text('name');
		$this->name->setDecorators($this->elementDecorators)
			->setRequired(true)->setLabel("Name");
			
		$this->title = new Zend_Form_Element_Text('title');
		$this->title->setDecorators($this->elementDecorators)
			->setRequired(true)->setLabel("Title");
			
		$this->description = new Zend_Form_Element_Textarea('description');
		$this->description->setDecorators($this->elementDecorators)
			->setRequired(true)->setLabel("Description");

		$this->approved = new Zend_Form_Element_Checkbox("approved");
		$this->approved->setLabel("Approved");
		
		$this->leased = new Zend_Form_Element_Checkbox("leased");
		$this->leased->setLabel("Leased");

		
		
		$_property = array ( $this->id, $this->created , $this->modified , $this->url, $this->token , $this->unitcode,  $this->name , $this->title,  $this->description , $this->approved , $this->leased );
		$this->addDisplayGroup($_property, "property");
		
		
		
		//address
		$this->latitude = new Zend_Form_Element_Hidden('latitude');
		$this->removeHiddenDecorators($this->latitude);
		
		$this->longitude= new Zend_Form_Element_Hidden('longitude');
		$this->removeHiddenDecorators($this->longitude);
			
		$this->line_one = new Zend_Form_Element_Text('line_one');
		$this->line_one->setDecorators($this->elementDecorators)
		->setRequired(true)->setLabel("Street");
			
		$this->line_two = new Zend_Form_Element_Text('line_two');
		$this->line_two->setDecorators($this->elementDecorators)
		->setRequired(true)->setLabel("Unit number");
		
		$this->city = new Zend_Form_Element_Text('city');
		$this->city->setDecorators($this->elementDecorators)
		->setRequired(true)->setLabel("City");
		
		$this->country = new Zend_Form_Element_Text('country');
		$this->country->setDecorators($this->elementDecorators)
		->setRequired(true)->setLabel("Country");
		
		$this->prs = new Zend_Form_Element_Text('prs');
		$this->prs->setDecorators($this->elementDecorators)
		->setRequired(true)->setLabel("Province/State");
		
		$_address = array ( $this->latitude, $this->longitude, $this->line_one, $this->line_two, $this->city, $this->country, $this->prs );
		$this->addDisplayGroup($_address, "address");
		
		
		
		$label = ( $this->getElement('id')->getValue() > 0 )? 'Save': 'Update';
		$this->save = new Zend_Form_Element_Submit( $label );
		$this->save->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');
		
		$this->addDisplayGroup( array( $this->save ), "buttons" );
		
		

	}



	/**
	 */
	public function getObject(){
	
		//value initialization
		$_time = date('Y-m-d h:i:s', time());
		$this->modified->setValue($_time);
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
					'approved' => $this->approved->isChecked() ? 1 : 0,
					'leased' => $this->leased->isChecked() ? 1 : 0 
			     );
			
		return  Core_Util_Factory::build($params, Core_Util_Factory::ENTITY_PROPERTY);
	}
	
	/**
	 * @todo should be refactored
	 */
	public function getPropertyObject(){
		return $this->getObject();
	}
	
	/**
	 * @todo should be implemented 
	 */
	public function getAddressObject(){
		
		
		$params = array (
							'latitude' => (float)$this->latitude->getValue(), 	
							'longitude' => (float)$this->longitude->getValue(),
							'line_one' => $this->line_one->getValue() ,	
							'line_two' => $this->line_two->getValue(),
							'city' => $this->city->getValue(),
							'country' => $this->country->getValue(),
							'prs' => $this->prs->getValue(),	
							'owner' => $this->token->getValue()
							
		);
			
		return  Core_Util_Factory::build($params, Core_Util_Factory::ENTITY_ADDRESS);
	}
	
	
	
	/**
	 * Overrides the parent to better initialize both address and property
	 * @see Zend_Form::populate()
	 */
	public function populate($values){
		parent::populate($values);
		
		
	if( array_key_exists( "property", $values ) ){
			$this->id->setValue( (int)$values["property"]->id );
			$this->created->setValue($values["property"]->created);
			$this->modified->setValue($values["property"]->line_one) ;	
			$this->token->setValue($values["property"]->token);
			$this->unitcode->setValue($values["property"]->unitcode);
			$this->name->setValue($values["property"]->country);
			$this->title->setValue($values["property"]->title);
			$this->description->setValue($values["property"]->description);
			$this->approved->setValue($values["property"]->approved);
			$this->leased->setValue($values["property"]->leased);
		}
		
		if( array_key_exists( "address", $values ) ){
			$this->latitude->setValue( $values["address"]->latitude );
			$this->longitude->setValue($values["address"]->longitude);
			$this->line_one->setValue($values["address"]->line_one) ;
			$this->line_two->setValue($values["address"]->line_two);
			$this->city->setValue($values["address"]->city);
			$this->country->setValue($values["address"]->country);
			$this->prs->setValue($values["address"]->prs);
			$this->token->setValue($values["address"]->token);
		}
		
	}
	
	
	
		
	}

?>