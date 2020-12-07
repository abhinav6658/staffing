<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Consultantstype extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('consultantstype_model');
		$this->load->database();
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
		$consultantType['title'] = 'Consultant Type';
		$consultantType['contype_data'] = $this->consultantstype_model->get_data();
		$this->templated->load('Backend/default_layout', 'contents', 'consultantstype/consultanttype_list', $consultantType);
	}
	/*public function add_consultant_type() {
		$this->load->view('consultantstype/add_consultanttype');
		if(isset($_POST['submit'])){
			$data = array(
				'name'   => $this->input->post('name')
			);
			//print_r($data);
			$consultantType = $this->consultantstype_model->insert($data);
			if($consultantType == TRUE) {
				$success_data = array(
					'success_msg' => 'Consultant type added successfully'
				);
				$this->templated->load('Backend/default_layout', 'contents', 'consultantstype/add_consultanttype', $success_data);
			} else {
				$error_data = array(
					'error_msg' => 'Something went wrong. Please try again'
				);
				$this->templated->load('Backend/default_layout', 'contents', 'consultantstype/add_consultanttype', $error_msg);
			}
		}
	}*/
}