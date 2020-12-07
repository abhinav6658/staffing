<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Consultants extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('string');
		hooks()->do_action('after_clients_area_init', $this);
		$this->load->library('pagination');
		$this->load->helper('form');
		$this->load->helper('guid_creator_helper');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('consultants_model');
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

	public function index($report = null) {
		$data['title']         = 'Consultants';
		$data['breathcum']     = 'Consultants';

		// $email = $this->session->userdata('email');

		// echo $email; die;
		// /*code for pagination*/

		if($_GET) {
			if($_GET['con'] != "") {
				$post['guid'] = $_GET['con'];
			}
			if($_GET['id']) {
				$post['consultant_type'] = $_GET['id'];
			}
		}
		
		// $config                = $this->config->item('pagination');
		// $config['base_url']    = base_url('consultant-list');
		// $post['count']         = 1;
		// $config['total_rows']  = $this->global_model->consultant_list($post);
		// $config['per_page']    = 100;
		// $config['uri_segment'] = 2;
		// $config['attributes'] = array('class' => 'page-item');
		// $config['suffix'] = "?test";
		// $config['reuse_query_string'] = TRUE;
		// $config['use_page_numbers'] = TRUE;

		// $this->pagination->initialize($config);
		// $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		// $post['limit']      = $config['per_page'];
		// $post['offset']     = $page;
		// $post['count']      = 0;
		$data['con_data']   = $this->global_model->consultant_list($post);
		// $data['per_page']   = $config['per_page'];
		// $data['segment']    = $page;
		// $data['total_rows'] = $config['total_rows'];
		// $data['links']      = $this->pagination->create_links();
		
		//$config['attributes'] = array('class' => 'page-item');
		//$config['suffix'] = "?test";
		//$config['reuse_query_string'] = TRUE;
		//$config['use_page_numbers'] = TRUE;

		//echo "<pre>";
		//print_r($data); die();
		// $data['mapping_data'] = $this->global_model->get_data('', array());

		/*code for pagination*/

		// $data['con_data'] = $this->global_model->get_data('panel_consultanttbl', array());
		$inc = 0;
		foreach ($data['con_data'] as $con_val) {
			$v_c_mapping = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $con_val['guid'], 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
			foreach ($v_c_mapping as $v_c_map_key => $v_c_map_val) {
				$vendor_id = $v_c_map_val['vendor_id'];
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
		$data['filt_con'] = $this->global_model->get_data('panel_consultanttbl', array());
		$data['con_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());

		$this->templated->load('Backend/default_layout', 'contents', 'consultants/consultant_list', $data);
	}

	public function consult_view() {
		$data['title']     = 'Add Consultant';
		$data['breathcum'] = 'Add Consultant';
		$data['consul_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());
		// $data['vendors']     = $this->global_model->get_data('panel_vendortbl', array());
		$data['consultant']  = $this->global_model->get_data('panel_consultanttbl', array());

		$data['states']      = $this->global_model->get_data('panel_states', array());
		$data['conslt_frec'] = $this->global_model->get_data('panel_consultant_frequency', array());
		$data['rate_type']   = $this->global_model->get_data('panel_rate_typetbl', array());
		$this->templated->load('Backend/default_layout', 'contents', 'consultants/add_consultant', $data);
	}

	public function add_consultant() {
		if(isset($_POST['submit'])) {
			$guid = GUID();
			//print_r($guid);die();
			$data = array(
				'org_id' => $this->input->post('org_id'),
				'guid'	 => $guid,
				'name'   => $this->input->post('name'),
				'email'  => $this->input->post('email'),
				'phone'  => $this->input->post('phone')
			);
			// print_r($data); die;
			$consultant = $this->consultants_model->insert_consultant($data);

			// print_r($consultant); die;
			if($consultant) {
				$success_message = 'Records added successfully';
				$this->session->set_flashdata('success_message',$success_message);  				
				redirect('consultant-list');
			} else {
				$error_message = 'Something went wrong. Please try again';
				$this->session->set_flashdata('error_message',$error_message);
				redirect('consultant-list');
			}
		}
	}

	public function display_consultant() {
		$consultant['title'] = 'Edit Consultant';
		$consultant['breathcum'] = 'Edit Consultant';
		$consultant['consul_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());
		// $data['vendors']     = $this->global_model->get_data('panel_vendortbl', array());
		$consultant['consultant']  = $this->global_model->get_data('panel_consultanttbl', array());

		$consultant['states']      = $this->global_model->get_data('panel_states', array());
		$consultant['conslt_frec'] = $this->global_model->get_data('panel_consultant_frequency', array());
		$consultant['rate_type']   = $this->global_model->get_data('panel_rate_typetbl', array());
		$consultant['vendors']     = $this->global_model->get_data('panel_vendortbl', array());

		$id = $this->uri->segment(2);
		$consultant['con_data'] = $this->consultants_model->getdata_by_id($id);
		$mapping_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consultant['con_data'][0]['guid'], 'order_by' => 'id'));
		foreach ($mapping_data as $mapping_key => $mapping_value) {
			if($mapping_key == (count($mapping_data)-1))
			$consultant['mapping_data'] = $mapping_value;
		}
		$this->templated->load('Backend/default_layout', 'contents', 'consultants/edit_consultant', $consultant);	
	}

	public function edit_consultant() {
		$id    = $this->input->post('consultant_id');
		$name  = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		if($id) {
			$data = array(
				'name' => set_value('name', $name),
				//'email' => set_value('email', $employee->email),
				'email' =>set_value('email', $email),
				'phone' => set_value('phone', $phone),
			);
			$consultant_data = $this->consultants_model->update_consultant('panel_consultanttbl', $data, $id);
			if ($consultant_data) {
				$success_message = 'Records updated successfully';
				$this->session->set_flashdata('success_message',$success_message); 
				if($this->uri->segment(3) != '') {
					redirect('consult-list/' . $this->uri->segment(3));
				} else {
					redirect('consultant-list');
				}			
			} else {
				$error_message = 'Something went wrong. Please try again';
				$this->session->set_flashdata('error_message',$error_message);
				redirect('consultant-list');
			}
		} else {
			return false;
		}
	}
	public function view_consultant() {
		$consultant['title'] = 'Consultant Details';
		$consultant['breathcum'] = 'Consultant Details';
		$consultant['consul_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());
		// $data['vendors']     = $this->global_model->get_data('panel_vendortbl', array());
		$consultant['consultant']  = $this->global_model->get_data('panel_consultanttbl', array());

		$consultant['states']      = $this->global_model->get_data('panel_states', array());
		$consultant['conslt_frec'] = $this->global_model->get_data('panel_consultant_frequency', array());
		$consultant['rate_type']   = $this->global_model->get_data('panel_rate_typetbl', array());
		$consultant['vendors']     = $this->global_model->get_data('panel_vendortbl', array());

		$id = $this->uri->segment(2);
		$consultant['con_data'] = $this->consultants_model->getdata_by_id($id);
		$mapping_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consultant['con_data'][0]['guid'], 'order_by' => 'id', 'cond' => 'DESC', 'limit' => '1'));
		foreach ($mapping_data as $mapping_key => $mapping_value) {
			if($mapping_key == (count($mapping_data)-1))
			$consultant['mapping_data'] = $mapping_value;
		}
		$this->templated->load('Backend/default_layout', 'contents', 'consultants/view_consultant', $consultant);	
	}
	public function consultant_filterSearch() {
		$data = array();
    	//$user_email = $_SESSION['user_email'];
		$data['title'] = 'Consultants';
    	//$data['consultant'] = $this->global_model->get_data('panel_consultanttbl',array('order_by'=>'consultant_id','status'=>1));
    	//$data['consultant_type'] = $this->global_model->get_data('panel_consultant_typetbl',array('status'=>1,'order_by'=>'consultant_type_id'));
		if($_GET) {
			if($_GET['consultant_type_id']!='') {
				$post['consultant_type_id'] = $_GET['consultant_type_id'];
			}
			if($_GET['consultant_id']!='') {
				$post['consultant_id'] = $_GET['consultant_id'];
			}
		}
    	//print_r($_GET);
		$data['consultant_id'] = $_GET['consultant_id'];
		$data['consultant_type_id']    = $_GET['consultant_type_id'];
    	//$data['consultant_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());
		$data['consultant_type'] = $this->global_model->get_consultant_type_list($post);
    	//$data['con_data'] = $this->global_model->consultant_list($post);
    	//echo "<br>";
		print_r($data['consultant_type']);
		$this->templated->load('Backend/default_layout', 'contents', 'consultants/consultant_list', $data);
	}
}