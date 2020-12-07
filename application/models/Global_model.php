<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

/*
* Global model for all common function related to modles
* Written by Prashant Kumar on Feb 24, 2020 15:10:46
*/
class Global_model extends CI_Model{
	function __construct() {
		parent::__construct();
	}

	public function get_data($table,$params = array()) {
		 // echo count($params);exit;
		$order_by = $params['order_by'];
		$cond = $params['cond'];
		$limit = $params['limit'];
		$is_single = false;
		if(isset($params['returnType']) && $params['returnType'] == 'single') {
			$is_single = true;
		}
		unset($params['cond']);
		unset($params['returnType']);
		unset($params['order_by']);
		unset($params['limit']);
		foreach ($params as $key => $value) {
			$this->db->where($key,$value);
			if($order_by=='') {
				$this->db->order_by('id');
			} else {
				$this->db->order_by($order_by,$cond);
			}
		}
		if($limit !='') {
			$this->db->limit($limit);
		}
		$query = $this->db->get($table);
		// echo $this->db->last_query();exit;
		if($is_single == true) {
			$result = ($query->num_rows() > 0)?$query->row_array():FALSE;
		} else {
			$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		}
		return $result;
	}

	public function del_data($table,$params = array()) {
		// echo $table; die;

		foreach ($params as $key => $value) {
			$this->db->where($key, $value);
			return $this->db->delete($table);
		}
	}

	public function updatebill_status($ids){

        
        $this->db->update($tbl_name ,$values);
        //echo $this->db->last_query();die;
        return true;
    }

    public function updateBillByIds($id){

    	$userinfo = ['bill_generated'=>0];
    	$this->db->set($userinfo);
    	$this->db->where('bill_id', $id);
        $this->db->update('panel_master_timesheettbl');

        // echo $this->db->last_query();die;
        
        return TRUE;
    }

    public function updateconsultantvendorIds($vid, $guid ){

    	$userinfo = $vid;
    	$this->db->set($userinfo);
    	$this->db->where('guid', $id);
        $this->db->update('panel_consultanttbl');

        echo $this->db->last_query();die;
        
        return TRUE;
    }

	public function set_data($table,$params = null) {
		$data = array();
		$data['status'] = false;
		if (isset($params['id']) && !empty($params['id'])) {
			$this->db->where('id', $params['id']);
			//unset($params['id']);      
			if($this->db->update($table, $params)) {
				$data['insert_id'] = $params['id'];
				$data['status']    = true;
				$data['message']   = 'Data successfully updated';
			} else {
				$data['message']   = 'Some problems occured, please try again.';
			}
			//echo $this->db->last_query();exit;
		} else {
			if($this->db->insert($table, $params)) {
				$insert_id = $this->db->insert_id();
				$data['insert_id'] = $insert_id;
				$data['status']    = true;
				$data['message']   = 'Your data was successfully added.';
			} else {
				$data['message']   = 'Some problems occured, please try again.';
			}
		}
		return $data;
	}

	public function get_num_rows($table,$params = array()) {
		
		$firstname = $params['firstname'];
		$middle_name = $params['middle_name'];
		$lastname = $params['lastname'];
		$alpha = $params['alpha'];
		$active = $params['active'];
		unset($params['alpha']);
		unset($params['active']);
		unset($params['firstname']);
		unset($params['middle_name']);
		unset($params['lastname']);
		if (count($params)==0) {
			$query = $this->db->get($table);
		} else {
			foreach ($params as $key => $value) {			  
				$this->db->where($key,$value);
			}
			if(isset($active)) {
				$this->db->where('active',$active);
			}
			if($firstname!='') {
				$this->db->like('firstname',$firstname);
			}
			if($middle_name!='') {
				$this->db->like('middle_name',$middle_name);
			}
			if($lastname!='') {
				$this->db->like('lastname',$lastname);
			}
			//echo $active; exit();
			if($active!='') {
			 	$this->db->where('active', $active);
			}
			$query = $this->db->get($table);
			// echo $this->db->last_query();exit();
		}
		return $query->num_rows();
	}
	
