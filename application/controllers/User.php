<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->load->model('consultants_model');
		$this->load->model('usertype_model');
		$this->load->model('global_model');
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
		$data['title'] = 'Users';
		$data['breathcum'] = 'Users';
		$data['user_data'] = $this->user_model->get_data();
		$this->templated->load('Backend/default_layout', 'contents', 'user/user_list', $data);
	}
	public function user_view() {
		$data['title'] = 'Add User';
		$data['breathcum'] = 'Add User';
		$data['vendor_emp_data'] = $this->consultants_model->get_data();
		$data['usertype_data'] = $this->usertype_model->get_data();
		//print_r($data); die();
		$this->templated->load('Backend/default_layout', 'contents', 'user/add_user', $data);
	}
	public function add_user() {
		$data['title'] = 'Add User';
		$data['breathcum'] = 'Add User';
		//$this->load->view('user/add_user');
		if(isset($_POST['submit'])){
			$data = array(
				'org_id' 		=> $this->input->post('org_id'),
				'name'   		=> $this->input->post('name'),
				'email'  		=> $this->input->post('email'),
				'phone'  		=> $this->input->post('phone'),
				'password' 		=> $this->input->post('password'),
				'user_type' 	=> $this->input->post('user_type'),
				'role'			=> $this->input->post('role'),
				'status'		=> $this->input->post('status')

			);
			
			// print_r($data); die;
			$user = $this->user_model->insert($data);
			if($user == TRUE) {
				
				$userid = $this->db->insert_id();

				$data1 = array(
				'user_id'		=> $userid,
				'email'  		=> $this->input->post('email'),
				'password' 		=> $this->input->post('password'),
				'user_type' 	=> $this->input->post('user_type'),
				'is_login'		=> '1'

			);

				$this->global_model->insert_data('panel_membertbl',$data1);

				$success_message = 'Records added successfully';
				$this->session->set_flashdata('success_message',$success_message);  				
				redirect('user-list');
			} else {
				$error_message = 'Something went wrong. Please try again';
    			$this->session->set_flashdata('error_message',$error_message);
				redirect('user-list');
			}
		}
	}
	public function display_user() {
		$data['title'] = 'Update User';
		$data['breathcum'] = 'Update User';
		$id = $this->uri->segment(2);
		$data['usertype_data'] = $this->usertype_model->get_data();
		$data['user_data'] = $this->user_model->getdata_by_id($id);
		$this->templated->load('Backend/default_layout', 'contents', 'user/edit_user', $data);	
	}
	public function edit_user() {
		
		$id 		=	$this->input->post('user_id');
		$name		=	$this->input->post('name');
		$email		=	$this->input->post('email');
		$phone		=	$this->input->post('phone');
		$password	=	$this->input->post('password');
		$user_type	=	$this->input->post('user_type');
		if($id){
			$data=array(
				'name'		=>	set_value('name', $name),
				'email' 	=>	set_value('email', $email),
				'phone' 	=> 	set_value('phone', $phone),
				'password'	=>	set_value('password', $password),
				'user_type'	=> 	set_value('user_type', $user_type)
			);
			$user_data = $this->user_model->update('panel_usertbl', $data, $id);
			if ($user_data == TRUE) {

			$data1=array(
				'email' 	=>	set_value('email', $email),
				'password'	=>	set_value('password', $password),
				'user_type'	=> 	set_value('user_type', $user_type)
			);

			$this->user_model->update('panel_membertbl', $data1, $id);

				$success_message = 'Records updated successfully';
				$this->session->set_flashdata('success_message',$success_message);  				
				redirect('user-list');	
			} else {
				$error_message = 'Something went wrong. Please try again';
    			$this->session->set_flashdata('error_message',$error_message);
				redirect('user-list');
			}
		}else{
			return false;
		}
	}

	public function delete_users() {
		if($this->input->get('id')){
            $this->global_model->del_data('panel_usertbl',array("user_id"=>$this->input->get('id')));
            $message    = array("1","Successfully Delete");
        }

								if($message[0] == 1) {

			$this->global_model->del_data('panel_membertbl',array("user_id"=>$this->input->get('id')));

									$success_message = 'Records Deleted successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect(base_url('user-list'),'location');
								} else {
									$error_message = 'Something Went Wrong';
									$this->session->set_flashdata('error_message',$error_message);  
									redirect(base_url('user-list'),'location');
								}
						

	}
}