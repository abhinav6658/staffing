<!--Main content box start here -->
<div class="dashboard-countBox">
	<h2 class="infi-heading"><?php echo $breatcumb; ?></h2>
	<div class="formBox">
		<?php echo form_open('vendors/add_vendor', array('id' => 'vendor_form')); ?>	
		<input type="hidden" name="org_id" class="form-control" placeholder="Type your name" value="<?php echo 1; ?>">
		<input type="hidden" name="guid" class="form-control" value="<?php echo rand(50,10000); ?>">
	
		<div class="infiform-inline">
			<div class="form-group">
				<label>Vendor Name</label>
				<input type="text" name="name" id="vendor_name" class="form-control" placeholder="Name">
				<div class="alert alert-danger" id="vendor_name_error" style="display: none;">
					<span>Please Enter Vendor Name</span>
				</div>
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="email" name="email" id="vendor_email" class="form-control" placeholder="Email">
				<div class="alert alert-danger" id="vendor_email_error" style="display: none;">
					<span>Please Enter Vendor Email</span>
				</div>
			</div>
			<div class="form-group">
				<label>Phone</label>
				<input type="phone" name="phone" id="vendor_phone" class="form-control" placeholder="Phone">
				<div class="alert alert-danger" id="vendor_phone_error" style="display: none;">
					<span>Please Enter Vendor phone</span>
				</div>
			</div>
			<div class="form-group">
				<label>Ext.</label>
				<input type="number" name="extension" id="vendor_ext" class="form-control" placeholder="Extension">
				<div class="alert alert-danger" id="vendor_phone_error" style="display: none;">
					<span>Please Enter Phone Extension</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="formBox">
		<h2 class="infi-heading" style="margin-top: 18px; margin-bottom: 0px;">HR Contact</h2>
		<div class="infiform-inline">
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="hr_name" id="hr_name" class="form-control" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="email" name="hr_email" id="hr_email" class="form-control" placeholder="Enter email">
			</div>
			<div class="form-group">
				<label>Phone</label>
				<input type="phone" name="hr_phone" id="hr_phone" class="form-control" placeholder="Enter phone">
			</div>
			<div class="form-group">
				<label>Ext.</label>
				<input type="number" name="hr_ext" id="hr_ext" class="form-control" placeholder=" Extension">
			</div>
		</div>
	</div>
	<div class="formBox">
		<h2 class="infi-heading" style="margin-top: 18px; margin-bottom: 0px;">Accounts Contact</h2>
		<div class="infiform-inline">
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="ac_name" id="ac_name" class="form-control" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="email" name="ac_email" id="ac_email" class="form-control" placeholder="Enter email">
			</div>
			<div class="form-group">
				<label>Phone</label>
				<input type="phone" name="ac_phone" id="ac_phone" class="form-control" placeholder="Enter phone">
			</div>
			<div class="form-group">
				<label>Ext.</label>
				<input type="number" name="ac_ext" id="ac_ext" class="form-control" placeholder="Extension">
			</div>
		</div>
		<div class="form-group">
			<input type="submit" value="Submit" id="submit" class="btn submit-btn" style="padding: 1px 1px;" name="submit">
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">
	jQuery("#vendor_name").keydown(function() {
		jQuery("#vendor_name_error").hide();
	});
	jQuery("#vendor_email").keydown(function() {
		jQuery("#vendor_email_error").hide();
	});
	// jQuery("#vendor_phone").keydown(function() {
	// 	jQuery("#vendor_phone_error").hide();
	// });
	jQuery("#submit").click(function(e) { 
		var vendor_name   = jQuery("#vendor_name").val();
		var vendor_email  = jQuery("#vendor_email").val();
		var vendor_phone  = jQuery("#vendor_phone").val();
			//alert("Fill all the fields.");
			//alert(vendor_name);
			if(vendor_name != "" && vendor_email != "") {
				jQuery("#vendor_form").submit();
			} else {
				e.preventDefault();
				if(vendor_name  == "") {
					jQuery("#vendor_name_error").show();
				}
				if(vendor_email == "") {
					jQuery("#vendor_email_error").show();
				}
			}
			// if(vendor_phone == "") {
			// 	jQuery("#vendor_phone_error").show();
			// }
		});
</script>