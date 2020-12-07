<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Vendors extends CI_Controller {
	public function __construct() {
		parent::__construct();
		hooks()->do_action('after_clients_area_init', $this);
		$this->load->library('pagination');
		$this->load->helper('form');
		$this->load->helper('guid_creator_helper');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('vendors_model');
		$this->load->model('global_model');
		$this->load->database();

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

		$data['title'] = 'Vendors';
		$data['breathcum'] = 'Vendor List';
		// $config = $this->config->item('pagination');
		// $config['base_url'] = base_url('vendor-list');
		// $post['count'] = 1;
		// $config['total_rows'] = $this->global_model->vendor_list($post);
		// $config['per_page'] = 100;
		// $config['uri_segment'] = 2;
		// $this->pagination->initialize($config);
		// $page =($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		// $post['limit'] = $config['per_page'];
		// $post['offset'] = $page;
		// $post['count'] = 0;
		if($_GET) {
			if($_GET['ven'] != "") {
				$post['guid'] = $_GET['ven'];
			}
			// if($_GET['id'] != "") {
			// 	$post['guid'] = $_GET['ven'];
			// }
		}
		// $config = $this->config->item('pagination');
		// $config['base_url'] = base_url('vendor-list');
		// $post['count'] = 1;
		// $config['total_rows'] = $this->global_model->vendor_list($post);
		// $config['per_page'] = 100;
		// $config['uri_segment'] = 2;
		// $this->pagination->initialize($config);
		// $page =($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		// $post['limit'] = $config['per_page'];
		// $post['offset'] = $page;
		// $post['count'] = 0;
		$data['vendor_data'] = $this->global_model->vendor_list($post);
		// $data['per_page'] = $config['per_page'];
		// $data['segment'] = $page;
		// $data['total_rows'] = $config['total_rows'];
		// $data['links'] = $this->pagination->create_links();

		$vendor_key1 = 0;
		$vendor_key2 = 0;
		foreach ($data['vendor_data'] as $vendor_data_val) {
			$ven_contact = $this->global_model->get_data('panel_vendor_contacts', array('vendor_id' => $vendor_data_val['guid']));
			foreach ($ven_contact as $ven_contact_value) {
				if($ven_contact_value['contact_type'] == 1) {
					$ven_con1[$vendor_key1] = $ven_contact_value;
					$vendor_key1++;
				} elseif ($ven_contact_value['contact_type'] == 2) {
					$ven_con2[$vendor_key2] = $ven_contact_value;
					$vendor_key2++;
				}
			}
		}

		$data['vendor_con1'] = $ven_con1;
		$data['vendor_con2'] = $ven_con2;
		$data['filt_ven'] = $this->global_model->get_data('panel_vendortbl', array());
		$this->templated->load('Backend/default_layout', 'contents', 'vendors/vendor_list', $data);
		//$vendor['title'] = 'Vendors';
		//$vendor['vendor_data'] = $this->vendors_model->get_data();
		//$this->templated->load('Backend/default_layout', 'contents', 'vendors/vendor_list', $vendor);
	}
	public function vendor_view() {
		$data['title'] = 'Add Vendor';
		$data['breatcumb'] = 'Add Vendor';
		$this->templated->load('Backend/default_layout', 'contents', 'vendors/add_vendor', $data);
	}

	public function add_vendor() {
		$data['title'] = 'Add Vendor';
		$data['breathcum'] = 'Add Vendor';
		
		if(isset($_POST['submit'])) {
			$guid = GUID();
			// $data = array(
			// 	'org_id' => $this->input->post('org_id'),
			// 	'guid'	 => $guid,
			// 	'name'   => $this->input->post('name'),
			// 	'email'  => $this->input->post('email'),
			// 	'phone'  => $this->input->post('phone')
			// );

			//print_r($data); die();
			$V_data['org_id'] = $this->input->post('org_id');
			$V_data['guid']   = $guid;
			$V_data['name']   = $this->input->post('name');
			$V_data['email']  = $this->input->post('email');
			$V_data['phone']  = $this->input->post('phone');
			$V_data['extension']  = $this->input->post('extension');
			
			$vendor = $this->global_model->set_data('panel_vendortbl', $V_data);

			$hr_con_name  = $this->input->post('hr_name');
			$hr_con_email = $this->input->post('hr_email');
			$hr_con_phone = $this->input->post('hr_phone');
			$hr_con_ext   = $this->input->post('hr_ext');

			if($hr_con_email != "" || $hr_con_phone != "") {
				$hr_data['contact_type'] = 1;
				$hr_data['vendor_id']    = $guid;
				$hr_data['name']         = $hr_con_name;
				$hr_data['email']        = $hr_con_email;
				$hr_data['phone']        = $hr_con_phone;
				$hr_data['extension']    = $hr_con_ext;
				
				$test = $this->global_model->set_data('panel_vendor_contacts', $hr_data);
			}

			$ac_con_name  = $this->input->post('ac_name');
			$ac_con_email = $this->input->post('ac_email');
			$ac_con_phone = $this->input->post('ac_phone');
			$ac_con_ext = $this->input->post('ac_ext');

			if($ac_con_email != "" || $ac_con_phone != "") {
				$ac_data['contact_type'] = 2;
				$ac_data['vendor_id']    = $guid;
				$ac_data['name']         = $ac_con_name;
				$ac_data['email']        = $ac_con_email;
				$ac_data['phone']        = $ac_con_phone;
				$ac_data['extension']    = $ac_con_ext;
				
				$test1 = $this->global_model->set_data('panel_vendor_contacts', $ac_data);
			}

			if($vendor['insert_id'] != "") {
				$success_message = 'Records added successfully';
				$this->session->set_flashdata('success_message',$success_message);  				
				redirect('vendor-list');
			} else {
				$error_message = 'Something went wrong. Please try again';
				$this->session->set_flashdata('error_message',$error_message);
				redirect('vendor-list');	
			}
		}

	}
	public function display_vendor() {
		$data['title'] = 'Update Vendor';
		$data['breathcum'] = 'Update Vendor';
		
		$id = $this->uri->segment(2);
		$data['vendor_data'] = $this->vendors_model->getdata_by_id($id);


		$data['vendor_contacts'] = $this->global_model->get_data('panel_vendor_contacts', array('vendor_id' => $data['vendor_data'][0]['guid'], 'order_by' => 'id' ));
		$this->templated->load('Backend/default_layout', 'contents', 'vendors/edit_vendor', $data);	
	}
	public function edit_vendor() {
		$data['title']     = 'Update Vendor';
		$data['breathcum'] = 'Update Vendor';

		// print_r($this->input->post());
		// exit();
		
		$id    = $this->input->post('vendor_id');
		$name  = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$ext   = $this->input->post('extension');

		$hr_id = $this->input->post('hr_id');
		$ac_id = $this->input->post('acc_id');

		$vendor_data = $this->global_model->get_data('panel_vendortbl', array('vendor_id' => $id, 'order_by' => 'vendor_id'));

		/*HR conatct*/
		$hr_data['id']           = $hr_id;
		$hr_data['contact_type'] = 1;
		$hr_data['vendor_id']    = $vendor_data[0]['guid'];
		$hr_data['name']         = $this->input->post('hr_name');
		$hr_data['email']        = $this->input->post('hr_email');
		$hr_data['phone']        = $this->input->post('hr_phone');
		$hr_data['extension']        = $this->input->post('hr_ext');

		if($hr_data['email'] != "" && $hr_data['phone'] != "") {
			$this->global_model->set_data('panel_vendor_contacts', $hr_data);
		}
		/*HR conatct*/
		/*Accounts conatct*/
		$acc_data['id']           = $ac_id;
		$acc_data['contact_type'] = 2;
		$acc_data['vendor_id']    = $vendor_data[0]['guid'];
		$acc_data['name']         = $this->input->post('ac_name');
		$acc_data['email']        = $this->input->post('ac_email');
		$acc_data['phone']        = $this->input->post('ac_phone');
		$acc_data['extension']    = $this->input->post('ac_ext');
		
		if($acc_data['email'] != "" && $acc_data['phone'] != "") {
			$this->global_model->set_data('panel_vendor_contacts', $acc_data);
		}
		/*Accounts conatct*/
		if($id) {
			$vedndata['vendor_id'] = $id;
			$vedndata['name']      = $name;
			$vedndata['email']     = $email;
			$vedndata['phone']     = $phone;
			$vedndata['extension'] = $ext;
			$vendor_data           = $this->global_model->vendor_update('panel_vendortbl', $vedndata);
			if ($vendor_data['insert_id'] != "") {
				$success_message = 'Records updated successfully';
				$this->session->set_flashdata('success_message', $success_message);  				
				redirect('vendor-list');	
			} else {
				$error_message = 'Something went wrong. Please try again';
				$this->session->set_flashdata('error_message', $error_message);
				redirect('vendor-list');	
			}
		} else {
			return false;
		}
	}
	public function vendor_consult() {
		$data['title'] = 'Consultants List';
		$data['breathcum'] = 'Consultants List';
		$vendor_id = $this->uri->segment(2);
		// echo $vendor_id; die;
		$data['vendor_data'] = $this->global_model->get_data('panel_vendortbl', array('vendor_id' => $vendor_id, 'order_by' => 'vendor_id' ));
		 $vendor_guid = $data['vendor_data'][0]['guid'];

		$data['vendor_consultant'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('vendor_id' => $vendor_guid, 'is_current' => '1', 'order_by' => 'id'));	
		$cosult_index = 0;
		$last_con_guid = '';
		foreach ($data['vendor_consultant'] as $row) {
			if($last_con_guid != $row['consultant_id']) {
				$data['con_data'][$cosult_index] = $this->global_model->get_data('panel_consultanttbl', array('guid' => $row['consultant_id'], 'order_by' => 'consultant_id'));
				$cosult_index++;
				$last_con_guid = $row['consultant_id'];
			}
		}
		$inc = 0;
		foreach ($data['con_data'] as $con_val) {
			$v_c_mapping = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $con_val[0]['guid'],'is_current' => '1', 'order_by' => 'id'));
			foreach ($v_c_mapping as $v_c_map_key => $v_c_map_val) {
				if($v_c_map_key == (count($v_c_map_key)-1)) {
					$data['mapping_data'][$inc] = $v_c_map_val;
					$inc++;
				}
			}
		}

		//print_r($data['mapping_data']);
		$data['filt_con'] = $this->global_model->get_data('panel_consultanttbl', array());
		$data['con_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());
		$this->templated->load('Backend/default_layout', 'contents', 'vendors/vendor_consult_list', $data);
	}

	public function add_consult_vendor() {
		if(isset($_POST['con_vend_submit'])) {
			$guid = GUID();
			$data = array(
				'org_id' => $this->input->post('org_id'),
				'guid'	 => $guid,
				'name'   => $this->input->post('name'),
				'email'  => $this->input->post('email'),
				'phone'  => $this->input->post('phone')
			);
			$vendor = $this->vendors_model->insert($data);
			if($vendor == TRUE) {
				$success_message = 'Records added successfully';
				$this->session->set_flashdata('success_message',$success_message);  				
				redirect('consultant-add');
			} else {
				$error_message = 'Something went wrong. Please try again';
				$this->session->set_flashdata('error_message',$error_message);
				redirect('consultant-add');	
			}
		}
	}

	public function add_contact() {
		$data['title'] = 'Vendor Contacts';
		$data['breathcumb'] = 'Add Contact';
		$this->templated->load('Backend/default_layout', 'contents', 'vendors/vendor_contact', $data);
	}

	public function save_contact() {
		$contact['vendor_id']    = $this->input->post('vendor_guid');
		$contact['name']         = $this->input->post('contact_name');
		$contact['email']        = $this->input->post('contact_email');
		$contact['phone']        = $this->input->post('phone');
		$contact['contact_type'] = 1;
		$contact['created_on']   = date("Y-m-d H:i:s");

		$contact_data = $this->global_model->set_data('panel_vendor_contacts', $contact);

		if($contact_data['insert_id'] != "") {
			redirect(base_url('vendor-list'));
		}
	}

	public function document_pending() {
		$data['title'] = 'Vendor pending Docs';
		$data['breathcumb'] = 'Vendor pending Docs';
		$all_vendors  = $this->global_model->get_data('panel_vendortbl', array());

		$vendor_count = 0;

		/*Code for vendor document pending count added by Prashant Kumar*/
		foreach ($all_vendors as $all_vendors_val) {
			$vendor_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $all_vendors_val['guid'], 'order_by' => 'doc_id'));
			if(empty($vendor_data)) {
				$vendor_arr[$vendor_count] = $all_vendors_val;
				$vendor_count++;
			}
		}
		$data['vendor_data'] = $vendor_arr;
		$data['filt_ven']    = $vendor_arr;
		/*Code for vendor document pending count added by Prashant Kumar*/

		if($_GET) {
			if($_GET['ven'] != "") {
				$post['guid'] = $_GET['ven'];
				$data['vendor_data'] = $this->global_model->vendor_list($post);
			}
		}

		$vendor_key1 = 0;
		$vendor_key2 = 0;
		foreach ($data['vendor_data'] as $vendor_data_val) {
			$ven_contact = $this->global_model->get_data('panel_vendor_contacts', array('vendor_id' => $vendor_data_val['guid']));
			foreach ($ven_contact as $ven_contact_value) {
				if($ven_contact_value['contact_type'] == 1) {
					$ven_con1[$vendor_key1] = $ven_contact_value;
					$vendor_key1++;
				} elseif ($ven_contact_value['contact_type'] == 2) {
					$ven_con2[$vendor_key2] = $ven_contact_value;
					$vendor_key2++;
				}
			}
		}

		$data['vendor_con1'] = $ven_con1;
		$data['vendor_con2'] = $ven_con2;

		$this->templated->load('Backend/default_layout', 'contents', 'vendors/pending_doc_vendor_list', $data);
	}

}