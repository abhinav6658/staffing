<?php

/**
* File contains all the ajax call from timesheet
* Writen by Prashant Kumar on March 2, 2020 17:50:26
*/
class TimesheetAjax extends CI_Controller
{
	
	function __construct() {
		parent:: __construct();
		$this->load->helper('custom_helper');
		$this->load->helper('guid_creator_helper');
		$this->load->model('global_model');
	}

	public function monthDays() {
		// $start_date     = date('Y-m-d', strtotime($_GET['start']));
		// $only_date      = explode("-", $start_date);
		// $date_var       = ltrim($only_date[2], '0');
		// $end_date       = date('Y-m-d', strtotime($_GET['end']));
		// $end_only_date  = explode("-", $end_date);
		// $for_date_day   = 1;
		$strcount       = 1;

		$start_date     = date('Y-m-d', strtotime($_GET['start']));
		$end_date       = date('Y-m-d', strtotime($_GET['end']));

		$begin = $start_date;
		$end = $end_date;

			$current_date = $begin;
			$str = '<table class="table table-striped table-borderless"><thead></thead><tbody><tr>';
			while(strtotime($current_date) <= strtotime($end))
			{

			// this strcount code for line break when it display date with working hours in table	
				if($strcount == 8) {
				$str .= '</tr><tr>';
				}
				if($strcount == 15) {
					$str .= '</tr><tr>';
				}
				
				if($strcount == 22) {
					$str .= '</tr><tr>';
				}
				if($strcount == 29) {
					$str .= '</tr><tr>';
				}
				$str .= '<td>
						<table>
							<tr>
								<td>
									<input type="hidden" name="dates[]" id="date_' . $strcount . '" value="' . $current_date . '">' . $current_date . '
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group timesheet-group">
										<input class="form-control" type="text" name="hours[]" id="Hour_' . $strcount . '" value="8">
									</div>
								</td>
							</tr>
						</table>
					</td>';
			
			$strcount++;
			  
			  $current_date= date("Y-m-d",strtotime("+1 day",strtotime($current_date)));
			}

			$str .= '</tr></tbody></table>';
			echo $str;
		}

