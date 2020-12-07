<link href="<?php echo base_url('assets/'); ?>css/calendar.css" rel="stylesheet" />
<script src="<?php echo base_url('assets/'); ?>js/calendar.js"></script>
<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $title; ?></h3>
	<div class="formBox">
		<?php echo form_open_multipart('timesheetw2/timesheet_upload_w2/'. $this->uri->segment(2) . '', array('id'=>'ts_form')); ?>
		<div class="infiform-inline">
			<div class="form-group">
				<label>Select Consultant</label>
				<select class="js-example-basic-single pr0 form-control" name="consultant_sel" id="consultant_sel">
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
				<div class="alert alert-danger" id="cosultant_id_error" style="display: none;">
					<span>Please Select Consultant</span>
				</div>
			</div>
			<div class="form-group">
				<label>Select Frequency</label>
				<!--<select class="js-example-basic-single pr0 form-control" name="cosul_frequency" id="cosul_frequency">
					<?php  
					foreach($frequency as $frequency_val) {
						$f = '';
						if($frequency_val['guid'] == $_GET['fre']) {
							$f ='selected';
						}
					}
					?>
					<?php if($frequency_val['consult_frequency'] == '1') { ?>
						<option value="<?php echo $frequency_val['consult_frequency']; ?>" <?php echo $f; ?> ><?php echo "Weekly"; ?></option>
					<?php }else if($frequency_val['consult_frequency'] == '2') { ?>
						<option value="<?php echo $frequency_val['consult_frequency']; ?>" <?php echo $f; ?> ><?php echo "Semi-Monthly"; ?></option>
					<?php }else { ?>
						<option value="<?php echo $frequency_val['consult_frequency']; ?>" <?php echo $f; ?> ><?php echo "Monthly"; }?> </option>
						
				</select>-->
				<input class="form-control" type="hidden" name="cosul_frequency" id="cosul_frequency" value="<?php echo $optn_value; ?>" readonly>
				<input class="form-control" type="text" name="cosul_frequency2" id="cosul_frequency2" value="<?php echo $optn_data; ?>" readonly>
				<div class="alert alert-danger" id="consul_frecy_error" style="display: none;">
					<span>Please Select Frequency</span>
				</div>	
			</div>
			<div class="form-group">
				<label>Select Date</label>
				<div class="consultant-datePeriod">
					<input type="hidden" name="rem_ids" id="remove_ids" value="">
					<!-- <?php 
						foreach($date_data as $date_data_val){
							$start_date = date('m/d/Y', strtotime($date_data_val['start_date']));
							$end_date	= date('m/d/Y', strtotime($date_data_val['end_date']));
						}  ?>
					 -->
					 <input type="text" id="datepicker4" name="start_date" value="<?php echo $s_date; ?>" class="form-control dateicon datepicker">
					<div class="formto">To</div>
					<input type="text" id="datepicker5" name="end_date" value="<?php echo $e_date; ?>" class="form-control dateicon datepicker">

					<input type="hidden" name="start_date_hidden" value="<?php echo $s_date; ?>" id="start_date_hidden">
					<input type="hidden" name="end_date_hidden" value="<?php echo $e_date; ?>" id="end_date_hidden">
				
				</div>
				<div class="alert alert-danger" id="start_date_error" style="display: none;">
					<span>Please Enter Valid Start Date</span>
				</div>
				<div class="alert alert-danger" id="end_date_error" style="display: none;">
					<span>Please Enter Valid End Date</span>
				</div>
			</div>
			<div class="form-group"><!--class="form-group comment-full"-->
				<label>Comment</label>
				<textarea class="form-control" name="comment" id="global_comment" style="resize: none"></textarea>
			</div>
			<div class="match-viewdata clearfix" id="consult_info">
			</div>
		</div>
		
	
	<div class="custome-box cpadding">
		<div class="row">
		<div class="col-md-6">
			<div class="table-responsive" id="timesheet_spec">
				<!-- <table class="table table-striped table-borderless">
					<thead></thead>
					<tbody>
						<tr>
							<td>
								<table>
									<tr>
										<td>
											<input type="hidden" name="dates[]" id="date_1" value="02/20/2020">
											02/20/2020
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<input class="form-control" type="text" name="hours[]" id="Hour_1" value="8">
											</div>
										</td>
									</tr>
								</table>
							</td>
							<td>
								<table>
									<tr>
										<td>
											<input type="hidden" name="dates[]" id="date_1" value="02/20/2020">
											02/20/2020
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<input class="form-control" type="text" name="hours[]" id="Hour_1" value="8">
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table> -->
			</div>	
			<div class="form-group files">		
				<label>Upload file</label>
				<input type="file" class="form-control" name="fileupload" id="fileupload">
				
			</div>
			<div class="alert alert-danger" id="fileupload_error" style="display: none;">
				<span>Please Select a File First</span>
			</div>
			<input type="hidden" name="ts_id" id="ts_id">
			<div class="multiple-btnBox">
				<!--<button class="btn submit-btn" type="button" onclick="form_submission()">Save</button>-->
				<!--<button class="btn submit-btn" type="submit" onclick="form_sub_upload()">Upload</button>-->
				<input type="submit" id="submit" name="submit" class="submit action-button submit-btn" value="Upload"/>
			</div>
				<!--</form>-->
		</div>
		<div class="col-md-6">
			<div id="calendar"></div>
		</div>
		</div>
	</div>