	public function get_limit_data($table,$params = array()) {
		$firstname = $params['firstname'];
		$middle_name = $params['middle_name'];
		$lastname = $params['lastname'];
		$city = $params['city'];
		$alpha = $params['alpha'];
		$active = $params['active'];
		//print_r($active);die();
		$orderbyName = $params['orderbyName'];
		$orderbyAcvive = $params['orderbyAcvive'];
		unset($params['orderbyAcvive']);
		unset($params['orderbyName']);
		unset($params['alpha']);
		unset($params['active']);
		unset($params['firstname']);
		unset($params['middle_name']);
		unset($params['lastname']);
		unset($params['city']);
		//print_r($params);exit;
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		foreach ($params as $key => $value) {
			$this->db->where($key,$value);
		}
		if(isset($active)) {
			$this->db->where('active',$active);
		}
		// if($params['userid'] != '') {
		// 	$this->db->where('userid', $params['userid']);
		// }
		// echo $active;exit;
		if($firstname !='') {
			$this->db->like('firstname',$firstname);
			$this->db->or_like('middle_name',$firstname);
			$this->db->or_like('lastname',$firstname);
		}
		if($middle_name !='') {
			$this->db->like('firstname',$middle_name);
			$this->db->or_like('middle_name',$middle_name);
			$this->db->or_like('lastname',$middle_name);
		}
		if($lastname !='') {
			$this->db->like('firstname',$lastname);
			$this->db->or_like('middle_name',$lastname);
			$this->db->like('lastname',$lastname);
		}

		if($city !='') {
			$this->db->like('city',$city);
		}
		
		if($alpha !='') {
			$this->db->like('lastname', $alpha, 'after');
		}
		//echo $active;exit;
		if($active!='') {
			$this->db->where('active', $active);
		}
		if($orderbyName!=''&& $orderbyAcvive!='') {
			$this->db->order_by($orderbyAcvive,'DESC');
			$this->db->order_by($orderbyName,'ASC');
		} else {
			$this->db->order_by('id','DESC');
		}
		$this->db->limit($limit ,$offset);
		$query = $this->db->get($table);
		// echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function get_user($user_id = null, $id = null) {
		$this->db->select('c.*,sa.*,d.*,st.*,ec.*');
		$this->db->from('tblcontacts as c');
		$this->db->join('tblkorskill_acitivity as sa','c.id = sa.user_id','left');
		$this->db->join('tblkor_documents as d','c.id = d.user_id','left');
		$this->db->join('tblkorstatus as st','c.id = st.user_id','left');
		$this->db->join('tblkoremergency_contact as ec','c.id = ec.user_id','left');

		$this->db->where('c.id',$id);
		$this->db->where('c.userid',$user_id);
		$query = $this->db->get();
		echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}

