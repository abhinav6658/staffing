<!--Code added by Ruchi Acharya on 17th april 2020-->
		
<div class="dashboard-countBox">
	<h4 class="headingnoborder"><?php echo $breatcumb; ?></h4>
	<div class="formBox">
		<?php echo form_open_multipart('billssole/upload_bills/'. $this->uri->segment(2) . '', array('id' => 'billsupload_form')); ?>
		<div class="row">

			<div class="col-md-6">
				<div class="bills-inline">
					<div class="form-group">
						<label>Vendor Name</label>
						<?php if(!empty($vendor)) { ?>
						<select class="js-example-basic-single pr0 form-control" name="vendor_id" id="vendor_id" >
							<?php 
							//print_r($vendor);
								foreach($vendor as $vendor_data_val) {
								$s = '';
								if($vendor_data_val['guid'] == $_GET['ven']) {
									$s ='selected';
								}
								?>
								<option value="<?php echo $vendor_data_val['guid']; ?>" <?php echo $s; ?> ><?php echo $vendor_data_val['name']; ?></option>
							<?php } ?>
							</select>
							<?php } else { ?>
								<select class="js-example-basic-single pr0 form-control" name="vendor_id" id="vendor_id" >
									<option value="w2">W2 Consultant</option>
								</select>
							<?php } ?>
						<div class="alert alert-danger" id="vendor_id_error" style="display: none;">
							<span>Please Select Vendor Name</span>
						</div>
					</div>
					<div class="form-group">
						<label>Consultant Name</label>
						<select class="js-example-basic-single pr0 form-control" name="consultant_id" id="consultant_id" >
							<?php  
							foreach($consult as $consult_val) {
								$s = '';
								if($consult_val['guid'] == $_GET['con']) {
									$s ='selected';
								}
								?>
								<option value="<?php echo $consult_val['guid']; ?>" <?php echo $s; ?> ><?php echo $consult_val['name']; ?></option>
							<?php } ?>
						</select>
						<div class="alert alert-danger" id="consultant_id_error" style="display: none;">
							<span>Please Enter Consultant Name</span>
						</div>
					</div>
				</div>
			</div>
			<?php foreach ($bills as $bills_value) {
				$start_date = date('m/d/Y', strtotime($bills_value['start_date']));
				$end_date 	= date('m/d/Y', strtotime($bills_value['end_date']));
				$bill_hrs 	= $bills_value['total_hrs'];
				$total_days = $bills_value['total_days'];
				# code...
			} ?>
			<div class="col-md-6">
				<div class="form-group">
					<label>Dates</label>
					<div class="consultant-datePeriod">
						<div class="formto">From</div>
						<input type="text" id="start_date" name="start_date" class="form-control dateicon datepicker" value="<?php echo $start_date; ?>">
						<div class="alert alert-danger" id="start_date_error" style="display: none;">
							<span>Please Enter Dates From</span>
						</div>
						<div class="formto">To</div>
						<input type="text" id="end_date" name="end_date" class="form-control dateicon datepicker" value="<?php echo $end_date; ?>" >
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
							<input type="text" class="form-control" name="total_hrs" id="total_hrs" value="<?php echo $bill_hrs; ?>">
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
			<input type="hidden" id="hidden_total_hrs" value="<?php echo $bill_hrs; ?>">
			<input type="hidden" id="hidden_total_days" name="hidden_total_days" value="<?php echo $total_days; ?>">
		</div>
		<div class="row">
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
		$(document).ready(function(){
		//$("#start_date").attr('readOnly' , 'true');
		//$("#end_date").attr('readOnly' , 'true');		
		});
	/* Code added by Ruchi Acharya*/	
	</script>