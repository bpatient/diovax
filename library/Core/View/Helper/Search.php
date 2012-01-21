<?php

/**
 * 
 * @todo remove category on search as we dont need it 
 * This class will be helping to include search functionality 
 * @author Pascal Maniraho
 *
 */
class Core_View_Helper_Search extends Core_View_Helper_Base{
	
	
	public function search($options = null ){
		return '<div class="rentable-search span-24 last">
					<input class="search" id="search" value="" name="q"/>
					<button class="button rounded"><span class="search">search</span></button>
				</div>';
	}
	
	
	
	private function _srch( $options = array ( 'q' => '' , 'id' => '' , 'type' => '' , 'class' => '' , 'selected' => '' , 'name' => '' , 'onclick' => '' , 'onchange' => '' , 'onchange' => '','category_lookup'=> array() , 'selected' => 0 ) ) {
	
		/**among parameters to search from, we have categories */
		$category_lookup = ( !empty( $options['category_lookup']) ) ? $options['category_lookup'] :  array();
		$q = ( isset( $options['q']) && !empty($options['q']) ) ? $options['q'] : '';
		$id = ( isset($options['id']) && !empty($options['id']) ) ? ' id = \''.$options['id'].'\' ' : ' id = \'search-box\' ';
		$value = ( $q != '' ) ? ' value = \''.$q.'\' ' : '';
		$type = ( isset($options['type'])  && !empty($options['type']) ) ? $options['type'] : 'submit';
		$class = ( isset($options['class'])  && !empty($options['class'])  )? ' class = \''.$options['class'].'\' ':' class = \'search-box\' ';
		$selected = ( isset( $options['selected']) && $options['selected'] > 0 )? $options['selected'] : 0;
		$name = ( isset( $options['name'])  && !empty( $options['name']) )? ' name = \''.$options['name'].'\' ' : ' name = \'q\' ';
		$onclick = ( isset( $options['onclick'])  && !empty( $options['onclick'])  )? ' onClick = \''.$options['onclick'].'\'' : '' ;
		$onchange = ( isset( $options['onchange'])  && !empty( $options['onchange'])  )? ' onChange = \''.$options['onchange'].'\'' : '' ;
		$style = ( isset( $options['style'] ) && !empty( $options['style'] )  )? ' style = \''.$options['style'].'\'' : '' ;
		$input = '<input type=\'text\' '.$id.'  '.$name.' '.$class.'   '.$style.'  '.$value.' '.$onclick.' '.$onchange.' />';
	
		$button = '<input type=\''.$type.'\' name=\'search\' class=\'search-button\' id=\'search-button\' value=\''.$this->translate->_('front_search').'\' />';
		$category_select = '<select class=\'category-select\'  name=\'ctg\'  id=\'category-selects\' >';
		$category_select .= '<option value=\'0\' label=\'All\'>All Categories</option>';
		if ( count( $category_lookup )  > 0  ):
		foreach ( $category_lookup as $clk => $category ):
		$_selected = ( $clk >= 0 && $clk == $selected) ? ' selected=\'selected\' ' : '';
		if( is_array($category) ) $category_select .= '<option '.$_selected.' value=\''.$category['id'].'\' label=\''.$category['label'].'\'>'.$category['label'].' </option>';
		else  $category_select .= '<option  '.$_selected.'  value=\''.$clk.'\' label=\''.$category.'\'>'.$category.'</option>';
		endforeach;
		endif;
		$category_select .= '</select>';
		$input = '<span class=\'span-'.$type.'\'>'.$input.'  '.$category_select.' '.$button.'</span>';
		return  $input;
	
	}
	
}


?>