	public function tm_hours_save() {
		$consul_id 		= $_GET['c_id'];
		$con_frecy 		= $_GET['c_frecy'];
		$arr_hours 		= $_GET['hour_arr'];
		$arr_dates 		= $_GET['date_arr'];
		$ttl_hours 		= $_GET['total_exd_hour'];
		//print_r($arr_dates); die();
		 	
		$mapping_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' =>$consul_id, 'is_current'=>1, 'order_by' => 'id'));
		//echo $mapping_data[0]['vendor_id'];
		//print_r($mapping_data); die();

		/* Code added by Ruchi Acharya */
		if(empty($mapping_data)) {
		 	echo 0;
		 	exit();
		} else {
			$ts_prev_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $consul_id, 'order_by' => 'id'));
			//print_r($ts_prev_data);
			$arr_db = array();
			foreach($ts_prev_data as $ts_prev_data_val) {
				$arr = array(); 
				$Variable1 = strtotime($ts_prev_data_val['start_date']); 
				$Variable2 = strtotime($ts_prev_data_val['end_date']); 
				// 86400 sec = 24 hrs = 60*60*24 = 1 day 
				for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) { 
				                                      
					$Store = date('Y-m-d', $currentDate); 
					//$arr[] = $Store; 
					array_push($arr,$Store);
				}
				array_push($arr_db,$arr);	
			}
			$result = array();	
			foreach ($arr_db as $val) {
				foreach($val as $valtocomp) {
					//print_r($valtocomp);
					array_push($result, $valtocomp);	
				}	 
			}
			//print_r($result);
			foreach($arr_dates as $dsp) {
				foreach($result as $result_val) {
					if($result_val == $dsp) {
						//echo $dsp;
						echo 1;
					}
				}
			}
			//die();	
			// print_r($var);
			// die();
			// $arr = array(); 
			// $Variable1 = strtotime($ts_prev_data[0]['start_date']); 
			// $Variable2 = strtotime($ts_prev_data[0]['end_date']); 
			// // 86400 sec = 24 hrs = 60*60*24 = 1 day 
			// for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) { 
			                                      
			// 	$Store = date('Y-m-d', $currentDate); 
			// 	//$arr[] = $Store; 
			// 	array_push($arr,$Store);
			// } 
			//$result = array_intersect($arr, $arr_dates);
			//print_r($result);
			
			// $result = array();
			// foreach ($arr as $val) {
			//     if (($key = array_search($val, $arr_dates))!==false) {
			//         $result[] = $val;
			//         unset($arr_dates[$key]);
			//     }
			// }
			//print_r($result);
			//die();
			if($var == '1') {
			//if(!empty($result)) {
				echo "Timesheet data already exists.";
				exit();
			} else {
				$timesheet['vendor_id'] 	= $mapping_data[0]['vendor_id'];
				$timesheet['consultant_id'] = $_GET['c_id'];
				$timesheet['start_date'] 	= date('Y-m-d', strtotime($_GET['start_date']));
				$timesheet['end_date'] 		= date('Y-m-d', strtotime($_GET['end_date']));
				$timesheet['total_hrs'] 	= $_GET['total_exd_hour'];
				$total_days 				= $_GET['date_arr'];
				$timesheet['total_days'] 	= end(array_keys($total_days)) + 1;
							
				$timesheet_data = $this->global_model->set_data('panel_master_timesheettbl', $timesheet);
				echo json_encode($timesheet_data); 

				$last_ts_id = $this->db->insert_id();
				
				$ts_array = array_combine($arr_dates, $arr_hours);
				//print_r($ts_array); die();
				foreach($ts_array as $key => $arr_dates_val) {
					//print_r($key);
					//print_r($arr_dates_val);
					$ts['t_id'] 		= $last_ts_id;
					$ts['t_date'] 		= $key;
					$ts['t_hrs'] 		= $arr_dates_val;
					$ts['comment'] 		= $_GET['glo_comment'];
					$ts['uploaded_by'] 	= $this->session->userdata('email');
					//print_r($ts); die();
					$this->global_model->set_data('panel_timesheettbl', $ts);
				}
			}
		}		
	}
	public function getFrequency() {
		$sel_consult_value = $_GET['consult_val'];
		// $data['mapping_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $sel_consult_value, 'order_by' => 'id'));	
		// $str = '<select class="form-control" id="cosul_frequency"><option value="">Select Frequency</option>';
		// //echo $data['mapping_data'][0]['consult_frequency'];
		// if($data['mapping_data'][0]['consult_frequency'] == 1) { $freq = "Weekly"; } 
		// else if($data['mapping_data'][0]['consult_frequency'] == 2) { $freq = "Semi-Monthly"; } 
		// else if($data['mapping_data'][0]['consult_frequency'] == 3) { $freq =  "Monthly"; } 
		// else { $freq = ""; }
		// $str .= '<option value="' . $data['mapping_data'][0]['consult_frequency'] . '">' . $freq  . '</option>';
		// $str .= '</select>';			 
		// echo $str;
		$data['frequency'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $sel_consult_value, 'is_current'=>1, 'order_by' => 'id'));
		if($data['frequency'][0]['consult_frequency'] == 1) { $freq = "Weekly"; } 
		else if($data['frequency'][0]['consult_frequency'] == 2) { $freq = "Semi-Monthly"; } 
		else if($data['frequency'][0]['consult_frequency'] == 3) { $freq =  "Monthly"; } 
		else { $freq = ""; }
		$fre['optn_value'] = $data['frequency'][0]['consult_frequency'];
		$fre['optn_data']  = $freq;
		echo json_encode($fre); 
	}
	public function getTimesheetDate() {
		$sel_consult_value = $_GET['consult_val'];
		$data['mapping_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $sel_consult_value, 'is_current'=>1, 'order_by' => 'id'));	
		$ts_prev_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $sel_consult_value, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));

		foreach($ts_prev_data as $ts_prev_data_val){
			$ts_val['start_date'] = date("m/d/Y", strtotime($ts_prev_data_val['start_date']));
			$ts_val['end_date']   = date("m/d/Y", strtotime($ts_prev_data_val['end_date']));
			$ts_val['freq']		  = $data['mapping_data'][0]['consult_frequency'];	
		}
		if($ts_prev_data){
			echo json_encode($ts_val);
			exit();	
		} else {
			echo 0;
			exit();
		}
		
	}
	/* Code added by Ruchi Acharya */
}