<!--Main content box start here -->
<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $breathcum; ?></h3>
	<div class="formBox">
		<?php //echo form_open('add-consultant'); ?>
		<?php echo form_open('Association/vendor_consultant_assoc', array('id'=>'msform')); ?>
			<!-- fieldsets -->
			<fieldset class="formSteps" id="form_fields">
				<div class="infiform-inline">
					<input type="hidden" name="org_id" id="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
					<div class="form-group">
						<label>Client</label>
						<input type="text" name="name" id="client_name" class="form-control" placeholder="Enter name">
						<div class="alert alert-danger" id="client_name_error" style="display: none;">
							<span>Please Enter Consultant Name</span>
						</div>
					</div>
					<div class="form-group">
						<label>Name</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<input type="text" name="name" id="consul_name" class="form-control" placeholder="Enter name">
						<div class="alert alert-danger" id="consul_name_error" style="display: none;">
							<span>Please Enter Consultant Name</span>
						</div>
					</div>
					<div class="form-group">
						<label>Email</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<input type="email" name="email" id="consul_email" class="form-control" placeholder="Enter email">
						<div class="alert alert-danger" id="consul_email_error" style="display: none;">
							<span>Please Enter Consultant Email</span>
						</div>
					</div>
					<div class="form-group">
						<label>Phone</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<input type="phone" name="phone" id="consul_phone" class="form-control" placeholder="Enter phone" >
						<div class="alert alert-danger" id="consul_phone_error" style="display: none;">
							<span>Please Enter Consultant Phone</span>
						</div>
					</div>
					<div class="form-group">
						<!-- <input type="submit" value="Submit" class="btn submit-btn" name="submit"> -->
					</div>
				</div>
				<h3 class="black-headingCommon">Consultant type and vendor</h3>
				<div class="infiform-inline">
					<div class="form-group">
						<label>Consultant Type</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<!-- <input class="form-control" id="myInput" type="text" placeholder="Search..">
						<ul id="myTable">
							<?php foreach($consul_type as $c_type) :?>
								<li><?php echo $c_type['consultant_type_name']; ?></li>
							<?php endforeach;?>
						</ul> -->
						<select class="form-control" id="consultant_type">
							<option value="">Select consultant type</option>
							<?php foreach($consul_type as $c_type) :?>
								<option value="<?php echo $c_type['consultant_type_id']; ?>"><?php echo $c_type['consultant_type_name']; ?></option>
							<?php endforeach;?>
						</select>
						<div class="alert alert-danger" id="consul_tpye_error" style="display: none;">
							<span>Please Select Consultant Type</span>
						</div>
					</div>
					<div class="form-group">
						<label>Select Vendor</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<select class="js-example-basic-single form-control" id="vendor_id">
							<option value=""></option>
						</select>
						<div class="alert alert-danger" id="vendor_error" style="display: none;">
							<span>Please Select Vendor</span>
						</div>
					</div>
					<!-- <div class="form-group">
						<a href="#" class="assign-add-list" data-toggle="modal" data-target="#cosnultvendorModal" ><img src="<?php //echo base_url('assets'); ?>/images/icon/add.svg" alt="Add Icon"></a>
					</div> -->
					<div class="">
						<!-- <a href="#" class="assign-add-list" data-toggle="modal" data-target="#mappingvendorModal"><img src="<?php //echo base_url('assets/'); ?>images/icon/add.svg" alt="Add Icon"></a> -->
					</div>
					<div class="match-viewdata clearfix" id="vend_info">
					</div>
					<!-- <div class="form-group">
						<label>Consultant</label>
						<select class="form-control" name="consultant_list" id="consultant_list">
							<option value="">Select Consultant</option>
							<?php
								foreach ($consultant as $consultant_val) {
							?>
									<option value="<?php echo $consultant_val['guid'];?>"><?php echo $consultant_val['name']; ?></option>
							<?php
								}
							?>
						</select>
						<div class="alert alert-danger" id="consul_error" style="display: none;">
							<span>Please Select Consultant</span>
						</div>
					</div> -->
					<div class="">
						<!-- <a href="#" class="assign-add-list" data-toggle="modal" data-target="#mappingconsultantModal"><img src="<?php //echo base_url('assets/'); ?>images/icon/add.svg" alt="Add Icon"></a> -->
					</div>
					<div class="match-viewdata clearfix" id="consul_info">
					</div>
				</div>
				<!-- <input type="button" id="step_first" name="next" class="next action-button submit-btn" value="Next"/> -->
				<!-- </fieldset>
					<fieldset class="formSteps"> -->
					<!-- <h3 class="black-headingCommon">Assign Vendor</h3>
					<div class="infiform-inline">
						<div class="form-group">
							<label>Select Vendor</label>
							<select class="form-control" id="vendor_id">
								<option value=""></option>
							</select>
							<div class="alert alert-danger" id="vendor_error" style="display: none;">
								<span>Please Select Vendor</span>
							</div>
						</div>
						<div class=""> -->
							<!-- <a href="#" class="assign-add-list" data-toggle="modal" data-target="#mappingvendorModal"><img src="<?php //echo base_url('assets/'); ?>images/icon/add.svg" alt="Add Icon"></a> -->
						<!-- </div>
						<div class="match-viewdata clearfix" id="vend_info">
						</div>
					</div> -->

					<!-- <input type="button" name="previous" class="previous action-button-previous submit-btn" value="Previous"/>
						<input type="button" id="step_two" name="next" class="next action-button submit-btn" value="Next"/> -->
				<!-- </fieldset>
					<fieldset class="formSteps"> -->
						<h3 class="black-headingCommon">Project Details</h3>
						<div class="infiform-inline">
							<div class="form-group">
								<label>Project Name</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<input type="text" id="project_name" name="project_name" class="form-control" placeholder="Type project name">
								<div class="alert alert-danger" id="pro_name_error" style="display: none;">
									<span>Please fill project name</span>
								</div>
							</div>
							<div class="form-group">
								<label>Timsesheet Frequency</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<select name="con_frec" id="con_frec" class="form-control">
									<option value="">Select Frequency</option>
									<?php
									foreach ($conslt_frec as $conslt_frec_val) {
										?>
										<option value="<?php echo $conslt_frec_val['id'];?>"><?php echo $conslt_frec_val['frequency'];?></option>
										<?php
									}
									?>
								</select>
								<div class="alert alert-danger" id="frequency_error" style="display: none;">
									<span>Please select frequency</span>
								</div>
							</div>
							<div class="form-group">
								<label>Start Date</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<input type="text" name="start_date" id="datepicker" class="form-control dateicon datepicker" placeholder="MM DD YYYY">
								<div class="alert alert-danger" id="start_date_error" style="display: none;">
									<span>Please fill start date</span>
								</div>
							</div>
							<div class="form-group">
								<label>End Date</label>
								<input type="text" name="end_Date" id="datepicker1" class="form-control dateicon datepicker" placeholder="MM DD YYYY">
								<div class="alert alert-danger" id="end_date_error" style="display: none;">
									<span>Please fill end date</span>
								</div>
							</div>

							<div class="form-group">
								<label>Role</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<input type="text" id="consultant_role" name="consultant_role" class="form-control" placeholder="Enter your role">
								<div class="alert alert-danger" id="role_error" style="display: none;">
									<span>Please fill role</span>
								</div>
							</div>
							<div class="form-group">
								<label>Project Location</label>
								<input type="text" id="pro_location" name="pro_location" class="form-control" placeholder="Enter project location">
								
							</div>
							<div class="form-group">
								<label>City</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<input type="text" id="pro_city" name="pro_city" class="form-control" placeholder="Enter city">
								<div class="alert alert-danger" id="pro_city_error" style="display: none;">
									<span>Please fill city name</span>
								</div>
							</div>
							<div class="form-group">
								<label>State</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<select name="pro_state" id="pro_state" class="form-control">
									<option value="">Select State</option>
									<?php
									foreach ($states as $states_val) {
										?>
										<option value="<?php echo $states_val['stateCode']; ?>"><?php echo $states_val['stateName']; ?></option>
										<?php
									}
									?>
								</select>
								<!-- <input type="text" id="pro_state" name="pro_state" class="form-control" placeholder="Enter state"> -->
								<div class="alert alert-danger" id="pro_state_error" style="display: none;">
									<span>Please fill state</span>
								</div>
							</div>
							<div class="form-group">
								<label>Recruiter Name</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<input type="text" id="recruiter_name" name="recruiter_name" class="form-control" placeholder="Enter recruiter name">
								<div class="alert alert-danger" id="recuiter_name_error" style="display: none;">
									<span>Please fill recruiter name</span>
								</div>
							</div>
							<div class="form-group">
								<label>Manager Name</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
								<input type="text" id="manager_name" name="manager_name" class="form-control" placeholder="Enter manager name">
								<div class="alert alert-danger" id="man_name_error" style="display: none;">
									<span>Please fill manager name</span>
								</div>
							</div>
							<div class="form-group">
								<label>Remote Work(100%)</label>
								<input type="text" id="remote_work" name="remote_work" class="form-control" placeholder="">
							</div>
						</div>
				<!-- <input type="button" name="previous" class="previous action-button-previous submit-btn" value="Previous"/>
					<input type="button" id="step_three" name="next" class="next action-button submit-btn" value="Next"/> -->
				<!-- </fieldset>
					<fieldset class="formSteps"> -->
						<h3 class="black-headingCommon">Cost setup</h3>
						<div class="infiform-inline">
	            	<!-- <div class="form-group">
						<label>Cost Price</label>
						<select class="form-control" id="consul_type2">
							<option value="">Select consultant type</option>
							<?php foreach($consul_type as $c_type) :?>
								<option value="<?php echo $c_type['consultant_type_id']; ?>"><?php echo $c_type['consultant_type_name']; ?></option>
							<?php endforeach;?>
						</select>
					</div> -->
					<div class="form-group" id="bill_hide">
						<label>Bill Rate</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<div class="three-control">
							<span class="doller">$</span>
							<input type="text" id="cost_price" name="cost_price" class="form-control vendor-control" placeholder="00">
							<select class="form-control vendor-sel" id="bill_rate_basis">
								<?php
								foreach ($rate_type as $rate_type_val) {
									?>
									<option value="<?php echo $rate_type_val['id']; ?>"><?php echo $rate_type_val['cost_type_name']; ?></option>
									<?php
								}
								?>
							</select>
							<div class="alert alert-danger" id="bill_rate_error" style="display: none;">
								<span>Please fill bill rate</span>
							</div>
						</div>
					</div>
					<div class="form-group" id="bill_date_hide">
						<label>Bill Rate Effective Date</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<input type="text" name="bill_effective_date" id="datepicker3" class="form-control dateicon datepicker" placeholder="MM DD YYYY">
						<div class="alert alert-danger" id="bill_effective_date_error" style="display: none;">
							<span>Please fill effective date</span>
						</div>
					</div>
					<div class="form-group">
						<label>Pay Rate</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<div class="three-control">
							<span class="doller">$</span>
							<input type="text" id="sell_price" name="sell_price" class="form-control vendor-control" placeholder="00">
							<select class="form-control vendor-sel" id="pay_rate_basis">
								<?php
								foreach ($rate_type as $rate_type_val) {
									?>
									<option value="<?php echo $rate_type_val['id']; ?>"><?php echo $rate_type_val['cost_type_name']; ?></option>
									<?php
								}
								?>
							</select>
							<div class="alert alert-danger" id="pay_rate_error" style="display: none;">
								<span>Please fill pay rate</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Pay Rate Effective Date</label><span><img class="requiredicon" src="<?php echo base_url('assets/')?>images/icon/required.png" alt="menu icon"></span>
						<input type="text" name="effective_date" id="datepicker2" class="form-control dateicon datepicker" placeholder="MM DD YYYY">
						<div class="alert alert-danger" id="effective_date_error" style="display: none;">
							<span>Please fill effective date</span>
						</div>
					</div>
				</div>
				<!-- <input type="button" name="previous" class="previous action-button-previous submit-btn" value="Previous"/> -->
				<input type="button" name="Review" id="Review" class="next action-button submit-btn" value="Review"/>
				<input type="submit" id="review_submit" name="submit" class="submit action-button submit-btn" value="Submit"/>
			</fieldset>
			<fieldset class="formSteps" id="review_fields" style="display: none;">
				<h3 class="black-headingCommon">Review</h3>
				<div class="row" id="review_data">
					<div class="form-group col-md-3">
						<label><strong>Client</strong></label>
						<p id="r_client"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Consultant Type</strong></label>
						<p id="r_con_type"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Consultant</strong></label>
						<p id="r_consultant"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Vendor</strong></label>
						<p id="r_vendor"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Project Name</strong></label>
						<p id="r_project_name"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Timeshhet Frequency</strong></label>
						<p id="r_time_frequency"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Start Date</strong></label>
						<p id="r_start_date"></p>
					</div>
					<!-- <div class="form-group col-md-3">
						<label><strong>End Date</strong></label>
						<p id="r_end_Date"></p>
					</div> -->
					<div class="form-group col-md-3">
						<label><strong>Role</strong></label>
						<p id="r_role"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Location</strong></label>
						<p id="r_location"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>City</strong></label>
						<p id="r_city"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>State</strong></label>
						<p id="r_state"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Recruiter</strong></label>
						<p id="r_recruiter"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Manager</strong></label>
						<p id="r_manager"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Pay Rate</strong></label>
						<p id="r_pay_rate"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Pay Rate Effective Date</strong></label>
						<p id="r_p_effective_date"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Bill Rate</strong></label>
						<p id="r_bill_rate"></p>
					</div>
					<div class="form-group col-md-3">
						<label><strong>Bill Rate Effective Date</strong></label>
						<p id="r_b_effective_date"></p>
					</div>
				</div>
				<input type="button" name="previous" class="previous action-button-previous submit-btn" value="Previous"/>
				<input type="submit" id="submit" name="submit" class="submit action-button submit-btn" value="Submit"/>
			</fieldset>
			<?php echo form_close(); ?>
		</div>
	</div>
	<!--Main content box end here -->
