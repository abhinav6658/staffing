<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Authentication_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function login_process($data) {
		$this->db->select('*');
		$this->db->from('panel_membertbl');
		$this->db->where('email', $data['userid']);
		$this->db->where('password', $data['password']);
		$this->db->where('is_login', '1');
		$query = $this->db->get();
		// print_r($query->result()); die;
		if($query->num_rows() == 1) {
			$row   = $query->row();
			$email = $row->email;
			$usertype  = $row->user_type;
			// print_r($row); die;
			$data = array(
				'email'    => $email,
				'is_login' => 1,
				'client_logged_in' => 1,
				'contact_user_id' => $row->member_id,
				'user_type' => $usertype
				//'name'  => name
			);
			// print_r($data); die;
			$this->session->set_userdata($data);

			return TRUE;
		}else {
			return FALSE;
		}

	}
}