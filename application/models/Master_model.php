<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Master_model extends CI_Model {
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
	}	
	// Master	
	public function manage_master($data) {
		if ($data["id"] == 0)
		{
			if ($data["code_value"]=="")
			{		
				$this->db->select('max(id) as `numrows`' );
				$this->db->from('tblcode_mstr');
				$this->db->order_by('id', 'desc');
				$qry = $this->db->get();
				$row = $qry->row();
				$tot = $row->numrows;
				$counter = $tot+1;
				$data["code_value"] = $data['code_fld'] ."-".sprintf("%04d", $counter);
			}
			// print_r($_SESSION);exit;
			$data["created_by"] = $this->session->userdata('staff_user_id');
			$data["created_on"] = date('Y-m-d H:i:s');
			
			// print_r($data); exit();
			return  $this->db->insert('tblcode_mstr', $data);
			
		}
		else
		{
			$data["modified_by"] = $this->session->userdata('user_id');
			$data["modified_on"] = date('Y-m-d H:i:s');
			$this->db->where('id', $data['id']);
			$this->db->update('tblcode_mstr', $data);
			return $sql = $this->db->affected_rows();
		}
	}
	
	
	public function delete_master($data) {	
		//print_r($data);exit;
		$this->db->where('id', $data['id']);
		$this->db->delete('tblcode_mstr');
		//echo $sql = $this->db->last_query();exit;
		return $sql = $this->db->affected_rows();		
	}		
	
	public function status_master($data) {		
		$mydata = array(
			'active'							=> $data['active'],
			'modified_by'						=> $data['admin_user_id'],
			'modified_on'						=> date('Y-m-j H:i:s')
		);
		
		$this->db->where('id', $data['id']);
		$this->db->update('tblcode_mstr', $mydata);
		return $sql = $this->db->affected_rows();
	}
	
	public function record_count() {
        return $this->db->count_all("tblcode_mstr");
		
    }
	
	public function record_count_grp_by($parameter) {
		$this->db->select('COUNT(*) AS `numrows`' );
		$this->db->from('tblcode_mstr');
		if($parameter){
			$this->db->where('code_fld', $parameter);
		}else{
			//$this->db->where('code_fld', $parameter);
		}
		$qry = $this->db->get();
		$row = $qry->row();
		return $row->numrows;
		// echo $this->db->last_query();	exit;
		
    }

	public function get_master($limit, $start) {
        $this->db->order_by("id","desc");
		$this->db->limit($limit, $start);
        $query = $this->db->get("tblcode_mstr");
		return $query->result() ;
	}
	
   
	public function get_master_by_id($test_id) {
		$this->db->from('tblcode_mstr');
		$this->db->where('id', $test_id);
        $query = $this ->db->get();
		return $query->result_array();
		
	}	
	
	// Get all master_desc
	public function get_all_master($limit, $start, $field) {
		//echo $limit, $start, $field ;exit;
		//echo 'master='. $field; 
		$field = urldecode($field); 
		//$sql = "SELECT cm.id AS 'ID', cm.active AS active, cm.code_fld AS 'Masters', cm.code_value AS 'Value', cm.code_desc AS 'code_desc' FROM tblcode_mstr cm INNER JOIN tblcode_mstr cd ON cd.id = cm.id Order by masters";
		$this->db->select('cm.id AS ID, cm.created_on AS created_on, cm.modified_on AS modified_on, cm.active AS active, cm.code_desc AS code_desc, cm.code_desc1 AS code_desc1, cm.code_desc2 AS code_desc2, cm.code_desc3 AS code_desc3, cm.code_desc4 AS code_desc4, cm.code_desc5 AS code_desc5, cm.code_fld AS Masters, cd.code_value AS Value' );
		$this->db->from('tblcode_mstr cm');
		$this->db->join('tblcode_mstr cd', 'cd.id = cm.id','inner join' );
		if($field=='setting'){
		//$this->db->where('cm.code_fld', $field);
		}elseif($field){
			$this->db->where('cm.code_fld', $field);
		}else{
			
		}
		$this->db->order_by('cm.code_value', 'asc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
       //echo $this->db->last_query();	exit;	
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//print_r($row);exit;
                $data[] = $row;
            }
            return $data;
        }
        return false;
        //return $data[]=0;
	}
	
	public function get_all_master_list() {		
        //$this->db->order_by("id","desc");
		//$this->db->limit($limit, $start);
        //$query = $this->db->get("tblcode_mstr");
		$sql = "SELECT cm.id AS 'ID', cm.code_fld AS 'Masters', cd.code_value AS 'Value' FROM tblcode_mstr cm INNER JOIN tblcode_mstr cd ON cd.id = cm.id Order by masters";
		$this->db->select('cm.id AS ID, cm.created_on AS created_on, cm.modified_on AS modified_on, cm.active AS active, cm.code_desc AS code_desc, cm.code_desc1 AS code_desc1, cm.code_desc2 AS code_desc2, cm.code_desc3 AS code_desc3, cm.code_desc4 AS code_desc4, cm.code_desc5 AS code_desc5, cm.code_fld AS Masters, cd.code_value AS Value' );
		$this->db->from('tblcode_mstr cm');
		$this->db->join('tblcode_mstr cd', 'cd.id = cm.id','inner join' );
		$this->db->group_by('masters');
		$this->db->order_by('masters');
		$query = $this->db->get();
       // echo $this->db->last_query();	exit;	
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//print_r($row);exit;
                $data[] = $row;
            }
            return $data;
        }
        return false;
        //return $data[]=0;
	}
	
	//Get total master screens
	public function countAllMasterScreen($mastername) {
		//echo $mastername;exit;
		$this->db->select('COUNT(*) AS `numrows`' );
		$this->db->from('tblcode_mstr');
		//$this->db->where('code_fld', 'MasterScreen');
		if($mastername!='masters'){
		$this->db->where('code_fld', $mastername);
		}
		$qry = $this->db->get();
		$row = $qry->row();
		return $row->numrows;
		echo $this->db->last_query();	exit;
		
    }
	
	// Get all master screens
	public function getAllMasterScreen($limit, $start,$mastername) {
		//$this->db->select('*' );		
		$this->db->select('id,code_desc, code_desc1, code_desc2, code_desc3, code_desc4, code_desc5, created_by, created_on, modified_by, modified_on, active' );		
		$this->db->from('tblcode_mstr');
		if($mastername!='masters'){
			$this->db->where('code_fld', $mastername);
		}
		if ($mastername=="Town")
			$this->db->order_by('code_desc1','asc');
		$this->db->order_by('code_desc','asc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();	//exit;	
		return $query->result();

	}
	
	public function get_masterdata($limit, $start) {
        $this->db->order_by("id","desc");
		$this->db->limit($limit, $start);
        $query = $this->db->get("tblcode_mstr");
		return $query->result() ;
	
	}
	
	// Get all master Menu
	public function getAllMasterScreenMenu() {
		
		$this->db->select('*' );
		$this->db->from('tblcode_mstr');
		$this->db->where('code_fld', 'MasterScreen');
		$this->db->where('active', true);
		$this->db->order_by('code_desc5');
		$query = $this->db->get();
		return $query->result_array() ;
	}
	
	// Get screen master by mastername
	public function getAllMasterScreenByMastername($mastername) {
		$this->db->select('*' );
		$this->db->from('tblcode_mstr');
		$this->db->where('code_fld', 'MasterScreen');
		$this->db->where('code_value', $mastername);
		$this->db->order_by('created_on');
		$query = $this->db->get();
		//echo $this->db->last_query();	exit;	
		return $query->result() ;
	  
	}

	// Get screen master field by mastername
	public function getAllMasterScreenFieldByMastername($mastername) {
		$this->db->select('*' );
		$this->db->from('tblcode_mstr');
		$this->db->where('code_fld', 'MasterScreen');
		$this->db->where('code_value', $mastername);
		$this->db->order_by('created_on');
		$query = $this->db->get();
		return $query->result() ;
		//echo $this->db->last_query();	exit;	
	   /*
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
		*/
	}
	
	public function getCompleteMasterScreen($mastername) {
		//$this->db->select('*' );		
		$this->db->select('id,code_desc, code_desc1, code_desc2, code_desc3, code_desc4, code_desc5, created_by, created_on, modified_by, modified_on, active' );		
		$this->db->from('tblcode_mstr');
		if($mastername!='masters'){
		$this->db->where('code_fld', $mastername);
		}
		//$this->db->order_by('created_on');
		//$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
		//echo $this->db->last_query();	exit;	

	}
}


