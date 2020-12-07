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
		$this->load->model('global_model');
	}

	public function monthDays() {
		$start_date     = date('Y-m-d', strtotime($_GET['start']));
		$only_date      = explode("-", $start_date);
		$date_var       = ltrim($only_date[2], '0');
		$end_date       = date('Y-m-d', strtotime($_GET['end']));
		$end_only_date  = explode("-", $end_date);
		$for_date_day   = 1;
		// $row_delete     = isset($_GET['delete']) ? $_GET['delete'] : 0;

		// $str = '<table class="table table-striped table-borderless"><thead><tr><th>Date</th><th width="200px">Hours</th><th></th></tr></thead><tbody>';
		// for ($day = $date_var; $day <= $end_only_date[2]; $day++) {

		// 	if($row_delete != $day) {
		// 		$date_day = date("Y", strtotime($start_date)) . '-' . date("m", strtotime($start_date)) . '-' . $day;
		// 		$date_day_except = date("D", strtotime($date_day));
		// 		$str .= '<tr id="row_id_' . $for_date_day . '">
		// 					<td style="width: 14%">' . $day . ' ' . date("M", strtotime($start_date)) . ' ' . date("Y", strtotime($start_date)) . ', '. $date_day_except .' </td>
		// 					<td class="table-field">
		// 						<div class="form-group">
		// 							<div class="input-group mb-2 mr-sm-2">
		// 								<input type="hidden" name="dates[]" id="tm_dates_' . $for_date_day . '" value="' . $date_day . '">
		// 								<input type="text" name="tm_hours[]" id="tm_hours_' . $for_date_day . '" value="8" class="form-control">
		// 							    <div class="input-group-prepend">
		// 							    	<div class="input-group-text">Hour</div>
		// 							    </div>
		// 							</div>
		// 						</div>
		// 					</td>
		// 					<td>
		// 						<a href="#" onclick="delete_row(' . $for_date_day . ')"><img src="' . base_url("assets/") . 'images/icon/close.svg" alt="View"></a>
		// 					</td>
		// 				</tr>';
		// 		$for_date_day++;
		// 	}
		// }
		// $str .= '</tbody></table>';
		// echo $str;

		// $str = '<table class="table table-striped table-borderless"><thead><tr><th>Date</th><th width="200px">Hours</th><th></th></tr></thead><tbody>';
		$str = '<table class="table table-striped table-borderless"><thead></thead><tbody><tr>';
		for ($day = $date_var; $day <= $end_only_date[2]; $day++) {

			// if($row_delete != $day) {
			$date_day = date("Y", strtotime($start_date)) . '-' . date("m", strtotime($start_date)) . '-' . $day;
			$date_day_except = date("D", strtotime($date_day));
			$str .= '<td>
						<input type="hidden" name="dates[]" id="date_1" value="' . $date_day . '">
						' . $date_day . '
					</td>';
			}
			$str .= '</tr><tr>';
			for ($day = $date_var; $day <= $end_only_date[2]; $day++) {
				$str .= '<td>
							<div class="form-group">
								<input class="form-control" type="text" name="hours[]" id="Hour_1" value="8">
							</div>
						</td>
						';
				// $str .= '<tr id="row_id_' . $for_date_day . '">
				// 			<td style="width: 14%">' . $day . ' ' . date("M", strtotime($start_date)) . ' ' . date("Y", strtotime($start_date)) . ', '. $date_day_except .' </td>
				// 			<td class="table-field">
				// 				<div class="form-group">
				// 					<div class="input-group mb-2 mr-sm-2">
				// 						<input type="hidden" name="dates[]" id="tm_dates_' . $for_date_day . '" value="' . $date_day . '">
				// 						<input type="text" name="tm_hours[]" id="tm_hours_' . $for_date_day . '" value="8" class="form-control">
				// 					    <div class="input-group-prepend">
				// 					    	<div class="input-group-text">Hour</div>
				// 					    </div>
				// 					</div>
				// 				</div>
				// 			</td>
				// 			<td>
				// 				<a href="#" onclick="delete_row(' . $for_date_day . ')"><img src="' . base_url("assets/") . 'images/icon/close.svg" alt="View"></a>
				// 			</td>
				// 		</tr>';
				// $for_date_day++;
			//}
		}
		$str .= '</tr></tbody></table>';
		echo $str;
	}

	public function tm_hours_save() {
		$consul_id = $_GET['c_id'];
		$con_frecy = $_GET['c_frecy'];
		$arr_hours = $_GET['hour_arr'];
		$arr_dates = $_GET['date_arr'];
		$ttl_hours = $_GET['total_exd_hour'];

		$vendordata = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consul_id, 'order_by' => 'id'));
		end($vendordata);
		print_r($vendordata);
	}
}