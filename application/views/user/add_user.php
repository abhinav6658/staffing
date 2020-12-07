<div class="dashboard-countBox">
	<h3 class="black-headingCommon">Add User</h3>
	<div class="formBox">
		<?php echo form_open('add-user'); ?>
		<div class="infiform-inline">
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
				<input type="phone" name="phone" class="form-control" placeholder="Enter phone" required>
			</div>
			<!-- <div class="form-group">
				<label>Vendor Emp ID</label>
				<input type="text" name="vendor_emp_id" class="form-control" placeholder="Enter Vendor Emp Id" required>
			</div> -->
			<div class="form-group">
				<label>Password</label>
				<input type="text" name="password" id="password" class="form-control" placeholder="Enter valid password">
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="text" name="cpassword" id="cpassword" class="form-control" placeholder="Re-type password" onblur="confirm_password()">
			</div>
			<div class="form-group">
				<label>User Type</label>
				<select class="form-control" name="user_type">
					<?php foreach ($usertype_data as $user_row){ ?>
						<option value="<?php echo $user_row['usertype_id'];?>"><?php echo $user_row['user_type'];?> </option>
					<?php } ?>
				</select>
			</div>
			<!-- <input type="hidden" class="form-control" name="vendor_emp_id"> -->
			<input type="hidden" name="role" class="form-control" value="<?php echo 2; ?>">
			<input type="hidden" name="status" class="form-control" value="<?php echo 1; ?>">
			<div class="form-group">
				<input type="submit" value="Submit" class="btn submit-btn" name="submit">
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>							


<!--Main content box end here -->
<script type="text/javascript">
	function confirm_password(){
		var password = document.getElementById('password').value;
		var cpassword = document.getElementById('cpassword').value;
		if(password == cpassword){
			return true;
		}else{
			alert("Password and Confirm Password did not match! Try again.");
		}
	}
</script>