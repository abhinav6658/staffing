<link href="<?php echo base_url('assets/'); ?>css/calendar.css" rel="stylesheet" />
<script src="<?php echo base_url('assets/'); ?>js/calendar.js"></script>

<div class="dashboard-countBox">
	<h4 class="headingnoborder"><?php echo $breatcumb; ?>
		<span class="message-heading">
			<div align="center">
				<?php if($this->session->flashdata('success_message')) { ?>
					<div class="col-md-12 alert alert-success">
						<strong><?php echo $this->session->flashdata('success_message'); ?></strong>
					</div>
				<?php } else if($this->session->flashdata('error_message')) { ?>
					<div class="col-md-12 alert alert-danger">
						<strong><?php echo $this->session->flashdata('error_message'); ?></strong>
					</div>	
				<?php } ?>
			</div>
		</span>
	</h4>
	<div class="formBox">
		<?php echo form_open_multipart('bills/upload_bills', array('id' => 'bills_form')); ?>
		<div class="row">

			<div class="col-md-6">
				<div class="bills-inline">
					<div class="form-group">
						<label>Vendor Name</label>
						<select class="js-example-basic-single pr0 form-control" name="vendor_id" id="vendor_id" >
							<option value="">Select</option>
							<option value="w2">W2 Consultant</option>
							<?php 
							foreach($vendor_data as $vendor_data_val) {
								$s = '';
								if($vendor_data_val['guid'] == $_GET['ven']) {
									$s ='selected';
								}
								?>
								<option value="<?php echo $vendor_data_val['guid']; ?>" <?php echo $s; ?> ><?php echo $vendor_data_val['name']; ?></option>
							<?php } ?>
						</select>
						<div class="alert alert-danger" id="vendor_id_error" style="display: none;">
							<span>Please Select Vendor Name</span>
						</div>
					</div>
					<div class="form-group">
						<label>Consultant Name</label>
						<select class="js-example-basic-single form-control" name="consultant_id" id="consultant_id">
							<option value=""></option>
						</select>
						<!--<select class="js-example-basic-single pr0 form-control" name="consultant_id" id="consultant_id" >
							<option value="">Select</option>
							<?php 
							foreach($consult_data as $consult_data_val) {
								$s = '';
								if($consult_data_val['guid'] == $_GET['con']) {
									$s ='selected';
								}
								?>
								<option value="<?php echo $consult_data_val['guid']; ?>" <?php echo $s; ?> ><?php echo $consult_data_val['name']; ?></option>
							<?php } ?>
						</select>-->
						<div class="alert alert-danger" id="consultant_id_error" style="display: none;">
							<span>Please Enter Consultant Name</span>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Dates</label>
					<div class="consultant-datePeriod">
						<div class="formto">From</div>
						<input type="text" id="start_date" name="start_date" class="form-control dateicon datepicker">
						<div class="alert alert-danger" id="start_date_error" style="display: none;">
							<span>Please Enter Dates From</span>
						</div>
						<div class="formto">To</div>
						<input type="text" id="end_date" name="end_date" class="form-control dateicon datepicker">
						<div class="alert alert-danger" id="end_date_error" style="display: none;">
							<span>Please Enter Dates To</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">	
				<div class="col-md-6">
					<div class="form-group">
						<label>Bill Hours</label>
						<div class="input-group mb-2 mr-sm-2">
							<input type="text" class="form-control" name="total_hrs" id="total_hrs">
							<div class="alert alert-danger" id="total_hrs_error" style="display: none;">
								<span>Please Enter Bill Hours</span>
							</div>
							<div class="input-group-prepend">
								<div class="input-group-text">Hours</div>
							</div>  
						</div>
					</div>
					<div class="match-viewdata clearfix">
						<span class="view-field">Name: <span>Jhon Doe</span></span>
						<span class="view-field">Email: <span>jhon@xyz.com</span></span>
						<span class="view-field">Phone: <span>700.000.1111</span></span>
					</div>
				</div>
			<input type="hidden" id="hidden_total_hrs">
			<input type="hidden" id="hidden_total_days" name="hidden_total_days">
		</div>
		<!-- Code added by Ruchi Acharya -->
		<div class="row">
			<!--<div class="col-md-6">
				<div id="calendar"></div>
			</div>-->
			<div class="col-md-12">
				<div class="form-group files">		
					<label>Upload file</label>
					<input type="file" class="form-control" name="fileupload" id="fileupload">
				</div>
				<div class="alert alert-danger" id="fileupload_error" style="display: none;">
					<span>Please Select a File First</span>
				</div>
				<div class="form-group">
					<input type="submit" value="Upload" class="btn submit-btn" name="submit" id="submit">
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="custome-box cpadding">
	<h2 class="infi-heading">
		<!--<span class="message-heading"><div align="center">
			<?php if($this->session->flashdata('success_message')){ ?>
				<div class="col-md-12 alert alert-success">
					<strong><?php echo $this->session->flashdata('success_message'); ?></strong>
				</div>
			<?php } else if($this->session->flashdata('error_message')) { ?>
				<div class="col-md-12 alert alert-danger">
					<strong><?php echo $this->session->flashdata('error_message'); ?></strong>
				</div>	
				<?php } ?></div>
			</span>-->
		</h2>
		<div class="full-pagetable">
			<div class="table-responsive">
				<table class="table table-striped table-borderless">
					<thead>
						<tr>
							<th>Vendor Name</th>
							<th>Consultant Name</th>
							<th>Date From</th>
							<th>Date To</th>
							<th>Timesheet Hours</th>
							<th>Bill Hours</th>
							<th>Action</th>
							<th>Download</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php 
				//print_r($bills_data);
				echo $timesheet[0]['total_hrs'];
						if(!empty($bills_data)) {
							$modal_id = 1;
							foreach($bills_data as $bills_data_value) {


							 ?>
								<tr>
									<td><?php if($bills_data_value['vendor_name']) { echo $bills_data_value['vendor_name']; } else { echo "W2 Consultant"; } ?></td>
									<td><?php echo $bills_data_value['consult_name'] ?></td>
									<td><?php if($bills_data_value['date_from']) { echo date('m-d-Y', strtotime($bills_data_value['date_from'])); }?></td>
									<td><?php if($bills_data_value['date_to']) { echo date('m-d-Y', strtotime($bills_data_value['date_to'])); } ?></td>
									<td><?php /*if($timesheet[0]['vendor_id'] == $bills_data_value['vendor_id'] && $timesheet[0]['consultant_id'] == $bills_data_value['consultant_id']) {
										echo $timesheet[0]['total_hrs'];
									}*/
									echo $bills_data_value['ts_total_hrs'];
									?></td>
									<td><?php echo $bills_data_value['bill_total_hrs']; ?></td>
									<td><?php 
									//echo $bills_data_value['file_path'];
									/* File view Link */
									$pathinfo = array_filter( explode('/', $bills_data_value['file_path']));
									$file_folder_name = array_pop($pathinfo);

									$fileName = basename($file_folder_name);
									$TfileName = array_filter( explode('FILE_', $fileName));	
									$TempfileName = array_pop($TfileName);
									
									$file_ext = array_filter( explode('.', $bills_data_value['file_name'] ));
									$fileExt = array_pop($file_ext);
									/* File view Link */

									?>
									<ul class="table-actionBtn">
										
										<li><a href="<?=base_url('assets/uploads/'.$file_folder_name .'/' . $TempfileName .'.'. $fileExt)?>" target="_blank" data-toggle="modal" data-target="#billsModal_<?php echo $modal_id; ?>"><img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="View"></a>
										</li>

										<!--<li><a href="#"><img src="<?php echo base_url('assets/'); ?>images/icon/delete.svg" alt="Delete"></a></li>-->

									</ul>
								</td>
								<td><a href="<?=base_url('assets/uploads/'.$file_folder_name .'/' . $TempfileName .'.'. $fileExt)?>" target="_blank">Download File</a></td>
								<td>
										<ul class="table-actionBtn">
											<li>
												 <a style="color: blue;" href="<?php echo base_url('Timesheet/delete_timesheet'); ?>?action=edit&id=<?php echo $bills_data_value['id']; ?>" onclick="return confirm('Are you sure?')"><img src="<?php echo base_url('assets/') ?>images/icon/delete.svg" alt="View"></a>
												 </li>
											<!--
											<li><a href="#"><img src="assets/images/icon/delete.svg" alt="Delete"></a></li>-->
											
											
										</ul>
									</td>
							</tr>
							<?php 
							$modal_id++;
						}
					} else {
						echo "<tr><td>No records found</td></tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
$i = 0;
$fName_array = array();
foreach($bills_data as $bills_data_value) {

	/* File view Link */
	$pathinfo = array_filter( explode('/', $bills_data_value['file_path']));
	$file_folder_name = array_pop($pathinfo);

	$fileName = basename($file_folder_name);
	$TfileName = array_filter( explode('FILE_', $fileName));	
	$TempfileName = array_pop($TfileName);

	$file_ext = array_filter( explode('.', $bills_data_value['file_name'] ));
	$fileExt = array_pop($file_ext);
	/* File view Link */

	$fName_array[$i] = array(
		'file_folder_name' => $file_folder_name,
		'TempfileName'=> $TempfileName,
		'fileExt'		  => $fileExt
	);
	$i++;
	//print_r($fName_array);
	//foreach($dName_array as $doc_full_name) {
		//echo $doc_full_name['docExt'];
}
$mod_id = 1;
	//print_r($fName_array);
foreach ($fName_array as $fName_array_value) {
	$arr_file_folder_name  = $fName_array_value['file_folder_name'];
	$arr_TempfileName = $fName_array_value['TempfileName'];
	$arr_fileExt           = $fName_array_value['fileExt'];

	?>
	<!--pop up bills for document view -->
	<div class="modal fade billsModal-modal-lg" id="billsModal_<?php echo $mod_id; ?>" tabindex="-1" role="dialog" aria-labelledby="billsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="billsModalLabel">Billls View</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php if($arr_fileExt == 'pdf'){ ?>
						<iframe src="<?=base_url('assets/uploads/'.$arr_file_folder_name .'/' . $arr_TempfileName .'.'. $arr_fileExt)?>" style="width:100%; height:500px;" style="overflow: hidden; "frameborder="0" marginheight="0" marginwidth="0"></iframe>

					<?php } else { ?>

						

						<iframe src="https://docs.google.com/viewer?url=<?=base_url('assets/uploads/'.$arr_file_folder_name .'/' . $arr_TempfileName .'.'. $arr_fileExt)?>&embedded=true" style="width:100%; height:500px;" style="overflow: hidden; "frameborder="0" marginheight="0" marginwidth="0"></iframe>

					<?php } ?>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<!--pop up modal for bills view ends here-->
	<?php $mod_id++; } ?>
	<!-- Code added by Ruchi Acharya -->
	<script type="text/javascript">
		jQuery("#vendor_id").keydown(function() {
			jQuery("#vendor_name_error").hide();
		});
		jQuery("#consultant_id").keydown(function() {
			jQuery("#consultant_id_error").hide();
		});
		jQuery("#start_date").keydown(function() {
			jQuery("#start_date_error").hide();
		});
		jQuery("#end_date").keydown(function() {
			jQuery("#end_date_error").hide();
		});
		jQuery("#total_hrs").keydown(function() {
			jQuery("#total_hrs_error").hide();
		});
		jQuery("#fileupload_error").hide();
		jQuery("#submit").click(function(e) { 
			var vendor_id   	= jQuery("#vendor_id").val();
			var consultant_id  	= jQuery("#consultant_id").val();
			var start_date  	= jQuery("#start_date").val();
			var end_date  		= jQuery("#end_date").val();
			var total_hrs  		= jQuery("#total_hrs").val();
			var fileupload   	= jQuery("#fileupload").val();

			if(vendor_id != "" && consultant_id != "" && start_date !="" && end_date != "" && total_hrs != "" && fileupload != "") {
				var hidden_total_hrs = jQuery("#hidden_total_hrs").val();
				//var t_hrs = jQuery("#total_hrs").val();
				//alert(total_hrs);
				if(total_hrs <= hidden_total_hrs) {
				  	//jQuery("#total_hrs").val(hidden_total_hrs);
				  	$('#total_hrs').val($('#hidden_total_hrs').val());
				  	//alert("Please select valid bill hours");
				}

				jQuery("#bills_form").submit();
				//alert("succesfully submitted");
			} else {
				e.preventDefault();
				if(vendor_id  == "") {
					jQuery("#vendor_id_error").show();
				}
				if(consultant_id == "") {
					jQuery("#consultant_id_error").show();
				}
				if(start_date == "") {
					jQuery("#start_date_error").show();
				}
				if(end_date == "") {
					jQuery("#end_date_error").show();
				}
				if(total_hrs == "") {
					jQuery("#total_hrs_error").show();
				}
				if(fileupload == "") {
					jQuery("#fileupload_error").show();
				}
			}
		});
		/* Code added by Ruchi Acharya*/
		$(document).ready(function(){	
		jQuery("#vendor_id").change(function() {
				var filter_sel      = jQuery("#vendor_id").val();
				var consultant_id   = jQuery("#consultant_id").val();
				// if(filter_sel != "" || consultant_id != "") {
				// 	window.location.href = "<?php echo base_url('bills'); ?>?ven="+filter_sel+"&con="+consultant_id;
				// } else {
				// 	window.location.href = "<?php echo base_url('bills'); ?>?ven="+filter_sel+"&con="+consultant_id;
				// }			
				jQuery.ajax({
					url: "<?php echo base_url('Bills/getConsultants');?>",
					type: "GET",
					datatype: 'html',
					data: {
						vendor_id: filter_sel
						//consultant_id: consultant_id
					},
					success: function(response) {
					//alert(response);
					//var x = $.trim(response);
					//alert(response);
					jQuery("#consultant_id").html($.trim(response));									
				}
			});
		});

		jQuery("#consultant_id").change(function() {
			var filter_sel      = jQuery("#vendor_id").val();
			var consultant_id 	= jQuery("#consultant_id").val();
			// if(filter_sel != "" || consultant_id != "") {
			// 	window.location.href = "<?php echo base_url('bills'); ?>?ven="+filter_sel+"&con="+consultant_id;
			// } else {
			// 	window.location.href = "<?php echo base_url('bills'); ?>?ven="+filter_sel+"&con="+consultant_id;
			// }

			jQuery.ajax({
				url: "<?php echo base_url('Bills/getTimesheetHrs');?>",
				type: "GET",
				//datatype: 'json',
				data: {
					vendor_id: filter_sel,
					consultant_id: consultant_id
				},
				success: function(response) {
					var trimmedResponse = $.trim(response);
					// alert(trimmedResponse);
					// die();
					//alert($.trim(response));
					var obj = JSON.parse(trimmedResponse);
					//alert(obj.total_hrs);
					if(trimmedResponse != 0) {
						jQuery("#start_date").val(obj.start_date);
						jQuery("#end_date").val(obj.end_date);
						jQuery("#total_hrs").val(obj.total_hrs);
						jQuery("#hidden_total_hrs").val(obj.total_hrs);
						jQuery("#hidden_total_days").val(obj.total_days);
						//alert(x);
					} else {
						alert("Data not available");
						jQuery("#start_date").val("");
						jQuery("#end_date").val("");
						jQuery("#total_hrs").val("");
						jQuery("#hidden_total_hrs").val("");
						jQuery("#hidden_total_days").val("");
						//alert($.trim(response));		
					}
				}
			});
		
		});
	});

	// function bills_upload() {
		
	// 	var vendor_id      = jQuery("#vendor_id").val();
	// 	var consultant_id = jQuery("#consultant_id").val();

	// 	//var st_date = date.split("/").reverse().join("-");
	// 	var stw_date = jQuery("#start_date").val();
	// 	var st_date=stw_date.getFullYear()+"-"+(stw_date.getMonth()+1)+"-"+stw_date.getDate();
		
	// 	//var st_date = $("#printDate").text(val);
	// 	var en_date = jQuery("#end_date").val();
	// 	//alert(st_date);
	// 	if(consultant_id != "" && vendor_id != "" && st_date != "" && en_date != "") {
	// 		jQuery.ajax({
	// 			url: "<?php echo base_url('Bills/getTimesheetHrs');?>",
	// 			type: "GET",
	// 			data: {
	// 				vendor_id: vendor_id,
	// 				consultant_id: consultant_id
	// 			},
	// 			success: function(response) {
	// 				//jQuery("#TimesheetContent").show();
	// 				//jQuery("#bill_check").val(response);
	// 				alert($.trim(response));
						
	// 				var obj = jQuery.parseJSON(response);
	// 				alert(obj[0].start_date);
	// 				alert(st_date);
					
	// 				if($.trim(response) == 0) {  
	// 					alert("Data not available");
	// 					//alert($.trim(response));
	// 				} else {
	// 					if(obj[0].start_date == st_date && obj[0].end_date == en_date) {
	// 						alert("got my oiutpot");
	// 						jQuery("#TimesheetContent").show();
	// 					}
	// 					alert($.trim(response));
	// 					//jQuery("#TimesheetContent").show();	
	// 				}
	// 			}
	// 		});
	// 	} else {
	// 		alert("Fill the require fields.");
	// 	}
 // 	}

	/* Code added by Ruchi Acharya*/	
	</script>