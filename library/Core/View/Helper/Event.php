<?php
/**
 * This view helper will display the task object
 * @author Pascal Maniraho
 */

class Core_View_Helper_Event extends Core_View_Helper_Base{
	function event ( $mixed, $options = array( 'class' => '', 'id' => '', 'style' => '' )  ){
			
			
			

		$this->schedule = $mixed;
		if( !($this->schedule instanceof Core_Entity_Schedule) ){
			$this->schedule = Core_Util_Factory::build($this->schedule, Core_Util_Factory::ENTITY_TICKET);
		}


			
			
		$this->_style = isset( $options['style'] ) && !empty($options['style']) ?' style=\''.$options['style'].'\' ':'';
		$this->_class = isset( $options['class'] ) && !empty($options['class']) ?' class=\''.$options['class'].'\' ':' class=\'title\' ';
		$this->_id = isset( $options['id'] ) && !empty($options['id'])? ' id=\''.$options['id'].'\' ' :' id=\'title\' ';
			
			
		if( isset( $options['image'] ) && $options['image'] != null  ) $_image = '<img src=\''.$options['image'].'\' alt = \'Image not available\'/>';
		if( isset( $options['rating'] ) && $options['rating'] != null ) $_rating = $options['rating'];
		if( isset( $options['booking']) && $options['booking'] != null ) $_booking = $options['booking'];/**should be a url to start booking process*/
		/**checking if booking is a link*/
		if( isset( $options['name'] ) && $options['name'] != null ) $_title = $options['name']; else  $_title = $this->schedule->name;
		if( isset( $options['site'] ) && $options['site'] != null ) $_site = $options['site'];
		if( isset( $options['words'] ) && $options['words'] != null ) $_words = $options['words'];


			
		$this->description = $this->schedule->description;
		if( isset($options['strip']) && $options['strip'] == true ) {
			$this->description = $this->oStr->cutText( $this->description ,  array( 'words' => $_words ) );
		}


		if( isset($options['editing']) &&  is_string($options['editing']) ){
			$_editing = $options['editing'];
		}else{ $_editing = '';
		}
		$this->editing = $_editing;

			
		$_html = '<div class=\'task-view-helper\'>';
		$_html .= $this->_ttl();
		$_html .= $this->_dsc();
		$_html .= $this->_edt();
		$_html .= '</div>';
		return $_html;
	}




	/**returns the string to edit an instance of a property*/
	private function _edt(){
		return '<div class=\'edit-widget\'>'.$this->editing.'</div>';
	}
	private function _ttl( ){
		return '<div class=\'\'>'.$this->schedule->title.'</div>'; /**<a href=\'/app/a/rental/'.$this->schedule->id.'\' rel=\'/app/a/rental/'.$this->schedule->id.'\'></a>*/
	}
	private function _dsc( ){
		return '<div class=\'description\'>'.$this->description.'</div>'; }
  
}
?>