<?php

/**
* All the cosultant ajax are define here
* Written by Prashant Kumar Feb 24, 2020 17:03:25
*/
class ConsultantAjax extends CI_Controller
{
	
	public function __construct() {
		parent:: __construct();
		$this->load->model('global_model');
	}

	public function getConsultant() {
		$sel_value = $_GET['s_val'];
		$consultant = $this->global_model->get_data('panel_consultanttbl', array('consultant_type' => $sel_value, 'order_by' => 'name'));
		$str = '<select class="form-group" id="consultant_list"><option value="">Select Consultant</option>';
		foreach ($consultant as $consultant_val) {
			$str .= '<option value="' . $consultant_val['guid'] . '">' . $consultant_val['name'] . '</option>';
		}
		$str .= '</select>';
		echo $str;
	}

	public function getConsultantinfo() {
		$cons_id = $_GET['con_val'];
		$consultinfo = $this->global_model->get_data('panel_consultanttbl', array('guid' => $cons_id, 'order_by' => 'name'));
		$str = '<span class="view-field">Name: <span>' . $consultinfo[0]["name"] . '</span></span><span class="view-field">Email: <span>' . $consultinfo[0]["email"] . '</span></span><span class="view-field">Phone: <span>' . $consultinfo[0]["phone"] . '</span></span>';
		echo $str;
	}

	public function assignedVendor() {
		$cons_id = $_GET['con_val'];
		$assigned_Vendor = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $cons_id, 'order_by' => 'id'));
		$vendor_name = $this->global_model->get_data('panel_vendortbl', array('guid' => $assigned_Vendor[0]['vendor_id'], 'order_by' => 'vendor_id'));
		if(!empty($assigned_Vendor)) {
			if($vendor_name[0]['name'] != "") {
				$str = 'Consultant is assigned to ' . $vendor_name[0]['name'] . '. If you want to continue click next button.';
			} else {
				$str = 'Consultant is assigned to W2 consultant. If you want to continue click ok button.';
			}
			echo $str;
		}
	}

	public function r_consultant() {
		$sel_value = $_GET['r_guid'];
		$consultant = $this->global_model->get_data('panel_consultanttbl', array('guid' => $sel_value, 'order_by' => 'name'));
		echo $consultant[0]['name'];
	}

	public function consul_type() {
		$con_type = $_GET['consult_type'];
		$consultant = $this->global_model->get_data('panel_consultant_typetbl', array('consultant_type_id' => $con_type, 'order_by' => 'consultant_type_name'));
		echo $consultant[0]['consultant_type_name'];
	}

	public function consul_freq() {
		$freq_id   = $_GET['con_freq'];
		$freq_data = $this->global_model->get_data('panel_consultant_frequency', array('id' => $freq_id, 'order_by' => 'id'));
		echo $freq_data[0]['frequency'];
	}

}
