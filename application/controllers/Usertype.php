<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Usertype extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('usertype_model');
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
		$usertype['title'] = 'User Type';
		$usertype['user_data'] = $this->usertype_model->get_data();
		$this->templated->load('Backend/default_layout', 'contents', 'usertype/usertype_list', $usertype);
		
	}
	/*public function add_user() {
		$this->load->view('usertype/add_usertype');
		if(isset($_POST['submit'])){
			$data = array(
				'name'   => $this->input->post('name'),
				'email'  => $this->input->post('email'),
				'phone'  => $this->input->post('phone')
			);
			$userType = $this->usertype_model->insert($data);
			if($userType == TRUE) {
				$success_data = array(
					'success_msg' => 'User added successfully'
				);
				$this->templated->load('Backend/default_layout', 'contents', 'usertype/add_usertype', $success_data);
			} else {
				$error_data = array(
					'error_msg' => 'Something went wrong. Please try again'
				);
				$this->templated->load('Backend/default_layout', 'contents', 'usertype/add_usertype', $error_msg);
			}
		}
	}*/
}