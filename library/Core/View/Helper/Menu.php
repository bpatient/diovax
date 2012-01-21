<?php
/**
 * This helper class will render the menu.
 *
 *
 *
 * @author Pascal Maniraho
 * @version 1.0.0
 * @todo implement menu function and register the view helper with the application
 * @todo define the datatype to send via $data parameter
 * @todo add private methods to parse/render html
 * @todo optimize html generation 
 *
 * 
 *
 */

class Core_View_Helper_Menu extends Zend_View_Helper_Abstract{



        /**
         * This variable holds html
         * @var string $menu
         */
        protected $menu;
		protected $id, $class; 


        /**
         *
         * @param array $data
         * @param array $options
         * @return string $menu
         */
        public function menu( $data , $options = array( "" => "" ) ){                   	
        	if( isset($options['class']) ) $this->class = $options['class']; else $this->class = 'menu'; 
        	if( isset($options['id']) ) $this->class = $options['class']; else $this->id = '';
        	$menu = '';
            if($options['principal_menu']){
                $menu = $this->_generatePrincipalMenu($this->_getMenu($data));
            }
            return $menu;
	}


        private function _generatePrincipalMenu($menu_with_items){
            $menu = '<ul class=\''.$this->class.'\' id=\''.$this->id.'\'>';
            foreach($menu_with_items as $item){                
                $menu .= $this->_generateItems($item);
            }
            $menu .= '</ul>';
            return $menu;
        }// end function


        private function _generateItems($item){
            $item_return = "<li><a href='".$item->url."'>".$item->title."</a>";
                if($item->submenu ){
                  $item_return .= $this->_generateSubItems($item->submenu);
                }
               $item_return .= "</li>";

               return $item_return;

        }// end function

            
        /**
         * This function generate sub items from a menu
         * @param array $sub_items
         * @return string 
         */
        private function _generateSubItems($sub_items){
                    $sub_menu_items = "<ul>";
                        foreach($sub_items as $sub_menu_item){
                            $sub_menu_items .= "<li><a href='".$sub_menu_item['url']."'>".$sub_menu_item['title']."</a></li>";
                        }
                    $sub_menu_items .= "</ul>";

                    return $sub_menu_items;
        }// end function _generateSubItems


        /**
	 * This function w=ill be replacing the top method to get menu
	 * it requires only options
	 * @param unknown_type $data
	 */
	private function _getMenu($data){
		$menu_items = array();
		foreach($data as $k => $v){
			$menu_item = new stdClass();						
                        $menu_item->url = $v['url'];                        
			$menu_item->title = $v['title'];
                        $menu_item->submenu = $v['submenu'];
			$menu_items[] = $menu_item;
                }
		return $menu_items;
	}// end function 
}
