<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $breathcum; ?></h3>
	<?php
		if(!empty($vendor_data)) {
			// foreach($vendor_data as $vendor_value) {
				//echo $vendor_value['name'];
			foreach ($vendor_contacts as $vendor_contacts_val) {
				if($vendor_contacts_val['contact_type'] == 1) {
					$hr_id    = $vendor_contacts_val['id'];
					$hr_name  = $vendor_contacts_val['name'];
					$hr_email = $vendor_contacts_val['email'];
					$hr_phone = $vendor_contacts_val['phone'];
					$hr_ext   = $vendor_contacts_val['extension'];
				} else if($vendor_contacts_val['contact_type'] == 2) {
					$acc_id    = $vendor_contacts_val['id'];
					$acc_name  = $vendor_contacts_val['name'];
					$acc_email = $vendor_contacts_val['email'];
					$acc_phone = $vendor_contacts_val['phone'];
					$acc_ext   = $vendor_contacts_val['extension'];
				}
			}
	?>
		<?php echo form_open('vendor-display'); ?>
			<input type="hidden" name="hr_id" id="hr_id" value="<?php echo $hr_id; ?>">
			<input type="hidden" name="acc_id" id="acc_id" value="<?php echo $acc_id; ?>">
			<div class="formBox">
				<div class="infiform-inline">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" placeholder="Type your name" value="<?php echo  $vendor_data[0]['name']; ?>">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $vendor_data[0]['email']; ?>">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="phone" name="phone" class="form-control" placeholder="Enter phone" value="<?php echo $vendor_data[0]['phone']; ?>">
					</div>
					<div class="form-group">
						<label>Ext</label>
						<input type="number" name="extension" class="form-control" placeholder="Enter phone" value="<?php echo $vendor_data[0]['extension']; ?>">
					</div>
					<input type="hidden"  name="vendor_id" value="<?php echo $vendor_data[0]['vendor_id']; ?>">
				</div>
			</div>
			<div class="formBox">
				<h2 class="infi-heading" style="margin-top: 18px; margin-bottom: 0px;">HR Contact</h2>
				<div class="infiform-inline">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="hr_name" id="hr_name" class="form-control" value="<?php echo $hr_name; ?>" placeholder="Type name">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="hr_email" id="hr_email" class="form-control" value="<?php echo $hr_email; ?>" placeholder="Enter your email">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="phone" name="hr_phone" id="hr_phone" class="form-control" value="<?php echo $hr_phone; ?>" placeholder="Enter phone">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="number" name="hr_ext" id="hr_ext" class="form-control" value="<?php echo $hr_ext; ?>" placeholder="Enter extension">
					</div>
				</div>
			</div>
			<div class="formBox">
				<h2 class="infi-heading" style="margin-top: 18px; margin-bottom: 0px;">Accounts Contact</h2>
				<div class="infiform-inline">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="ac_name" id="ac_name" class="form-control" value="<?php echo $acc_name; ?>" placeholder="Type vendor name">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="ac_email" id="ac_email" class="form-control" value="<?php echo $acc_email; ?>" placeholder="Enter your email">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="phone" name="ac_phone" id="ac_phone" class="form-control" value="<?php echo $acc_phone; ?>" placeholder="Enter phone">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="number" name="ac_ext" id="ac_ext" class="form-control" value="<?php echo $acc_ext; ?>" placeholder="Enter extension">
					</div>
				</div>
				<div class="form-group">
					<input type="submit" value="Submit" id="submit" class="btn submit-btn" style="padding: 1px 1px;" name="submit">
				</div>
			</div>
		<?php echo form_close(); ?>
	<?php 
			//}
		}
	?>
</div>							
