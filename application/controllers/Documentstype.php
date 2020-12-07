<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Documentstype extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('documentstype_model');
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
		$doc['title'] = 'Documents Type';
		$doc['doc_data'] = $this->documentstype_model->get_data();
		$this->templated->load('Backend/default_layout', 'contents', 'documentstype/doc_type_list', $doc);
	}
	/*public function add_document() {
		$this->load->view('documentstype/add_documentstype');
		if(isset($_POST['submit'])){
			$data = array(
				'doc_name'   => $this->input->post('doc_name')
			);
			$docType = $this->documentstype_model->insert($data);
			if($docType == TRUE) {
				$success_data = array(
					'success_msg' => 'Documents added successfully'
				);
				$this->templated->load('Backend/default_layout', 'contents', 'documentstype/add_document', $success_data);
			} else {
				$error_data = array(
					'error_msg' => 'Something went wrong. Please try again'
				);
				$this->templated->load('Backend/default_layout', 'contents', 'documentstype/add_document', $error_msg);
			}
		}
	}*/
}