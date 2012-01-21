<?php
class Core_View_Helper_AdminMenu{


	private $_object;
	public function adminMenu( Core_Entity_Abstract $entity , $options = array('display' => 0 ) ){
			
		$this->_object = $entity;
		$_html = $this->_analytics();
		$display = $options['display'];
		switch ( $display ){


			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_ANALYTICS:
				$_html = $this->_analytics();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_BILLING:
				$_html = $this->_billing();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_BOOKING:
				$_html = $this->_booking();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_CUSTOMER:
				$_html = $this->_customer();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_INDEX:
				$_html = $this->_index();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_LEASE:
				$_html = $this->_lease();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_LOCATION:
				$_html = $this->_location();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_MEDIA:
				$_html = $this->_media();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_MESSAGE:
				$_html = $this->_message();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_PROPERTY:
				$_html = $this->_property();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_SETTINGS:
				$_html = $this->_settings();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_TASK:
				$_html = $this->_task();
				break;
			case Core_Util_Settings::MENU_ADMIN_CONTROLLER_TECH:
				$_html = $this->_tech();
			break;
			
			default:
				$_html = $this->_index();
			break;
					
					
		}


		return $_html;
			
	}





	private function _analytics(){
		$_html = '';

		return $_html;
	}

	private function _billing(){

		$_html = '';

		return $_html;
	}

	private function _booking(){
		$_html = "<ul class='menu'>
		<li><a class='link' href='/landlord/booking/index'><span class='add-link'>All Bookings</span></a></li>
		<li><a class='link' href='/landlord/booking/edit'><span class='add-link'>New Booking</span></a></li>
		<li><a class='link' href='/landlord/booking/requests'><span class='add-link'>Requests</span></a></li>
		<li><a class='link' href='/landlord/lease/index'><span class='add-link'>Leases</span></a></li>
		<li><a class='link' href='/landlord/booking/schedule'><span class='add-link'>Schedule</span></a></li>
		<li><a class='link' href='/landlord/booking/events'><span class='add-link'>Events</span></a></li>
		<li><a class='link' href='/landlord/booking/event'><span class='add-link'>Add Event</span></a></li>
		<li><a class='link' href='/landlord/booking/staffs'><span class='add-link'>Staff members</span></a></li>
		<li><a class='link' href='/landlord/booking/staff'><span class='add-link'>Add Staff</span></a></li>
		</ul>";

		return $_html;
	}

	private function _customer(){
		$_html = '';
		return $_html;
	}

	private function _handymen(){
		$_html = "<ul class='menu'>
				    <li><a class='link' href='/landlord/settings/search'><span class='add-link'>Search</span></a></li>
				    <li><a class='link' href='/landlord/settings/requests'><span class='add-link'>Requests</span></a></li>
				    <li><a class='link' href='/landlord/settings/handymen'><span class='add-link'>My Handymen</span></a></li>
				    <li><a class='link' href='/landlord/settings/staffs'><span class='add-link'>My Staff</span></a></li>
				    <li><a class='link' href='/landlord/settings/staff'><span class='add-link'>Add Staff</span></a></li>
				    <li><a class='link' href='/landlord/settings/billing'><span class='add-link'>Billing</span></a></li>
				</ul>";
		return $_html;
	}

	private function _index(){
		$_html = '<ul id="menu" class="navigation menu">
				<li class="dash"><a href="/landlord/analytics/index"><span>Dashboard</span></a></li>
				<li class="dash"><a href="/landlord/property/index"><span>Property</span></a></li>
				<li class="cal"><a href="/landlord/booking/index"><span>Booking</span></a></li>
				<li class="dash" ><a href="/landlord/booking/occupancy/"><span>Occupancy</span></a></li>
				<li class="dash"><a href="/landlord/customer/index"><span>Customer</span></a></li>
				<li class="dash"><a href="/landlord/tech/index"><span>Handymen</span></a></li>
				<li class="dash"><a href="/landlord/task/index"><span>Task</span> </a></li>
				<li class="dash"><a href="/landlord/settings/index"><span>Settings</span></a></li>
			</ul>';
		return $_html;
	}

	private function _lease(){
		$_html = "<ul class='menu'>
				    <li><a class='link' href='/landlord/lease/index'><span class='add-link'>Leases</span></a></li>
				    <li><a class='link' href='/landlord/lease/edit'><span class='add-link'>Edit Lease</span></a></li>
				    <li><a class='link' href='/landlord/booking/index'><span class='add-link'>Booking</span></a></li>
				</ul>";
		return $_html;
	}

	private function _location(){
		$_html = $this->_property();
		return $_html;
	}

	private function _media(){
		$_html = '';
		return $_html;
	}

	private function _message(){
		$_html = '';
		return $_html;
	}


	private function _property(){
		$this->property = $this->_object;
		$_html = "<ul class='menu'>
    		<li><a class='link' href='/landlord/property/edit/'><span class='add-link'>Add a Property</span></a></li>";
		if(is_object($this->property) && $this->property->id > 0 ){
			$_html .= "<li><a class='link' href='/landlord/property/view/".( $this->property->id )."?pid=".(  $this->property->id ) ."&token=".(  $this->property->token ) ."'><span class='add-link'>View</a></span></li>
			<li><a class='link' href='/landlord/property/amenities/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Amenities</a></span></li>
			<li><a class='link' href='/landlord/property/availability/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Occupancy</a></span></li>
			<li><a class='link' href='/landlord/property/detail/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Features</a></span></li>
			<li><a class='link' href='/landlord/booking/index/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Booking</a></span></li>
			<li><a class='link' href='/landlord/lease/index/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Leases</a></span></li>
			<li><a class='link' href='/landlord/property/location/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Address</a></span></li>
			<li><a class='link' href='/landlord/property/media/?pid=".(  $this->property->id )."&token=".(  $this->property->token )."'><span class='add-link'>Photos</a></span></li>";
		}
		$_html .= "<li><a class='link' href='/landlord/location/edit/'><span class='add-link'>Add Location</span></a></li>
		</ul>";
		return $_html;
	}

	private function _settings(){
		$_html = "<ul class='menu'>
		<li><a class='link' href='/landlord/settings/profile'><span class='add-link'>Public Profile</span></a></li>
		<li><a class='link' href='/landlord/settings/account'><span class='add-link'>Account Admin</span></a></li>
		<li><a class='link' href='/landlord/settings/contact'><span class='add-link'>Company Profile</span></a></li>
		<li><a class='link' href='/landlord/settings/plan'><span class='add-link'>Plan</span></a></li>
		<li><a class='link' href='/landlord/settings/message'><span class='add-link'>Notice & Message</span></a></li>
		<li><a class='link' href='/landlord/settings/billing'><span class='add-link'>Billing</span></a></li>
		</ul>";
		return $_html;
	}

	private function _task(){
		$_html = "<ul class='menu span-5'>
			<li><a class='link' href='/landlord/task/ticket'><span class='add-link'>Add Ticket</span></a></li>
			<li><a class='link' href='/landlord/task/index'><span class='add-link'>Customer Tickets</span></a></li>
			<li><a class='link' href='/landlord/task/tasks'><span class='add-link'>Tech Tasks</span></a></li>
		</ul>";
		return $_html;
	}
	
	private function _tech(){
		$_html = '';
		return $_html;
	}


}


?>