<!--Main content box start here -->
<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $breathcum; ?></h3>
	<div class="formBox">
		<?php //echo form_open('add-consultant'); ?>
		<!--<form class="infiform-inline" method="post" action="add-consultant">-->
		<!-- fieldsets -->
			<fieldset class="formSteps" id="form_fields">
				<div class="infiform-inline">
					<div class="form-group">
						<label class="label-headingCommon">Client Name</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['client']?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Name</label>
						<div class="labdis-divCommon"><?php echo $con_data[0]['name']?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Email</label>
						<div class="labdis-divCommon"><?php echo $con_data[0]['email']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Phone</label>
						<div class="labdis-divCommon"><?php echo $con_data[0]['phone'];?></div>
					</div>
				</div>
				<h3 class="black-headingCommon">Consultant type and vendor</h3>
				<div class="infiform-inline">
					<div class="form-group">
						<label class="label-headingCommon">Consultant Type</label>
						<div class="labdis-divCommon">
							<?php foreach($consul_type as $c_type) :?>
								<?php if($mapping_data['consultant_type'] == $c_type['consultant_type_id']) {  echo $c_type['consultant_type_name']; } ?>
							<?php endforeach;?>
						</div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Selected Vendor</label>
						<div class="labdis-divCommon">
							<?php if($mapping_data['consultant_type'] == 2) { 
									foreach ($vendors as $vendors_value) {
										if($mapping_data['vendor_id'] == $vendors_value['guid']) {
											 echo $vendors_value['name'];
										}
									}
								} elseif ($mapping_data['consultant_type'] == 1) {
									echo "W2";
								}
							?>
						</div>
					</div>
				</div>	
				<h3 class="black-headingCommon">Project Details</h3>
				<div class="infiform-inline">
					<div class="form-group">
						<label class="label-headingCommon">Project Name</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['project_name']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Timsesheet Frequency</label>
						<div class="labdis-divCommon">
							<?php foreach ($conslt_frec as $conslt_frec_val) {
								if($mapping_data['consult_frequency'] == $conslt_frec_val['id']) { echo $conslt_frec_val['frequency'];
								}
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Start Date</label>
						<div class="labdis-divCommon"><?php echo date('m/d/Y', strtotime($mapping_data['start_date'])); ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">End Date</label>
						<div class="labdis-divCommon"><?php if($mapping_data['end_date'] != "0000-00-00") { echo date('m/d/Y', strtotime($mapping_data['end_date'])); } ?></div>
					</div>

					<div class="form-group">
						<label class="label-headingCommon">Role</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['role']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Project Location</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['project_location']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">City</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['city']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">State</label>
						<div class="labdis-divCommon">
							<?php foreach ($states as $states_val) {
									if ($mapping_data['state']==$states_val['stateCode']) {  echo $states_val['stateName']; 
									}
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Recruiter Name</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['recruiter_name']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Manager Name</label>
						<div class="labdis-divCommon"><?php echo $mapping_data['manager_name']; ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Remote Work(100%)</label>
						<div class="labdis-divCommon">&nbsp;</div>
					</div>
				</div>
				<h3 class="black-headingCommon">Cost setup</h3>
	            <div class="infiform-inline">
					<div class="form-group">
						<label class="label-headingCommon">Bill Rate</label>
						<div class="three-control">
							<span class="doller">$</span>
							<div class="labdis-divCommon"><?php echo $mapping_data['cost'];?>
								<?php foreach ($rate_type as $rate_type_val) {
									if($mapping_data['cost_rate_type'] == $rate_type_val['id']) { echo $rate_type_val['cost_type_name']; 
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Bill Rate Effective Date</label>
						<div class="labdis-divCommon"><?php echo date("m/d/Y", strtotime($mapping_data['cost_effective_date'])); ?></div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Pay Rate</label>
						<div class="three-control">
							<span class="doller">$</span>
							<div class="labdis-divCommon"><?php echo $mapping_data['sell'];?>
								<?php foreach ($rate_type as $rate_type_val) {
									if($mapping_data['sell_rate_type'] == $rate_type_val['id']) { echo $rate_type_val['cost_type_name']; 
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="label-headingCommon">Pay Rate Effective Date</label>
						<div class="labdis-divCommon"><?php echo date('m/d/Y', strtotime($mapping_data['sell_effective_date'])); ?></div>
					</div>
	            </div><a href="<?php echo base_url('consultant-list'); ?>">
	            <input type="button" name="submit" class="submit action-button submit-btn" value="Back"/></a>
        	</fieldset>
	        
			<!-- </form> -->
	</div>
</div>
<!--Main content box end here -->
