<?php
/**
 * @author Pascal Maniraho
 * @version 1.0.2
 */
class Core_Form_Lease extends Core_Form_Base{



	private $types, $cycles, $payments, $statuses;
	public function __construct( $options = array ( 'id' => 0 ) ){

		parent::__construct();
		$this->types = array();
		$this->cycles = array ( 'daily' => 'Daily', 'weekly' => 'Weekly', 'biweekly' => 'Biweekly', 'monthly' => 'Monthly','annualy' => 'Annualy' );
		$this->payments = array  ( 'credit'  => "Credit" ,'check' => "Check",'cash' => "Cash" );
		$this->statuses = array ( "open" => "Open", "closed" => "Closed" );//is it status or just matter of active / In-activitiy?
		if( isset($options['types']) ){
			$this->types = $options['types'];
		}
			
		$this->id = new Zend_Form_Element_Hidden('id');
		$this->removeHiddenDecorators($this->id);

		$this->booking_id = new Zend_Form_Element_Hidden('booking_id');
		$this->removeHiddenDecorators($this->booking_id);

		$this->created = new Zend_Form_Element_Hidden('created');
		$this->removeHiddenDecorators($this->created);

		$this->modified = new Zend_Form_Element_Hidden('modified');
		$this->removeHiddenDecorators($this->modified);

		$this->status = new Zend_Form_Element_Select("status");
		$this->status->setLabel("Status")->addMultiOptions($this->statuses)->setDecorators($this->elementDecorators)->setRequired(true);

		$this->cycle = new Zend_Form_Element_Select("cycle");
		$this->cycle->setLabel("Payment cycle")->addMultiOptions($this->cycles)->setDecorators($this->elementDecorators)->setRequired(true);

		$this->payment = new Zend_Form_Element_Select("payment");
		$this->payment->setLabel("Payment Preference")->addMultiOptions($this->payments)->setDecorators($this->elementDecorators)->setRequired(true);

		$this->lease_type_id = new Zend_Form_Element_Select("lease_type_id");
		$this->lease_type_id->setLabel("Lease Type")->addMultiOptions($this->types)->setDecorators($this->elementDecorators)->setRequired(true);

		$this->movein = new Zend_Form_Element_Text('movein');
		$this->movein->setLabel('Checkin')->setDecorators($this->elementDecorators)->setRequired(true);

		$this->moveout = new Zend_Form_Element_Text('moveout');
		$this->moveout->setLabel('Checkout')->setDecorators($this->elementDecorators)->setRequired(true);

		$this->rent = new Zend_Form_Element_Text('rent');
		$this->rent->setLabel('Rent ')->setDecorators($this->elementDecorators)->setRequired(true)
		->setAttrib('maxlength', 6);
		$label = ( $this->getElement('id')->getValue() > 0 )? 'Save': 'Update';
		$this->button = new Zend_Form_Element_Submit( $label );
		$this->button->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setAttrib('class', 'button greyishBtn submitForm');

		//value initialization
		$_time = date('Y-m-d h:i:s', time());
		if( !$this->modified->getValue() )$this->modified->setValue($_time);
		if( !$this->created->getValue() )$this->created->setValue($_time);

	}



	/**
	 */
	public function getObject(){
		return new Core_Entity_Lease(
		array(
                                    'id'  => (int)$this->id->getValue(),
                                    'property_id' => $this->property_id->getValue(),
                                    'start' => $this->start->getValue(),
                                    'ends' => $this->ends->getValue(),
                                    'started' => $this->started->getValue(),
                                    'owner' => $this->owner->getValue()
		)
		);
	}/*validation and decorations*/
		
	}

?>