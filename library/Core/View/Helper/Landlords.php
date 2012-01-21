<?php
/**
 * This helper will be used to display landlords with ajaxed checkobx to update landlord's table. 
 * @author Pascal Maniraho 
 */
class Core_View_Helper_Landlords extends Zend_View_Helper_Url{
	
	public function landlords( $data , $options = array() ){
		
		
		/**Copy attribute before sending data*/
		extract( $options );
		$this->data = $data;
		
		/****/
		if( !is_array( $this->data) && is_object($this->data) ){
			$this->data = (array)$this->data;
		}
		
		$content = "";
		$_header = $this->_header();
		if( count( $this->data ) >= 1 ){
			foreach( $this->data as $k => $date ){
				
				
				$content .= '<div class=\'table-row-div\' ><div class=\'table-cell-div xl-large-cell\'>'.
								$date['name'].'</div>'.
								'<div class=\'table-cell-div small-cell\'>'.$date['status'].'</div>'.//data
								'<div class=\'table-cell-div small-cell\'><input type=\'checkbox\' name=\'landlord['.$date['user'].']\' class=\'view-landlords\' '.( (((int)$date['user']) == ((int)$date['user_id']) ) ? 'checked=\'checked\'' : '' ).'/></div>'.
							'</div>';
			} 			
			$content = '<div class=\'table-div\'>'.$_header.''.$content.'</div>';
		}else{
			$content .= '<div class=\'title notice\'>No Landlords have been found yet</div>';
		}
		return $content;
	}
	
	/**styling our header**/
	private function _header(){
		return '<div class=\'table-header-div\' > 
					<div class=\'table-cell-div xl-large-cell\' > Names </div>
					<div class=\'table-cell-div small-cell\' > Status </div>
					<div class=\'table-cell-div small-cell\' > Landlord </div>
				</div>';
	}
	
	
	
	/**this function has to have Paging object**/
	private function _footer(){
		return '<div class=\'table-header-div\' > 
					<div class=\'table-cell-div xl-large-cell\' > Names </div>
					<div class=\'table-cell-div small-cell\' > Status </div>
					<div class=\'table-cell-div small-cell\' > Landlord </div>
				</div>';
	}
	
	
}
?>