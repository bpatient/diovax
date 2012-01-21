<?php
/**
 * Thias helper will allow us to ajaxify any input including checkboxes and radio boxes  
 * it requires the url to send ajax request to. 
 * a class and an id
 * checkbox status 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 */
class Core_View_Helper_AjaxInput extends Zend_View_Helper_Abstract{
	
	/**
	 * @param array mixed $option
	 */
	function ajaxInput($option = array()){		
			
		$value = ( $option['value']   &&  !empty($option['value'])  ) ? ' value = \''.$option['value'].'\' ' : ' ' ;
		$type = ( isset($option['type'])  &&  !empty($option['type']) )? $option['type'] : 'checkbox' ;
		$checked = (  isset($option['status'] ) && true   === $option['status'] )? ' checked = \'checked\' ' : ' ' ;
		$id = ( isset($option['id'] )   &&  !empty($option['id'])  ) ? ' id = '.$option['id'].' ' : ' ' ;
		$class = ( isset($option['class'] ) &&  !empty($option['class']) )? ' class = \''.$option['class'].'\' ' : ' ' ;
		$name = ( isset($option['name'] ) &&  !empty($option['name']) )? ' name = \''.$option['name'].'\' ' : ' ' ;
		$type = ( isset($option['type'] ) &&  !empty($option['type']) )? $option['type'] : 'checkbox' ;
		$rel = ( isset($option['rel'] ) &&  !empty($option['rel']) )? ' rel = \''.$option['rel'].'\'' : '' ;
		/**this section will send pieace of js applications that can hold sensitive data*/
                $data = ( isset($option['data'] ) &&  !empty($option['data']) )? ' data = \''.$option['data'].'\'' : '' ;
		$style = ( isset($option['style'] ) &&  !empty($option['style']) )? ' style = \''.$option['style'].'\'' : '' ;
		
		$ajaxInput = '<input type=\''.$type.'\' '.$id.'  '.$name.' '.$class.'   '.$style.'  '.$checked.'   '.$value.'  '.$data.' '.$rel.'/>';
		$ajaxInput = '<span class=\'span-'.$type.'\'>'.$ajaxInput.'</span>';
		return  $ajaxInput;
	}
}
?>