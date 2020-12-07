<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Association class for vendor and consultant
* Written by Prashant Kumar on Feb 24, 2020 14:42:20
*/
class Association extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		$this->load->model('global_model');
		$this->load->helper('guid_creator_helper');
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
		$data['title']       = 'Association';
		$data['consul_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());
		// $data['vendors']     = $this->global_model->get_data('panel_vendortbl', array());
		$data['consultant']  = $this->global_model->get_data('panel_consultanttbl', array());

		$data['states']      = $this->global_model->get_data('panel_states', array());
		$data['conslt_frec'] = $this->global_model->get_data('panel_consultant_frequency', array());
		$data['rate_type']   = $this->global_model->get_data('panel_rate_typetbl', array());

		$this->templated->load('Backend/default_layout', 'contents', 'association/vendor_consultant_association', $data);
	}

	public function vendor_consultant_assoc() {
		redirect('authentication/dashboard');
	}

	// public function mapping_consult_add() {
	// 	if(isset($_POST['mapping_consult_submit'])) {
	// 		$guid = GUID();
	// 		//print_r($guid);die();
	// 		$data = array(
	// 			'org_id' => $this->input->post('org_id'),
	// 			'guid'	 => $guid,
	// 			'name'   => $this->input->post('name'),
	// 			'email'  => $this->input->post('email'),
	// 			'phone'  => $this->input->post('phone')
	// 		);
	// 		//print_r($data); //die();
	// 		$consultant = $this->global_model->set_data('panel_consultanttbl', $data);
	// 		if($consultant['insert_id']) {
	// 			$success_message = 'Records added successfully';
 //    			$this->session->set_flashdata('success_message',$success_message);  				
	// 			redirect(base_url('association'));
	// 		} else {
	// 			$error_message = 'Something went wrong. Please try again';
 //    			$this->session->set_flashdata('error_message',$error_message);
	// 			redirect(base_url('association'));
	// 		}
	// 	}
	// }

	// public function mapping_vendor_add() {
	// 	if(isset($_POST['mapping_vendor_submit'])) {
	// 		$guid = GUID();
	// 		$data = array(
	// 			'org_id' => $this->input->post('org_id'),
	// 			'guid'	 => $guid,
	// 			'name'   => $this->input->post('name'),
	// 			'email'  => $this->input->post('email'),
	// 			'phone'  => $this->input->post('phone')
	// 		);
	// 		//print_r($data); die();
	// 		$vendor = $this->global_model->set_data('panel_vendortbl', $data);
	// 		if($vendor['insert_id']) {
	// 			$success_message = 'Records added successfully';
	// 			$this->session->set_flashdata('success_message',$success_message);  				
	// 			redirect(base_url('association'));
	// 		} else {
	// 			$error_message = 'Something went wrong. Please try again';
	// 			$this->session->set_flashdata('error_message',$error_message);
	// 			redirect(base_url('association'));	
	// 		}
	// 	}

	// }
}