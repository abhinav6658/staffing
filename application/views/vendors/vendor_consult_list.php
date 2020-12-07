<!--Main content box start here -->
<div class="dashboard-countBox">
		<h2 class="infi-heading">Vendor Details</h2>
				<?php //print_r($vendor_data); 
					foreach($vendor_data as $vendor_data_value){
						echo "Vendor Name - ".$vendor_data_value['name']." | ";
						echo "Email - ".$vendor_data_value['email']." | ";	
						echo "Contact - ".$vendor_data_value['phone'];
					}

				?>
		
	
</div>

<div class="custome-box cpadding">
	<h2 class="infi-heading"><?php echo $breathcum; ?> <span class="message-heading"><div align="center">
		<?php if($this->session->flashdata('success_message')){ ?>
			<div class="form-group col-md-12 alert alert-success">
				<strong><?php echo $this->session->flashdata('success_message'); ?></strong>
			</div>
		<?php } else if($this->session->flashdata('error_message')) { ?>
			<div class="form-group col-md-12 alert alert-danger">
				<strong><?php echo $this->session->flashdata('error_message'); ?></strong>
			</div>	
			<?php } ?></div>
		</span> <!--<span class="rightAddbtn"><a href="vendor-page" data-toggle="modal" data-target="#vendorModal"><img src="<?php //echo base_url('assets/') ?>images/icon/add.svg" alt="Add Icon"></a></span>--></h2>
		
		<div class="main-pagetable">
			<div class="table-responsive">
				<table class="table table-striped table-borderless">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th style="min-width: 144px;">Consultant Type</th>
							<th>Vendor</th>
							<th>Project</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							// print_r($con_data);
							if(!empty($con_data)) {
								//$con_index = 0;
								foreach($con_data as $consult_value){
									//echo "<pre>";
									// print_r($consult_value);
									foreach ($mapping_data as $mapping_data_val) {
										if($consult_value[0]['guid'] == $mapping_data_val['consultant_id']) {
											$project_loc      = $mapping_data_val['project_name'];
											$pro_start_date   = $mapping_data_val['start_date'];
											$project_end_date = $mapping_data_val['end_date'];
											break;
										} else {
											$project_loc      = "";
											$pro_start_date   = "";
											$project_end_date = "";
										}
									}
						?>
									<tr>
										<td><?php echo $consult_value[0]['name']; ?></td>
										<td><?php echo $consult_value[0]['email']; ?></td>
										<td><?php echo $consult_value[0]['phone']; ?></td>
										<td width="5%">
										<?php
											if($consult_value[0]['consultant_type'] == "1"){
												echo "W2";
											} else if($consult_value[0]['consultant_type'] == "2") {
												echo "C2C";
											} else if($consult_value[0]['consultant_type'] == "3") {
												echo "1099";
											}
										?>
										</td>
										<td width="18"><?php echo $vendor_data[0]['name']; ?></td>
										<td width="10%">
											<?php echo $project_loc; ?>
										</td>
										<td width="10%">
											<?php echo $pro_start_date; ?>
										</td>
										<td width="10%">
											<?php echo $project_end_date; ?>
										</td>
										<td>
											<ul class="table-actionBtn">
												<li><a href="<?php echo base_url() ?>document-list/<?php echo $consult_value[0]['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/action.svg" alt="Document"></a></li>
												<li>
													<!-- <a href="<?php //echo base_url() ?>edit-consultant/<?php //echo $consult_value[0]['consultant_id'] ?>" data-toggle="modal" data-target="#consultantModal_<?php //echo $consult_value[0]['consultant_id'] ?>"><img src="<?php //echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a> -->
													<a href="<?php echo base_url() ?>edit-consultant/<?php echo $consult_value[0]['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a>
												<!-- <li>
													<a href="<?php //echo base_url() ?>document-list/<?php //echo $consult_value[0]['consultant_id'] ?>"><img src="<?php //echo base_url('assets/') ?>images/icon/document.svg" alt="Document"></a>
												</li>
												<li>
													<a href="<?php //echo base_url() ?>edit-consultant/<?php //echo $consult_value[0]['consultant_id'] ?>" data-toggle="modal" data-target="#consultantModal_<?php //echo $consult_value[0]['consultant_id'] ?>"><img src="<?php //echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a>
												</li> -->
											</ul>
										</td>
									</tr>
						<?php
									//$con_index++;
									 //echo $con_index;
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
