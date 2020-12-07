<!--Main content box start here -->
<section class="mainBox-content">
	<div class="container-fluid percent">
		<div class="row percent">
			<!--Right sidebar content area start here -->
			<div class="col-lg-12 percent nopadding">
				<div class="inficare-scrollBar">
					<div class="custome-box cpadding">
						<h2 class="infi-heading">Users <span class="message-heading"><div align="center">
							<?php if($this->session->flashdata('success_message')){ ?>
								<div class="form-group col-md-4 alert alert-success">
									<strong><?php echo $this->session->flashdata('success_message'); ?></strong>
								</div>
							<?php } else if($this->session->flashdata('error_message')) { ?>
								<div class="form-group col-md-4 alert alert-danger">
									<strong><?php echo $this->session->flashdata('error_message'); ?></strong>
								</div>	
								<?php } ?></div>
							</span><span class="rightAddbtn"><a href="user-page"><img src="assets/images/icon/add.svg" alt="Add Icon"></a></span></h2>
							<div class="main-pagetable">
								<div class="table-responsive">
									<table class="table table-striped table-borderless">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Name</th>
												<th>Email</th>
												<th>Phone</th>
												<th>User Type</th>
												<!--<th>Role</th>-->
												<th>Action</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$slno = 1;
											//print_r($value);
											if(!empty($user_data)) {
												foreach($user_data as $user_val){

													?>
													<tr>
														<td><?php echo $slno; ?></td>
														<td><?php echo $user_val['name']; ?></td>
														<td><?php echo $user_val['email']; ?></td>
														<td><?php echo $user_val['phone']; ?></td>
														<td><?php if($user_val['user_type']==1) {
															echo "1099 (Sole Proprietor)";
														} else if($user_val['user_type']==2) {
															echo "W2";
														}else if($user_val['user_type']==3) {
															echo "C2C";
														}else if($user_val['user_type']==4) {
															echo "Super Admin";
														}else {
															echo "N/A";
														} //echo $user_val['user_type']; ?></td>
														<!--<td><?php// echo $user_val['role']; ?></td>-->
														<td>
															<ul class="table-actionBtn">
																<!--<li><a href="#"><img src="assets/images/icon/view.svg" alt="View"></a></li>-->
																<li><a href="<?php echo base_url() ?>user-display/<?php echo $user_val['user_id'] ?>"><img src="<?php echo base_url('assets/'); ?>images/icon/edit.svg" alt="Edit"></a></li>
																
															</ul>
														</td>
														<td>
															<ul class="table-actionBtn">
																<!--<li><a href="#"><img src="assets/images/icon/view.svg" alt="View"></a></li>-->
																
																<li>
																<?php if($user_val['user_type']==4)
																{ ?>	
																	
																<?php } else{ ?>

																	<a style="color: blue;" href="<?php echo base_url('User/delete_users'); ?>?action=edit&id=<?php echo $user_val['user_id']; ?>" onclick="return confirm('Are you sure?')"><img src="<?php echo base_url('assets/') ?>images/icon/delete.svg" alt="View"></a>
															<?php	}
																 ?>
																	</li>
															</ul>
														</td>
													
													</tr>
													<?php $slno++;
												}
											} else {
												echo "No records found";
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--Right sidebar content area end here -->
			</div>
		</div>
	</section>
	<!--Main content box end here -->
