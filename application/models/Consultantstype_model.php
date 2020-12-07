<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Consultantstype_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_data() {
		$this->db->select('*');
		$this->db->from('panel_consultant_typetbl');
		$this->db->where('status', '1');
		$this->db->order_by('consultant_type_id', 'DESC');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return FALSE;
		}
	}
	public function get_total_count() {
		$this->db->select('*');
		$this->db->from('panel_consultant_typetbl');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	public function insert($data) {
		$this->db->insert('panel_consultant_typetbl', $data);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}

	}
}