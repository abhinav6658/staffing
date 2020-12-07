<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function getDatas($table, $param = array()) {
        $ci=& get_instance();
        $ci->load->database();
		$query = $ci->db->get_where($table,$param);
		//echo $ci->db->last_query();
		$arr = array();
		if($query->num_rows() > 0) {
           $result = $query->result_array();
		   $arr['result'] = $result;
		   $arr['status'] = true;
       } else {
           $arr['status'] = false;
       }
	   return $arr;
    }
	function state_name($code) {
		$data = getDatas('tblkor_states',array('code'=>$code));
	    return $data['result'][0]['name'];
	}
	function agency_id($id) {
		$data = getDatas('tblclients',array('userid'=>$id));
	    return $data['result'][0];
	}
	function agency_Dtails($agency_id) {
		$data = getDatas('tblclients',array('agency_id'=>$agency_id));
	    return $data['result'][0];
	}
	function schedule_status($id) {
		$data = getDatas('tblkor_schedule',array('id'=>$id));
	    return $data['result'][0]['status'];
	}
	function country_name($id) {
		$data = getDatas('tblcountries',array('country_id'=>$id));
	    return $data['result'][0]['short_name'];
	}
	function caregiver_name($id) {
		$data = getDatas('tblcontacts',array('id'=>$id));
	    return $data['result'][0];
	}
	function client_name($id) {
		$data = getDatas('tblkor_clients',array('id'=>$id));
	    return $data['result'][0];
	}
	function masterName($id='') {
		$data = getDatas('code_mstr',array('code_value'=>$id));
	    return $data['result'][0]['code_desc'];
	}
	function DmasName($id='',$lang='en') {
		$data = getDatas('tblkor_dmas_activity',array('id'=>$id));
	    return $data['result'][0]['activity_'.$lang];
	}
	function service_name($id='') {
		$data = getDatas('tblkor_services',array('id'=>$id));
	    return $data['result'][0]['service_name_en'];
	}
	function ethnicity() {
		$data = array(
			'1'=>'African American',
			'2'=>'Hispanic and Latino',
			'3'=>'Asian',
			'4'=>'White',
			'5'=>'Native Hawaiian and Other Pacific Islander',
			'6'=>'American Indian'
		);
		return $data;
	}
	function services() {
		$data = array(
			'1'=>'Nursing',
			'2'=>'Speech',
			'3'=>'OT',
			'4'=>'PT',
			'5'=>'Other'
		);
		return $data;
	}
	function commu_need() {
		$data = array(
			'1'=>'Speech',
			'2'=>'Hearing Impaired',
			'3'=>'Visually Impaired'
		);
		return $data;
	}
	function schedule() {
		$data = array(
			'1'=>'Beginner',
			'2'=>'Intermediate',
			'3'=>'Expert'
		);
		return $data;
	}
	function payrol_type() {
		$data = array(
			'1'=>'Per Hour',
			'2'=>'Per Day',
			'3'=>'Per Month'
		);
		return $data;
	}
	function emp_role() {
		$data = array(
			'1'=>'PCA - Personal Care Assistant',
			'2'=>'CNA - Certified Nursing Assistant',
			'3'=>'HHA - Home Health Aide',
			'4'=>'CG - CareGiver',
			'5'=>'MGR - Manager / (Admin)',
			'6'=>'Billing and Payroll'
		);
		return $data;
	}
	function doc_type() {
		$data = array(
			'1'=>'Affiliations',
			'2'=>'Certifications',
			'3'=>'Documentations'
		);
		return $data;
	}
	function address_type() {
		$data = array(
			'1'=>'Home',
			'2'=>'Office'
		);
		return $data;
	}
	function relationship() {
		$data = array(
			'1'=>'Son',
			'2'=>'Daughter',
			'3'=>'Grand Son',
			'4'=>'Grand Daughter',
			'5'=>'Father',
			'6'=>'Mother',
			'7'=>'Spouse',
			'8'=>'Sibling',
			'9'=>'Friend',
			'10'=>'Other'
		);
		return $data;
	}
	function marital_status() {
		$data = array(
			'1'=>'Divorced',
			'2'=>'Married',
			'3'=>'Separated',
			'4'=>'Single',
			'5'=>'Unknown',
			'6'=>'Widowed'
		);
		return $data;
	}
	function house_type() {
		$data = array(
			'1'=>'ALF',
			'2'=>'Apartment',
			'3'=>'Live w/Family',
			'4'=>'Nursing Facility',
			'5'=>'Other',
			'6'=>'Own House',
			'7'=>'Rent House',
			'8'=>'Rented Room'
		);
		return $data;
	}
	function days_list() {
		$data = array(
			'2'=>'Mon',
			'3'=>'Tue',
			'4'=>'Wed',
			'5'=>'Thu',
			'6'=>'Fri',
			'7'=>'Sat',
			'1'=>'Sun'
		);
		return $data;
	}
	function app_language() {
		$data = array(
			'en'=>'English',
			'kr'=>'Korean',
			'ch'=>'Chinese'
		);
		return $data;
	}
	function question_list($lang) {
		if($lang == 'kr'){
			//Korean
			$data = array(
				'1'=>"개인의 신체 상태에 변화가 있음을 관찰 했습니까?",
				'2'=>"개인의 감정 상태의 변화를 관찰 했습니까?",
				'3'=>"개인의 일상적인 일상 활동에 변화가 있었습니까?", 
				'4'=>"서비스에 대한 개인의 반응에 대해 관찰 해 보셨습니까?"
			);
		} else if($lang=='ch') {
			//Chinese
			$data = array(
				'1'=>"您是否觀察到個人身體狀況的任何變化？",
				'2'=>"您是否觀察到個人情緒狀況的任何變化？",
				'3'=>"個人的日常活動有沒有變化？", 
				'4'=>"您是否對個人對服務的回應有任何意見？"
			);
		} else {
			//English
			$data = array(
				'1'=>"Did you observe any changes in the individual's physical condition?",
				'2'=>"Did you observe any changes in the individual's emotional condition?",
				'3'=>"Was there any change in the individual's regular daily activities?", 
				'4'=>"Did you have any observations about the individual's response to services?"
			);
		}
		return $data;
	}
	function get_dateTime($date=null,$time=null) {
		$data = date('d F, Y',strtotime($date)).' at '.date('h:i A',strtotime($time));
		return $data;
	}
	function get_totalTime($checkout_date=null,$checkout_time=null,$checkin_date=null,$checkin_time=null,$rate_type=null,$return_hour=null) {
		$end_date 	= date('Y-m-d',strtotime($checkout_date));
		$end_time 	= date('H:i:s',strtotime($checkout_time));
		$start_date = date('Y-m-d',strtotime($checkin_date));
		$start_time = date('H:i:s',strtotime($checkin_time));
		//1 - Per Hour 2 - Per Day 3 - Per Month
		$totalworking = (strtotime($end_date.' '.$end_time)-strtotime($start_date.' '.$start_time))/60;
		//echo $totalworking;exit;
		$hour = $totalworking/60;
		$min = $totalworking%60;
		$sec = $min/60;
		if($hour==0) {
			$hour = '00';
		} else {
			$hour = floor($hour);
			if(strlen($hour)==1) {
				$hour = '0'.$hour;
			}
		}
		if($min==0) {
			$min = '00';
		} else {
			$min = floor($min);
			if(strlen($min)==1) {
				$min = '0'.$min;
			}
		}
		if($sec ==0) {
			$sec = '00';
		} else {
			$sec = floor($sec);
			if(strlen($sec)==1) {
				$sec = '0'.$sec;
			}
		}
		$time = $hour.':'.$min.':'.$sec;
		if($return_hour == 1) {
			$hour = $totalworking/60;
			return $hour;
		} else {
			return $time;
		}
	}
	function getStartAndEndDate($week, $year) {
		$dto = new DateTime();
	    $dto->setISODate($year, $week);
		$ret['start_date'] = $dto->format('Y-m-d');
		$dto->modify('+6 days');
		$ret['end_date'] = $dto->format('Y-m-d');
		return $ret;
	}

	function semifirsttartAndEndDate() {
		$dtosemi = new DateTime();
		$retsemi['start_date'] = $dtosemi->format('Y-m-1');
		// $dtosemi->modify('+14 days');
		$retsemi['end_date'] = $dtosemi->format('Y-m-15');
		$retsemi['end_date1'] = $dtosemi->format('Y-m-16');
	
		return $retsemi;
	}

	function semisecondStartAndEndDate($week, $year) {
		$datesec = new DateTime();
		$datesec->setISODate($year, $week);
		$retsec['start_date'] = $datesec->format('Y-m-16');
		$datesec->modify('last day of this month');
		$retsec['end_date'] =  $datesec->format('Y-m-d');
		
		return $retsec;
	}

	function monthlyStartAndEndDate($week, $year) {
		$dtomonthly = new DateTime();
		$dtomonthly->setISODate($year, $week);
		$retmonthly['start_date'] = $dtomonthly->format('Y-m-1');
		$dtomonthly->modify('last day of this month');
		$retmonthly['end_date'] = $dtomonthly->format('Y-m-d');
		
		return $retmonthly;
	}


	function get_time_min_sec($end_date=null,$end_time=null,$start_date=null,$start_time=null) {
		//$time = ( strtotime($end_time) - strtotime($start_time) )/60;
		$time = (strtotime($end_date.' '.$end_time)-strtotime($start_date.' '.$start_time))/60;
		$hour = $time/60;
		$min = $time%60;
		$sec = $min/60;
		if($hour==0){
			$hour = '00';
		}else{
			$hour = floor($hour);
			if(strlen($hour)==1){
				$hour = '0'.$hour;
			}
		}
		if($min==0){
			$min = '00';
		}else{
			$min = floor($min);
			if(strlen($min)==1){
				$min = '0'.$min;
			}
		}
		if($sec ==0){
			$sec = '00';
		}else{
			$sec = floor($sec);
			if(strlen($sec)==1){
				$sec = '0'.$sec;
			}
		}
		$time = $hour.':'.$min.':'.$sec;
		return $time;
	}
	function get_number_format($str=null) {
		$str = str_replace('(','',$str);
		$str = str_replace(') ','',$str);
		$str = str_replace('-','',$str);
		return $str;
	}
	function get_diff_betw_two_days($recuring_date,$end_date) {
		$date1 = date_create($end_date);
		$date2 = date_create($recuring_date);
		$diff  = date_diff($date1,$date2);
		return $diff->format("%a");
	}
	function AddMin_to_date($date,$time,$Addmin) {
		$time = new DateTime($date.' '.$time);
		$time->add(new DateInterval('PT' . $Addmin . 'M'));
		$stamp = $time->format('Y-m-d H:i:s');
		return $stamp;
	}
	
?>