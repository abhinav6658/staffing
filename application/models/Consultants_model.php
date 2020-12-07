<?php
defined('BASEPATH') or exit('No direct script access allowed');

Class Consultants_model extends CI_Model {
	function __construct() {
		parent::__construct();
			//$table='panel_consultanttbl';
	}
	public function total_rows() {
		$this->db->select('*');
		$this->db->from('panel_consultanttbl');
		$this->db->where('status', '1');
		return $this->db->count_all_results();
	}
	public function index_limit($limit, $start=0) {
		//$this->db->select('*');
		//$this->db->from('panel_consultanttbl');
		$this->db->order_by('consultant_id', 'DESC');
		$this->db->limit($limit, $start);
		return $this->db->get('panel_consultanttbl')->result_array();
	}
	public function get_data() {
		$this->db->select('*');
		$this->db->from('panel_consultanttbl');
		$this->db->where('status', '1');
		$this->db->order_by('consultant_id', 'DESC');
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
		$this->db->where('consultant_id', $id);
	 	$qry=$this->db->get('panel_consultanttbl');
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
		$this->db->from('panel_consultanttbl');
		$query = $this->db->get();
		//print_r($query->num_rows());
		if($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return FALSE;
		}
	}
	public function insert_consultant($data) {
		$this->db->insert('panel_consultanttbl', $data);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	public function update_consultant($table,$data,$id) {
		$this->db->where('consultant_id', $id);
		$this->db->update($table, $data);
		if ($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function update_consultantguid($table,$data,$id) {
		$this->db->where('guid', $id);
		$this->db->update($table, $data);
		if ($this->db->affected_rows() > 0){
			alert('true'); die;
			return true;
		}else{
			alert('false'); die;
			return false;
		}
	}
}