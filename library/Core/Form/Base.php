<?php



	/**
	 * 
	 * This class will enclose basic functionality of forms that are used with this application 
	 * 
	 * 
	 * @author Pascal Maniraho 
	 * @version 1.0.2 
	 * 
	 */
	class Core_Form_Base extends Zend_Form{
		
		
		private $object; 
		public $elementDecorators = array(
        'ViewHelper',
	        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element')),
	        array('Label', array('tag' => 'div', 'class' => 'element-label topLabel')),
	        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element-row rowElem noborder' ))
   		 );		

   		 
   		 
   		 public $smallElementDecorators = array(
        'ViewHelper',
	        array(array('data' => 'HtmlTag'), array( 'tag' => 'div', 'class' => 'element')),
	        array('Label', array('tag' => 'div', 'class' => 'element-label')),
	        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'small-element-row rowElem noborder' ))
   		 );		
   		 
	    
   		public $smallTextAreaDecorators = array(
        'ViewHelper',
	        array(array('data' => 'HtmlTag'), array( 'tag' => 'div', 'class' => 'element')),
	        array('Label', array('tag' => 'div', 'class' => 'element-label')),
	        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'small-textarea-row rowElem noborder' ))
   		 );		
   		 
   		 
   		 
   		 public $buttonDecorators = array(
	        'ViewHelper',
	        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'button')),
	        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element-row rowElem noborder' )),
	    );
		
		public $translate;

		public function init(){
			$this->setMethod("post");
			$this->setAction('');
		}
		
		
		
		
		
		
		//
		function __construct(){ 
	 		parent::__construct();
			$this->removeDecorator('label');
			$this->removeDecorator('tag');
            $this->translate = Zend_Registry::get('language');//system_powered_by  
            $this->setAttrib('accept-charset', 'utf-8')->setAttrib("class", "mainForm");  
			$this->setDecorators( 
				array(
					'Description',
					'FormElements',
					'Form'
				) 
			);                    
		}
		
		
		/**
		 * removeHiddenDecorators 
		 * this function removes decorators to hidden elements
		 * this removes DRY on decorators side and increases the time of rewritting long same lines of code 
		 * @param $hiddenElement
		 * @return &$hiddenElement 
		 */
		function removeHiddenDecorators(&$hiddenElement){
				$hiddenElement->removeDecorator('DtDdWrapper')
					->removeDecorator('label')
					->removeDecorator('tag');
					return $hiddenElement;			
		}
		
		
		/**
		 * This function will initialize the form $this->view->formwith values of the current object
		 * 
		 */
		public function setObject(Zend_Db_Table_Abstract $object){
				$this->object = $object;
		}
		
		
		
		public function getObject(){
				return $this->object;
		}
		
		
		
		
		
	}

?>