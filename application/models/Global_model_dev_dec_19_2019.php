<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Global_model extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	public function get_data($table,$params = array()){
		//echo count($params);exit;
		$order_by = $params['order_by'];
		$cond = $params['cond'];
		$limit = $params['limit'];
		$is_single = false;
		if(isset($params['returnType']) && $params['returnType'] == 'single'){
			$is_single = true;
		}
		unset($params['cond']);
		unset($params['returnType']);
		unset($params['order_by']);
		unset($params['limit']);
		foreach ($params as $key => $value) {
			$this->db->where($key,$value);
			if($order_by==''){
				$this->db->order_by('id');
			}else{
				$this->db->order_by($order_by,$cond);
			}
		}
		if($limit !=''){
			$this->db->limit($limit);
		}
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		if($is_single == true){
			$result = ($query->num_rows() > 0)?$query->row_array():FALSE;
		}else{
			$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		}
		return $result;
	}

	public function del_data($table,$params = array()){
		foreach ($params as $key => $value) {
			$this->db->where($key, $value);
			return $this->db->delete($table);
		}
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
	public function get_num_rows($table,$params = array()){
		
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
		if (count($params)==0){
			$query = $this->db->get($table);
		}else{
			foreach ($params as $key => $value) {			  
				$this->db->where($key,$value);
			}
			if($firstname!=''){
				$this->db->like('firstname',$firstname);
			}
			if($middle_name!=''){
				$this->db->like('middle_name',$middle_name);
			}
			if($lastname!=''){
				$this->db->like('lastname',$lastname);
			}
			if($alpha!=''){
				$this->db->like('lastname', $alpha, 'after');
			}
			if(isset($active)){
				$this->db->where('active', $active);
			}
			$query = $this->db->get($table);
		}
		return $query->num_rows();
	}
	
	public function get_limit_data($table,$params = array()){
		$firstname = $params['firstname'];
		$middle_name = $params['middle_name'];
		$lastname = $params['lastname'];
		$city = $params['city'];
		$alpha = $params['alpha'];
		$active = $params['active'];
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
		if($firstname !=''){		
			$this->db->like('firstname',$firstname);
			$this->db->or_like('middle_name',$firstname);
			$this->db->or_like('lastname',$firstname);
		}
		if($middle_name !=''){
			$this->db->like('firstname',$middle_name);
			$this->db->or_like('middle_name',$middle_name);
			$this->db->or_like('lastname',$middle_name);
		}
		if($lastname !=''){	
			$this->db->like('firstname',$lastname);
			$this->db->or_like('middle_name',$lastname);
			$this->db->like('lastname',$lastname);
		}	

		if($city !=''){
			$this->db->like('city',$city);
		}
		
		if($alpha !=''){
			$this->db->like('lastname', $alpha, 'after');
		}
		//echo $active;
		if(isset($active)){
			$this->db->where('active', $active);
		}
		if($orderbyName!=''&& $orderbyAcvive!=''){
			$this->db->order_by($orderbyAcvive,'DESC');
			$this->db->order_by($orderbyName,'ASC');
		}else{
			$this->db->order_by('id','DESC');
		}
		$this->db->limit($limit ,$offset);
		$query = $this->db->get($table);
		// echo $this->db->last_query();exit;
		return $query->result_array();
	}
	public function get_data_by_limit($table,$params = array()){
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		foreach ($params as $key => $value) {			  
			$this->db->where($key,$value);
		}
		if($table =='events'){
			$this->db->order_by('start_date','desc');
		}
		if($count==0){
			$this->db->limit($limit ,$offset);
		}
		$query = $this->db->get($table);
		//echo $this->db->last_query();//exit;
		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}
	public function get_user($user_id = null, $id = null){
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
	public function get_caregiver($agency_state){
		$this->db->select('mp.*');
		$this->db->from('tblkor_medicaid_provider as mp');
		$this->db->where("FIND_IN_SET('$agency_state', mp.state)");
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	public function get_late_checkIn(){
		$this->db->select('s.start_date,s.start_time,ts.checkin_date,ts.checkin_time,ts.late_check_deff,c.id,c.firstname,c.middle_name,c.lastname');
		$this->db->from('tblkor_schedule as s');
		$this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		$this->db->join('tblcontacts as c','c.id = s.caregiver_id','left');
		$this->db->where('ts.agency_id',$this->session->userdata('client_user_id'));
		$this->db->where('ts.late_check_deff >',7);
		$this->db->where('ts.checkin_date',date('Y-m-d'));
		
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	public function get_today_appoientment($params = array()){
		$caregiver_id = $params['caregiver_id'];
		$latechek = $params['latechek'];
		$inprocess = $params['inprocess'];
		$client_id = $params['client_id'];
		$today = date('Y-m-d',strtotime($params['date']));
		$agency_id 	= $params['agency_id'];
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		$this->db->select('s.*,ts.late_check_deff as late_check,ts.checkin_time,ts.checkout_time,ts.checkin_date,ts.checkout_date,ts.late_check_our_diff as let_chekout,ts.id as timesheedID');
		$this->db->from('tblkor_schedule as s');
		$this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		$this->db->where('s.start_date',$today);
		$this->db->where('s.user_id',$agency_id);
		if($latechek!=''){
			$this->db->where('ts.late_check_deff >',7);
		}
		if($inprocess!=''){
			$this->db->where('ts.checkin_time!=','');
			$this->db->where('ts.checkout_time','00:00:00');
		}
		if($client_id!=''){
			$this->db->where('s.client_id',$client_id);
		}
		if($caregiver_id!=''){
			$this->db->where('s.caregiver_id',$caregiver_id);
		}
		if($count==0){
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.start_time' ,'ASC');
			
		}
		$query = $this->db->get();
		//echo $this->db->last_query();//exit;
		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	
    // Raj function start here

	public function get_today_no_appointment($params = array()){

		$firstname = $params['firstname'];
		$middle_name = $params['middle_name'];
		$lastname = $params['lastname'];
		$caregiver_id = $params['caregiver_id'];
		// $latechek = $params['latechek'];
		// $inprocess = $params['inprocess'];
		$client_id = $params['client_id'];
		$today = date('Y-m-d',strtotime($params['date']));
		$agency_id 	= $params['agency_id'];
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		$this->db->select('DISTINCT(client_id)');
		$this->db->where('user_id',$this->session->userdata('client_user_id'));
		$this->db->where('active = ','1');
		$this->db->where('start_date =', $today);
		$query = $this->db->get('tblkor_schedule');

		$client_id = array();
		foreach ($query->result_array() as $key => $cid) {

			$client_id[] = $cid['client_id'];

	# code...
		}

// $this->db->select(id);
		$this->db->where('userid',$this->session->userdata('client_user_id'));
		$this->db->where('active = ','1');
		$this->db->where_not_in('id',$client_id);
		if($firstname !=''){
			$this->db->like('firstname',$firstname);
			$this->db->or_like('middle_name',$firstname);
			$this->db->or_like('lastname',$firstname);
		}
		if($middle_name !=''){
			$this->db->like('firstname',$middle_name);
			$this->db->or_like('middle_name',$middle_name);
			$this->db->or_like('lastname',$middle_name);
		}
		if($lastname !=''){
			$this->db->like('firstname',$lastname);
			$this->db->or_like('middle_name',$lastname);
			$this->db->like('lastname',$lastname);
		}
		if($count==0)
		{
			$this->db->limit($limit ,$offset);
		}

		$query = $this->db->get('tblkor_clients');


		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	public function miss_check_in($params = array()){
		$caregiver_id = $params['caregiver_id'];
		$latechek = $params['latechek'];
		$inprocess = $params['inprocess'];
		$client_id = $params['client_id'];
		$today = date('Y-m-d',strtotime($params['date']));
		$agency_id 	= $params['agency_id'];
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		// $this->db->select('s.*,ts.late_check_deff as late_check,ts.checkin_time,ts.checkout_time,ts.checkin_date,ts.checkout_date,ts.late_check_our_diff as let_chekout,ts.id as timesheedID');
		// $this->db->from('tblkor_schedule as s');
		// // $this->db->from('tblkor_clients.id as cid');
		// $this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','inner');
		// $this->db->where('s.start_date',$today);
		// $this->db->where('s.user_id',$agency_id);
		// $this->db->where_not_in('s.client_id','ts.client_id');


		$this->db->select('*')->from('tblkor_schedule as s');
		$this->db->where('`id` NOT IN (SELECT `schedule_id` FROM `tblkortime_sheet`)', NULL, FALSE);
		$this->db->where('s.start_date',$today);
		$this->db->where('s.user_id',$agency_id);


		if($latechek!=''){
			$this->db->where('ts.late_check_deff >',7);
		}
		if($inprocess!=''){
			$this->db->where('ts.checkin_time!=','');
			$this->db->where('ts.checkout_time','00:00:00');
		}
		if($client_id!=''){
			$this->db->where('s.client_id',$client_id);
		}
		if($caregiver_id!=''){
			$this->db->where('s.caregiver_id',$caregiver_id);
		}
		if($count==0){
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.start_time' ,'ASC');
			
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}


	public function late_checkin($params = array()){
		$caregiver_id = $params['caregiver_id'];
		$latechek = $params['latechek'];
		$inprocess = $params['inprocess'];
		$client_id = $params['client_id'];
		// $today = date('Y-m-d',strtotime($params['date']));
		$agency_id 	= $params['agency_id'];
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		$this->db->select('s.*,ts.late_check_deff as late_check,ts.checkin_time,ts.checkout_time,ts.checkin_date,ts.checkout_date,ts.late_check_our_diff as let_chekout,ts.id as timesheedID');
		$this->db->from('tblkor_schedule as s');
		$this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		// $this->db->where('s.start_date',$today);
		$this->db->where('s.user_id',$agency_id);
		if($latechek!=''){
			$this->db->where('ts.late_check_deff >',7);
		}
		if($inprocess!=''){
			$this->db->where('ts.checkin_time!=','');
			$this->db->where('ts.checkout_time','00:00:00');
		}
		if($client_id!=''){
			$this->db->where('s.client_id',$client_id);
		}
		if($caregiver_id!=''){
			$this->db->where('s.caregiver_id',$caregiver_id);
		}
		if($count==0){
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.start_time' ,'ASC');
			
		}
		$query = $this->db->get();
		//echo $this->db->last_query();//exit;
		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}


	public function total_late_checkIn(){
		$this->db->select('s.start_date,s.start_time,ts.checkin_date,ts.checkin_time,ts.late_check_deff,c.id,c.firstname,c.middle_name,c.lastname');
		$this->db->from('tblkor_schedule as s');
		$this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		$this->db->join('tblcontacts as c','c.id = s.caregiver_id','left');
		$this->db->where('ts.agency_id',$this->session->userdata('client_user_id'));
		$this->db->where('ts.late_check_deff >',7);
		// $this->db->where('ts.checkin_date',date('Y-m-d'));
		
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}


	public function get_clientdetail($params = array()){
		$firstname = $params['firstname'];
		$middle_name = $params['middle_name'];
		$lastname = $params['lastname'];
		$agency_id 	= $params['agency_id'];	
		$expire_date = $params['expire_date'];	
		$today = date('Y-m-d');
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);

		$thirtyday = date('Y-m-d', strtotime($today. ' + 30 days'));
		$this->db->select('tblkor_clients.id as client_id,tblkor_clients.firstname,tblkor_clients.middle_name,tblkor_clients.lastname,tblkor_clients.email,tblkor_medicateProvider.oth_info_start_date,tblkor_medicateProvider.oth_info_end_date');
		$this->db->from('tblkor_clients');
		$this->db->join('tblkor_medicateProvider', 'tblkor_medicateProvider.user_id = tblkor_clients.id');
		$this->db->join('tblclients', 'tblclients.userid = tblkor_clients.userid');
		
		$this->db->where('tblkor_clients.userid',$agency_id);
		if($firstname !=''){
			$this->db->like('tblkor_clients.firstname',$firstname);
		}
		if($middle_name !=''){
			$this->db->like('tblkor_clients.middle_name',$middle_name);
		}
		if($lastname !=''){
			$this->db->like('tblkor_clients.lastname',$lastname);
		}
		if($count==0){
			$this->db->limit($limit ,$offset);
			// $this->db->order_by('s.start_time' ,'ASC');
			
		}
		if($expire_date == 15)
		{
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 15 days'));
			$this->db->where('tblkor_medicateProvider.oth_info_end_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		}
		elseif ($expire_date == 7) 
		{

			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 7 days'));
			$this->db->where('tblkor_medicateProvider.oth_info_end_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		}
		elseif ($expire_date == 30) 
		{

			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 30 days'));
			$this->db->where('tblkor_medicateProvider.oth_info_end_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		}
		else
			$this->db->where('tblkor_medicateProvider.oth_info_end_date <',$today);
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		$count = $query->num_rows();
		return $count;		
	}

	public function get_expired_auth_client($params = array()){
	// echo "<pre>";
	// print_r($params);die;
		$firstname = $params['firstname'];
		$middle_name = $params['middle_name'];
		$lastname = $params['lastname'];
		$agency_id 	= $params['agency_id'];
		$expire_date = $params['expire_date'];	
		$count = $params['count'];
		$limit = $params['limit'];
		$offset = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);


		$this->db->select('tblkor_clients.id as client_id,tblkor_clients.firstname,tblkor_clients.middle_name,tblkor_clients.lastname,tblkor_clients.email,tblkor_medicateProvider.oth_info_start_date,tblkor_medicateProvider.oth_info_end_date');
		$this->db->from('tblkor_clients');
		$this->db->join('tblkor_medicateProvider', 'tblkor_medicateProvider.user_id = tblkor_clients.id');
		$this->db->join('tblclients', 'tblclients.userid = tblkor_clients.userid');
		
		$this->db->where('tblkor_clients.userid',$agency_id);
		if($firstname !='') {
			$this->db->like('tblkor_clients.firstname',$firstname);
		}
		if($middle_name !='') {
			$this->db->like('tblkor_clients.middle_name',$middle_name);
		}
		if($lastname !='') {
			$this->db->like('tblkor_clients.lastname',$lastname);
		}
		if($count==0) {
			$this->db->limit($limit ,$offset);
			// $this->db->order_by('s.start_time' ,'ASC');
		}
		$today = date('Y-m-d');
		if($expire_date == 15) {
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 15 days'));
			$this->db->where('tblkor_medicateProvider.oth_info_end_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		} elseif ($expire_date == 7)  {
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 7 days'));
			$this->db->where('tblkor_medicateProvider.oth_info_end_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		} elseif ($expire_date == 30) {
			$expire_auth_date = date('Y-m-d', strtotime($today. ' + 30 days'));
			$this->db->where('tblkor_medicateProvider.oth_info_end_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		} else {
			$this->db->where('tblkor_medicateProvider.oth_info_end_date <',$today);
		}
		$query = $this->db->get();

		// echo $count = $query->num_rows();die;
		//echo $result;
		// echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}

    // Raj function end here

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
		
		if($client_id!='') {
			$this->db->where('ts.client_id',$client_id);
			$this->db->group_by('ts.user_id');
		}
		if($user_id!='') {
			$this->db->where('ts.user_id',$user_id);
		}
		/*
		if($client_id==''){
			$this->db->group_by('ts.client_id');
		}
		*/
		$this->db->order_by('ts.client_id');
		if($count==0) {
			$this->db->limit($limit ,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();//exit;
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
	public function view_pdf_data($params = array()) {
		$start_date = $params['start_date'];
		$end_date 	= $params['end_date'];
		$agency_id 	= $params['agency_id'];
		$client_id 	= $params['client_id'];
		$user_id 	= $params['user_id'];
		$type 	= $params['type'];
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
	public function check_already_added_schedule($params = array(),$end_date) {
		$start_date = date('Y-m-d',strtotime($params['start_date']));
		$end_date 	= $end_date;
		//$agency_id 	= $params['user_id'];
		$start_time = date('H:i:s', strtotime($params['start_time']));
		// $end_time   = date('H:i:s', strtotime($params['end_time']));s
		$client_id 	= $params['client_id'];
		// $status 	= $params['status'];
		$caregiver_id 	= $params['caregiver_id'];
		$this->db->select('s.*');
		$this->db->from('tblkor_schedule as s');
		//$this->db->where('s.user_id',$agency_id);
		$this->db->where('s.client_id',$client_id);
		$this->db->where('s.start_date',$start_date);
		$this->db->where('s.end_date',$end_date);
		$this->db->where('s.start_time <= "' . $start_time . '"');
		$this->db->where('s.end_time >= "' . $start_time . '"');
		//$this->db->where('s.status',$status);
		$this->db->where('s.caregiver_id',$caregiver_id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	public function get_schedule_list($params = array()) {
		$agency_id 	  = $params['agency_id'];
		$caregiver_id = $params['caregiver_id'];
		$prev_2_month = $params['prev_2_month'];
		$next_2_month = $params['next_2_month'];
		$client_id    = $params['client_id'];
		$this->db->select('s.*,ts.late_check_deff as late_check,ts.checkin_time,ts.checkout_time,ts.checkin_date,ts.checkout_date,ts.late_check_our_diff as let_chekout');
		$this->db->from('tblkor_schedule as s');
		$this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		// $this->db->where('s.start_date',$today);
		$this->db->where('s.user_id',$agency_id);
		if($client_id!='') {
			$this->db->where('s.client_id',$client_id);
		}
		if($caregiver_id!='') {
			$this->db->where('s.caregiver_id',$caregiver_id);
		}
		$this->db->where('s.start_date >=',$prev_2_month);
		$this->db->where('s.start_date <=',$next_2_month);
		$this->db->where('s.active',1);
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
		return $result;
	}
	public function get_claim_data($params = array()) {
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
		
		$this->db->select('distinct (ts.client_id),ts.user_id,tc.claim_status as claim_status,tc.id as claimID,tc.response as response,tc.claimed_amt as claimed_amt,tc.approved_amt as approved_amt,tc.eraid as eraid,tc.created_on as submitedDate,tc.modified_on as updatedDate,tc.client_account as client_account,tc.sender_name as sender_name');
		$this->db->from('tblkortime_sheet as ts');
		$this->db->join('tblclaims as tc','tc.client_id = ts.client_id','left');
		$this->db->where('ts.checkout_date>=',$start_date);
		$this->db->where('ts.checkout_date<=',$end_date);
		$this->db->where('ts.agency_id',$agency_id);
		$this->db->where('ts.status=','1');
		
		if($client_id!='') {
			$this->db->where('ts.client_id',$client_id);
			//$this->db->group_by('ts.user_id');
			$this->db->group_by('ts.client_id');
		}
		if($user_id!='') {
			$this->db->where('ts.user_id',$user_id);
		}
		
		if($client_id=='') {
			$this->db->group_by('ts.client_id');
		}
		
		$this->db->order_by('ts.client_id');
		if($count==0) {
			$this->db->limit($limit ,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
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
	public function getClaimProcessingData($params = array()) {
		$start_date = $params['start_date'];
		$end_date 	= $params['end_date'];
		$agency_id 	= $params['agency_id'];
		$client_id 	= $params['client_id'];
		$this->db->select('ts.*');
		$this->db->from('tblkortime_sheet as ts');
		$this->db->join('tblkor_schedule as s','s.id = ts.schedule_id','left');
		$this->db->where('ts.checkout_date>=',$start_date);
		$this->db->where('ts.checkout_date<=',$end_date);
		$this->db->where('ts.agency_id',$agency_id);
		$this->db->where('ts.client_id',$client_id);
		$this->db->where('ts.status=','1');
		$this->db->order_by('ts.checkout_date');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	public function get_maxIdStatus($params=array()) {
		//print_r($params);
		$status = $params['status'];
		$user_id = $params['user_id'];
		$user_type = $params['user_type'];
		$this->db->select('MAX(ts.id) as Maxid,ts.*');
		$this->db->from('tblkorstatus as ts');
		$this->db->where('ts.status',$status);
		$this->db->where('ts.user_id',$user_id);
		$this->db->where('ts.user_type',$user_type);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row_array();
	}

	/*  @Rakesh 23_Oct_2019 */
	public function caregiver_expired_docs($params = array()){
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
		$this->db->from('tblcontacts as tc');
		$this->db->join('tblkor_documents as doc','doc.user_id = tc.id','left');
		
		// $today = date('Y-m-d');
		// if($expireDocs == 15) {
		// 	$expire_auth_date = date('Y-m-d', strtotime($today. ' + 15 days'));
		// 	$this->db->where('doc.doc_expire_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		// } elseif ($expireDocs == 7) {
		// 	$expire_auth_date = date('Y-m-d', strtotime($today. ' + 7 days'));
		// 	$this->db->where('doc.doc_expire_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		// } elseif ($expireDocs == 30) {
		// 	$expire_auth_date = date('Y-m-d', strtotime($today. ' + 30 days'));
		// 	$this->db->where('doc.doc_expire_date BETWEEN "'. date('Y-m-d', strtotime($today)). '" and "'. date('Y-m-d', strtotime($expire_auth_date)).'"');
		// } else {
		// 	$this->db->where('doc.doc_expire_date <',$today);
		// }

		$this->db->where('doc.doc_expire_date>=',$start_date);
		$this->db->where('doc.doc_expire_date<=',$end_date);
		$this->db->where('doc.user_type',1);
		$this->db->where('tc.userid',$agency_id);

		// $this->db->select('*');
		// $this->db->from('tblkor_documents as doc');
		// $this->db->where('doc.doc_expire_date>=',$start_date);
		// $this->db->where('doc.doc_expire_date<=',$end_date);
		
		if($user_id!=''){
			$this->db->where('doc.user_id',$user_id);
		}
		if($count==0){
			$this->db->limit($limit ,$offset);
			//$this->db->order_by('s.start_time' ,'ASC');
			
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	/*Code Added by Prashant Kumar on 20 nov 2019*/

	public function get_all_appointment($params = array()){
		$caregiver_id = $params['caregiver_id'];
		$latechek     = $params['latechek'];
		$inprocess    = $params['inprocess'];
		$client_id    = $params['client_id'];
		// $today     = $params['date'];
		$agency_id    = $params['agency_id'];
		$count        = $params['count'];
		$limit        = $params['limit'];
		$offset       = isset($params['offset'])?$params['offset']:0;
		unset($params['limit']);
		unset($params['offset']);
		unset($params['count']);
		// $date_arr  = explode("/", $today);
		// $filter_date = $date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1];
		$strat_date   = $params['start_date'];
		$end_date     = $params['end_date'];

		$schedule_id_arr = array();
		$this->db->select('ts.*');
		$this->db->from('tblkortime_sheet as ts');
		$sheet_query = $this->db->get();
		$sheet_array = $sheet_query->result_array();
		foreach ($sheet_array as $sheet_val) {
			array_push($schedule_id_arr, $sheet_val['schedule_id']);
		}
		$this->db->select('s.*');
		$this->db->from('tblkor_schedule as s');
		// $this->db->join('tblkortime_sheet as ts','ts.schedule_id = s.id','left');
		if($strat_date!='') {
			$this->db->where('s.start_date>=',$strat_date);
		}
		if($end_date!='') {
			$this->db->where('s.end_date<=',$end_date);
		}
		$this->db->where('s.user_id',$agency_id);
		// $this->db->where('ts.id', 'IS NULL');
		if(!empty($schedule_id_arr)) {
			$this->db->where_not_in('s.id', $schedule_id_arr);
		}
		// if($latechek!=''){
		// 	$this->db->where('ts.late_check_deff >',7);
		// }
		// if($inprocess!=''){
		// 	$this->db->where('ts.checkin_time!=','');
		// 	$this->db->where('ts.checkout_time','00:00:00');
		// }
		if($client_id!='') {
			$this->db->where('s.client_id',$client_id);
		}
		if($caregiver_id!='') {
			$this->db->where('s.caregiver_id',$caregiver_id);
		}
		if($count==0) {
			$this->db->limit($limit ,$offset);
			$this->db->order_by('s.start_time' ,'ASC');
		}
		$query = $this->db->get();
		//echo $this->db->last_query();//exit;
		if ($query->num_rows() >= 1) {
			if($count==0){
				return $query->result_array();
			}else{
				return $query->num_rows();
			}
		} else {
			return false;
		}		
	}

	public function get_all_miss_app($params = array()){
		$agency_id 	= $params['agency_id'];
		$schedule_id_arr = array();
		$this->db->select('ts.*');
		$this->db->from('tblkortime_sheet as ts');
		$sheet_query = $this->db->get();
		$sheet_array = $sheet_query->result_array();

		if(!empty($sheet_array)) {
			foreach ($sheet_array as $sheet_val) {
				array_push($schedule_id_arr, $sheet_val['schedule_id']);
			}
			$this->db->select('s.*');
			$this->db->from('tblkor_schedule as s');
			
			if($today!='') {
				$this->db->where('s.start_date',$filter_date);
			}
			$this->db->where('s.user_id',$agency_id);
			$this->db->where_not_in('s.id', $schedule_id_arr);
			$query = $this->db->get();

			if ($query->num_rows() >= 1) {
				return $query->num_rows();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/*Code Added by Prashant Kumar on 20 nov 2019*/

	/*Code Added by Prashant Kumar on 22 nov 2019*/

	public function user_expiring_docs($params = array()){
		$user_id    = $params['user_id'];
		$client_id  = $params['client_id'];
		$start_date = $params['start_date'];
		$end_date 	= $params['end_date'];

		$expireDocs = $params['expire_range'];

		$today      = date('Y-m-d');
		$monday     = strtotime("last monday");
		$monday     = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday     = strtotime(date("Y-m-d",$monday)." +6 days");

		$this_week_sd = date("Y-m-d",$monday);
		$this_week_ed = date("Y-m-d",$sunday);

		$month_sd = date('Y-m') . "-" . 01;
		$month_ed = date("Y-m-t", strtotime($today));

		$agency_id 	= $params['agency_id'];
		$count      = $params['count'];
		$limit      = $params['limit'];
		$offset     = isset($params['offset'])?$params['offset']:0;
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
		
		if($user_id!=''){
			$this->db->where('doc.user_id',$user_id);
		}
		if($count==0){
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

	/*Code Added by Prashant Kumar on 22 nov 2019*/

	/*Code Addes by Prashant Kumar on 06 dec 2019*/

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

	/*Code Added by Prashant Kumar on 06 dec 2019*/

	/*Code Added by Prashant Kumar on 13 dec 2019*/

	public function get_all_comp_app($params = array()){
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
		$this->db->where('s.agency_id',$agency_id);
		if($count==0) {
			$this->db->limit($limit ,$offset);
			// $this->db->order_by('s.start_time' ,'ASC');
		}
		$this->db->where('s.checkout_time!=', '00:00:00');
		$query = $this->db->get();
		//echo $this->db->last_query();//exit;
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

	/*Code Added by Prashant Kumar on 13 dec 2019*/

	/*Code Added by Prashant Kumar on 18 dec 2019*/

	public function schedule_status_change($table,$params = array()) {
		$post['active'] = $params['status'];
		$this->db->where('client_id', $params['user_id']);
		$up_query = $this->db->update($table, $post);
		if($up_query) {
			return true;
		} else {
			return false;
		}
	}

	/*Code Added by Prashant Kumar on 18 dec 2019*/

}