<script type="text/javascript">
	jQuery("#consultant_type").change(function() {
		jQuery("#consul_tpye_error").hide();
		jQuery("#consul_info").hide();
		var sel_val = jQuery("#consultant_type").val();
		// if(sel_val == 1) {
		// 	jQuery("#bill_hide").hide();
		// 	jQuery("#bill_date_hide").hide();
		// } else {
		// 	jQuery("#bill_hide").show();
		// 	jQuery("#bill_date_hide").show();
		// }
		jQuery.ajax({
			url: "<?php echo base_url('VendorAjax/getVendors');?>",
			type: "GET",
			data: {
				s_val: sel_val,
			},
			success: function(response) {
				// alert(response);
				jQuery("#vendor_id").html(response);
			}
		});
	});

	// jQuery("#consultant_list").change(function() {
	// 	jQuery("#consul_error").hide();
	// 	var consultant_list = jQuery("#consultant_list").val();
	// 	if(consultant_list != "") {
	// 		jQuery.ajax({
	// 			url: "<?php //echo base_url('ConsultantAjax/getConsultantinfo'); ?>",
	// 			type: "GET",
	// 			data: {
	// 				con_val: consultant_list,
	// 			},
	// 			success:function(response) {
	// 				// alert(response);
	// 				if(response != "") {
	// 					jQuery("#consul_info").html(response);
	// 					jQuery("#consul_info").show();
	// 				}
	// 			}
	// 		});
	// 		jQuery.ajax({
	// 			url: "<?php //echo base_url('ConsultantAjax/assignedVendor'); ?>",
	// 			type: "GET",
	// 			data: {
	// 				con_val: consultant_list,
	// 			},
	// 			success:function(response) {
	// 				if(response != "") {
	// 					alert(response);
	// 				}
	// 			}
	// 		});
	// 	} else {
	// 		jQuery("#consul_info").hide();
	// 	}
	// });

	jQuery("#vendor_id").change(function() {
		jQuery("#vendor_error").hide();
		var vend_id = jQuery("#vendor_id").val();
		if(vend_id != "") {
			jQuery.ajax({
				url: "<?php echo base_url('VendorAjax/getVendortInfo'); ?>",
				type: "GET",
				data: {
					ven_val: vend_id,
				},
				success:function(response) {
					// alert(response);
					if(response != "") {
						jQuery("#vend_info").html(response);
						jQuery("#vend_info").show();
					}
				}
			});
		} else {
			jQuery("#vend_info").hide();
		}
	});

	jQuery("#consul_name").keydown(function() {
		jQuery("#consul_name_error").hide();
	});
	jQuery("#consul_email").keydown(function() {
		jQuery("#consul_email_error").hide();
	});
	jQuery("#consul_phone").keydown(function() {
		jQuery("#consul_phone_error").hide();
	});
	jQuery("#project_name").keydown(function() {
		jQuery("#pro_name_error").hide();
	});
	jQuery("#datepicker").click(function() {
		jQuery("#start_date_error").hide();
	});
	// jQuery("#datepicker1").click(function() {
	// 	jQuery("#end_date_error").hide();
	// });
	jQuery("#consultant_role").keydown(function() {
		jQuery("#role_error").hide();
	});
	// jQuery("#pro_location").keydown(function() {
	// 	jQuery("#pro_loc_error").hide();
	// });
	jQuery("#con_frec").click(function() {
		jQuery("#frequency_error").hide();
	});
	jQuery("#pro_city").keydown(function() {
		jQuery("#pro_city_error").hide();
	});
	jQuery("#pro_state").click(function() {
		jQuery("#pro_state_error").hide();
	});
	jQuery("#recruiter_name").keydown(function() {
		jQuery("#recuiter_name_error").hide();
	});
	jQuery("#manager_name").keydown(function() {
		jQuery("#man_name_error").hide();
	});

	jQuery("#cost_price").keydown(function() {
		jQuery("#bill_rate_error").hide();
	});
	jQuery("#sell_price").keydown(function() {
		jQuery("#pay_rate_error").hide();
	});
	jQuery("#datepicker2").click(function() {
		jQuery("#effective_date_error").hide();
	});
	jQuery("#datepicker3").click(function() {
		jQuery("#bill_effective_date_error").hide();
	});

	jQuery(".submit").click(function(e) {
		e.preventDefault();
		var client         = jQuery("#client_name").val();
		var organisation   = jQuery("#org_id").val();
		var consult_name   = jQuery("#consul_name").val();
		var consult_email  = jQuery("#consul_email").val();
		var consult_phone  = jQuery("#consul_phone").val();
		var c_type         = jQuery("#consultant_type").val();
		// var consult        = jQuery("#consultant_list").val();
		var vend           = jQuery("#vendor_id").val();
		var pro_name       = jQuery("#project_name").val();
		var con_frqc       = jQuery("#con_frec").val();
		var srt_date       = jQuery("#datepicker").val();
		var end_date       = jQuery("#datepicker1").val();
		var emp_role       = jQuery("#consultant_role").val();
		var pro_locn       = jQuery("#pro_location").val();
		var pro_city       = jQuery("#pro_city").val();
		var pro_stat       = jQuery("#pro_state").val();
		var rec_name       = jQuery("#recruiter_name").val();
		var man_name       = jQuery("#manager_name").val();
		// var c_type_2 = jQuery("#consul_type2").val();
		var cost_prc       = jQuery("#cost_price").val();
		var bill_eff       = jQuery("#datepicker3").val();
		var sell_prc       = jQuery("#sell_price").val();
		var eff_date       = jQuery("#datepicker2").val();
		var bill_rate_type = jQuery("#bill_rate_basis").val();
		var pay_rate_type  = jQuery("#pay_rate_basis").val();

		if(c_type != "" && vend != "" && pro_name != "" && con_frqc != "" && srt_date != "" && emp_role != "" && pro_city != "" && pro_stat != "" && rec_name != "" && man_name != ""  && sell_prc != "" && cost_prc != "" && bill_eff != "" && eff_date != "") {

			jQuery.ajax({
				url: "<?php echo base_url('Mappingajax/save_mapping_data'); ?>",
				type: "GET",
				data: {
					client: client,
					orgn_id: organisation,
					con_name: consult_name,
					con_email: consult_email,
					con_phone: consult_phone, 
					con_type: c_type,
					// con: consult,
					ven: vend,
					project: pro_name,
					frec_con: con_frqc,
					start: srt_date,
					end: end_date,
					role: emp_role,
					location: pro_locn,
					city: pro_city,
					state: pro_stat,
					recruiter: rec_name,
					manager: man_name,
					cost: cost_prc,
					sell: sell_prc,
					pay_effective: eff_date,
					bill_effective: bill_eff,
					cost_rate_tp: pay_rate_type,
					bill_rate_tp: bill_rate_type,
				},
				success: function(response) {
					// alert(response);
					if(response == 1) {
						//window.location.href = "<?php echo base_url('consultant-list'); ?>";
						window.location.href = document.referrer;
					} else if(response == 0) {
						// jQuery("#consul_email_error").show();
						// jQuery("#consul_email_error span").html("User exist for same email address.");
						alert("Consultant exist for same email address.");
					}
				}
			});
		} else {
			e.preventDefault();
			// alert("Fill all the fields.");
			if(consult_name  == "") {
				jQuery("#consul_name_error").show();
			}
			if(consult_email == "") {
				jQuery("#consul_email_error").show();
			}
			if(consult_phone == "") {
				jQuery("#consul_phone_error").show();
			}
			if(c_type == "") {
				jQuery("#consul_tpye_error").show();
			}
			// if(consult == "") {
			// 	jQuery("#consul_error").show();
			// }
			if(vend == "") {
				jQuery("#vendor_error").show();
			}
			if(pro_name == "") {
				jQuery("#pro_name_error").show();
			}
			if(con_frqc == "") {
				jQuery("#frequency_error").show();
			}
			if(srt_date == "") {
				jQuery("#start_date_error").show();
			}
			// if(end_date == "") {
			// 	jQuery("#end_date_error").show();
			// }
			if(emp_role == "") {
				jQuery("#role_error").show();
			}
			// if(pro_locn == "") {
			// 	jQuery("#pro_loc_error").show();
			// }
			if(pro_city == "") {
				jQuery("#pro_city_error").show();
			}
			if(pro_stat == "") {
				jQuery("#pro_state_error").show();
			}
			if(rec_name == "") {
				jQuery("#recuiter_name_error").show();
			}
			if(man_name == "") {
				jQuery("#man_name_error").show();
			}
			if(cost_prc == "") {
				jQuery("#bill_rate_error").show();
			}
			if(sell_prc == "") {
				jQuery("#pay_rate_error").show();
			}
			if(eff_date == "") {
				jQuery("#effective_date_error").show();
			}
			if (bill_eff == "") {
				jQuery("#bill_effective_date_error").show();
			}
		}
	});
