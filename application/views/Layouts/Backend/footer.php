<!--pop up modal for consultant add view -->
<div class="modal fade consultantModal-modal-lg" id="consultantModal" tabindex="-1" role="dialog" aria-labelledby="consultantModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="consultant">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="consultantModalLabel">Add Consultant</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="dashboard-countBox">
					<div class="formBox">
						<?php echo form_open('add-consultant'); ?>
						<!--<form class="infiform-inline" method="post" action="add-consultant">-->
						<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="form-control" placeholder="Type your name" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
						</div>
						<div class="form-group">
							<input type="submit" value="Submit" class="btn submit-btn" name="submit">
						</div>
						
						<!--</form>-->
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>
<!--pop up modal for consultant add view ends here-->
<!--pop up modal for consultant modify view -->
<?php
if(!empty($con_data)){
	//print_r($con_data);
	foreach($con_data as $consult_value){
		//echo $consult_value['name'];		
	?>	
	<div class="modal fade consultantModal-modal-lg" id="consultantModal_<?php echo $consult_value['consultant_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="consultantModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="consultant">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="consultantModalLabel">Update Consultant</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="dashboard-countBox">
						<div class="formBox">
							<?php echo form_open('consultant-display'); ?>
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="name" class="form-control" placeholder="Type your name" value="<?php echo  $consult_value['name']; ?>" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $consult_value['email']; ?>" required>
								</div>
								<div class="form-group">
									<label>Phone</label>
									<input type="text" name="phone" class="form-control" placeholder="Enter phone" value="<?php echo $consult_value['phone']; ?>" maxlength="14" required>
								</div>
								<input type="hidden"  name="consultant_id" value="<?php echo $consult_value['consultant_id']; ?>">
								<div class="form-group btnbox">
									<input type="submit" value="Update" class="btn submit-btn" name="submit">
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>							
				</div>
				<div class="modal-footer">

				</div>
			</div>
		</div>
	</div>
	<?php 
	}
}
?>
<!--pop up modal for consultant modify view ends here-->
<!--new consultant modify view-->
<?php
if(!empty($con_data)) {
	//print_r($con_data);
	foreach($con_data as $consult_value) {
		//echo $consult_value['name'];		
	?>	
	<div class="modal fade consultantModal-modal-lg" id="consultantModal_<?php echo $consult_value[0]['consultant_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="consultantModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="consultant">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="consultantModalLabel">Update Consultant</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="dashboard-countBox">
						<div class="formBox">
							<?php //echo $this->uri->segment(2); 
								//$consult_id = $consult_value[0]['consultant_id']; //die();
							?>
							<?php echo form_open('consultants/edit_consultant/'. $this->uri->segment(2) . '') ?>
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="name" class="form-control" placeholder="Type your name" value="<?php echo  $consult_value[0]['name']; ?>" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $consult_value[0]['email']; ?>" required>
								</div>
								<div class="form-group">
									<label>Phone</label>
									<input type="text" name="phone" class="form-control" placeholder="Enter phone" value="<?php echo $consult_value[0]['phone']; ?>" maxlength="14" required>
								</div>
								<input type="hidden"  name="consultant_id" value="<?php echo $consult_value[0]['consultant_id']; ?>">
								<div class="form-group btnbox">
									<input type="submit" value="Update" class="btn submit-btn" name="submit">
								</div>
							<?php echo form_close(); ?>
							
						</div>
					</div>							
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<?php 
	}
}
?>
<!--pop up modal for new consultant modify view ends here-->


