<?php




/**
 * This helper class will be used to generate hiearchical categories.
 * the format of array to be passed in should be like id | parent | name[title|label|category] 
 * 
 * 
 * @version 1.0.1
 * @author Pascal Maniraho 
 * @todo  add a way to display list, dropdown, or simply nested divs
 * @link http://wiki.phpontrax.com/index.php/How_do_I_model_a_tree/hierarchy%3F for recursivity on html lists 
 * 
 *
 */

class Core_Util_Categorizer{

	
	
	
	/**
	 * 
	 * $_data
	 * $_list 
	 * $_refs 
	 */
	protected $_data = array();
	public $_list = array();
	public $_refs = array(); 
	private $_show = -1; 
	
	
	/**
	 * To collect select elements 
	 * 
	 */
	
	public $_sel_elts = array();

	/**
	 * CSS variables 
	 */
	public $id, $name ,$class, $link;

	
	/**
	 * @param $data
	 * @param $config
	 */
	function __construct($data = array(), $config = array()){
		
		if ( $data ){
			$this->init( $data, $config );	
		}
		
		
		
	}
	
	
	
	/**
	 * option 
	 * 
	 * sometimes some tables don't follow configuration for this class.
	 * if the database table used 'name' instead of category, option = array( 'category' => 'name' ) 
	 * will help to fix those issues. 
	 * key is the value in data, and value is 
	 * 
	 *@param array $options [ key = class variable name, value = data array used array ] 
	 **/
	function init( $data, $options = array('id' => 'id', 'parent' => 'parent', 'category' => 'category', 'class' => '' , 'link' => '' ) ){
		$tmp_data = array();
		foreach ( $data as $k => $date ){
			$tmp_data[$k][ 'id' ] = $date[ $options['id'] ]; 
			$tmp_data[$k][ 'parent' ] = $date[ $options['parent'] ]; 
			$tmp_data[$k][ 'category' ] = $date[ $options['category'] ]; 
				
		}
		$this->_data = $tmp_data;
		
		$this->id = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : 'category';
		$this->class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : 'category';
		$this->name = ( isset($options['name']) && !empty($options['name']) ) ? $options['name'] : 'category';
		$this->link = (isset($options['link']) &&  $options['link'] != '' )	? $options['link'] : '';
		$this->categories();
		$this->initSelectElements();

		/**/
		$this->_show = isset($options['show'])? $options['show'] : -1;
		
	}
	
	/**
	 * this function categorizes the 
	 */
	function categories(){
	$counter = 0; 	
	foreach($this->_data as $k => $data) {
	  
	  $thisref = &$this->_refs[ $data['id'] ];
	  $thisref['parent'] = $data['parent'];
	  $thisref['category'] = $data['category'];
	  $thisref['id'] = $data['id'];
	  
	  if ($data['parent'] < 0 ) {
	       $this->_list[ $data['id'] ] = &$thisref;
	   } else {
	       $this->_refs[ $data['parent'] ]['children'][ $data['id'] ] = &$thisref;
	   }
	$counter++;
	}
}//function
	
	
public function toHtmlList( $data = 'nodata' ){
	$html = ""; 
	$data = ( $data == 'nodata' )? $this->_list : $data;
	if ( is_array($data) && count($data) ) {
		foreach($data as $k => $date){
			$category = $date['category']; 
			if ( $this->link != '' ) $category = '<a href=\''.$this->link.'/'.$date['id'].'\'>'.$date['category'].'</a>';	
			$html .= '<li id=\''.$date['id'].'\' class=\''.$date['parent'].'\'>'.$category;
			if(!isset($date['children'])){
                             $date['children'] = "";
                        }
                        if ( $date['children'] && count($date['children']) ){
				$html .= $this->toHtmlList ( $date['children'] );
			}
			$html .= '</li>';
		}
	}
	$show = ( $this->_show > 0 && $this->_show == $date['parent'] ) ? ' show' : '';//there is a leading space
	return '<ul class=\'parent'.$show.'\'>'.$html.'</ul>';
}





/**
 * this function generates an array of parent / children array 
 * it gonna be useful for category drop downs  
 */
//function initSelectElements( $data = 'nodata', $parent = '' ){
function initSelectElements( $data = 'nodata', $parent = '' ){
	$html = '';
	$data = ( $data == 'nodata' )? $this->_list : $data;	
	if ( is_array($data) && count($data) ) {
		foreach($data as $k => $date ){
			$html = (isset( $date['parent']) &&  $date['parent'] == -1 ) ? $date['category'] : $parent.' / '.$date['category'];
			if(!isset($date['children'])){
                             $date['children'] = "";
                        }
                        $this->_sel_elts[$date['id']] = $html . $this->initSelectElements ( $date['children'], $html );
			$html = '';
		}
	}
	return  $html;
}


public function getSelectElements(){ return $this->_sel_elts ? $this->_sel_elts : array(); }




/**
 * this function categorizes the 
 */
function toHtmlOption( $data = 'nodata', $parent = '' ){
	$html = ""; 
	$data = ( $data == 'nodata' )? $this->_list : $data;
	if ( is_array($data) && count($data) ) {
		foreach($data as $k => $date ){
			if ( $parent != '' ) {
				$html .= '<option value=\''.$date['id'].'\' >'.$parent.' / '.$date['category'] ; 
				$html .= $this->toHtmlOption ( $date['children'], $parent.' / '.$date['category'] ); 			
			}else{
				$html .= '<option value=\''.$date['id'].'\' >'.$date['category'] ; 
				$html .= $this->toHtmlOption ( $date['children'], $date['category'] ); 			
			} 
		}
	}
	/**checking the last element 
	 * this functionality reduce the response time */
	$last = end( $this->_list );
	return (  $last['id'] == $date['id'] ) ? '<select name=\''.$this->name.'\'  id=\''.$this->id.'\'  class=\''.$this->class.'\' >'. $html.'</select>' : $html;
}

	/**
	 * 
	 * @param unknown_type $alist
	 * @param unknown_type $options
	 */
	function render($alist = null, $options = array() ){
		$html = "";
		$i = 0;//counter 
		$list = ($alist == null)?$this->_list:$alist;
		foreach($list as $k => $data):
			$options = ($data["parent"] < 0 )?$data["category"]:"$options > $data[category]";
			if(array_key_exists("children",$data)):
				$html .=  $this->render($data['children'],$options);//, 
			else:
				$html .= '<li id =\''.$data['id'].'\'>'.$options.' '.$i.'</li>';
			endif;
			$i ++;
		endforeach;
		return $html;	
		
	}//
		
	
	/*returns a one breadth */
	function toArray(){
		
		$html = "";
		$list = ($alist == null)?$this->_list:$alist;
		foreach($list as $k => $data):
			if(array_key_exists("children",$data)):
				$options = ($data["parent"] < 0 )?$data["category"]:"$options> $data[category]";
				$html .=  $this->render($data['children'], $options);
			else:
				$html .= "$options > $data[category]";	
				 $this->_array[ $data['id'] ] = $html;
			endif;
		endforeach;
		return $html;	
		
	}
		
		
}//end of the class 




?>