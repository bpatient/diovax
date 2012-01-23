<?php
    /**
	 * @author Pascal Maniraho
	 * @version 1.0.2
	 * @todo should have a description on top, and a link to cancel, just in case the connected guy is not our guy 
	 */
	class Core_Form_Contact extends Core_Form_Base{




            public function __construct(){

                    parent::__construct();
                    
                    
                    
                    $this->name = new Zend_Form_Element_Text('name');
                    $this->name->setDecorators($this->elementDecorators)->setLabel('Full Name ');
                    $this->name->setRequired(true);
                    	
                    $this->email = new Zend_Form_Element_Text('email');
                    $this->email->setRequired(true)->setDecorators($this->smallTextAreaDecorators)->setLabel('Primary Email');
                    						
                    $this->birthday = new Zend_Form_Element_Textarea('message');
                    $this->birthday->setRequired(true)->setDecorators($this->elementDecorators)->setLabel('Birthday')->setRequired(true);
                    	
                    
  				
                    $this->save = new Zend_Form_Element_Submit( "Save" );
                    $this->save->setDecorators($this->buttonDecorators)->setAttrib('class', 'button')->setValue("save")->setAttrib('class', 'button greyishBtn submitForm');
                    
                    if( isset($_POST['value']) ){
                    	$identicalValidator = new Zend_Validate_Identical($_POST['value']);//I used $_POST as this->_request was not working
                    	$identicalValidator->setMessages(array('notSame' => 'Value doesn\'t match!','missingToken' => 'Value doesn\'t match!'));
                    	$this->password->addValidator($identicalValidator);
                    }
                    
            

            }

		
		
		/**
		 * 
		 * 
		 * (non-PHPdoc)
		 * @see Core_Form_Base::getObject()
		 */
		public function getObject(){
			return new stdClass();
			
		}/*validation and decorations*/

	}
?>