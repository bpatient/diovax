<?php
/**
 * This class will help to list photos for a property and enable/disable, edit content and much more.
 * @author Pascal Maniraho
 *
 */
class Core_View_Helper_Photo extends Zend_View_Helper_Abstract{
	/**have to use kml content from google*/
	public function photo($mixed, $options = array ( 'class' => '',  'property' => '' )){


            $param = '';
            if( $mixed instanceof Core_Entity_Media ) {
            	$this->media = $mixed;
            }
            if( $mixed instanceof Core_Model_Media ){
            	$this->media = $mixed->toArray();
            }elseif( is_array($mixed) ) {
            	$this->media = Core_Util_Factory::build($mixed, Core_Util_Factory::ENTITY_MEDIA);//new Core_Model_Media( $mixed );
            }else if( !($mixed instanceof Core_Entity_Media) ){
            	$this->media = Core_Util_Factory::build(array(), Core_Util_Factory::ENTITY_MEDIA);
            }

            $this->selected = 0;/***/
            if( isset($options['property']) && $options['property'] != null ) $this->selected = (int)$options['property'];

            $_class = ( isset($options['class']) && !empty($options['class']) ) ? $options['class'] : '';
            $_checked = "";
            if( $this->media->id == $this->selected ||  $this->media->token == $this->selected  ){ $_checked = 'checked=\'checked\''; }
            $_class = ( isset($options['class']) && !empty($options['class']) ) ? ' class =\''.$options['class'].'\' ' : '';
            $_id = ( isset($options['id']) && !empty($options['id']) )? ' id =\''.$options['id'].'\' ' : '';
            $_content ="Media Selector";
            $_content ='<div class=\'photo\'>';
                $_content .='<div class=\'checkbox\'><input type=\'checkbox\' name=\'media\' value=\''.$this->media->id.'\' '.$_checked.'/></div>';
                    $_content .='<div class=\'thumbnail\'><image src=\'/assets/img/t/'.$this->media->media_value.'\'/></div>';
                    $_content .='<div class=\'left\'><div class=\'name\'><input type=\'text\' name=\'title\' value=\''.$this->media->title.'\'/></div>';
                    $_content .='<div class=\'media\'><input type=\'text\' name=\'caption\' value=\''.$this->media->caption.'\'/></div>';
                    $_content .='<div class=\'description\'><textarea class=\'note\' name=\'description\'>'.$this->media->description.'</textarea></div>';
                    $_content .='</div>';
            $_content .='</div>';
            $_html = '<div class=\'helper-photo '.$_class.'\'>'.$_content.'</div>';
            return $_html;
	}

}

?>