<?php echo form_close(); ?>

</div>
</div>

<script type="text/javascript">
	jQuery("#consultant_sel").keydown(function() {
		jQuery("#cosultant_id_error").hide();
	});
	jQuery("#cosul_frequency").keydown(function() {
		jQuery("#consul_frecy_error").hide();
	});
	jQuery("#datepicker4").keydown(function() {
		jQuery("#start_date_error").hide();
	});
	jQuery("#datepicker5").keydown(function() {
		jQuery("#end_date_error").hide();
	});
	jQuery("#fileupload_error").hide();

	$(document).ready(function () {
		$("#datepicker5").attr("disabled","disabled");
	    //$('#datepicker5').attr('readOnly', 'true');
	    var strt_date = jQuery("#datepicker4").val();
		var end_date  = jQuery("#datepicker5").val();
		if(strt_date != "" && end_date != "") {
			jQuery.ajax({
				url: "<?php echo base_url('TimesheetAjax/monthDays'); ?>",
				type: "GET",
				data: {
					start: strt_date,
					end: end_date,
				},
				success: function(response) {
					// alert(response);
					jQuery("#timesheet_spec").html(response);
				}
			});
		}
	});
	jQuery("#datepicker4").change(function() {

	 	var cosul_frequency = jQuery("#cosul_frequency").val();
		var stdate 			= jQuery("#datepicker4").val();
		var sthidden 		= jQuery("#start_date_hidden").val();
		var endhidden 		= jQuery("#end_date_hidden").val();
		

		var prevdate1 = new Date(stdate);
	    var newdate1 = new Date(prevdate1);
	    newdate1.setDate(newdate1.getDate());
	    
	    var d = ('0' + newdate1.getDate()).slice(-2);
	    var m = ('0' + (newdate1.getMonth() + 1)).slice(-2);
	    var y = newdate1.getFullYear();

	    //var end_datedp5 = m + '/' + d + '/' + y;
	   	var dayName = newdate1.getDay();
	    
		//alert(dayName);
		if(sthidden != '' && endhidden != '' && dayName != '') { 
			if(cosul_frequency == '1') {
				if(dayName == '1') {
					//monday
					var days = 6;
				} else {
					alert("select valid weekday.");
					// jQuery("#datepicker4").val(sthidden);
					// jQuery("#datepicker5").val(endhidden);
					// jQuery("#start_date_hidden").val(sthidden);
		 		// 	jQuery("#end_date_hidden").val(endhidden);
		 			//jQuery("#timesheet_spec").html("");
					
				}
				//var days = 6;
			}else if(cosul_frequency == '2') {
				if(d == '01'){
					var days = 14;
				} else if(d == '16') {
					if(noofdays == '28'){
						var days = 12;
					} else if(noofdays == '29') {
						var days = 13;
					} else if(noofdays == '30') {
						var days = 14;
					} else if(noofdays == '31') {
						var days = 15;
					}
				} else {
					alert("Please select valid start date.");
					// jQuery("#datepicker4").val(sthidden);
					// jQuery("#datepicker5").val(endhidden);
				}
			}else if(cosul_frequency == '3'){
				if(d == "01") {
					if(noofdays == '28'){
						var days = 27;
					} else if(noofdays == '29') {
						var days = 28;
					} else if(noofdays == '30') {
						var days = 29;
					} else if(noofdays == '31') {
						var days = 30;
					}
				} else {
					alert("Please select valid start date.");
					// jQuery("#datepicker4").val(sthidden);
					// jQuery("#datepicker5").val(endhidden);
				}
			} else {
				alert("Invalid Frequency");
			}
			//alert(days);
			if(days){ 
				var prevdate = new Date(sthidden);
			    var newdate = new Date(prevdate);
			    newdate.setDate(newdate.getDate() + days);
			    
			    var d = ('0' + newdate.getDate()).slice(-2);
			    var m = ('0' + (newdate.getMonth() + 1)).slice(-2);
			    var y = newdate.getFullYear();

			    var someFormattedDate = m + '/' + d + '/' + y;
			    $("#datepicker4").val(sthidden);
		    	$("#datepicker5").val(someFormattedDate);
		    	$("#end_date_hidden").val(someFormattedDate);
	
	    	} else {
	    		
	    			$("#datepicker4").val(sthidden);
		    		$("#datepicker5").val(endhidden);
		    		alert("Please enter valid start date");
		    		//$("#start_date_hidden").val(stdate);
		    		//$("#end_date_hidden").val(endhidden);
	    	}
		} else {
			//alert(stdate);

	    		var prevdate = new Date(stdate);
			    var newdate = new Date(prevdate);
			    newdate.setDate(newdate.getDate());
			    
			    var d = ('0' + newdate.getDate()).slice(-2);
			    var m = ('0' + (newdate.getMonth() + 1)).slice(-2);
			    var y = newdate.getFullYear();

			    //var end_datedp5 = m + '/' + d + '/' + y;
			   	var noofdays = new Date(y, m, 0).getDate();
			    //alert(noofdays);
			    var dayName = newdate.getDay();
			    //alert(dayName);
			
			    if(cosul_frequency == '1') {
						//var sel_day = today.getDay();
						if(dayName == '1') {
							//monday
							var days = 6;
						} else {
							jQuery("#datepicker4").val("");
							jQuery("#datepicker5").val("");
							jQuery("#start_date_hidden").val("");
	    		 			jQuery("#end_date_hidden").val("");
	    		 			jQuery("#timesheet_spec").html("");
	    					alert("select valid weekday.");
						}
						//var days = 6;
				}else if(cosul_frequency == '2') {
						if(d == '01'){
							var days = 14;
						} else if(d == '16') {
							if(noofdays == '28'){
								var days = 12;
							} else if(noofdays == '29') {
								var days = 13;
							} else if(noofdays == '30') {
								var days = 14;
							} else if(noofdays == '31') {
								var days = 15;
							}
						} else {
							jQuery("#datepicker4").val("");
							jQuery("#datepicker5").val("");
							jQuery("#start_date_hidden").val("");
	    					jQuery("#end_date_hidden").val("");
	    					jQuery("#timesheet_spec").html("");
	    					alert("Please select valid start date.");
						}
					}else {
						if(d == "01") {
							if(noofdays == '28'){
								var days = 27;
							} else if(noofdays == '29') {
								var days = 28;
							} else if(noofdays == '30') {
								var days = 29;
							} else if(noofdays == '31') {
								var days = 30;
							}
						} else {
							jQuery("#datepicker4").val("");
							jQuery("#datepicker5").val("");
							jQuery("#start_date_hidden").val("");
	    					jQuery("#end_date_hidden").val("");
	    					jQuery("#timesheet_spec").html("");
	    					alert("Please select valid start date.");
							
						}
					}
					//alert(days);
				if(days) {
					var sel_start_date = new Date(stdate);
				    var selnewdate = new Date(sel_start_date);
				    selnewdate.setDate(selnewdate.getDate() + days);
				    
				    var d = ('0' + selnewdate.getDate()).slice(-2);
				    var m = ('0' + (selnewdate.getMonth() + 1)).slice(-2);
				    var y = selnewdate.getFullYear();

				    var end_datedp5 = m + '/' + d + '/' + y;

				    $("#datepicker4").val(stdate);
		    		$("#datepicker5").val(end_datedp5);
		    		$("#start_date_hidden").val(stdate);
		    		$("#end_date_hidden").val(end_datedp5);
	    		} else {
	    			jQuery("#datepicker4").val("");
					jQuery("#datepicker5").val("");
					jQuery("#start_date_hidden").val("");
	    			jQuery("#end_date_hidden").val("");
	    			jQuery("#timesheet_spec").html("");
	    		}

		}


		var strt_date = jQuery("#datepicker4").val();
		var end_date  = jQuery("#datepicker5").val();
		// alert(strt_date);
		// alert(end_date);
		if(strt_date != "" && end_date != "") {
			jQuery.ajax({
				url: "<?php echo base_url('TimesheetAjax/monthDays'); ?>",
				type: "GET",
				data: {
					start: strt_date,
					end: end_date,
				},
				success: function(response) {
					// alert(response);
					jQuery("#timesheet_spec").html(response);
				}
			});
		}
	});
	jQuery("#datepicker5").change(function() {
		var strt_date = jQuery("#datepicker4").val();
		var end_date  = jQuery("#datepicker5").val();
		// alert(strt_date);
		// alert(end_date);
		if(strt_date != "" && end_date != "") {
			jQuery.ajax({
				url: "<?php echo base_url('TimesheetAjax/monthDays'); ?>",
				type: "GET",
				data: {
					start: strt_date,
					end: end_date,
				},
				success: function(response) {
					// alert(response);
					jQuery("#timesheet_spec").html(response);
				}
			});
		}
	});
	jQuery("#cosul_frequency").change(function() {
		var strt_date = jQuery("#datepicker4").val();
		var end_date  = jQuery("#datepicker5").val();
		// alert(strt_date);
		// alert(end_date);
		if(strt_date != "" && end_date != "") {
			jQuery.ajax({
				url: "<?php echo base_url('TimesheetAjax/monthDays'); ?>",
				type: "GET",
				data: {
					start: strt_date,
					end: end_date,
				},
				success: function(response) {
					// alert(response);
					jQuery("#timesheet_spec").html(response);
				}
			});
		}
	});
	jQuery("#submit").click(function(e) { 
		//alert();
		var cosultant_id = jQuery("#consultant_sel").val();
		var consul_frecy = jQuery("#cosul_frequency").val();
		var start_date   = jQuery("#datepicker4").val();
		var end_date     = jQuery("#datepicker5").val();
		var fileupload   = jQuery("#fileupload").val();
			//alert("Fill all the fields.");
			if(cosultant_id != "" && consul_frecy != ""  && start_date != ""  && end_date != ""  && fileupload != "") {
				jQuery("#ts_form").submit();
			} else {
				e.preventDefault();
				if(cosultant_id  == "") {
					jQuery("#cosultant_id_error").show();
				}
				if(consul_frecy == "") {
					jQuery("#consul_frecy_error").show();
				}
				if(start_date == "") {
					jQuery("#start_date_error").show();
				}
				if(end_date == "") {
					jQuery("#end_date_error").show();
				}
				if(fileupload == "") {
					jQuery("#fileupload_error").show();
				}
			}
			
	});
	// function form_submission() {
	// 	var cosultant_id = jQuery("#consultant_sel").val();
	// 	var consul_frecy = jQuery("#cosul_frequency").val();
	// 	var start_date   = jQuery("#datepicker4").val();
	// 	var end_date     = jQuery("#datepicker5").val();
	// 	var glo_comment  = jQuery("#global_comment").val();
	// 	// var tm_hours_val = jQuery("input[name='tm_hours[]']").map(function() {
	// 	// 		return $(this).val();
	// 	// 	}).get();
	// 	var tm_hours_val = jQuery("input[name='hours[]']").map(function() {
	// 			return $(this).val();
	// 		}).get();
	// 	var tm_date_val  = jQuery("input[name='dates[]']").map(function() {
	// 			return $(this).val();
	// 		}).get();
	// 	var total_expended_hours = 0;
	// 	for (var i = tm_hours_val.length - 1; i >= 0; i--) {
	// 		total_expended_hours = parseInt(total_expended_hours) + parseInt(tm_hours_val[i]);
	// 	}
	// 	if(cosultant_id != "" && consul_frecy != "" && start_date != "" && end_date != "") {
	// 		jQuery.ajax({
	// 			url: "<?php echo base_url('TimesheetAjax/tm_hours_save'); ?>",
	// 			type: "GET",
	// 			data: {
	// 				c_id           : cosultant_id,
	// 				c_frecy        : consul_frecy,
	// 				start_date	   : start_date,
	// 				end_date	   : end_date,
	// 				hour_arr       : tm_hours_val,
	// 				date_arr       : tm_date_val,
	// 				total_exd_hour : total_expended_hours,
	// 				glo_comment    : glo_comment,
	// 			},
	// 			success: function(response) {
	// 				//alert(response);
	// 				var obj = jQuery.parseJSON(response);
	// 				//alert(obj.insert_id);
	// 				if(response) {
	// 					jQuery("#ts_id").val(obj.insert_id);
	// 					alert("Successfully Saved");
	// 					//window.location.href = "<?php echo base_url('Timesheet'); ?>";
						
	// 				} else {
	// 					alert("Something went wrong. Please try again.");
	// 				}
	// 				// window.location.href = "<?php //echo base_url('Timesheet'); ?>";
	// 			}
	// 		});
	// 	} else {
	// 		alert("Fill the require fields.");
	// 	}
 // 	}
</script>