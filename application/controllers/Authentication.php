<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Authentication extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('custom_helper');
		$this->load->library('form_validation');
		$this->load->model('authentication_model');
		$this->load->model('consultants_model');
		$this->load->model('vendors_model');
		$this->load->model('global_model');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('pagination');
		//hooks()->do_action('after_clients_area_init', $this);

		/**
         * The Clients.php controller methods requires a logged in contact
         */
        //if (!is_client_logged_in()) {
        	// redirect_after_login_to_current_url();
        	// redirect('authentication');
        //}

        //if (is_client_logged_in() && !is_contact_email_verified()) {
        	// redirect('verification');
        //}
	}
	public function index() {
		$data['title'] = 'Login';
		$this->load->view('authentication/login', $data);
	}
	public function dashboard() {
		// $data['count_consultant'] = $this->consultants_model->get_total_count();
		// $data['count_vendor'] = $this->vendors_model->get_total_count();

		$data['title'] = 'Dashboard';

		$all_consults = $this->global_model->get_data('panel_consultanttbl', array());
		$all_vendors  = $this->global_model->get_data('panel_vendortbl', array());

		$con_id_arr = array();
		$ven_id_arr = array();

		/*Code for consultant document pending count added by Prashant Kumar*/
		foreach ($all_consults as $all_consults_val) {
			array_push($con_id_arr, $all_consults_val['guid']);
		}

		$cosult_count = 0;

		foreach ($con_id_arr as $con_id_arr_val) {
			$consult_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $con_id_arr_val, 'order_by' => 'doc_id'));
			if(empty($consult_data)) {
				$cosult_count++;
			}
		}

		$data['consult_count'] = $cosult_count;
		/*Code for consultant document pending count added by Prashant Kumar*/

		/*Code for bills pending count added by Ruchi Acharya*/
		$all_bills_count  = $this->global_model->get_data('panel_master_timesheettbl', array('bill_generated' => '0', 'order_by' => 'id'));
		$bill_count = 0;
		foreach($all_bills_count as $all_bills_count_val){
			if(!empty($all_bills_count)) {
				$bill_count++;
			}
		}
		$data['bills_count'] = $bill_count;
		/*Code for bills pending count added by Ruchi Acharya*/

		/*Code for vendor document pending count added by Prashant Kumar*/
		foreach ($all_vendors as $all_vendors_val) {
			array_push($ven_id_arr, $all_vendors_val['guid']);
		}

		$vendor_count = 0;

		foreach ($ven_id_arr as $ven_id_arr_val) {
			$vendor_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $ven_id_arr_val, 'order_by' => 'doc_id'));
			if(empty($vendor_data)) {
				$vendor_count++;
			}
		}
		$data['vendor_count'] = $vendor_count;
		/*Code for vendor document pending count added by Prashant Kumar*/

		/*Code for timesheet pending added by Prashant Kumar*/
		

		$timesheet_arr = array();

		$timesheet_count = 0;
		
		// print_r($all_consults); die;
		foreach ($all_consults as $all_consults_key => $all_consults_value) {

			// print_r($all_consults_key); die;

			// $week_dates    = getStartAndEndDate(date('W')-1, date('Y'));
			// $semi_month    = semifirsttartAndEndDate();
			// $semi_month1   = semisecondStartAndEndDate(date('W')-1, date('Y'));
			// $monthly       = monthlyStartAndEndDate(date('W')-1, date('Y'));
			$week_dates    = getStartAndEndDate(date('W')-1, date('Y'));
			$semi_month    = semifirsttartAndEndDate();
			$semi_month1   = semisecondStartAndEndDate(date('W')-1, date('Y'));
			$monthly       = monthlyStartAndEndDate(date('W')-1, date('Y'));

			$crtime = new DateTime();
			$currenttime= $crtime->format('Y-m-d');

			// echo $semi_month1['end_date']; die;

			$consult_freq_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $all_consults_value['guid'], 'is_current' => 1, 'order_by' => 'id'));


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
		
		$data['timesheet_count'] = $timesheet_count;
						
		//print_r($timesheet);
		$data['timesheet'] = $timesheet;
		/*Code for timesheet pending added by Prashant Kumar*/

		$this->templated->load('Backend/default_layout', 'contents', 'dashboard', $data);
	}


		public function dashboardc2c() {
		// $data['count_consultant'] = $this->consultants_model->get_total_count();
		// $data['count_vendor'] = $this->vendors_model->get_total_count();

		$data['title'] = 'Dashboard';
		$email = $this->session->userdata['email'];

		$all_vendors  = $this->global_model->get_data('panel_vendortbl', array('email'=> $email, 'order_by' => 'vendor_id'));

		 $vendid = $all_vendors[0]['guid'];

		$all_consults = $this->global_model->get_data('panel_consultanttbl', array('vendor_id'=> $vendid, 'order_by' => 'consultant_id'));
		

		$con_id_arr = array();
		$ven_id_arr = array();

		/*Code for consultant document pending count added by Prashant Kumar*/
		foreach ($all_consults as $all_consults_val) {
			array_push($con_id_arr, $all_consults_val['guid']);
		}

		$cosult_count = 0;

		foreach ($con_id_arr as $con_id_arr_val) {
			$consult_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $con_id_arr_val, 'order_by' => 'doc_id'));
			if(empty($consult_data)) {
				$cosult_count++;
			}
		}

		$data['consult_count'] = $cosult_count;
		/*Code for consultant document pending count added by Prashant Kumar*/

		/*Code for bills pending count added by Ruchi Acharya*/
		$all_bills_count  = $this->global_model->get_data('panel_master_timesheettbl', array('bill_generated' => '0','vendor_id'=>$vendid, 'order_by' => 'id'));
		$bill_count = 0;
		foreach($all_bills_count as $all_bills_count_val){
			if(!empty($all_bills_count)) {
				$bill_count++;
			}
		}
		$data['bills_count'] = $bill_count;
		/*Code for bills pending count added by Ruchi Acharya*/

		/*Code for vendor document pending count added by Prashant Kumar*/
		foreach ($all_vendors as $all_vendors_val) {
			array_push($ven_id_arr, $all_vendors_val['guid']);
		}

		$vendor_count = 0;

		foreach ($ven_id_arr as $ven_id_arr_val) {
			$vendor_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $ven_id_arr_val, 'order_by' => 'doc_id'));
			if(empty($vendor_data)) {
				$vendor_count++;
			}
		}
		$data['vendor_count'] = $vendor_count;
		/*Code for vendor document pending count added by Prashant Kumar*/

		/*Code for timesheet pending added by Prashant Kumar*/
		

		$timesheet_arr = array();

		$timesheet_count = 0;
		
		// print_r($all_consults); die;
		foreach ($all_consults as $all_consults_key => $all_consults_value) {

			// print_r($all_consults_key); die;

		$week_dates    = getStartAndEndDate(date('W')-1, date('Y'));
		$semi_month    = semifirsttartAndEndDate();
		$semi_month1   = semisecondStartAndEndDate(date('W')-1, date('Y'));
		$monthly       = monthlyStartAndEndDate(date('W')-1, date('Y'));

			$crtime = new DateTime();
			$currenttime= $crtime->format('Y-m-d');

		

			$consult_freq_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $all_consults_value['guid'], 'is_current' => 1, 'order_by' => 'id'));


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
		
		$data['timesheet_count'] = $timesheet_count;
						
		//sprint_r($timesheet);
		$data['timesheet'] = $timesheet;
		/*Code for timesheet pending added by Prashant Kumar*/

		$this->templated->load('Backend/c2c/default_layout', 'contents', 'dashboardc2c', $data);
	}

	public function dashboardw2() {
		// $data['count_consultant'] = $this->consultants_model->get_total_count();
		// $data['count_vendor'] = $this->vendors_model->get_total_count();

		$data['title'] = 'Dashboard';
		$email = $this->session->userdata['email'];
		$all_consults = $this->global_model->get_data('panel_consultanttbl', array('email'=> $email, 'order_by' => 'consultant_id'));
		// print_r($all_consults);die;

		$con_id_arr = array();

		/*Code for consultant document pending count added by Prashant Kumar*/
		foreach ($all_consults as $all_consults_val) {
			array_push($con_id_arr, $all_consults_val['guid']);
		}

		$cosult_count = 0;

		foreach ($con_id_arr as $con_id_arr_val) {
			$consult_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $con_id_arr_val, 'order_by' => 'doc_id'));
			if(empty($consult_data)) {
				$cosult_count++;
			}
		}

		// print_r($cosult_count); die;
		$data['consult_count'] = $cosult_count;
		/*Code for consultant document pending count added by Prashant Kumar*/


		$timesheet_arr = array();

		$timesheet_count = 0;
		
		// print_r($all_consults); die;
		foreach ($all_consults as $all_consults_key => $all_consults_value) {

			// print_r($all_consults_key); die;

			$week_dates    = getStartAndEndDate(date('W')-1, date('Y'));
			$semi_month    = semifirsttartAndEndDate();
			$semi_month1   = semisecondStartAndEndDate(date('W')-1, date('Y'));
			$monthly       = monthlyStartAndEndDate(date('W')-1, date('Y'));

			$crtime = new DateTime();
			$currenttime= $crtime->format('Y-m-d');

		

			$consult_freq_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $all_consults_value['guid'], 'is_current' => 1, 'order_by' => 'id'));


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
		
		$data['timesheet_count'] = $timesheet_count;
						
		//sprint_r($timesheet);
		$data['timesheet'] = $timesheet;
		/*Code for timesheet pending added by Prashant Kumar*/

		$this->templated->load('Backend/w2/default_layout', 'contents', 'dashboardw2', $data);
	}

	public function dashboardsole() {
		// $data['count_consultant'] = $this->consultants_model->get_total_count();
		// $data['count_vendor'] = $this->vendors_model->get_total_count();
		// echo "you are here"; die;
		$data['title'] = 'Dashboard';
		$email = $this->session->userdata['email'];
		$all_consults = $this->global_model->get_data('panel_consultanttbl', array('email'=> $email, 'order_by' => 'consultant_id'));
		// print_r($all_consults);die;

		$con_id_arr = array();

		/*Code for consultant document pending count added by Prashant Kumar*/
		foreach ($all_consults as $all_consults_val) {
			array_push($con_id_arr, $all_consults_val['guid']);
		}

		$cosult_count = 0;

		foreach ($con_id_arr as $con_id_arr_val) {
			$consult_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $con_id_arr_val, 'order_by' => 'doc_id'));
			if(empty($consult_data)) {
				$cosult_count++;
			}
		}

		 $consultantid = $all_consults[0]['guid'];

		// print_r($cosult_count); die;
		$data['consult_count'] = $cosult_count;
		/*Code for consultant document pending count added by Prashant Kumar*/

		/*Code for bills pending count added by Ruchi Acharya*/
		$all_bills_count  = $this->global_model->get_data('panel_master_timesheettbl', array('bill_generated' => '0','consultant_id'=>$consultantid, 'order_by' => 'id'));
		
		$bill_count = 0;
		
		foreach($all_bills_count as $all_bills_count_val){
			if(!empty($all_bills_count)) {
				$bill_count++;
			}
		}
		
		$data['bills_count'] = $bill_count;
		/*Code for bills pending count added by Ruchi Acharya*/

		$timesheet_arr = array();

		$timesheet_count = 0;
		
		// print_r($all_consults); die;
		foreach ($all_consults as $all_consults_key => $all_consults_value) {

			// print_r($all_consults_key); die;

			$week_dates    = getStartAndEndDate(date('W')-1, date('Y'));
			$semi_month    = semifirsttartAndEndDate();
			$semi_month1   = semisecondStartAndEndDate(date('W')-1, date('Y'));
			$monthly       = monthlyStartAndEndDate(date('W')-1, date('Y'));

			$crtime = new DateTime();
			$currenttime= $crtime->format('Y-m-d');

		

			$consult_freq_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $all_consults_value['guid'], 'is_current' => 1, 'order_by' => 'id'));


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
		
		$data['timesheet_count'] = $timesheet_count;
						
		//sprint_r($timesheet);
		$data['timesheet'] = $timesheet;
		/*Code for timesheet pending added by Prashant Kumar*/

		$this->templated->load('Backend/sole/default_layout', 'contents', 'dashboardsole', $data);
	}

	public function login() {
		// if(isset($_POST['btn_login'])) {
			$this->form_validation->set_rules('userid', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if($this->form_validation->run() == FALSE) {
				$message    = "Please Enter Username and Password";
            	$this->session->set_flashdata('message', $message);
				 redirect(base_url());
				 //$this->load->view('authentication/login');
			} else {
				//$userid=$this->security->xss_clean($this->input->post('userid'));
				$data = array(
					'userid'   => $this->input->post('userid'),
					'password' => $this->input->post('password') 
				);
				$result = $this->authentication_model->login_process($data);
				
				echo json_encode($result);

				// if($result) {

				// 	if($this->session->userdata['user_type']==2)
				// 	{
				// 		redirect('dashboardw2');
				// 	}
				// 	else if($this->session->userdata['user_type']==1)
				// 	{
				// 		// echo "sole"; die;
				// 		redirect('dashboardsole');
				// 	}
				// 	else if($this->session->userdata['user_type']==3)
				// 	{
				// 		// echo "sole"; die;
				// 		redirect('dashboardc2c');
				// 	}

				// 	else
				// 	{
				// 		redirect('dashboard');
				// 	}
				// } else {
				// 	$data = array(
				// 		'error_msg' => 'Invalid Username or Password. Please try again.'
				// 	);
				// 	//redirect(base_url(), $data);
				// 	$this->load->view('authentication/login', $data);
				// }
			}
		// } else {
		// 	$this->session->sess_destroy();
		// 	redirect('authentication');
		// }
	}
	public function logout() {
		$this->session->sess_destroy();
		$data = array(
			'success_msg' => 'You have successfully logout!'
		);
		//redirect('authentication', $data);
		$this->load->view('authentication/login', $data);
	}
}
?>