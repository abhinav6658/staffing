<!--Main content box start here -->
<section class="mainBox-content">
	<div class="container-fluid percent">
		<div class="row percent">
			<!--Right sidebar content area start here -->
			<div class="col-lg-12 percent nopadding">
				<div class="inficare-scrollBar">

					<div class="dashboard-countBox">
						<h3 class="black-headingCommon">Modify User</h3>
						<div class="formBox">
							<?php
								if(!empty($user_data)){
									foreach($user_data as $user_value){		
							?>
										<?php echo form_open('edit-user'); ?>
											<div class="infiform-inline">
												<div class="form-group">
													<label>Name</label>
													<input type="text" name="name" class="form-control" placeholder="Type your name" value="<?php echo $user_value['name'] ?>">
												</div>
												<div class="form-group">
													<label>Email</label>
													<input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $user_value['email'] ?>">
												</div>
												<div class="form-group">
													<label>Phone</label>
													<input type="text" name="phone" class="form-control" placeholder="Enter phone" value="<?php echo $user_value['phone'] ?>">
												</div>
												<div class="form-group">
													<label>Password</label>
													<input type="text" name="password" class="form-control" placeholder="Type new Password" required>
												</div>
												<div class="form-group">
													<label>User Type</label>
													<select class="form-control" name="user_type">
														<?php foreach ($usertype_data as $user_row){ ?>
														<option value="<?php echo $user_row['usertype_id'];?>"

														<?php if($user_value['user_type']==$user_row['usertype_id']){echo "selected";}?>> <?php echo $user_row['user_type']?>
														</option>
														<?php } ?>
													</select>
												</div>
												<input type="hidden"  name="user_id" value="<?php echo $user_value['user_id']; ?>">
												<div class="form-group">
													<input type="submit" value="Update" class="btn submit-btn" name="submit">
												</div>
											</div>
										<?php echo form_close(); ?>
								<?php 
									}
								}

							?>
						</div>
					</div>							

				</div>
			</div>
			<!--Right sidebar content area end here -->
		</div>
	</div>
</section>
<!--Main content box end here -->