<?php

/**
* Timesheet management controller class
* Written by Prashant Kumar on Feb 24, 2020 14:45:25
*/
class Timesheet extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		$this->load->helper('guid_creator_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->load->model('global_model');
		$this->load->helper('custom_helper');
		hooks()->do_action('after_clients_area_init', $this);
		/**
         * The Clients.php controller methods requires a logged in contact
         */
		if (!is_client_logged_in()) {
			redirect_after_login_to_current_url();
			redirect(site_url('authentication/login'));
		}

		if (is_client_logged_in() && !is_contact_email_verified()) {
			redirect(site_url('verification'));
		}
	}

	public function index() {
		$data['consultant_data'] = $this->global_model->get_data('panel_consultanttbl', array());
		$data['title']           = 'Timesheet';
		$this->templated->load('Backend/default_layout', 'contents', 'timesheet/timesheet', $data);
	}


	public function delete_timesheet() {
		if($this->input->get('id')){

			$del_data = $this->global_model->get_data('panel_master_timesheettbl', array("id"=>$this->input->get('id'),'order_by' => 'id'));
          
           $path = $del_data[0]['file_path'];

           delete_files($path, true , false, 1);

            $this->global_model->del_data('panel_master_timesheettbl',array("id"=>$this->input->get('id')));
            $message    = array("1","Successfully Delete");
        }

								if($message[0] == 1) {

			$this->global_model->del_data('panel_timesheettbl',array("t_id"=>$this->input->get('id')));

									$success_message = 'Records Deleted successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect(base_url('time-expense-report'),'location');
								} else {
									$error_message = 'Something Went Wrong';
									$this->session->set_flashdata('error_message',$error_message);  
									redirect(base_url('time-expense-report'),'location');
								}
						

	}

	public function timesheet_report($report = null) {
		$data['title']         = 'Old TimeSheet Report';
		$data['breathcum']     = 'Old TimeSheet Report';

		
		$data['con_data']   = $this->global_model->Timesheet_Report_list($post);
		
		$inc = 0;
		foreach ($data['con_data'] as $con_val) {
			$v_c_mapping = $this->global_model->get_data('panel_consultanttbl', array('guid' => $con_val['consultant_id'], 'order_by' => 'consultant_id', 'cond' => 'DESC'));
			foreach ($v_c_mapping as $v_c_map_key => $v_c_map_val) {
				$vendor_id = $con_val['vendor_id'];
				$ven_data  = $this->global_model->get_data('panel_vendortbl', array('guid' => $vendor_id, 'order_by' => 'vendor_id'));
				if(!empty($ven_data)) {
					$v_c_map_val['vendor_name'] = $ven_data[0]['name'];
				} else {
					$v_c_map_val['vendor_name'] = 'W2';
				}
				if($v_c_map_key == (count($v_c_map_key)-1)) {
					$data['mapping_data'][$inc] = $v_c_map_val;
					$inc++;
				}
			}
		}

		//print_r($data['mapping_data']);
		// $data['filt_con'] = $this->global_model->get_data('panel_consultanttbl', array());
		// $data['con_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());

		$this->templated->load('Backend/default_layout', 'contents', 'timesheet/time_expense_report', $data);
	}

	

	public function timesheet_upload() {
		$data['title']  	= 'Upload Timesheet';
		$data['breatcumb'] 	= 'Upload Timesheet';
		//var_dump($_POST);
		if(isset($_POST['submit'])) {
			$consultant_id = $this->input->post('consultant_sel');
			if($_POST['hours']){
				$arr_hours = array();
				$total_expended_hours = 0;
				foreach($_POST['hours'] as $key => $hrstext_field){
					//$hrs_field_vals .= $hrstext_field .", ";
					array_push($arr_hours, $hrstext_field);
					$total_expended_hours = $hrstext_field + $total_expended_hours;
				}
			}
			if($_POST['dates']){
				$arr_dates = array();
				foreach($_POST['dates'] as $key => $datetext_field){
					//$dates_field_vals .= $datetext_field .", ";
					array_push($arr_dates, $datetext_field);
				}
			}

			$mapping_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' =>$consultant_id, 'is_current' => 1, 'order_by' => 'id'));
			if(empty($mapping_data)) {
				echo 0;
				exit();
			} else {

				$ts_prev_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $consultant_id, 'order_by' => 'id'));
				//print_r($ts_prev_data); die();

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
							//echo 1;
							$var = 1;
						} else {
							$var = 0;
						}
					}
				}
				//echo $var ; //die();
				if($var == '1') {
					//echo "Timesheet data already exists.";
					if($this->uri->segment(3) != '') {
						$error_message = 'Timesheet data already exists.Please try again.';
						$this->session->set_flashdata('error_message',$error_message);  
						redirect('pending-timesheet');
					} else {
						$error_message = 'Timesheet data already exists.Please try again.';
						$this->session->set_flashdata('error_message',$error_message);  
						redirect('time-sheet');
					}
					//exit();
				} else {
					//if($consultant_sel != "" || $cosul_frequency != ""  || $start_date != ""  || $end_date != ""  || $fileupload != "") {
						$timesheet['vendor_id'] 	= $mapping_data[0]['vendor_id'];
						$timesheet['consultant_id'] = $consultant_id;
						$timesheet['start_date'] 	= date('Y-m-d', strtotime($this->input->post('start_date')));
						$timesheet['end_date'] 		= date('Y-m-d', strtotime($this->input->post('end_date_hidden')));
						$timesheet['total_hrs'] 	= $total_expended_hours;
						$total_days 				= $arr_dates;
						$timesheet['total_days'] 	= end(array_keys($total_days)) + 1;
						$timesheet['comment'] 		= $this->input->post('comment');

						$guid = GUID();
						$file_id = 'FILE_'.$guid;
						$file_name = $guid;	

						if($path == '') {
							if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$file_id)) {
								mkdir($_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$file_id, 0777 , true);
							}
							$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$file_id;
						} else {
							$config['upload_path'] = $path;
						}

						$config['allowed_types'] = 'pdf|docx|doc|xlsx|csv|xls|jpeg|jpg|png';
						$config['overwrite'] = false;
						$config['remove_spaces'] = TRUE;
						$config['file_name'] = $file_name;
				// echo "1";
						$file_ext = array_filter(explode('.', $_FILES['fileupload']['name']));
						$fileExt = array_pop($file_ext);
				//print_r($fileExt); die();
						if($fileExt == 'pdf' || $fileExt == 'docx' || $fileExt == 'doc' || $fileExt == 'xlsx' || $fileExt == 'csv' || $fileExt == 'xls' || $fileExt == 'jpeg' || $fileExt == 'jpg' || $fileExt == 'png') {
							
							if(!empty($_FILES['fileupload'])) {
								$_FILES['file']['name']     = $_FILES['fileupload']['name'];
								$_FILES['file']['type']     = $_FILES['fileupload']['type'];
								$_FILES['file']['tmp_name'] = $_FILES['fileupload']['tmp_name'];
								$_FILES['file']['error']    = $_FILES['fileupload']['error'];
								$_FILES['file']['size']     = $_FILES['fileupload']['size'];

								$this->load->library('upload', $config);
								$this->upload->initialize($config);
							// Upload file to server
								if($this->upload->do_upload('file')) {
							// Uploaded file data
									$fileData = $this->upload->data();
									$uploadData = $fileData['file_name'];
									$timesheet['uploaded_file_name']  	= $fileData['file_name'];
									$timesheet['file_name']  	= $_FILES['file']['name'];
									$timesheet['file_path']  	= $config['upload_path'];
									$timesheet['uploaded_by'] 	= $this->session->userdata('email');
								} else {
									echo $this->upload->display_errors();
								}
								$upload = implode(',',$uploadData);
							}
						//print_r($timesheet); die();
							$timesheet_data = $this->global_model->set_data('panel_master_timesheettbl', $timesheet);
						//echo json_encode($timesheet_data); 
							$last_ts_id = $this->db->insert_id();
						//echo $last_ts_id;
							$ts_array = array_combine($arr_dates, $arr_hours);
							foreach($ts_array as $key => $arr_dates_val) {
						//print_r($key);
						//print_r($arr_dates_val);
								$ts['t_id'] 		= $last_ts_id;
								$ts['t_date'] 		= $key;
								$ts['t_hrs'] 		= $arr_dates_val;
								$ts['comment'] 		= $this->input->post('comment');
								$ts['uploaded_by'] 	= $this->session->userdata('email');
						//print_r($ts); die();
								$ts_upload = $this->global_model->set_data('panel_timesheettbl', $ts);

							}
							if($ts_upload){
								if($this->uri->segment(3) != '') {
									$success_message = 'Records added successfully';
								$this->session->set_flashdata('success_message',$success_message);  
									redirect('pending-timesheet');
								} else {
									$success_message = 'Records added successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect('time-sheet');
								}
							}
						} else {
							if($this->uri->segment(3) != '') {
								$error_message = 'Something went wrong. Please select valid File Type';
								$this->session->set_flashdata('error_message',$error_message);  
								redirect('pending-timesheet');
							} else {
								$error_message = 'Something went wrong. Please select valid File Type';
								$this->session->set_flashdata('error_message',$error_message);  
								redirect('time-sheet');
							}
						}
					
				}
			}
		}
	}
	public function getPendingTimesheet() {
		$data['title'] = 'Timesheet Pending List';
		$all_consults = $this->global_model->get_data('panel_consultanttbl', array());
		$all_vendors  = $this->global_model->get_data('panel_vendortbl', array());
		$week_dates    = getStartAndEndDate(date('W')-1, date('Y'));
		$semi_month    = semifirsttartAndEndDate();
		$semi_month1   = semisecondStartAndEndDate(date('W')-1, date('Y'));
		$monthly       = monthlyStartAndEndDate(date('W')-1, date('Y'));
		$timesheet_arr = array();

		//echo $semi_month1['start_date'];die;

		$crtime = new DateTime();
			$currenttime= $crtime->format('Y-m-d');

			//echo $currenttime; die;

		foreach ($all_consults as $all_consults_key => $all_consults_value) {
			$consult_freq_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $all_consults_value['guid'], 'is_current'=> 1, 'order_by' => 'id'));

			if($consult_freq_data[0]['consult_frequency']==1)
			{
				if($consult_freq_data[0]['start_date'] > $week_dates['end_date'])
			 {
			 	
			 }
			 else
			 {
			 	// echo count($consult_freq_data); die;

			// if($all_consults_key == (count($consult_freq_data)-1)) {
				if(!empty($consult_freq_data)) {
					$vendor_data = $this->global_model->get_data('panel_vendortbl', array('guid' => $consult_freq_data[0]['vendor_id'], 'order_by' => 'guid'));
					$documents_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $vendor_data[0]['guid'], 'doc_type' => 20, 'order_by' => 'doc_id'));

					foreach ($documents_data as $documents_data_key => $documents_data_value) {
						if($documents_data_key == (count($documents_data)-1)) {
							$coi_data = $documents_data_value;
						}
					}
					$consult_timesheet_freq = $consult_freq_data['consult_frequency'];
					$sheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('vendor_id' => $consult_freq_data[0]['vendor_id'], 'consultant_id' => $consult_freq_data[0]['consultant_id'], 'start_date' => $week_dates['start_date'], 'end_date' => $week_dates['end_date']));



					//echo "<pre>";
					//print_r($consult_freq_data[0]['vendor_id']);
					if(empty($sheet_data)) {
						$timesheet[$all_consults_key]['consult_name'] = $all_consults_value['name'];
						$timesheet[$all_consults_key]['consultant_id']= $all_consults_value['consultant_id'];
						
						$timesheet[$all_consults_key]['date_from']    = $week_dates['start_date'];
						$timesheet[$all_consults_key]['date_to']      = $week_dates['end_date'];
						$timesheet[$all_consults_key]['vendor_name']  = $vendor_data[0]['name'];
						$timesheet[$all_consults_key]['start_date']   = $consult_freq_data[0]['start_date'];
						$timesheet[$all_consults_key]['end_date']   = $consult_freq_data[0]['end_date'];
						$timesheet[$all_consults_key]['freuency']     = $consult_freq_data[0]['consult_frequency'];
						$timesheet[$all_consults_key]['coi_expiry']   = $coi_data['valid_to'];
						$timesheet[$all_consults_key]['client_name']  = $consult_freq_data[0]['client'];
						// array_push($timesheet_arr, $consult_freq_data[0]['consultant_id']);
						$timesheet_count++;
					}
				}
			// }
			 	
			 }

			}
			elseif($consult_freq_data[0]['consult_frequency']==2)
			{
				 

				 if($currenttime>=$semi_month['end_date1'] && $currenttime<$semi_month1['end_date'])
				 {
				 	// echo "abhinav"; die;

			// if($all_consults_key == (count($consult_freq_data)-1)) {
				if(!empty($consult_freq_data)) {
					$vendor_data = $this->global_model->get_data('panel_vendortbl', array('guid' => $consult_freq_data[0]['vendor_id'], 'order_by' => 'guid'));
					$documents_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $vendor_data[0]['guid'], 'doc_type' => 20, 'order_by' => 'doc_id'));

					foreach ($documents_data as $documents_data_key => $documents_data_value) {
						if($documents_data_key == (count($documents_data)-1)) {
							$coi_data = $documents_data_value;
						}
					}
					$consult_timesheet_freq = $consult_freq_data['consult_frequency'];
					$sheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('vendor_id' => $consult_freq_data[0]['vendor_id'], 'consultant_id' => $consult_freq_data[0]['consultant_id'], 'start_date' => $semi_month['start_date'], 'end_date' => $semi_month['end_date']));



					//echo "<pre>";
					//print_r($consult_freq_data[0]['vendor_id']);
					if(empty($sheet_data)) {
						$timesheet[$all_consults_key]['consult_name'] = $all_consults_value['name'];
						$timesheet[$all_consults_key]['consultant_id']= $all_consults_value['consultant_id'];
						
						$timesheet[$all_consults_key]['date_from']    = $semi_month['start_date'];
						$timesheet[$all_consults_key]['date_to']      = $semi_month['end_date'];
						$timesheet[$all_consults_key]['vendor_name']  = $vendor_data[0]['name'];
						$timesheet[$all_consults_key]['start_date']   = $consult_freq_data[0]['start_date'];
						$timesheet[$all_consults_key]['end_date']   = $consult_freq_data[0]['end_date'];
						$timesheet[$all_consults_key]['freuency']     = $consult_freq_data[0]['consult_frequency'];
						$timesheet[$all_consults_key]['coi_expiry']   = $coi_data['valid_to'];
						$timesheet[$all_consults_key]['client_name']  = $consult_freq_data[0]['client'];
						// array_push($timesheet_arr, $consult_freq_data[0]['consultant_id']);
						$timesheet_count++;
					}
				 }
			// }

				 }
				 elseif($currenttime>=$semi_month1['end_date'] )
				 {
				 	//echo "abhinav kumar"; die;
				 	 		// echo count($consult_freq_data); die;

			// if($all_consults_key == (count($consult_freq_data)-1)) {
				if(!empty($consult_freq_data)) {
					$vendor_data = $this->global_model->get_data('panel_vendortbl', array('guid' => $consult_freq_data[0]['vendor_id'], 'order_by' => 'guid'));
					$documents_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $vendor_data[0]['guid'], 'doc_type' => 20, 'order_by' => 'doc_id'));

					foreach ($documents_data as $documents_data_key => $documents_data_value) {
						if($documents_data_key == (count($documents_data)-1)) {
							$coi_data = $documents_data_value;
						}
					}
					$consult_timesheet_freq = $consult_freq_data['consult_frequency'];
					$sheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('vendor_id' => $consult_freq_data[0]['vendor_id'], 'consultant_id' => $consult_freq_data[0]['consultant_id'], 'start_date' => $semi_month1['start_date'], 'end_date' => $semi_month1['end_date']));



					//echo "<pre>";
					//print_r($consult_freq_data[0]['vendor_id']);
					if(empty($sheet_data)) {
						$timesheet[$all_consults_key]['consult_name'] = $all_consults_value['name'];
						$timesheet[$all_consults_key]['consultant_id']= $all_consults_value['consultant_id'];
						
						$timesheet[$all_consults_key]['date_from']    = $semi_month1['start_date'];
						$timesheet[$all_consults_key]['date_to']      = $semi_month1['end_date'];
						$timesheet[$all_consults_key]['vendor_name']  = $vendor_data[0]['name'];
						$timesheet[$all_consults_key]['start_date']   = $consult_freq_data[0]['start_date'];
						$timesheet[$all_consults_key]['end_date']   = $consult_freq_data[0]['end_date'];
						$timesheet[$all_consults_key]['freuency']     = $consult_freq_data[0]['consult_frequency'];
						$timesheet[$all_consults_key]['coi_expiry']   = $coi_data['valid_to'];
						$timesheet[$all_consults_key]['client_name']  = $consult_freq_data[0]['client'];
						// array_push($timesheet_arr, $consult_freq_data[0]['consultant_id']);
						$timesheet_count++;
					}
				}
			// }

			 }

				 

			}
			elseif($consult_freq_data[0]['consult_frequency']==3)
			{
				if($currenttime >= $monthly['end_date'])
				 {
				 		// echo "poja kumar"; die;			 	 	// echo count($consult_freq_data); die;

			// if($all_consults_key == (count($consult_freq_data)-1)) {
				if(!empty($consult_freq_data)) {
					$vendor_data = $this->global_model->get_data('panel_vendortbl', array('guid' => $consult_freq_data[0]['vendor_id'], 'order_by' => 'guid'));
					$documents_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $vendor_data[0]['guid'], 'doc_type' => 20, 'order_by' => 'doc_id'));

					foreach ($documents_data as $documents_data_key => $documents_data_value) {
						if($documents_data_key == (count($documents_data)-1)) {
							$coi_data = $documents_data_value;
						}
					}
					$consult_timesheet_freq = $consult_freq_data['consult_frequency'];
					$sheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('vendor_id' => $consult_freq_data[0]['vendor_id'], 'consultant_id' => $consult_freq_data[0]['consultant_id'], 'start_date' => $monthly['start_date'], 'end_date' => $monthly['end_date']));



					//echo "<pre>";
					//print_r($consult_freq_data[0]['vendor_id']);
					if(empty($sheet_data)) {
						$timesheet[$all_consults_key]['consult_name'] = $all_consults_value['name'];
						$timesheet[$all_consults_key]['consultant_id']= $all_consults_value['consultant_id'];
						
						$timesheet[$all_consults_key]['date_from']    = $monthly['start_date'];
						$timesheet[$all_consults_key]['date_to']      = $monthly['end_date'];
						$timesheet[$all_consults_key]['vendor_name']  = $vendor_data[0]['name'];
						$timesheet[$all_consults_key]['start_date']   = $consult_freq_data[0]['start_date'];
						$timesheet[$all_consults_key]['end_date']   = $consult_freq_data[0]['end_date'];
						$timesheet[$all_consults_key]['freuency']     = $consult_freq_data[0]['consult_frequency'];
						$timesheet[$all_consults_key]['coi_expiry']   = $coi_data['valid_to'];
						$timesheet[$all_consults_key]['client_name']  = $consult_freq_data[0]['client'];
						// array_push($timesheet_arr, $consult_freq_data[0]['consultant_id']);
						$timesheet_count++;
					}
				}
			// }	
				 	
				 }
				 else
				 {
				
				 }
				

			}
			
		}
		//sprint_r($timesheet);
		$data['timesheet'] = $timesheet;
		
		$this->templated->load('Backend/default_layout', 'contents', 'timesheet/consultlist_pen_timesheet', $data);
	}
	public function pending_timesheet() {
		$data['title'] = 'Pending Timesheet';
		$consultant_id = $this->uri->segment(2);
	    $consultant_date = $this->uri->segment(3);

		$data['consult']  = $this->global_model->get_data('panel_consultanttbl', array('consultant_id' => $consultant_id, 'order_by' => 'consultant_id'));
		$data['frequency'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $data['consult'][0]['guid'], 'is_current'=>1, 'order_by' => 'id'));
		$data['date_data'] = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $data['consult'][0]['guid'], 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));


		if($data['frequency'][0]['consult_frequency'] == 1) { $freq = "Weekly"; } 
		else if($data['frequency'][0]['consult_frequency'] == 2) { $freq = "Semi-Monthly"; } 
		else if($data['frequency'][0]['consult_frequency'] == 3) { $freq =  "Monthly"; } 
		else { $freq = ""; }
		$data['optn_value'] = $data['frequency'][0]['consult_frequency'];
		$data['optn_data']  = $freq;

		$cosul_frequency 	= $data['frequency'][0]['consult_frequency'];
		$prevdate 			= $data['date_data'][0]['end_date'];
		
		if(!empty($prevdate))
		{
		 	$data['s_date'] 	= date('m/d/Y', strtotime($prevdate. ' + 1 days'));
		
		$date_s = date($data['s_date']);
		$d = date('d', strtotime($date_s));
		$m = date('m', strtotime($date_s));
		$y = date('Y', strtotime($date_s));
		$noofdays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
		// echo $d;
		// echo $noofdays;
		//die();
		if($cosul_frequency == '1') {
					$days = 7;
				}else if($cosul_frequency == '2') {
					if($d == '01') {
						$days = 15;
					} else if($d == '16') {
						if($noofdays == '28'){
							$days = 13;
						} else if($noofdays == '29') {
							$days = 14;
						} else if($noofdays == '30') {
							$days = 15;
						} else if($noofdays == '31') {
							$days = 16;
						}
					} else {
						alert("Please select valid start date.");
						exit();
						$this->load->view('timesheet/pending-timesheet');
						
					}
				}else if($cosul_frequency == '3'){
					// echo "you are here"; die;	
					if($d == "01") {
						if($noofdays == '28'){
							$days = 28;
						} else if($noofdays == '29') {
							$days = 29;
						} else if($noofdays == '30') {
							$days = 30;
						} else if($noofdays == '31') {
							$days = 31;
						}
					} else {
						alert("Please select valid start date.");
						exit();
						$this->load->view('timesheet/pending-timesheet');
						
					}
				} else {
					$z = 0;
					//alert("Invalid fre");
				}
				
		$data['e_date'] = date('m/d/Y', strtotime($prevdate. ' + ' .$days." days"));
		//echo $start_date;
		//echo $end_date;
		$this->templated->load('Backend/default_layout', 'contents', 'timesheet/upload_pending_timesheet', $data);
	}
	else
	{
		$data['s_date'] 	= date('m/d/Y', strtotime($consultant_date));
		
		$date_s = date($data['s_date']);
		$d = date('d', strtotime($date_s));
		$m = date('m', strtotime($date_s));
		$y = date('Y', strtotime($date_s));
		 $noofdays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
		// echo $d;
		// echo $noofdays;
		//die();
		if($cosul_frequency == '1') {
					$days = 6;
				}else if($cosul_frequency == '2') {
					if($d == '01') {
						$days = 14;
					} else if($d == '16') {
						if($noofdays == '28'){
							$days = 12;
						} else if($noofdays == '29') {
							$days = 13;
						} else if($noofdays == '30') {
							$days = 14;
						} else if($noofdays == '31') {
							$days = 15;
						}
					} else {
						echo "Please select valid start date.";
						exit();
					}
				}else if($cosul_frequency == '3'){
					// echo "you are here"; die;	
					if($d == "01") {
						if($noofdays == '28'){
							$days = 27;
						} else if($noofdays == '29') {
							$days = 28;
						} else if($noofdays == '30') {
							$days = 29;
						} else if($noofdays == '31') {
							$days = 30;
						}
					} else {
						echo "Please select valid start date.";
						exit();
					}
				} else {
					$z = 0;
					//alert("Invalid fre");
				}
				
		$data['e_date'] = date('m/d/Y', strtotime($consultant_date. ' + ' .$days." days"));
		//echo $start_date;
		//echo $end_date;
		$this->templated->load('Backend/default_layout', 'contents', 'timesheet/upload_pending_timesheet', $data);
	}
}

	/* Code added by Ruchi Acharya */
}
