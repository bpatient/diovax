<?php
/**
 * @author Pascal Maniraho 
 * @uses 
 * @version 1.0.0 
 */
class Core_View_Helper_AjaxCheckable extends Core_View_Helper_Base{
	/**
	 * This function will help to format the option in such a way we can add an ajax function on it. 
	 * @param array mixed $option
	 */
	function ajaxCheckable($option = array( 'status' => '','id' => '', 'class' => '','name' => '', 'type' => '', 'data' => '', 'rel' => '', 'style' => ''  )){


                //print_r( $option );

		$checked = (  isset($option['status'] ) && true   === $option['status'] ) ? ' checked = \'checked\' ' : ' ' ;
		$value = (  isset($option['value'] ) && !empty($option['value'] ) )? ' value = \''.$option['value'].'\' ' : '' ;
		$id = ( isset($option['id'] ) &&  $option['id'] ) ? ' id = '.$option['id'].' ' : ' ' ;
		$class = ( isset($option['class'] ) &&  !empty($option['class']) )? ' class = \''.$option['class'].'\' ' : ' ' ;
		$name = ( isset($option['name'] ) &&  !empty($option['name']) )? ' name = \''.$option['name'].'\' ' : ' ' ;
		$type = ( isset($option['type'] ) &&  !empty($option['type']) )? $option['type'] : 'checkbox' ;
		$rel = ( isset($option['rel'] ) &&  !empty($option['rel']) )? ' rel = \''.$option['rel'].'\'' : '' ;
		/**this section will send pieace of js applications that can hold sensitive data*/
                $data = ( isset($option['data'] ) &&  !empty($option['data']) )? ' data = \''.$option['data'].'\'' : '' ;
		$style = ( isset($option['style'] ) &&  !empty($option['style']) )? ' style = \''.$option['style'].'\'' : '' ;
		$ajaxCheckboxString = '<input type=\''.$type.'\' '.$id.' '.$value.' '.$name.' '.$class.'   '.$style.'  '.$checked.' '.$data.' '.$rel.' />';

                $ajaxCheckboxString = '<span class=\'span-'.$type.'\'>'.$ajaxCheckboxString.'</span>';
		return  $ajaxCheckboxString;
	}
	
}
?>