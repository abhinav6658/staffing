<?php
/**
* Vendor and Consultant Association controller
* Written on Feb 21, 2020 by Prashant Kumar
*/
class  Association extends CI_Controller
{
	
	public function __construct() {
		parent::__construct();
		$this->load->model('global_model');
		$this->load->library('pagination');
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

	/*
	* Index function
	*/

	Public function ven_con_assoc() {
		return echo "Test";
		//$this->templated->load('Layouts/Backend/default_layout', 'contents', 'association/vendor_consultant_association');
	}

	/*
	* Association function
	*/

	// public function ven_con_assoc() {}
}