jQuery("#Review").click(function() {
	var client         = jQuery("#client_name").val();
	var consult_name   = jQuery("#consul_name").val();
	var consult_email  = jQuery("#consul_email").val();
	var consult_phone  = jQuery("#consul_phone").val();
	var c_type         = jQuery("#consultant_type").val();
	// var consult        = jQuery("#consultant_list").val();
	var vend           = jQuery("#vendor_id").val();
	var pro_name       = jQuery("#project_name").val();
	var con_frqc       = jQuery("#con_frec").val();
	var srt_date       = jQuery("#datepicker").val();
	var end_date       = jQuery("#datepicker1").val();
	var emp_role       = jQuery("#consultant_role").val();
	var pro_locn       = jQuery("#pro_location").val();
	var pro_city       = jQuery("#pro_city").val();
	var pro_stat       = jQuery("#pro_state").val();
	var rec_name       = jQuery("#recruiter_name").val();
	var man_name       = jQuery("#manager_name").val();
	// var c_type_2 = jQuery("#consul_type2").val();
	var cost_prc       = jQuery("#cost_price").val();
	var bill_eff       = jQuery("#datepicker3").val();
	var sell_prc       = jQuery("#sell_price").val();
	var eff_date       = jQuery("#datepicker2").val();

	if(c_type != "" && vend != "" && pro_name != "" && con_frqc != "" && srt_date != "" && emp_role != "" && pro_city != "" && pro_stat != "" && rec_name != "" && man_name != "" && sell_prc != "" && cost_prc != "" && bill_eff != "" && eff_date != "") {

		jQuery("#form_fields").hide();
		jQuery("#review_fields").show();

		// jQuery.ajax({
		// 	url: "<?php //echo base_url('ConsultantAjax/r_consultant'); ?>",
		// 	type: "GET",
		// 	data: {
		// 		r_guid: consult,
		// 	},
		// 	success: function(response) {
		// 		jQuery("#r_consultant").html(response);
		// 	}
		// });

		jQuery.ajax({
			url: "<?php echo base_url('VendorAjax/review_vendors'); ?>",
			type: "GET",
			data: {
				r_v_guid: vend,
			},
			success: function(response) {
				// alert(response);
				jQuery("#r_vendor").html(response);
			}
		});

		jQuery.ajax({
			url: "<?php echo base_url('ConsultantAjax/consul_type'); ?>",
			type: "GET",
			data: {
				consult_type: c_type,
			},
			success: function(response) {
				jQuery("#r_con_type").html(response);
			}
		});

		jQuery.ajax({
			url: "<?php echo base_url('VendorAjax/consul_state'); ?>",
			type: "GET",
			data: {
				con_state: pro_stat,
			},
			success: function(response) {
				jQuery("#r_state").html(response);
			}
		});

		jQuery.ajax({
			url: "<?php echo base_url('ConsultantAjax/consul_freq'); ?>",
			type: "GET",
			data: {
				con_freq: con_frqc,
			},
			success: function(response) {
				jQuery("#r_time_frequency").html(response);
			}
		});

		jQuery('#r_client').html(client);
		jQuery('#r_consultant').html(consult_name);
		jQuery("#r_project_name").html(pro_name);
		jQuery("#r_start_date").html(srt_date);
		// jQuery("#r_end_Date").html(end_date);
		jQuery("#r_role").html(emp_role);
		jQuery("#r_location").html(pro_locn);
		jQuery("#r_city").html(pro_city);
		// jQuery("#r_state").html(pro_stat);	
		jQuery("#r_recruiter").html(rec_name);
		jQuery("#r_manager").html(man_name);
		jQuery("#r_pay_rate").html(sell_prc);
		jQuery("#r_bill_rate").html(cost_prc);
		jQuery("#r_p_effective_date").html(eff_date);
		jQuery("#r_b_effective_date").html(bill_eff);
	} else {
		if(consult_name  == "") {
			jQuery("#consul_name_error").show();
		}
		if(consult_email == "") {
			jQuery("#consul_email_error").show();
		}
		if(consult_phone == "") {
			jQuery("#consul_phone_error").show();
		}
		if(c_type == "") {
			jQuery("#consul_tpye_error").show();
		}
		// if(consult == "") {
		// 	jQuery("#consul_error").show();
		// }
		if(vend == "") {
			jQuery("#vendor_error").show();
		}
		if(pro_name == "") {
			jQuery("#pro_name_error").show();
		}
		if(con_frqc == "") {
			jQuery("#frequency_error").show();
		}
		if(srt_date == "") {
			jQuery("#start_date_error").show();
		}
		// if(end_date == "") {
		// 	jQuery("#end_date_error").show();
		// }
		if(emp_role == "") {
			jQuery("#role_error").show();
		}
		if(pro_locn == "") {
			jQuery("#pro_loc_error").show();
		}
		if(pro_city == "") {
			jQuery("#pro_city_error").show();
		}
		if(pro_stat == "") {
			jQuery("#pro_state_error").show();
		}
		if(rec_name == "") {
			jQuery("#recuiter_name_error").show();
		}
		if(man_name == "") {
			jQuery("#man_name_error").show();
		}
		if(cost_prc == "") {
			jQuery("#bill_rate_error").show();
		}
		if(sell_prc == "") {
			jQuery("#pay_rate_error").show();
		}
		if(eff_date == "") {
			jQuery("#effective_date_error").show();
		}
		if (bill_eff == "") {
			jQuery("#bill_effective_date_error").show();
		}
	}
});
jQuery(".previous").click(function() {
	jQuery("#form_fields").show();
	jQuery("#review_fields").hide();
});
	// $(document).ready(function() {
	// 	$("#myInput").on("keyup", function() {
	// 		var value = $(this).val().toLowerCase();
	// 		$("#myTable").filter(function() {
	// 			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	// 		});
	// 	});
	// });
</script>