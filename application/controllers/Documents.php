<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Documents extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('guid_creator_helper');
		//$this->load->library('encryption');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('global_model');
		$this->load->database();
		hooks()->do_action('after_clients_area_init', $this);
		

		// echo "$user_type"; die;
		/**
         * The Clients.php controller methods requires a logged in contact
         */
		if (!is_client_logged_in()) {
			redirect_after_login_to_current_url();
			redirect(site_url('authentication/login'));
		}

		if (is_client_logged_in() && !is_contact_email_verified()) {
			redirect(site_url('verification'));
		}
	}
	public function index() {

		$data['title'] = 'Document List';
		$data['breathcum'] = 'Document List';
		$consult_id = $this->uri->segment(2);
		$data['doc_data'] = $this->global_model->getdata_by_id('panel_consultanttbl', 'consultant_id', $consult_id);
		foreach($data['doc_data'] as $consult_value) { 
			$consult_type_var = $consult_value['consultant_type'];
			$consult_guid = $consult_value['guid'];
		}
		//echo $consult_guid;		
		if($consult_type_var == '1'){
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'1', 'status' => '1', 'order_by' => 'doc_type_id'));	
		} else {
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'2','status' => '1', 'order_by' => 'doc_type_id'));
		}
		$data['mapping_consul_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consult_guid, 'is_current' => 1, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
		
		$v_c_guid = $data['doc_data'][0]['guid'];
		// echo $v_c_guid;
		// echo "<br>";
		// echo $consult_type_var;
		$data['documents'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid, 'order_by' => 'doc_id'));
		$data['doc_type_filter'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid , 'order_by' => 'doc_id'));

		$user_type = $this->session->userdata['user_type'];

		if($user_type=='2')
		{
			
			$this->templated->load('Backend/w2/default_layout', 'contents', 'documents/documents_view', $data);
		}
		else if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/documents_view', $data);
		}
		else if($user_type=='1')
		{	
			$this->templated->load('Backend/sole/default_layout', 'contents', 'documents/documents_view', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/documents_view', $data);
		}
		
	}

	public function delete_document() {
		if($this->input->get('id')){

			$del_data = $this->global_model->get_data('panel_documentstbl', array("doc_id"=>$this->input->get('id'),'order_by' => 'doc_id'));
          
           $path = $del_data[0]['doc_path'];
           $docname = $del_data[0]['doc_name'];

           $com_path = ($path . '/' . $docname);

           unlink($com_path);

            $this->global_model->del_data('panel_documentstbl',array("doc_id"=>$this->input->get('id')));
            $message    = array("1","Successfully Delete");
        }

								if($message[0] == 1) {



			//$this->global_model->del_data('panel_timesheettbl',array("t_id"=>$this->input->get('id')));

									$success_message = 'Records Deleted successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect('document-list/' . $this->uri->segment(3));
									} else {
										$error_message = 'Something Went Wrong';
										$this->session->set_flashdata('error_message',$error_message);  
										redirect('document-list/' . $this->uri->segment(3));
									}
						

	}

	public function delete_misc_document() {
		if($this->input->get('id')){

		$del_data = $this->global_model->get_data('panel_miscdocumentstbl', array("doc_id"=>$this->input->get('id'),'order_by' => 'doc_id'));
          
           $path = $del_data[0]['doc_path'];
           $docname = $del_data[0]['doc_name'];
           $com_path = ($path . '/' . $docname);
           unlink($com_path);

            $this->global_model->del_data('panel_miscdocumentstbl',array("doc_id"=>$this->input->get('id')));
            $message    = array("1","Successfully Delete");
        }

								if($message[0] == 1) {

			//$this->global_model->del_data('panel_timesheettbl',array("t_id"=>$this->input->get('id')));

									$success_message = 'Records Deleted successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect('miscellaneous-uploaded-list/' . $this->uri->segment(3).'/' . $this->uri->segment(4));
									} else {
										$error_message = 'Something Went Wrong';
										$this->session->set_flashdata('error_message',$error_message);  
										redirect('miscellaneous-uploaded-list/' . $this->uri->segment(3).'/' . $this->uri->segment(4));
									}
						

	}

	public function move_misc_document() {

		$uri2 = $this->input->post('uri2'); 
	    $uri3 = $this->input->post('uri3');
		 $id = $this->input->post('id'); 
		 $doc_id = $this->input->post('doc_id');
		$doc_type = $this->input->post('doc_type');

		
		if($id !=''){

			$miscdoc_detail = $this->global_model->get_data('panel_miscdocumentstbl', array("doc_id"=>$id,'order_by' => 'doc_id'));

				// print_r($miscdoc_detail); die;
				

				 $miscdata = array(
							 'vendor_emp_id' => $miscdoc_detail[0]['vendor_emp_id'],
							 'doc_name' => $miscdoc_detail[0]['doc_name'],
							 'doc_temp_name' => $miscdoc_detail[0]['doc_temp_name'],
							 'doc_path' => $miscdoc_detail[0]['doc_path'],
							 'uploaded_by' => $miscdoc_detail[0]['uploaded_by'],
							 'doc_type' => $doc_type,
						);

				 $misc = $this->global_model->insert_data('panel_documentstbl', $miscdata);


				 if($misc){

				 		$this->global_model->del_data('panel_miscdocumentstbl',array("doc_id"=>$id));
				 		
				 		$message    = array("1","Successfully Delete");

				 		if($message[0] == 1) {

			//$this->global_model->del_data('panel_timesheettbl',array("t_id"=>$this->input->get('id')));

									$success_message = 'Records Moved successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect('miscellaneous-uploaded-list/' . $uri2.'/' . $uri3);
									} else {
										$error_message = 'Something Went Wrong.';
										$this->session->set_flashdata('error_message',$error_message);  
										redirect('miscellaneous-uploaded-list/' . $uri2.'/' . $uri3);
									}
							
						} 
            
        }

								
						

	}
	public function delete_document_vendor() {
		if($this->input->get('id')){

			$del_data = $this->global_model->get_data('panel_documentstbl', array("doc_id"=>$this->input->get('id'),'order_by' => 'doc_id'));
          
           $path = $del_data[0]['doc_path'];

           delete_files($path, true , false, 1);
           // unlink($com_path);

            $this->global_model->del_data('panel_documentstbl',array("doc_id"=>$this->input->get('id')));
            $message    = array("1","Successfully Delete");
        }

								if($message[0] == 1) {

			//$this->global_model->del_data('panel_timesheettbl',array("t_id"=>$this->input->get('id')));

									$success_message = 'Records Deleted successfully';
									$this->session->set_flashdata('success_message',$success_message);  
									redirect('doc-list/' . $this->uri->segment(3));
								} else {
									$error_message = 'Something Went Wrong';
									$this->session->set_flashdata('error_message',$error_message);  
									redirect('doc-list/' . $this->uri->segment(3));
								}
						

	}
	public function doc_upload_panel() {
		$data['title'] = 'Document List';
		$data['breathcum'] = 'Document List';
		$consult_id = $this->uri->segment(2);
		$data['doc_data'] = $this->global_model->getdata_by_id('panel_consultanttbl', 'consultant_id', $consult_id);
		foreach($data['doc_data'] as $consult_value) { 
			$consult_type_var = $consult_value['consultant_type']; 
			$consult_guid = $consult_value['guid'];
		}
		//echo $consult_type_var;
		if($consult_type_var == '1'){
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'1', 'status' => '1', 'order_by' => 'doc_type_id'));	
		} else {
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'2', 'status' => '1', 'order_by' => 'doc_type_id'));
		}
		$data['mapping_consul_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consult_guid, 'is_current' => 1, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
		
		$v_c_guid = $data['doc_data'][0]['guid'];
		$data['documents'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid, 'order_by' => 'doc_id'));
		$data['doc_type_filter'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid , 'order_by' => 'doc_id'));

		$user_type = $this->session->userdata['user_type'];

		if($user_type=='2')
		{
			
			$this->templated->load('Backend/w2/default_layout', 'contents', 'documents/documents_view', $data);
		}
		else if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/documents_view', $data);
		}
		else if($user_type=='1')
		{	
			$this->templated->load('Backend/sole/default_layout', 'contents', 'documents/documents_view', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/documents_view', $data);
		}
		
	}

