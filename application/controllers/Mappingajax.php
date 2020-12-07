<?php

/**
* Vendor consultant mapping ajax
* Written by Prashant Kumar on Frb 26, 2020 19:13:16
*/
class Mappingajax extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		$this->load->model('global_model');
		$this->load->helper('guid_creator_helper');
	}

	public function save_mapping_data() {

		$guid = GUID();

		/*consultant creation*/
		$consult['org_id']          = $_GET['orgn_id'];
		$consult['guid']            = $guid;
		$consult['name']            = $_GET['con_name'];
		$consult['email']           = $_GET['con_email'];
		$consult['phone']           = $_GET['con_phone'];
		$consult['consultant_type'] = $_GET['con_type'];
		$consult['vendor_id'] 		= $_GET['ven'];
		$consult['start_date'] = date("Y-m-d", strtotime($_GET['start']));

		$consult_pre_data = $this->global_model->get_data('panel_consultanttbl', array('email' => $consult['email'], 'order_by' => 'consultant_id'));
		if(!empty($consult_pre_data)) {
			echo 0;
			exit();
		} else {
			$consult_data = $this->global_model->set_data('panel_consultanttbl', $consult);
			/*consultant creation*/

			/*consultant vendor mapping*/
			if($consult_data['insert_id'] != "") {

				$cosnult_data_arr = $this->global_model->get_data('panel_consultanttbl', array('consultant_id' => $consult_data['insert_id'], 'order_by' => 'consultant_id'));
				$mapping_data['client']              = $_GET['client'];
				$mapping_data['consultant_id']       = $cosnult_data_arr[0]['guid'];
				$mapping_data['vendor_id']           = $_GET['ven'];
				$mapping_data['consultant_type']     = $_GET['con_type'];
				$mapping_data['project_id']          = 1;
				$mapping_data['project_name']        = $_GET['project'];
				$mapping_data['consult_frequency']   = $_GET['frec_con'];
				$mapping_data['start_date']          = date("Y-m-d", strtotime($_GET['start']));
				if($_GET['end'] != "") {
					$mapping_data['end_date']        = date("Y-m-d", strtotime($_GET['end']));
				} else {
					$mapping_data['end_date']        = "0000-00-00";
				}
				$mapping_data['role']                = $_GET['role'];
				$mapping_data['project_location']    = $_GET['location'];
				$mapping_data['city']                = $_GET['city'];
				$mapping_data['state']               = $_GET['state'];
				$mapping_data['recruiter_name']      = $_GET['recruiter'];
				$mapping_data['manager_name']        = $_GET['manager'];
				$mapping_data['cost']                = $_GET['cost'];
				$mapping_data['sell']                = $_GET['sell'];
				$mapping_data['cost_effective_date'] = date("Y-m-d", strtotime($_GET['bill_effective']));
				$mapping_data['sell_effective_date'] = date("Y-m-d", strtotime($_GET['pay_effective']));
				$mapping_data['cost_rate_type']      = $_GET['cost_rate_tp'];
				$mapping_data['sell_rate_type']      = $_GET['bill_rate_tp'];
				$mapping_data['status']              = 1;
				$mapping_data['is_current']          = 1;
				$mapping_data['created_on']          = date("Y-m-d H:i:s");

				$user_get_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $_GET['con'], 'order_by' => 'id'));

				foreach ($user_get_data as $user_get_val) {
					$user_get_val['is_current']  = 0;
					$user_get_val['status']      = 0;
					$user_get_val['modified_on'] = date("Y-m-d H:i:s");
					$this->global_model->set_data('panel_emp_vendor_mappingtbl', $user_get_val);
				}

				$map_data = $this->global_model->set_data('panel_emp_vendor_mappingtbl', $mapping_data);
			}
		}

		/*consultant vendor mapping*/

		if($map_data['insert_id'] != "") {
			echo 1;
		}
	}

	public function edit_mapping_data() {

		if(isset($_GET['con']) && $_GET['con'] != "") {
			/*consultant update*/
			$consult['name']            = $_GET['con_name'];
			$consult['email']           = $_GET['con_email'];
			$consult['phone']           = $_GET['con_phone'];
			$consult['consultant_type'] = $_GET['con_type'];
			$consult['vendor_id'] 		= $_GET['ven'];

			$this->db->where('guid', $_GET['con']);

			$consult_data = $this->db->update('panel_consultanttbl', $consult);
			/*consultant update*/
		}

		/*consultant vendor mapping*/
		if($consult_data == 1) {

			$cosnult_data_arr = $this->global_model->get_data('panel_consultanttbl', array('consultant_id' => $consult_data['insert_id'], 'order_by' => 'consultant_id'));

			$mapping_data['client']              = $_GET['client'];
			$mapping_data['consultant_id']       = $_GET['con'];
			$mapping_data['vendor_id']           = $_GET['ven'];
			$mapping_data['consultant_type']     = $_GET['con_type'];
			$mapping_data['project_id']          = 1;
			$mapping_data['project_name']        = $_GET['project'];
			$mapping_data['consult_frequency']   = $_GET['frec_con'];
			$mapping_data['start_date']          = date("Y-m-d", strtotime($_GET['start']));
			if($_GET['end'] != "") {
				$mapping_data['end_date']        = date("Y-m-d", strtotime($_GET['end']));
			} else {
				$mapping_data['end_date']        = "0000-00-00";
			}
			$mapping_data['role']                = $_GET['role'];
			$mapping_data['project_location']    = $_GET['location'];
			$mapping_data['city']                = $_GET['city'];
			$mapping_data['state']               = $_GET['state'];
			$mapping_data['recruiter_name']      = $_GET['recruiter'];
			$mapping_data['manager_name']        = $_GET['manager'];
			$mapping_data['cost']                = $_GET['cost'];
			$mapping_data['sell']                = $_GET['sell'];
			$mapping_data['cost_effective_date'] = date("Y-m-d", strtotime($_GET['bill_effective']));
			$mapping_data['sell_effective_date'] = date("Y-m-d", strtotime($_GET['pay_effective']));
			$mapping_data['cost_rate_type']      = $_GET['cost_rate_tp'];
			$mapping_data['sell_rate_type']      = $_GET['bill_rate_tp'];
			$mapping_data['status']              = 1;
			$mapping_data['is_current']          = 1;
			$mapping_data['created_on']          = date("Y-m-d H:i:s");

			$user_get_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $_GET['con'], 'order_by' => 'id'));

			foreach ($user_get_data as $user_get_val) {
				$user_get_val['is_current']  = 0;
				$user_get_val['status']      = 0;
				$user_get_val['modified_on'] = date("Y-m-d H:i:s");
				$this->global_model->set_data('panel_emp_vendor_mappingtbl', $user_get_val);
			}

			$data = $this->global_model->set_data('panel_emp_vendor_mappingtbl', $mapping_data);
		}

		/*consultant vendor mapping*/

		if($data['insert_id'] != "") {
			echo 1;
		}
	}
}