	public function get_pdf_data($params = array()) {
		$user_id    = $params['user_id'];
		$client_id  = $params['client_id'];
		$start_date = $params['start_date'];
		$end_date 	= $params['end_date'];
		$agency_id 	= $params['agency_id'];
		$count      = $params['count'];
		$limit      = $params['limit'];
		$offset     = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		
		$this->db->select('distinct (ts.client_id),ts.user_id');
		//$this->db->distinct('ts.client_id');
		//$this->db->distinct('ts.user_id');
		$this->db->from('tblkortime_sheet as ts');
		$this->db->where('ts.checkout_date>=',$start_date);
		$this->db->where('ts.checkout_date<=',$end_date);
		$this->db->where('ts.agency_id',$agency_id);
		$this->db->where('ts.status=','1');
		
		if($client_id != '') {
			$this->db->where('ts.client_id',$client_id);
			$this->db->group_by('ts.user_id');
		}
		if($user_id != '') {
			$this->db->where('ts.user_id',$user_id);
		}
		/*
		if($client_id==''){
			$this->db->group_by('ts.client_id');
		}
		*/
		$this->db->order_by('ts.client_id');
		if($count == 0) {
			$this->db->limit($limit ,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();//exit;
		if ($query->num_rows() >= 1) {
			if($count == 0){
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	public function view_pdf_data($params = array()) {
		$start_date = $params['start_date'];
		$end_date 	= $params['end_date'];
		$agency_id 	= $params['agency_id'];
		$client_id 	= $params['client_id'];
		$user_id 	= $params['user_id'];
		$type 	    = $params['type'];
		$this->db->select('ts.*,s.status as type');
		$this->db->from('tblkortime_sheet as ts');
		$this->db->join('tblkor_schedule as s','s.id = ts.schedule_id','left');
		$this->db->where('ts.checkout_date>=',$start_date);
		$this->db->where('ts.checkout_date<=',$end_date);
		$this->db->where('ts.agency_id',$agency_id);
		$this->db->where('ts.client_id',$client_id);
		$this->db->where('ts.user_id',$user_id);
		$this->db->where('ts.status=','1');
		if($type!='') {
			$this->db->where('s.status=',$type);
		}
		$this->db->order_by('ts.checkout_date');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}

	public function user_expiring_docs($params = array()) {
		$user_id      = $params['user_id'];
		$client_id    = $params['client_id'];
		$start_date   = $params['start_date'];
		$end_date 	  = $params['end_date'];

		$expireDocs   = $params['expire_range'];

		$today        = date('Y-m-d');
		$monday       = strtotime("last monday");
		$monday       = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday       = strtotime(date("Y-m-d",$monday)." +6 days");

		$this_week_sd = date("Y-m-d",$monday);
		$this_week_ed = date("Y-m-d",$sunday);

		$month_sd     = date('Y-m') . "-" . 01;
		$month_ed     = date("Y-m-t", strtotime($today));

		$agency_id 	  = $params['agency_id'];
		$count        = $params['count'];
		$limit        = $params['limit'];
		$offset       = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);

		$this->db->select('tc.*,doc.user_id as caregiver_id,doc.id as doc_id,doc.doc_type as doc_type,doc.doc_issue_date as doc_issue_date,doc.doc_expire_date as doc_expire_date');
		$this->db->from('tblcontacts as tc');
		$this->db->join('tblkor_documents as doc','doc.user_id = tc.id','left');

		if($expireDocs == "week") {
			$this->db->where('doc.doc_expire_date BETWEEN "'. $this_week_sd . '" and "'. $this_week_ed .'"');
		} elseif ($expireDocs == "month") {
			$this->db->where('doc.doc_expire_date BETWEEN "'. $month_sd . '" and "'. $month_ed .'"');
		} else {
			$this->db->where('doc.doc_expire_date <',$today);
		}

		$this->db->where('doc.user_type',1);
		$this->db->where('tc.userid',$agency_id);
		
		if($user_id!='') {
			$this->db->where('doc.user_id',$user_id);
		}
		if($count==0) {
			$this->db->limit($limit ,$offset);
			//$this->db->order_by('s.start_time' ,'ASC');
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		if ($query->num_rows() >= 1) {
			if($count==0) {
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	public function client_expired_docs($params = array()) {
		$user_id    = $params['user_id'];
		$client_id  = $params['client_id'];
		$start_date = $params['start_date'];
		$end_date 	= $params['end_date'];

		$expireDocs = $params['expire_range'];

		$agency_id 	= $params['agency_id'];
		$count      = $params['count'];
		$limit      = $params['limit'];
		$offset     = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);

		// $this->db->select('ts.*');
		// $this->db->from('tblkortime_sheet as ts');
		// $this->db->join('tblkor_schedule as s','s.id = ts.schedule_id','left');
		// $this->db->where('ts.checkout_date>=',$start_date);
		// $this->db->where('ts.checkout_date<=',$end_date);
		// $this->db->where('ts.agency_id',$agency_id);
		// $this->db->where('ts.client_id',$client_id);

		$this->db->select('tc.*,doc.user_id as caregiver_id,doc.id as doc_id,doc.doc_type as doc_type,doc.doc_issue_date as doc_issue_date,doc.doc_expire_date as doc_expire_date');
		$this->db->from('tblkor_clients as tc');
		$this->db->join('tblkor_documents as doc','doc.user_id = tc.id','left');
		
		$today = date('Y-m-d');
		if($expireDocs == 15) {
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 15 days'));
			$this->db->where('doc.doc_expire_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		} elseif ($expireDocs == 7) {
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 7 days'));
			$this->db->where('doc.doc_expire_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		} elseif ($expireDocs == 30) {
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 30 days'));
			$this->db->where('doc.doc_expire_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		} else {
			$this->db->where('doc.doc_expire_date <',$today);
		}

		//$this->db->where('doc.doc_expire_date>=',$start_date);
		//$this->db->where('doc.doc_expire_date<=',$end_date);
		$this->db->where('doc.user_type',1);
		$this->db->where('tc.userid',$agency_id);

		// $this->db->select('*');
		// $this->db->from('tblkor_documents as doc');
		// $this->db->where('doc.doc_expire_date>=',$start_date);
		// $this->db->where('doc.doc_expire_date<=',$end_date);
		
		if($user_id!='') {
			$this->db->where('doc.user_id',$user_id);
		}
		if($count==0) {
			$this->db->limit($limit ,$offset);
			//$this->db->order_by('s.start_time' ,'ASC');
			
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		if ($query->num_rows() >= 1) {
			if($count==0) {
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	public function get_all_comp_app($params = array()) {
		$agency_id    = $params['agency_id'];
		$count        = $params['count'];
		$limit        = $params['limit'];
		$offset       = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		$this->db->select('s.*');
		$this->db->from('tblkortime_sheet as s');
		// $this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		// if($start_date!='') {
		// 	$this->db->where('s.start_date>=',$start_date);
		// }
		// if($end_date!='') {
		// 	$this->db->where('s.end_date<=',$end_date);
		// }
		if($params['caregiver_id'] != '') {
			$this->db->where('s.user_id', $params['caregiver_id']);
		}
		if($params['client_id'] != '') {
			$this->db->where('s.client_id', $params['client_id']);
		}
		if($params['year'] != '' && $params['month'] != '') {
			$start_date = $params['year'] . '-' . $params['month'] . '-' . 01;
			$end_date   = $params['year'] . '-' . $params['month'] . '-' . 31;
			$this->db->where('s.checkin_date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
		} else if($params['year'] != '') {
			$start_date = $params['year'] . '-' . 01 . '-' . 01;
			$end_date   = $params['year'] . '-' . 12 . '-' . 31;
			$this->db->where('s.checkin_date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
		} else if($params['month'] != '') {
			$start_date = date('Y') . '-' . $params['month'] . '-' . 01;
			$end_date   = date('Y') . '-' . $params['month'] . '-' . 31;
			$this->db->where('s.checkin_date BETWEEN "' . $start_date . '" and "' . $end_date . '"' );
		}
		$this->db->where('s.agency_id',$agency_id);
		if($count==0) {
			$this->db->limit($limit ,$offset);
			// $this->db->order_by('s.start_time' ,'ASC');
		}
		$this->db->where('s.checkout_time!=', '00:00:00');
		$query = $this->db->get();
		// if($params['caregiver_id'] != '') {
		// 	echo $this->db->last_query();
		// 	exit;
		// }
		if ($query->num_rows() >= 1) {
			if($count==0) {
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}
	}


	//Global model merge codes

	public function getdata_by_id($table,$id,$consult_id){
		$this->db->where($id, $consult_id);
	 	$qry=$this->db->get($table);
	 	if($qry->num_rows() > 0){
	 		return $qry->result_array();
	 	}else{
	 		return false;
	 	}
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
	public function insert_data($table,$data) {
		$this->db->insert($table, $data);
		if($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function Timesheet_Report_list($params = array()) {
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);

		foreach ($params as $params_key => $params_value) {
			$this->db->where($params_key, $params_value);
		}

		$this->db->select('*')->from('panel_master_timesheettbl as s');

		if($count == 0){
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.id' ,'DESC');
		}
		$query = $this->db->get();
		// echo $this->db->last_query();

		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}	
	}
	public function consultant_list($params = array()) {
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);

		foreach ($params as $params_key => $params_value) {
			$this->db->where($params_key, $params_value);
		}

		$this->db->select('*')->from('panel_consultanttbl as s');

		if($count == 0){
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.consultant_id' ,'DESC');
		}
		$query = $this->db->get();
		// echo $this->db->last_query();

		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}	
	}


	public function vendor_list($params = array()) {
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		foreach ($params as $params_key => $params_value) {
			$this->db->where($params_key, $params_value);
		}
		$this->db->select('*')->from('panel_vendortbl as s');
		if($count == 0) {
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.vendor_id' ,'DESC');
		}
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() >= 1) {
			if($count==0) {
				return $query->result_array();
			} else {
				return $query->num_rows();
			}
		} else {
			return false;
		}	
	}
	public function get_consultant_type_list($params = array()) {
   		$consultant_id = $params['consultant_id'];
		$consultant_type_id    = $params['consultant_type_id'];
		$this->db->select('*');
		$this->db->from('panel_consultanttbl as s');
		$this->db->join('panel_consultant_typetbl as ct','s.consultant_type = ct.consultant_type_id','left');
		// $this->db->where('s.start_date',$today);
		$this->db->where('ct.consultant_type_id',$consultant_type_id);
		
		if($consultant_id!='') {
			$this->db->where('s.consultant_id',$consultant_id);
		}
		$this->db->where('s.status',1);
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}

	public function vendor_update($table, $params=null) {
		$vd_data = array();
		if(isset($params['vendor_id']) && !empty($params['vendor_id'])) {
			$this->db->where('vendor_id', $params['vendor_id']);
			if($this->db->update($table, $params)) {
				$vd_data['insert_id'] = $params['vendor_id'];
				$vd_data['status']    = true;
				$vd_data['message']   = 'Data successfully updated';
			} else {
				$vd_data['message']   = 'Some problems occured, please try again.';
			}
		}
		return $vd_data;
	}
}