/*Miscellaneous document lists*/
	public function misc_upload_panel() {
		$data['title'] = 'Document List';
		$data['breathcum'] = 'Document List';
		$consult_id = $this->uri->segment(2); 
		$data['doc_data'] = $this->global_model->getdata_by_id('panel_consultanttbl', 'consultant_id', $consult_id);
		foreach($data['doc_data'] as $consult_value) { 
			$consult_type_var = $consult_value['consultant_type']; 
			$consult_guid = $consult_value['guid'];
		}
		//echo $consult_type_var;
		if($consult_type_var == '1'){
			// echo "yes"; die;
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'1', 'status' => '1', 'order_by' => 'doc_type_id'));

			// print_r($data['doc_type']); die;
		} else {
			// echo "no"; die;
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'2', 'status' => '1', 'order_by' => 'doc_type_id'));
		}
		$data['mapping_consul_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consult_guid, 'is_current' => 1, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
		
		$v_c_guid = $data['doc_data'][0]['guid'];
		$data['documents'] = $this->global_model->get_data('panel_miscdocumentstbl', array('vendor_emp_id' => $v_c_guid, 'order_by' => 'doc_id'));
		$data['doc_type_filter'] = $this->global_model->get_data('panel_miscdocumentstbl', array('vendor_emp_id' => $v_c_guid , 'order_by' => 'doc_id'));

		$user_type = $this->session->userdata['user_type'];

		if($user_type=='2')
		{
			
			$this->templated->load('Backend/w2/default_layout', 'contents', 'documents/misc_documents_view', $data);
		}
		else if($user_type=='4')
		{	
			// echo "yes"; die;
			$this->templated->load('Backend/default_layout', 'contents', 'documents/misc_documents_view', $data);
		}
		else if($user_type=='1')
		{	
			$this->templated->load('Backend/sole/default_layout', 'contents', 'documents/misc_documents_view', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/misc_documents_view', $data);
		}
		
	}
	/*Vendor document lists*/
	public function vendor_document_list() {
		$data['title'] = 'Document List';
		$data['breathcum'] = 'Document List';
		$vendor_id = $this->uri->segment(2);
		$data['vendor_data'] = $this->global_model->getdata_by_id('panel_vendortbl', 'vendor_id', $vendor_id);
		$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'4', 'status' => '1', 'order_by' => 'doc_type_id'));
		$v_c_guid = $data['vendor_data'][0]['guid'];
		$data['documents'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid, 'order_by' => 'doc_id'));
		$data['doc_type_filter'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid , 'order_by' => 'doc_id'));

		$user_type = $this->session->userdata['user_type'];
		// echo "abinav"; die;
		if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/vendor_documents_view', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/vendor_documents_view', $data);
		}

		
	}
	public function vendor_document_type_list() {
		$data['title'] = 'Document List';
		$data['breathcum'] = 'Document List';
		$vendor_id = $this->uri->segment(2);
		$data['vendor_data'] = $this->global_model->getdata_by_id('panel_vendortbl', 'vendor_id', $vendor_id);
		$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'4', 'status' => '1', 'order_by' => 'doc_type_id'));
		$v_c_guid = $data['vendor_data'][0]['guid'];
		$data['documents'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid, 'order_by' => 'doc_id'));
		$data['doc_type_filter'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_c_guid , 'order_by' => 'doc_id'));

		$user_type = $this->session->userdata['user_type'];

		if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/vendor_documents_view', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/vendor_documents_view', $data);
		}

		
	}
	public function vendor_document_view() {
		$vendor_id = $this->uri->segment(2);


		// echo $vendor_id; die;
		$data['vendor_data'] = $this->global_model->getdata_by_id('panel_vendortbl', 'vendor_id', $vendor_id);
		$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type' => '4', 'status' => '1', 'order_by' => 'doc_type_id'));

		// echo $user_type = $this->session->userdata['user_type']; die;
		$user_type = $this->session->userdata['user_type'];
		
		if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/add_document', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/add_document', $data);
		}

		
	}
	public function vendor_purchase_list () {
		$data['title'] = 'Document List';
		$data['breathcum'] = 'Document List';
		$vendor_id = $this->uri->segment(2);
		$data['vendor_data'] = $this->global_model->get_data('panel_vendortbl', array('vendor_id' =>$vendor_id, 'order_by' => 'vendor_id'));
		$v_guid = $data['vendor_data'][0]['guid'];
		$data['vendor_mapping_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('vendor_id' => $v_guid, 'is_current' => 1, 'order_by' => 'id'));
		
		$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'4', 'status' => '1', 'order_by' => 'doc_type_id'));
		$data['documents'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $v_guid, 'order_by' => 'doc_id'));
		$map_index = 0;
		$consul_po = array();
		foreach ($data['vendor_mapping_data'] as $mapping_value) {
			$var_vendor_mapping_data = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $mapping_value['consultant_id'], 'doc_type'=> '1', 'status' => '1', 'order_by' => 'doc_id'));
			foreach($var_vendor_mapping_data  as $po_list_value) {
				array_push($consul_po, $po_list_value);
			}
		}
		$data['po_filter'] = $consul_po;
		//print_r($data['po_filter'][0]);
		$user_type = $this->session->userdata['user_type'];

		if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/vendor_purchase_list', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/vendor_purchase_list', $data);
		}
		
	}
	public function purchase_add_document() {
		$data['title'] = 'Document Upload';
		$data['breathcum'] = 'Document Upload';	
		//$data['consultant_data'] = $this->global_model->get_data('panel_consultanttbl', array());
		$vendor_id = $this->uri->segment(2);
		$data['vendor_data'] = $this->global_model->getdata_by_id('panel_vendortbl', 'vendor_id', $vendor_id);
		$v_guid = $data['vendor_data'][0]['guid'];
		//echo $v_guid;
		$data['consult_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('vendor_id' => $v_guid, 'is_current' => 1));
		$consult_arr = array();
		foreach($data['consult_data'] as $consult_data_value){
			$consult_guid = $this->global_model->get_data('panel_consultanttbl', array('guid' => $consult_data_value['consultant_id'], 'order_by' => 'consultant_id'));
			array_push($consult_arr, $consult_guid);
		}
		$data['consultant_data'] = $consult_arr;
		
		$user_type = $this->session->userdata['user_type'];

		if($user_type=='4')
		{	
			$this->templated->load('Backend/default_layout', 'contents', 'documents/vendor_purchase_adddocument', $data);
		}
		else
		{	
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/vendor_purchase_adddocument', $data);
		}
		
	}
	/*vendor document list*/

	public function doc_view() {
		$user_type = $this->session->userdata['user_type'];
		$data['title'] = 'Document Upload';
		$data['breathcum'] = 'Document Upload';
		
		$consult_id = $this->uri->segment(2);
		$data['con_data'] = $this->global_model->getdata_by_id('panel_consultanttbl', 'consultant_id', $consult_id);
		foreach($data['con_data'] as $consult_value) { 
			$consult_type_var = $consult_value['consultant_type']; 
			$consult_guid = $consult_value['guid'];
		}
		if($consult_type_var == '1'){
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'1', 'status' => '1', 'order_by' => 'doc_type_id'));	
		} else {
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'2', 'status' => '1', 'order_by' => 'doc_type_id'));
		}
		$data['mapping_consul_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consult_guid, 'is_current' => 1, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
		
		//$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type' => '1', 'order_by' => 'doc_type_id'));
		
		if($user_type=='2')
		{
			
			$this->templated->load('Backend/w2/default_layout', 'contents', 'documents/add_document', $data);
		}
		else if($user_type=='4')
		{
			
			$this->templated->load('Backend/default_layout', 'contents', 'documents/add_document', $data);
		}
		else if($user_type=='1')
		{
			$this->templated->load('Backend/sole/default_layout', 'contents', 'documents/add_document', $data);
		}
		else
		{
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/add_document', $data);
		}	
		
	}

	public function misc_doc_view() {
		$user_type = $this->session->userdata['user_type'];
		$data['title'] = 'Document Upload';
		$data['breathcum'] = 'Document Upload';
		
		$consult_id = $this->uri->segment(2);
		$data['con_data'] = $this->global_model->getdata_by_id('panel_consultanttbl', 'consultant_id', $consult_id);
		foreach($data['con_data'] as $consult_value) { 
			$consult_type_var = $consult_value['consultant_type']; 
			$consult_guid = $consult_value['guid'];
		}
		if($consult_type_var == '1'){
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'1', 'status' => '1', 'order_by' => 'doc_type_id'));	
		} else {
			$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type'=>'2', 'status' => '1', 'order_by' => 'doc_type_id'));
		}
		$data['mapping_consul_data'] = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' => $consult_guid, 'is_current' => 1, 'limit' => '1', 'order_by' => 'id', 'cond' => 'DESC'));
		
		//$data['doc_type'] = $this->global_model->get_data('panel_doc_typetbl', array('is_user_doc_type' => '1', 'order_by' => 'doc_type_id'));
		
		if($user_type=='2')
		{
			
			$this->templated->load('Backend/w2/default_layout', 'contents', 'documents/add_misc_document', $data);
		}
		else if($user_type=='4')
		{
			
			$this->templated->load('Backend/default_layout', 'contents', 'documents/add_misc_document', $data);
		}
		else if($user_type=='1')
		{
			$this->templated->load('Backend/sole/default_layout', 'contents', 'documents/add_misc_document', $data);
		}
		else
		{
			$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/add_misc_document', $data);
		}	
		
	}
	public function do_upload() {
		//alert("abhinav"); return false;
		if(isset($_POST['submit'])) {
			//echo $this->uri->segment(4); die();
			$guid = GUID();
			$user_id = 'DOC_'.$guid;
			//$dbfile_name = $user_id . '' . $guid;
			//$dbfile_name = $guid;
			// $file_name = $guid;	
			$file_name = $_FILES['file']['name'];		
			if($path == '') {
				if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$user_id)) {
					mkdir($_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$user_id, 0777 , true);
				}
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$user_id;
			} else {
				$config['upload_path'] = $path;
			}
			$config['allowed_types'] = 'pdf|docx|doc|xlsx|csv|xls|jpeg|jpg|png|JPG|JPEG|PNG';
			$config['overwrite'] = false;
			$config['remove_spaces'] = TRUE;
			$config['file_name'] = $file_name;
		//	print_r($_FILES['fileupload']); die();
			
			if(!empty($_FILES['fileupload'])) {
				$_FILES['file']['name']     = $_FILES['fileupload']['name'];
				$_FILES['file']['type']     = $_FILES['fileupload']['type'];
				$_FILES['file']['tmp_name'] = $_FILES['fileupload']['tmp_name'];
				$_FILES['file']['error']    = $_FILES['fileupload']['error'];
				$_FILES['file']['size']     = $_FILES['fileupload']['size'];
				//print_r($_FILES); die();
				//echo $_FILES['file']['name']; die();
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// Upload file to server
				if($this->upload->do_upload('file')) {

					$file_ext = array_filter(explode('.', $_FILES['fileupload']['name']));
					$fileExt = array_pop($file_ext);
					if($fileExt == 'pdf' || $fileExt == 'docx' || $fileExt == 'doc' || $fileExt == 'xlsx' || $fileExt == 'csv' || $fileExt == 'xls' || $fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'png') {

					// Uploaded file data
						$fileData = $this->upload->data();
					//print_r($fileData);exit;
						// print_r($_POST['valid_from']);
						// print_r($_POST['valid_to']);
						if($_POST['valid_from']) {
							$valid_from_dt = date('Y-m-d', strtotime($this->input->post('valid_from')));
						}
						if($_POST['valid_to']) {
								$valid_to_dt = date('Y-m-d', strtotime($this->input->post('valid_to')));
						}
						$uploadData = $fileData['file_name'];
						$data = array(
							'vendor_emp_id' =>  $this->input->post('vendor_emp_id'),
						//'doc_name'		=>	$config['file_name'],
							'doc_name'		=> 	$_FILES['file']['name'],
							'doc_temp_name' =>  $this->input->post('doc_temp_name'),
							'doc_path' 		=>	$config['upload_path'],
							'doc_type'		=>	$this->input->post('doc_type'),
							'valid_from'	=>	$valid_from_dt,
							'valid_to'		=>	$valid_to_dt,
							'uploaded_by'	=> 	$this->session->userdata('email')
						);
						//print_r($data); die();
						$doc = $this->global_model->insert_data('panel_documentstbl', $data); 
					//print_r($data); die();
						if($doc){
							if($this->uri->segment(4) == '4'){
								redirect('doc-list/' . $this->uri->segment(3));
							} else {
								redirect('document-list/' . $this->uri->segment(3));			
							}
						//redirect('document-list/' . $this->uri->segment(3));
						}
					} else {
						if($this->uri->segment(4) == '4'){
							$error_message = 'Something went wrong. Please select valid File Type';
							$this->session->set_flashdata('error_message',$error_message);  
							redirect('doc-list/' . $this->uri->segment(3));
						} else {
							$error_message = 'Something went wrong. Please select valid File Type';
							$this->session->set_flashdata('error_message',$error_message);  
							redirect('document-list/' . $this->uri->segment(3));
						}
					}

				} else {
					echo $this->upload->display_errors();
				}
				$upload = implode(',',$uploadData);
			}
		}
	}

	public function do_upload_misc() {
		//alert("abhinav"); return false;
		if(isset($_POST['submit'])) {
			//echo $this->uri->segment(4); die();
			$guid = GUID();
			$user_id = 'DOC_'.$guid; 
			//$dbfile_name = $user_id . '' . $guid;
			//$dbfile_name = $guid;
			$file_name = $_FILES['file']['name'];

			// echo $file_name; die;
			// $file_name = $guid;			
			if($path == '') {
				if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$user_id)) {
					mkdir($_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$user_id, 0777 , true);
				}
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/staffing_panel/assets/uploads/'.$user_id;
			} else {
				$config['upload_path'] = $path;
			}
			$config['allowed_types'] = 'pdf|docx|doc|xlsx|csv|xls|jpeg|jpg|png|JPG|JPEG|PNG';
			$config['overwrite'] = false;
			$config['remove_spaces'] = TRUE;
			$config['file_name'] = $file_name;
		
			
			if(!empty($_FILES['fileupload']['name']) && count(array_filter($_FILES['fileupload']['name'])) > 0) {

				$count_images = count($_FILES['fileupload']['name']);
				
				//echo $count_images; die;

				for($i=0;$i<$count_images;$i++){

					//echo $i; die;

				$_FILES['file']['name']     = $_FILES['fileupload']['name'][$i];
				$_FILES['file']['type']     = $_FILES['fileupload']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['fileupload']['tmp_name'][$i];
				$_FILES['file']['error']    = $_FILES['fileupload']['error'][$i];
				$_FILES['file']['size']     = $_FILES['fileupload']['size'][$i];
				//print_r($_FILES); die();
				// echo $_FILES['file']['name']; die();
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// Upload file to server
				if($this->upload->do_upload('file')) {

					// echo "yu"; die;

					$file_ext = array_filter(explode('.', $_FILES['fileupload']['name'][$i]));
					$fileExt = array_pop($file_ext);

						$fileData = $this->upload->data();
						
						// $uploadData[$i]['file_name'] = $fileData['file_name']; 
						// $uploadData = $fileData['file_name']; 
						$data = array(
							'vendor_emp_id' =>  $this->input->post('vendor_emp_id'),
							'doc_temp_name' =>  $this->input->post('doc_temp_name'),
						//'doc_name'		=>	$config['file_name'],
							'doc_name'		=> 	$_FILES['file']['name'],
							'doc_path' 		=>	$config['upload_path'],
							'doc_type'		=>	$this->input->post('doc_type'),
							'uploaded_by'	=> 	$this->session->userdata('email')
						);
						
						$doc = $this->global_model->insert_data('panel_miscdocumentstbl', $data); 
					 

					} else {
						echo $this->upload->display_errors();
					}
				}
				if($doc){
							if($this->uri->segment(4) == '4'){
								$success_message = 'Documents Uploaded successfully';
									$this->session->set_flashdata('success_message',$success_message);
								redirect('doc-list/' . $this->uri->segment(3));
							} else {
								$success_message = 'Documents Uploaded successfully';
									$this->session->set_flashdata('success_message',$success_message);
								redirect('miscellaneous-uploaded-list/' . $this->uri->segment(3).'/' . $this->uri->segment(4));			
							}
						//redirect('document-list/' . $this->uri->segment(3));
						}
				 else {
						if($this->uri->segment(4) == '4'){
							$error_message = 'Something went wrong. Please select valid File Type';
							$this->session->set_flashdata('error_message',$error_message);  
							redirect('doc-list/' . $this->uri->segment(3));
						} else {
							$error_message = 'Something went wrong. Please select valid File Type';
							$this->session->set_flashdata('error_message',$error_message);  
							redirect('miscellaneous-uploaded-list/' . $this->uri->segment(3).'/' . $this->uri->segment(4));
						}
					}


					$upload = implode(',',$uploadData);
			}
		}
	}
	public function getDocType() {
		$selected_doctype = $_GET['doc_type_id'];
		$doc_type = $this->global_model->get_data('panel_doc_typetbl', array());
		foreach($doc_type as $doc_typ) {
			if($doc_typ['doc_type_id'] == $selected_doctype){
				$val = $doc_typ['doc_type_code'];
				echo $val;
			}
		}		
	}
	public function getPendingDocument() {
		$data['title'] = 'Consultant pending Docs';
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('consultant-list');
		$post['count'] = 1;
		$config['total_rows'] = $this->global_model->consultant_list($post);
		$config['per_page'] = 100;
		$config['uri_segment'] = 2;
		//$config['attributes'] = array('class' => 'page-item');
		//$config['suffix'] = "?test";
		//$config['reuse_query_string'] = TRUE;
		//$config['use_page_numbers'] = TRUE;

		$this->pagination->initialize($config);
		$page =($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$post['limit'] = $config['per_page'];
		$post['offset'] = $page;
		$post['count'] = 0;
		//$data['con_data'] = $this->global_model->consultant_list($post);
		$data['per_page'] = $config['per_page'];
		$data['segment'] = $page;
		$data['total_rows'] = $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$data['consultant_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());

		$consult_arr = array();
		$con['consults'] = $this->global_model->get_data('panel_consultanttbl', array());
		$con_guid = array();
		foreach ($con['consults'] as $consults_val) {
			array_push($con_guid, $consults_val['guid']);
		}
		
		foreach ($con_guid as $con_guid_val) {
			$data['con_data2'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $con_guid_val, 'order_by' => 'doc_id'));
			
			if($con_guid_val != $data['con_data2'][0]['vendor_emp_id']) {
				if(empty($data['con_data2'][0]['vendor_emp_id'])){
					$dName_array[0] = array(
						'con_matched_guid' => $con_guid_val
					);	
					
					$cid = 1;
					foreach ($dName_array as $dName_array_value) {
						$arr_dcon_guid_val  = $dName_array_value['con_matched_guid'];
						$consult_data = $this->global_model->get_data('panel_consultanttbl', array('guid' => $arr_dcon_guid_val , 'order_by' => 'consultant_id'));

						array_push($consult_arr, $consult_data);
						$cid++;
					}	
				}	
			}
		}
		$data['con_data'] = $consult_arr;
		$mapping_arr = array();
		foreach ($data['con_data'] as $confilt_value){
			//print_r($data['mapping_data']);
			//echo "<br>";
			//echo $confilt_value[0]['guid'];
			$mapping_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' =>  $confilt_value[0]['guid'], 'is_current' => 1, 'order_by' => 'id', 'cond' => 'DESC', 'limit' => '1'));
			array_push($mapping_arr, $mapping_data);		

		}
		$data['mapping_data'] = $mapping_arr;
		//print_r($mapping_arr);

		$this->templated->load('Backend/default_layout', 'contents', 'documents/pending_document_list', $data);
	}
	
	public function getPendingDocumentc2c() {
		$data['title'] = 'Consultant pending Docs';
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('consultant-list');
		$post['count'] = 1;
		$config['total_rows'] = $this->global_model->consultant_list($post);
		$config['per_page'] = 100;
		$config['uri_segment'] = 2;
		//$config['attributes'] = array('class' => 'page-item');
		//$config['suffix'] = "?test";
		//$config['reuse_query_string'] = TRUE;
		//$config['use_page_numbers'] = TRUE;

		$this->pagination->initialize($config);
		$page =($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$post['limit'] = $config['per_page'];
		$post['offset'] = $page;
		$post['count'] = 0;
		//$data['con_data'] = $this->global_model->consultant_list($post);
		$data['per_page'] = $config['per_page'];
		$data['segment'] = $page;
		$data['total_rows'] = $config['total_rows'];
		$data['links'] = $this->pagination->create_links();
		$data['consultant_type'] = $this->global_model->get_data('panel_consultant_typetbl', array());

		$email = $this->session->userdata['email'];

		$all_vendors  = $this->global_model->get_data('panel_vendortbl', array('email'=> $email, 'order_by' => 'vendor_id'));

		 $vendid = $all_vendors[0]['guid'];

		$consult_arr = array();
		
		$con['consults'] = $this->global_model->get_data('panel_consultanttbl', array('vendor_id'=> $vendid, 'order_by' => 'consultant_id'));

		$con_guid = array();
		foreach ($con['consults'] as $consults_val) {
			array_push($con_guid, $consults_val['guid']);
		}
		
		foreach ($con_guid as $con_guid_val) {
			$data['con_data2'] = $this->global_model->get_data('panel_documentstbl', array('vendor_emp_id' => $con_guid_val, 'order_by' => 'doc_id'));
			
			if($con_guid_val != $data['con_data2'][0]['vendor_emp_id']) {
				if(empty($data['con_data2'][0]['vendor_emp_id'])){
					$dName_array[0] = array(
						'con_matched_guid' => $con_guid_val
					);	
					
					$cid = 1;
					foreach ($dName_array as $dName_array_value) {
						$arr_dcon_guid_val  = $dName_array_value['con_matched_guid'];
						$consult_data = $this->global_model->get_data('panel_consultanttbl', array('guid' => $arr_dcon_guid_val , 'order_by' => 'consultant_id'));

						array_push($consult_arr, $consult_data);
						$cid++;
					}	
				}	
			}
		}
		$data['con_data'] = $consult_arr;
		$mapping_arr = array();
		foreach ($data['con_data'] as $confilt_value){
			//print_r($data['mapping_data']);
			//echo "<br>";
			//echo $confilt_value[0]['guid'];
			$mapping_data = $this->global_model->get_data('panel_emp_vendor_mappingtbl', array('consultant_id' =>  $confilt_value[0]['guid'], 'is_current' => 1, 'order_by' => 'id', 'cond' => 'DESC', 'limit' => '1'));
			array_push($mapping_arr, $mapping_data);		

		}
		$data['mapping_data'] = $mapping_arr;
		//print_r($mapping_arr);
		
		$this->templated->load('Backend/c2c/default_layout', 'contents', 'documents/pending_document_list_c2c', $data);
	}
}