<!--pop up modal for vendor add view -->
<div class="modal fade vendorModal-modal-lg" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="consultant">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="vendorModalLabel">Add Vendor</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="dashboard-countBox">
				<div class="formBox">
					<?php echo form_open('vendors/add_vendor'); ?>
					<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
					<!--<div class="infiform-inline">-->

						<div class="form-group">
							<label>Vendor Name</label>
							<input type="text" name="name" class="form-control" placeholder="Type vendor name" required>

						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
						</div>
						<div class="form-group">
							<input type="submit" value="Submit" class="btn submit-btn" name="submit">
						</div>
						<!--</div>-->
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!--pop up modal for vendor add view ends here-->
<!--pop up modal for vendor modify view -->
<?php
if(!empty($vendor_data)) {
	$count = 1;
	foreach($vendor_data as $vendor_value) {

		?>
		<div class="modal fade vendorModal-modal-lg" id="vendorModal_<?php echo $vendor_value['vendor_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="consultant">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="vendorModalLabel">Update Vendor</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="dashboard-countBox">
							<div class="formBox">
								<?php

						//if(!empty($vendor_data)){
							//foreach($vendor_data as $vendor_value){
								//echo $vendor_value['name'];		
								?>
								<?php echo form_open('vendor-display'); ?>
									<div class="form-group">
										<label>Name</label>
										<input type="text" name="name" class="form-control" placeholder="Type your name" value="<?php echo  $vendor_value['name']; ?>">
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $vendor_value['email']; ?>">
									</div>
									<div class="form-group">
										<label>Phone</label>
										<input type="text" name="phone" class="form-control" placeholder="Enter phone" maxlength="14" value="<?php echo $vendor_value['phone']; ?>">
									</div>
									<input type="hidden"  name="vendor_id" value="<?php echo $vendor_value['vendor_id']; ?>">
									<div class="form-group btnbox">
										<input type="submit" value="Update" class="btn submit-btn" name="submit">
									</div>
								<?php echo form_close(); ?>
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>
<?php 
		$count++;
	}
}

?>
<!--pop up modal for vendor modify view ends here-->

<!--pop up modal for mapping consultant add view -->
<div class="modal fade mappingconsultantModal-modal-lg" id="mappingconsultantModal" tabindex="-1" role="dialog" aria-labelledby="consultantModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="consultant">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="consultantModalLabel">Add Consultant</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="dashboard-countBox">
					<div class="formBox">
						<?php echo form_open(base_url('association/mapping_consult_add')); ?>
						<!--<form class="infiform-inline" method="post" action="add-consultant">-->
						<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="form-control" placeholder="Type your name" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
						</div>
						<div class="form-group">
							<input type="submit" value="Submit" class="btn submit-btn" name="mapping_consult_submit">
						</div>
						
						<!--</form>-->
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!--pop up modal for mapping consultant add view ends here-->

<!--pop up modal for mapping vendor add view -->
<div class="modal fade mappingvendorModal-modal-lg" id="mappingvendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="consultant">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="vendorModalLabel">Add Vendor</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="dashboard-countBox">
				<div class="formBox">
					<?php echo form_open(base_url('association/mapping_vendor_add')); ?>
					<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
					<!--<div class="infiform-inline">-->

						<div class="form-group">
							<label>Vendor Name</label>
							<input type="text" name="name" class="form-control" placeholder="Type vendor name" required>

						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
						</div>
						<div class="form-group">
							<input type="submit" value="Submit" class="btn submit-btn" name="mapping_vendor_submit">
						</div>
						<!--</div>-->
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!--pop up modal for mapping vendor add view ends here-->

<!--pop up modal for vendor add view -->
<div class="modal fade cosnultvendorModal-modal-lg" id="cosnultvendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="consultant">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="vendorModalLabel">Add Vendor</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="dashboard-countBox">
				<div class="formBox">
					<?php echo form_open('vendors/add_consult_vendor'); ?>
					<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
						<div class="form-group">
							<label>Vendor Name</label>
							<input type="text" name="name" class="form-control" placeholder="Type vendor name" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
						</div>
						<div class="form-group">
							<input type="submit" value="Submit" class="btn submit-btn" name="con_vend_submit">
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!--pop up modal for vendor add view ends here-->
