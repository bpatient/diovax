<?php
/**
 * this helper will replace the default display in user listing table,
 * it will embedd edit buttons on admin/landlord/
 */
class Core_View_Helper_User extends Core_View_Helper_Base{
	/**
	 * @param object | array |string $mixed
	 * @param object $options [optional]
	 * @return string $house;
	 */
        private $oStr, $_mdl, $user;
	public function user( $mixed = "", $options = array('editing' => '','image' => '','class' => '', 'event' => '', 'site' => '','tenant' => '', 'ticket' => '', 'landlord' => '','rating' => '') ){


                if( is_array($mixed) ) $mixed = (object)$mixed;
                elseif( is_object($mixed) ) {
                    if($mixed instanceof Core_Model_Entity ) $mixed = (object)$mixed->toArray();
                }


                if( !is_object ($mixed) ){
                    throw new Exception("Object Parameter required @ ".__METHOD__." ");
                }
                /***initialization*/
                $_class = ""; $_long = ""; 
                $this->user = $mixed;
                $this->oStr = new Core_Util_String();
                
                /***/
                if( isset($options['class']) && !empty($options['class']) ) $_class = $options['class'];
                /***/
                if( isset($options['editing']) && !empty($options['editing']) ) $this->_editing = $options['editing'];
                else $this->_editing = "";
                /***/
                if( isset($options['image']) && !empty($options['image']) ) $this->_image = $options['image'];
                else $this->_image = "/assets/gallery.png";
                /***/
                if( isset($options['long']) && !empty($options['long']) ) $_long = ( $options['long'] ? true : false );
                if( $_long == true ) $_class .= ' long';

                if( isset($options['module']) && !empty($options['module']) ) $this->_mdl =  $options['module'];
                else $this->_mdl = 'admin';



				/*
                $_html = '<div class=\'user-view-helper '.$_class.'\'>';
                        $_html .= $this->_p();
                        $_html .= $this->_card();
                        $_html .= $this->_ed( );
                $_html .= '</div>';
                return $_html;
                */
                return $this->_nCard();
	}

	/**
	 * @param object $_mxd
	 * @return string $html
	 * Formats data directly from the property object
	 **/
	public function _p(){
            $_html = '<div class=\'image\'><a href=\'/'.$this->_mdl.'/user/view/'.$this->user->id.'\'><img src=\''.$this->_image.'\'/></a></div>';
            return $_html;
	}

        /***/
	private function _card(){           
            $_html = "<div class='right'>".
                    "<div class='name'>".$this->user->name."</div>".
                    "<div class='email'>".$this->user->email."</div>".
                    "<div class='category'>".$this->user->category."</div>".
                    "<div class='banned'>".( $this->user->banned ? "Banned" : " Not Banned" ) ."</div>".
                    "<div class='active'>".( $this->user->active ? "Active" : "Not Active" ) ."</div>".
               "</div>";
           return $_html;
        }

        /***/
	private function _ed(){
           if( $this->_editing ) return "<div class='edit-widget'>".$this->_editing."</div>";
           return "";
        }
        
        private function _nCard(){
        		
        		
        		
        	$_html = "<div class='supTicket nobg'>".
        			        		"<div class='issueType'>".
        			        	"<span class='issueInfo'><a href='". ( $this->_mdl.'/user/view/'.$this->user->id ). "' title='' class='floatleft'>".$this->user->name."</a></span>".
        			        	                            "<span class='issueNum'>[ #".$this->user->id." ]</span>".
        			        	"<div class='fix'></div>".
        			        	"</div>".
        
        			        	"<div class='issueSummary'>".
        			        	                       		"<a href='". ( $this->_mdl.'/user/view/'.$this->user->id ). "' title='' class='floatleft'><img src='/assets/images/avatar.png' alt='' /></a>".	
        			        	                            "<div class='ticketInfo'>".
        			        	                            	"<ul>".
        			        	                                	"<li><a href='#' title=''>".$this->user->email."</a></li>".
        			        	"<li class='even'><strong class='red'>[ ".$this->user->category." ]</strong></li>".
        			        	"<li>Status: <strong class='".( $this->user->banned ? "red" : "green" ) ."'>[ ".( $this->user->banned ? "Banned" : "Allowed" ) ." ]</strong></li>".
        			        	"<li class='even'> ".( isset($this->user->created) ? " Since ". date("M d, Y",  strtotime( $this->user->created ) ): " " )."</li>".
        			        	"</ul>".
        			        	"<div class='fix'></div>".
        			        	"</div>".
        			        	"<div class='fix'></div>".
        			        	"</div>".
        			        	"</div>";
        
        	return $_html;
        }




        

		
}
?>
