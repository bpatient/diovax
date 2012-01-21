<?php
/**
 * This view helper will be used to display edit menu box,
 * the core feature of this, is to give an array of config, ang guess current module, controller and action to link to 
 * @author Pascal Maniraho 
 */
class Core_View_Helper_Edit extends Zend_View_Helper_Abstract{
function edit( $mixed, $options = array ('class' => '', 'id' => '', 'style' => '', 'span' => false )  ){
    /***/
    $_html = "";
    $_span = false; $_text = true; 
    if( isset($options['span']) && $options['span'] ){ $_span = true; }
    if( isset($options['text']) && !empty($options['text']) ){ $_text = $options['text']; }

    if( is_array($mixed) ){
        foreach( $mixed as $k => $_o ) {
            $_class = $k;
            if( $_text == false ) $k = "";
            if($_span) $k = '<span class=\''.$_class.'\'>'.$k.'</span>';
            $_html .= '<li><a class=\'button\' href='.$_o.'>'.$k.'</a></li>';
           }
        }
    return "<ul class='edit-list'>".$_html."</ul>";
    }
}?>