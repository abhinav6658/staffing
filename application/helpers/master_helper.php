<?php	 
	function GetMastersByID($ID) {
		$CI =&get_instance();	
		echo $sql ="SELECT * FROM `tblcode_mstr` WHERE `id`=". $ID;
		$query = $CI->db->query($sql);
		$result = $query->result();
		print_r($result);exit;
	} 
	function getPagination($url, $total_rows ) {
		$config = array();
		$config["base_url"] = $url;// base_url() . 'admin/master/setting' . $url_seg;
		$config["total_rows"] = $total_rows; //$this->master_model->record_count_grp_by($para);		
		//print_r($config["total_rows"]);exit;	
		$config["per_page"] = 10;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['full_tag_open'] = '<div><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$config['anchor_class'] = 'follow_link';
		return $config;
	}
	function GetUniqueName($m_type,$name,$inventory_id) {
		$CI =&get_instance();	
		$sql ="SELECT COUNT(`inv_media_id`) as totrec FROM `inventory_media` WHERE `media_type` ='".$m_type."' AND `media_name`='".$name."' AND `inventory_id`='".$inventory_id."'";
		$query = $CI->db->query($sql);
		return $result = $query->result();
		//print($result['totrec']);exit;
	}
	function getCodeName($codeval) {
		$sql = "select code_desc from tblcode_mstr where code_value = '$codeval'";
		return getResults($sql)[0]["code_desc"];	
	}
	function getCodeMasterList($where) {
		$CI =&get_instance();	
		$sql = "SELECT * FROM `tblcode_mstr` WHERE active=1 and $where";
		return getResults($sql);
	}
	function getResults($query) {
		$CI =&get_instance();	
		$query = $CI->db->query($query);
		return $query->result_array();
	}
	function generateControl($hd, $count, $value) {
		$fdata = explode(',',$hd); 
		$title = trim($fdata[0]);
		$type = trim($fdata[1]);
		$reqval ='';
		$onchange = '';
		$functions_list ="";
		if (count($fdata)>2) {
			$attrib = explode("|",trim($fdata[2]));
			//print_r($attrib);
			if ($attrib[0]=="*")
				$reqval = 'required'; 
			if (count($attrib)>1 && $attrib[1]!="")
				$code_arr = getCodeMasterList($attrib[1]);
			if (count($attrib)>2 && $attrib[2]!="") {
				$onchange = "onchange = ". str_replace('~',',',$attrib[2]);
				$functions_list .= str_replace('~',',',$attrib[2]);
			}
		}

		if($count==0)
			$name = 'code_desc'; 
		else
			$name = 'code_desc'.$count;
		$val = "";
		if (!empty($value))
			$val = $value[0][$name]; 
		
		echo "<label for='$name'>$title</label>";
		if ($type == "text")
			echo "<input type='text' class='form-control'  $reqval name='$name' id='$name' placeholder='Enter $title' value='$val'>";
		if ($type == "checkbox") {
			$checked = "";
			if ($val == "1" || $val=="on") $checked = "checked";
			echo "<input type='checkbox' class='checkbox'  $reqval name='$name' id='$name'  value='1' $checked>";
		}
		if ($type == "select") {
			//echo $onchange;	
			echo "<select class='form-control' $reqval name='$name' id='$name' $onchange>";
			if (trim($val)!="") {
				echo "<option value='$val'>". getCodeName($val)."</option>";
			}
			echo "<option value=''>---Select---</option>";
			foreach($code_arr as $r) {
				$sel = "";
				if ($r['code_value']==$val) $sel = "selected";
				echo "<option value='".$r['code_value']."' $sel>".$r['code_desc']."</option>";
			}
			echo "</select>";
		}
		if ($type == "file") {
			if ($val!='') echo "<br><img src='". base_url() ."uploads/master_images/$val' width=100>";
			echo "<input type='file' class='checkbox'  $reqval name='$name' id='$name' value='$val'>";
		}
		if ($type == "textarea")
			echo "<textarea row='5' class='form-control'  $reqval name='$name' id='$name' placeholder='Enter $title'>$val</textarea>";
		echo "<br>";
	}
	
?>