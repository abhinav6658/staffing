<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class User_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_data() {
		$this->db->select('*');
		$this->db->from('panel_usertbl');
		$this->db->where('status', '1');
		$this->db->order_by('user_id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return FALSE;
		}
	}
	public function getdata_by_id($id){
		$this->db->where('user_id', $id);
	 	$qry=$this->db->get('panel_usertbl');
	 	//print_r($qry->num_rows());
	 	if($qry->num_rows() > 0){
	 		return $qry->result_array();
	 	}else{
	 		return false;
	 	}
	}
	public function get_total_count() {
		$this->db->select('*');
		$this->db->from('panel_usertbl');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	public function insert($data) {
		$this->db->insert('panel_usertbl', $data);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	public function update($table,$data,$id) {
		$this->db->where('user_id', $id);
		$this->db->update($table, $data);
		if ($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
}