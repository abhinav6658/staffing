<!--Main content box start here -->
<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $breathcumb; ?></h3>
	<div class="formBox">
		<?php echo form_open('vendors/save_contact', array('id' => 'contact_form', 'method' => 'POST')); ?>
			<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
			<input type="hidden" name="vendor_guid" class="form-control" value="<?php echo $this->uri->segment(2); ?>">
			<div class="custome-box form-group">
				<h2 class="infi-heading" style="font-size: 16px">HR Contact</h2>
			</div>
			<div class="infiform-inline">
				<div class="form-group">
					<label>Contact Name</label>
					<input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Type vendor name" required>
					<div class="alert alert-danger" id="contact_name_error" style="display: none;">
						<span>Please Enter Consultant Name</span>
					</div>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="Enter your email" required>
					<div class="alert alert-danger" id="contact_email_error" style="display: none;">
						<span>Please Enter Consultant Name</span>
					</div>
				</div>
				<div class="form-group">
					<label>Phone</label>
					<input type="text" name="phone" id="contact_phone" class="form-control" placeholder="Enter phone" required>
					<div class="alert alert-danger" id="contact_phone_error" style="display: none;">
						<span>Please Enter Consultant Name</span>
					</div>
				</div>
			</div>
			<div class="custome-box form-group">
				<h2 class="infi-heading" style="font-size: 16px">Accounts Contact</h2>
			</div>
			<div class="infiform-inline">
				<div class="form-group">
					<label>Contact Name</label>
					<input type="text" name="contact_name" id="acc_contact_name" class="form-control" placeholder="Type vendor name" required>
					<div class="alert alert-danger" id="contact_name_error" style="display: none;">
						<span>Please Enter Consultant Name</span>
					</div>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="contact_email" id="acc_contact_email" class="form-control" placeholder="Enter your email" required>
					<div class="alert alert-danger" id="contact_email_error" style="display: none;">
						<span>Please Enter Consultant Name</span>
					</div>
				</div>
				<div class="form-group">
					<label>Phone</label>
					<input type="text" name="phone" id="acc_contact_phone" class="form-control" placeholder="Enter phone" required>
					<div class="alert alert-danger" id="contact_phone_error" style="display: none;">
						<span>Please Enter Consultant Name</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" value="Submit" class="btn submit-btn" name="contact_submit" id="contact_submit">
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<!--Main content box end here -->
<script type="text/javascript">
	jQuery(window).ready(function() {
		jQuery("#contact_submit").click(function(e) {
			var contact_name = jQuery("#contact_name").val();
			var contact_mail = jQuery("#contact_email").val();
			var contact_phne = jQuery("#contact_phone").val();
			if(contact_name != "" && contact_mail != "" && contact_phne != "") {
				jQuery("#contact_form").submit();
			} else {
				if(contact_name == "") {
					jQuery("#contact_name_error").show();
				}
				if(contact_mail == "") {
					jQuery("#contact_email_error").show();
				}
				if(contact_phne == "") {
					jQuery("#contact_phone_error").show();
				}
				e.preventDefault();
			}
		});
	});
	jQuery("#contact_name").keydown(function() {
		jQuery("#contact_name_error").hide();
	});
	jQuery("#contact_email").keydown(function() {
		jQuery("#contact_email_error").hide();
	});
	jQuery("#contact_phone").keydown(function() {
		jQuery("#contact_phone_error").hide();
	});
</script>