<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Usertype_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_data() {
		$this->db->select('*');
		$this->db->from('panel_master_user_typetbl');
		$this->db->where('status', '1');
		$this->db->order_by('usertype_id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return FALSE;
		}
	}
	public function get_total_count() {
		$this->db->select('*');
		$this->db->from('panel_master_user_typetbl');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	public function insert($data) {
		$this->db->insert('panel_master_user_typetbl', $data);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}

	}
}