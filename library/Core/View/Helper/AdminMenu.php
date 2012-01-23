<?php
class Core_View_Helper_AdminMenu{


	private $_object;
	public function adminMenu( Core_Entity_Abstract $entity , $options = array('display' => 0 ) ){
			
		$this->_object = $entity;
		$_html = $this->_analytics();
		$display = $options['display'];
		switch ( $display ){




			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_INDEX:
				$_html = $this->_index();
				break;

			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_USER:
				$_html = $this->_customer();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_MEDIA:
				$_html = $this->_media();
				break;

			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_PROPERTY:
				$_html = $this->_property();
				break;	
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_ANALYTICS:
				$_html = $this->_analytics();
				break;
			default:
				$_html = $this->_index();
			break;


		}


		return $_html;
			
	}








	private function _index(){
		$_html = '<ul id="menu" class="navigation menu">
				<li class="dash"><a href="/admin/analytics/index"><span>Dashboard</span></a></li>
				<li class="dash"><a href="/admin/user/index"><span>Customers</span></a></li>
				<li class="dash"><a href="/admin/customer/index"><span>Customer</span></a></li>
				<li class="dash"><a href="/admin/media/index"><span>Media</span></a></li>
			</ul>';
		return $_html;
	}



	private function _customer(){
		$_html = "<ul class='menu span-5'>
				<li><a class='link' href='/admin/user/edit'><span class='add-link'>Add/Edit User</span></a></li>
				<li><a class='link' href='/admin/user'><span class='add-link'>Home</span></a></li>
			</ul>";
		return $_html;
	}



	private function _media(){
		$_html = "<ul class='menu span-5'>
			<li><a class='link' href='/admin/media'><span class='add-link'>Media</span></a></li>
			<li><a class='link' href='/admin/media/upload'><span class='add-link'>Upload</span></a></li>
		</ul>";
		return $_html;
	}




	private function _property(){
		$this->property = $this->_object;
		$_html = "<ul class='menu'>
    		<li><a class='link' href='/admin/property/edit/'><span class='add-link'>Add a Property</span></a></li>";
		if(is_object($this->property) && $this->property->id > 0 ){
			$_html .= "<li><a class='link' href='/admin/property/edit/".( $this->property->id )."?pid=".(  $this->property->id ) ."&token=".(  $this->property->token ) ."'><span class='add-link'>View</a></span></li>
			<li><a class='link' href='/admin/property/view/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Amenities</a></span></li>
			<li><a class='link' href='/admin/property/operation/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Occupancy</a></span></li>
			";
		}
		$_html .= "</ul>";
		return $_html;
	}



	
	private function _analytics(){
	$_html = "<ul class='menu span-5'>
				<li><a class='link' href='/admin/analytics/'><span class='add-link'>Dashboard</span></a></li>
				<li><a class='link' href='/admin/analytics/customer'><span class='add-link'>Customer</span></a></li>
				<li><a class='link' href='/admin/analytics/property'><span class='add-link'>Property</span></a></li>
				<li><a class='link' href='/admin/analytics/profitability'><span class='add-link'>Profitability</span></a></li>
			</ul>";
	return $_html;
	}
	


}


?>