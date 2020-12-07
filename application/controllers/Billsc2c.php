<?php

/**
* Bills class controller
* Written by Prashant Kumar on Feb 24, 2020 14:50:40
*/
class Billsc2c extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		hooks()->do_action('after_clients_area_init', $this);
		$this->load->helper('guid_creator_helper');
		$this->load->helper(array('form', 'url'));
		$this->load->model('global_model');
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
		$data['title']  = 'Upload Vendor Bill';
		$data['breatcumb'] = 'Upload Vendor Bill';

		$email = $this->session->userdata['email'];

		$data['vendor_data'] = $this->global_model->get_data('panel_vendortbl', array('email'=> $email, 'order_by' => 'vendor_id'));

		// print_r($data['vendor_data']); die;

		$data['consult_data'] = $this->global_model->get_data('panel_consultanttbl', array());

		/* Code written by Ruchi Acharya*/

		$allbills_data = $this->global_model->get_data('panel_master_billstbl', array('order_by' => 'bill_id', 'cond' => 'DESC'));

		
		foreach ($allbills_data as $all_bills_key => $allbills_value) {

			
			//echo $allbills_value['bill_id'];
			$filt_consult_data = $this->global_model->get_data('panel_consultanttbl', array('guid' => $allbills_value['consultant_id'], 'order_by' => 'consultant_id'));
			$filt_vendor_data = $this->global_model->get_data('panel_vendortbl', array('guid' => $allbills_value['vendor_id'], 'order_by' => 'vendor_id'));
			$filt_bill_data = $this->global_model->get_data('panel_billstbl', array('bill_id' => $allbills_value['bill_id'], 'order_by' => 'id'));
			
			$timesheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $allbills_value['consultant_id'], 'vendor_id' => $allbills_value['vendor_id'], 'start_date' => $allbills_value['start_date'], 'end_date' => $allbills_value['end_date'], 'order_by' => 'id'));
			//print_r($timesheet_data[0]['total_hrs']);
			//die();
			//if(!empty($filt_consult_data) && !empty($filt_vendor_data)){
				$bills[$all_bills_key]['vendor_name']  		= $filt_vendor_data[0]['name'];
				$bills[$all_bills_key]['consult_name'] 		= $filt_consult_data[0]['name'];
				$bills[$all_bills_key]['date_from']    		= $allbills_value['start_date'];
				$bills[$all_bills_key]['date_to']      		= $allbills_value['end_date'];
				$bills[$all_bills_key]['bill_total_hrs']    = $allbills_value['total_hrs'];	
				//$bills[$all_bills_key]['project']  			= $allbills_value['project_id'];
				$bills[$all_bills_key]['vendor_id']     	= $allbills_value['vendor_id'];
				$bills[$all_bills_key]['consultant_id'] 	= $allbills_value['consultant_id'];
				$bills[$all_bills_key]['bill_id'] 			= $allbills_value['bill_id'];
				$bills[$all_bills_key]['file_path'] 		= $filt_bill_data[0]['file_path'];
				$bills[$all_bills_key]['file_name']			= $filt_bill_data[0]['file_name'];
				$bills[$all_bills_key]['ts_total_hrs']  	= $timesheet_data[0]['total_hrs'];
			//}
		}
		 
		// print_r($bills); die;
		$data['bills_data'] = $bills; ;
		
		/* Code written by Ruchi Acharya*/
		$this->templated->load('Backend/c2c/default_layout', 'contents', 'bills/billsc2c', $data);
	}

	public function delete_bills() {
		if($this->input->get('id')){

			$del_data = $this->global_model->get_data('panel_billstbl', array("bill_id"=>$this->input->get('id'),'order_by' => 'bill_id'));
          
           $path = $del_data[0]['file_path'];

           delete_files($path, true , false, 1);
           
            $this->global_model->del_data('panel_master_billstbl',array("bill_id"=>$this->input->get('id')));
            $message    = array("1","Successfully Deleted");
        }

								if($message[0] == 1) {

		$this->global_model->del_data('panel_billstbl',array("bill_id"=>$this->input->get('id')));
		
		// $this->global_model->updatebill_status('panel_master_timesheettbl','bill_generated'=>'0',array("id"=>$this->input->get('id')));

					$id =  $this->input->get('id');

					$this->global_model->updateBillByIds($id);

									$success_message = 'Records Deleted successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect(base_url('bills-c2c-report'),'location');
								} else {
									$error_message = 'Something Went Wrong';
									$this->session->set_flashdata('error_message',$error_message);  
									redirect(base_url('bills-c2c-report'),'location');
								}
						

	}

	public function bills_report() {
		$data['title']  = 'Old Bills Report';
		$data['breatcumb'] = 'Bills Report';

		$email = $this->session->userdata['email'];

		$data = $this->global_model->get_data('panel_vendortbl', array('email'=> $email, 'order_by' => 'vendor_id', 'cond' => 'DESC'));

		$vendid = $data[0]['guid'];
		// echo $vendid; die;
		//$data['vendor_data'] = $this->global_model->get_data('panel_vendortbl', array());
		$data['consult_data'] = $this->global_model->get_data('panel_consultanttbl', array('vendor_id'=> $vendid, 'order_by' => 'consultant_id'));

		/* Code written by Ruchi Acharya*/

		$allbills_data = $this->global_model->get_data('panel_master_billstbl', array('vendor_id'=>$vendid, 'order_by' => 'bill_id', 'cond' => 'DESC'));
		
		foreach ($allbills_data as $all_bills_key => $allbills_value) {
			//echo $allbills_value['bill_id'];
			$filt_consult_data = $this->global_model->get_data('panel_consultanttbl', array('guid' => $allbills_value['consultant_id'], 'order_by' => 'consultant_id'));
			$filt_vendor_data = $this->global_model->get_data('panel_vendortbl', array('guid' => $allbills_value['vendor_id'], 'order_by' => 'vendor_id'));
			$filt_bill_data = $this->global_model->get_data('panel_billstbl', array('bill_id' => $allbills_value['bill_id'], 'order_by' => 'id'));
			
			$timesheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $allbills_value['consultant_id'], 'start_date' => $allbills_value['start_date'], 'end_date' => $allbills_value['end_date'], 'order_by' => 'id'));
			//print_r($timesheet_data[0]['total_hrs']);
			//die();
			//if(!empty($filt_consult_data) && !empty($filt_vendor_data)){
				$bills[$all_bills_key]['vendor_name']  		= $filt_vendor_data[0]['name'];
				$bills[$all_bills_key]['consult_name'] 		= $filt_consult_data[0]['name'];
				$bills[$all_bills_key]['date_from']    		= $allbills_value['start_date'];
				$bills[$all_bills_key]['date_to']      		= $allbills_value['end_date'];
				$bills[$all_bills_key]['bill_total_hrs']    = $allbills_value['total_hrs'];	
				//$bills[$all_bills_key]['project']  			= $allbills_value['project_id'];
				$bills[$all_bills_key]['vendor_id']     	= $allbills_value['vendor_id'];
				$bills[$all_bills_key]['consultant_id'] 	= $allbills_value['consultant_id'];
				$bills[$all_bills_key]['bill_id'] 			= $allbills_value['bill_id'];
				$bills[$all_bills_key]['file_path'] 		= $filt_bill_data[0]['file_path'];
				$bills[$all_bills_key]['file_name']			= $filt_bill_data[0]['file_name'];
				$bills[$all_bills_key]['ts_total_hrs']  	= $timesheet_data[0]['total_hrs'];
			//}
		}
		//print_r($bills);
		$data['bills_data'] = $bills;
		
		/* Code written by Ruchi Acharya*/
		$this->templated->load('Backend/c2c/default_layout', 'contents', 'bills/bills_c2c_report', $data);
	}


	/* Code written by Ruchi Acharya*/
	public function upload_bills() {
		$data['title']  = 'Upload Vendor Bill';
		$data['breatcumb'] = 'Upload Vendor Bill';

		if(isset($_POST['submit'])) {
			$start_date 					= date('Y-m-d', strtotime($this->input->post('start_date')));
			$end_date  						= date('Y-m-d', strtotime($this->input->post('end_date')));	
			$bills_data['vendor_id'] 		= $this->input->post('vendor_id');
			$bills_data['consultant_id']   	= $this->input->post('consultant_id');
			$bills_data['start_date']  		= $start_date;
			$bills_data['end_date']  		= $end_date;
			$bills_data['total_hrs'] 		= $this->input->post('total_hrs');
			$bills_data['total_days']		= $this->input->post('hidden_total_days');
			
			$file_ext = array_filter(explode('.', $_FILES['fileupload']['name']));
			$fileExt = array_pop($file_ext);
			//print_r($fileExt); die();
			if($fileExt == 'pdf' || $fileExt == 'docx' || $fileExt == 'doc' || $fileExt == 'xlsx' || $fileExt == 'csv' || $fileExt == 'xls' || $fileExt == 'jpeg' || $fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'JPEG' || $fileExt == 'PNG') {

				$bill = $this->global_model->set_data('panel_master_billstbl', $bills_data);

				$last_bill_id = $this->db->insert_id();
				//echo $last_bill_id; die();

				$ts_prev_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $bills_data['consultant_id'], 'bill_generated' => '0', 'limit' => '1', 'order_by' => 'id'));
				//print_r($ts_prev_data); die();	
				if(!empty($ts_prev_data)) {
					foreach ($ts_prev_data as $ts_prev_data_value) {
						$ts_prev_data_value['bill_generated']  = 1;
						$ts_prev_data_value['bill_id']  = $last_bill_id;
						//print_r($ts_prev_data_value); //die();
						$this->global_model->set_data('panel_master_timesheettbl', $ts_prev_data_value);	
					}	
				} else {
					echo 0;
					exit(); 
				}


				$guid = GUID();
				$file_id = 'FILE_'.$guid;
				$file_name = $guid;	

				if($path == '') {
					if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$file_id)) {
						mkdir($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$file_id, 0777 , true);
					}
					$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$file_id;
				} else {
					$config['upload_path'] = $path;
				}

				$config['allowed_types'] = 'pdf|docx|doc|xlsx|csv|xls|jpeg|jpg|png|JPG|JPEG|PNG';
				$config['overwrite'] = false;
				$config['remove_spaces'] = TRUE;
				$config['file_name'] = $file_name;
				//print_r($_FILES['fileupload']); die();
				
				if(!empty($_FILES['fileupload'])) {
					$_FILES['file']['name']     = $_FILES['fileupload']['name'];
					$_FILES['file']['type']     = $_FILES['fileupload']['type'];
					$_FILES['file']['tmp_name'] = $_FILES['fileupload']['tmp_name'];
					$_FILES['file']['error']    = $_FILES['fileupload']['error'];
					$_FILES['file']['size']     = $_FILES['fileupload']['size'];

					//print_r($_FILES['file']['name']); die();

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					// Upload file to server
					if($this->upload->do_upload('file')) {
						// Uploaded file data
						$fileData = $this->upload->data();
						$uploadData = $fileData['file_name'];
						$data = array(
							'bill_id'			=>  $last_bill_id,
							'file_name'			=> 	$_FILES['file']['name'],
							//'file_temp_name' 	=>  $this->input->post('file_temp_name'),
							'file_path' 		=>	$config['upload_path'],
							'uploaded_by'		=> 	$this->session->userdata('email')
						);
						$file_upload = $this->global_model->set_data('panel_billstbl', $data);


					} else {
						echo $this->upload->display_errors();
					}
					$upload = implode(',',$uploadData);
				}
				if($bill['insert_id'] != "") {
					$success_message = 'Records added successfully';
					$this->session->set_flashdata('success_message',$success_message); 
					//echo $this->uri->segment(3);  die();
					if($this->uri->segment(3) != '') {
						redirect('pending-c2c-bills/'. $this->uri->segment(3));
					} else {
						redirect('billsc2c');
					}			
					
				} else {
					$error_message = 'Something went wrong. Please try again';
					$this->session->set_flashdata('error_message',$error_message);
					redirect('billsc2c');	
				}

			} else {
				if($this->uri->segment(3) != '') {
					$error_message = 'Something went wrong. Please select valid File Type';
					$this->session->set_flashdata('error_message',$error_message);  
					redirect('pending-c2c-bills/'. $this->uri->segment(3));
				} else {
					$error_message = 'Something went wrong. Please select valid File Type';
					$this->session->set_flashdata('error_message',$error_message);  
					redirect('billsc2c');
				}
			}
		}
	}
	public function getTimesheetHrs() {
		$selected_vendorId 		= $_GET['vendor_id'];
		$selected_consultantId 	= $_GET['consultant_id']; 
		// echo $selected_consultantId;
		// echo $selected_vendorId;

		$timesheet_data = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' =>$selected_consultantId, 'bill_generated' => '0', 'limit' => '1', 'order_by' => 'id'));
		if($timesheet_data) {
			//exit(0);
			//echo 1;
			//print_r($timesheet_data); die();
			foreach($timesheet_data as $timesheet_data_val){
				$ts_val['start_date'] = date("m/d/Y", strtotime($timesheet_data_val['start_date']));
				$ts_val['end_date']   = date("m/d/Y", strtotime($timesheet_data_val['end_date']));
				$ts_val['total_hrs']  = $timesheet_data_val['total_hrs'];
				$ts_val['total_days'] = $timesheet_data_val['total_days'];
			}
			echo json_encode($ts_val);
			exit();
		} else {
			echo 0;
			exit();

		}		
	}
	public function getConsultants() {
		$sel_vendor = $_GET['vendor_id'];
		//echo $sel_vendor; 
		if($sel_vendor == 'w2') {
			$consults = $this->global_model->get_data('panel_consultanttbl', array());

			$str = '<select class="form-control" id="consultant_id"><option value="">Select Consultant</option>';
			foreach($consults as $consult) :
				$str .= '<option value="' . $consult['guid'] . '">' . $consult['name'] . '</option>';
			endforeach;
			$str .= '</select>';
		}  else {
			$data['vendor_consultant'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('vendor_id' => $sel_vendor, 'is_current' => 1, 'order_by' => 'id'));	
			$cosult_index = 0;
			$last_con_guid = '';
			foreach ($data['vendor_consultant'] as $row) {
				if($last_con_guid != $row['consultant_id']) {
					$data['con_data'][$cosult_index] = $this->global_model->get_data('panel_consultanttbl', array('guid' => $row['consultant_id'], 'order_by' => 'consultant_id'));
					$cosult_index++;
					$last_con_guid = $row['consultant_id'];
					//echo $last_con_guid;
				}
			}
			//print_r($data['con_data']);
			$str = '<select class="form-control" id="consultant_id"><option value="">Select Consultant</option>';
			foreach($data['con_data'] as $consult) :
				$str .= '<option value="' . $consult[0]['guid'] . '">' . $consult[0]['name'] . '</option>';
			endforeach;
			$str .= '</select>';			
		} 
		echo $str;
	}
	public function getPendingBills() {
		$data['title'] = 'Bills Pending List';

		$email = $this->session->userdata['email'];
		$all_vendors  = $this->global_model->get_data('panel_vendortbl', array('email'=> $email, 'order_by' => 'vendor_id'));

		$vendid = $all_vendors[0]['guid'];

		$data['consult_data'] = $this->global_model->get_data('panel_consultanttbl', array('vendor_id'=> $vendid, 'order_by' => 'consultant_id'));
		$count = 0;
		foreach ($data['consult_data'] as $con_val) {
			$v_c_mapping = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $con_val['guid'], 'is_current' => 1, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
			foreach ($v_c_mapping as $v_c_map_key => $v_c_map_val) {
				$vendor_id = $v_c_map_val['vendor_id'];
				$ven_data  = $this->global_model->get_data('panel_vendortbl', array('guid' => $vendor_id, 'order_by' => 'vendor_id'));
				if(!empty($ven_data)) {
					$v_c_map_val['vendor_name'] = $ven_data[0]['name'];
				} else {
					$v_c_map_val['vendor_name'] = 'W2';
				}
				if($v_c_map_key == (count($v_c_map_key)-1)) {
					$data['mapping_data'][$count] = $v_c_map_val;
					$count++;
				}
			}
		}

		$this->templated->load('Backend/c2c/default_layout', 'contents', 'bills/consultlistc2c_pen_bills', $data);
	}
	public function pending_bills() {
		$data['title'] = 'Bills Pending List';
		$consultant_id = $this->uri->segment(2);
		$data['consult'] = $this->global_model->get_data('panel_consultanttbl', array('consultant_id' => $consultant_id, 'order_by' => 'consultant_id'));
		//echo $data['consult'][0]['guid'];
		$data['bills'] = $this->global_model->get_data('panel_master_timesheettbl', array('consultant_id' => $data['consult'][0]['guid'], 'bill_generated' => '0', 'order_by' => 'id'));
		$this->templated->load('Backend/c2c/default_layout', 'contents', 'bills/pending_c2c_bills', $data);
	}
	public function upload_pending_bills() {
		$data['title'] = 'Upload Pending Bills';
		$tsheet_id = $this->uri->segment(3);
		$data['bills'] = $this->global_model->get_data('panel_master_timesheettbl', array('id' => $tsheet_id, 'bill_generated' => '0', 'order_by' => 'id'));
		//print_r($data['bills']);
		$consultant_id = $data['bills'][0]['consultant_id'];
		$vendor_id	   = $data['bills'][0]['vendor_id'];
		$data['consult'] = $this->global_model->get_data('panel_consultanttbl', array('guid' => $consultant_id, 'order_by' => 'consultant_id'));
		$data['vendor']  = $this->global_model->get_data('panel_vendortbl', array('guid' => $vendor_id, 'order_by' => 'vendor_id'));
		//print_r($data);
		$this->templated->load('Backend/c2c/default_layout', 'contents', 'bills/upload_c2c_pending_bills', $data);

	}
	/* Code written by Ruchi Acharya*/
}