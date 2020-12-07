<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Vendors_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_data() {
		$this->db->select('*');
		$this->db->from('panel_vendortbl');
		$this->db->where('status', '1');
		$this->db->order_by('vendor_id', 'DESC');
		$query = $this->db->get();
		//print_r($query->result());
		if($query->num_rows() > 0) {
			//return TRUE;
			return $query->result_array();
		}else {
			return FALSE;
		}
	}
	public function getdata_by_id($id){
		$this->db->where('vendor_id', $id);
	 	$qry=$this->db->get('panel_vendortbl');
	 	//print_r($qry->num_rows());
	 	if($qry->num_rows() > 0){
	 		return $qry->result_array();
	 	}else{
	 		return false;
	 	}
	 	//return $results;
	}
	public function get_total_count() {
		$this->db->select('*');
		$this->db->from('panel_vendortbl');
		$this->db->where('status', '1');
		$query = $this->db->get();
		//print_r($query->num_rows());
		if($query->num_rows() > 0) {
			return $query->num_rows();
		}else {
			return FALSE;
		}
	}
	public function insert($data) {
		$this->db->insert('panel_vendortbl', $data);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	public function update($table,$data,$id) {
		$this->db->where('vendor_id', $id);
		$this->db->update($table, $data);
		if ($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
}