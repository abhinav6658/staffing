<?php

/**
* All the vendor ajax are define here
* Written by Prashant Kumar Feb 24, 2020 21:20:23
*/
class VendorAjax extends CI_Controller
{
	
	function __construct() {
		parent:: __construct();
		$this->load->model('global_model');
	}

	public function getVendortInfo() {
		$vend_id    = $_GET['ven_val'];
		$vendorinfo = $this->global_model->get_data('panel_vendortbl', array('guid'=>$vend_id, 'order_by'=>'name'));
		if(!empty($vendorinfo)) {
			$str = '<span class="view-field">Name: <span>' . $vendorinfo[0]["name"] . '</span></span><span class="view-field">Email: <span>' . $vendorinfo[0]["email"] . '</span></span><span class="view-field">Phone: <span>' . $vendorinfo[0]["phone"] . '</span></span>';
			echo $str;
		}
	}

	public function getVendors() {
		$sel_val = $_GET['s_val'];
		if($sel_val == 2) {
			$vendors = $this->global_model->get_data('panel_vendortbl', array());
			$str = '<select class="form-control" id="vendor_id"><option value="">Select Vendor</option>';
			foreach($vendors as $vendor) :
				$str .= '<option value="' . $vendor['guid'] . '">' . $vendor['name'] . '</option>';
			endforeach;
			$str .= '</select>';
		} else if($sel_val == 3) {
			$str = '<select class="form-control" id="vendor_id"><option value="">Select</option><option value="1099">1099 Consultant</option></select>';
		} else if($sel_val == 1) {
			$str = '<select class="form-control" id="vendor_id"><option value="">Select</option><option value="w2">W2 Consultant</option></select>';
		} else {
			$str = '<select class="form-control" id="vendor_id"><option value=""></option></select>';
		}
		echo $str;
	}

	public function review_vendors() {
		$sel_val   = $_GET['r_v_guid'];
		$r_vendors = $this->global_model->get_data('panel_vendortbl', array('guid'=>$sel_val, 'order_by'=>'name'));
		if($r_vendors[0]['name'] != "") {
			echo $r_vendors[0]['name'];
		} else {
			echo 'W2 Consultant';
		}
	}

	public function consul_state() {
		$state_code = $_GET['con_state'];
		$state_data = $this->global_model->get_data('panel_states', array('stateCode' => $state_code, 'order_by' => 'id'));
		echo $state_data[0]['stateName'];
	}
}
