<div class="heading-noborder">
	<font color="#C97B29">Consultants</font>
</div>
<!--<div class="dashboard-countBox">
	<div class="formBox">
		<div class="infiform-inline">
			<div class="form-group">
				<label>Search Consultants</label>
				<input class="form-control selectpicker" type="text" name="searchCon" id="searchCon" placeholder="Search..">
				<!--<select class="form-control selectpicker" name="searchCon" id="searchCon" data-show-subtext="true" data-live-search="true">
						<option value="0">Select Consultants</option>
						<?php foreach ($con_data as $row) { ?>
						<option value="<?php echo $row['name'] ?>" data-tokens="<?php echo $row['name'] ?>"><?php echo $row['name'] ?> </option>
						<?php } ?>
				</select>-->
			<!--</div>
			<div class="form-group">
				<label>&nbsp;</label>
				<div class="form-group">
					<button type="button" class="btn btn-warning" id="resetBtn" name="resetBtn">
						<i class="fa fa-undo" aria-hidden="true" title="Reset"></i>
					</button>
				</div>
			</div>
			
		</div>
	</div>
</div>-->

<!--<div id="collapse-16" class="collapse show" role="tabpanel" aria-labelledby="heading-16" data-parent="#accordion-6">
	<div class="card-body">
		<?php echo form_open_multipart(base_url(''), array('id'=>'form','autocomplete'=>'off','method'=>'get')); ?>
	
			<div class="infiform-inline">
				<div class="form-group">
					<label for="consult_name">Consultant Name</label>
					<select class="js-example-basic-single pr0 form-control" name="client_id" id="client_id">
						<option value="">Select</option>
						<?php 
							foreach($filt_con as $con_data_val) {
								$s = '';
								if($con_data_val['guid'] == $_GET['con']) {
									$s ='selected';
								}
						?>
								<option value="<?php echo $con_data_val['guid']; ?>" <?php echo $s; ?> ><?php echo $con_data_val['name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="consult_type">Consultant Type</label>
					<select class="js-example-basic-single pr0 form-control" name="consult_type_id" id="consult_type_id">
						<option value="">Select</option>
						<?php 
							foreach($con_type as $con_type_val) {
								$s = '';
								if($con_type_val['consultant_type_id'] == $_GET['id']) {
									$s ='selected';
								}
						?>
								<option value="<?php echo $con_type_val['consultant_type_id']; ?>" <?php echo $s; ?> ><?php echo $con_type_val['consultant_type_name']; ?></option>
						?>
								<option value="<?php echo $con_data_val['consultant_id']; ?>" <?php echo $s; ?> ><?php echo $name; ?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="form-group col-md-1 p0 fillter-btn">
					<button type="button" class="btn btn-warning" onclick="reset_filter();">
						<i class="fa fa-undo" aria-hidden="true" title="Reset"></i>
					</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>-->

<div class="custome-box cpadding">
	<h2 class="infi-heading"> 
		<div class="infiform-inline">
			<div class="form-group">
				<input class="form-control selectpicker" type="text" name="searchCon" id="searchCon" placeholder="Search.." size="300">
			</div>
			<div class="form-group">
				<div class="form-group">
					<button type="button" class="btn btn-warning" id="resetBtn" name="resetBtn">
						<i class="fa fa-undo" aria-hidden="true" title="Reset"></i>
					</button>
				</div>
			</div>
	<span class="message-heading">
		<div align="center">
			<?php if($this->session->flashdata('success_message')) { ?>
				<div class="col-md-12 alert alert-success">
					<strong><?php echo $this->session->flashdata('success_message'); ?></strong>
				</div>
			<?php } else if($this->session->flashdata('error_message')) { ?>
				<div class="col-md-12 alert alert-danger">
					<strong><?php echo $this->session->flashdata('error_message'); ?></strong>
				</div>	
			<?php } ?>
		</div>

		</span></div> <span class="rightAddbtn">
		<a href="<?php echo base_url('add-consultant'); ?>"><img src="<?php echo base_url('assets/'); ?>images/icon/add.svg" alt="Add Icon"></a></span>
	</h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<!--<th>S No.</th>-->
						<th>Name</th>
						<th>Client</th>
						<th>Email</th>
						<th>Phone</th>
						<th style="min-width: 120px;">Consultant Type</th>
						<th>Vendor</th>
						<th>Project</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="consultantList">
					<?php
						//$slno = 1;
						// print_r($mapping_data);
						if(!empty($con_data)) {
							foreach($con_data as $con_value) {
								foreach ($mapping_data as $mapping_data_val) {
									if($con_value['guid'] == $mapping_data_val['consultant_id']) {
										$project_loc      = $mapping_data_val['project_name'];
										$pro_start_date   = $mapping_data_val['start_date'];
										$project_end_date = $mapping_data_val['end_date'];
										$vendor_name      = $mapping_data_val['vendor_name'];
										$client_name      = $mapping_data_val['client'];
										break;
									} else {
										$project_loc      = "";
										$pro_start_date   = "";
										$project_end_date = "";
									}
								}
					?>
								<tr>
									<!--<td><?php// echo $slno++; ?></td>-->
									<td width="12%"><?php echo $con_value['name']; ?></td>
									<td width="8%"><?php echo $client_name; ?></td>
									<td width="20%"><?php echo $con_value['email']; ?></td>
									<td width="10%"><?php echo $con_value['phone']; ?></td>
									<td width="5%"><?php
										if($con_value['consultant_type'] == "1"){
											echo "W2";
										} else if($con_value['consultant_type'] == "2") {
											echo "C2C";
										} else if($con_value['consultant_type'] == "3") {
											echo "1099";
										}?>
									</td>
									<td width="10%"><?php echo $vendor_name; ?></td>
									<td width="10%"><?php echo $project_loc; ?></td>
									<td width="10%">
										<?php echo date("m/d/Y", strtotime($pro_start_date)); ?>
									</td>
									<td width="10%">
										<?php if($project_end_date != "0000-00-00") { echo date("m/d/Y", strtotime($project_end_date)); } ?>
									</td>
									<td width="5%">
										<ul class="table-actionBtn">
											<li><a href="<?php echo base_url() ?>view-consultant/<?php echo $con_value['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="View"></a></li>
											<!--
											<li><a href="#"><img src="assets/images/icon/delete.svg" alt="Delete"></a></li>-->
											<li><a href="<?php echo base_url() ?>document-list/<?php echo $con_value['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/document.svg" alt="Document"></a></li>
											<li>
												<!-- <a href="<?php //echo base_url() ?>edit-consultant/<?php// echo $con_value['consultant_id'] ?>" data-toggle="modal" data-target="#consultantModal_<?php //echo $con_value['consultant_id'] ?>"><img src="<?php //echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a> -->
												<a href="<?php echo base_url() ?>edit-consultant/<?php echo $con_value['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a>
												<!--<a href="<?php //echo base_url() ?>edit-consultant/<?php //echo $con_value['consultant_id'] ?>"><img src="<?php// echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a>-->
											</li>
										</ul>
									</td>
								</tr>
					<?php
							}
							$n++;
							//$slno++;
						} else {
							echo "<tr><td>No records found</td></tr>";
						}
					?>
				</tbody>
			</table>
			<?php
	
				// //$seg = $segment+$per_page; // 4 & 5 error
				// $seg = $total_rows - $segment; // 1,2,3 error
				// //echo $seg;
				// $p = ($this->uri->segment(2)) ? $this->uri->segment(2)+1 : 1;
				// if($total_rows == $segment+1){
				// 	$n = $this->uri->segment(2)+1; 
				// } else {
				// 	// $n = ($this->uri->segment(2)) ? $p + $seg - 1 : $per_page;
				// 	$n = $total_rows;
				// }
		
				// if($total_rows != 0) {
			?>
					<!-- <div class="container-fluid">
						<div class="row">
							<div class="col-sm-12 col-md-5">
								<div class="text-left mt-3">
									<div>Showing <?php //echo $p; ?> to <?php //echo $n; ?> of <?php //echo $total_rows; ?> entries</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-7">
								<div class="text-right fr mt-2 custome-pagination">
									<?php //echo $links ?>
								</div>
							</div>
						</div>
					</div> -->
			<?php //} ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(window).ready(function() {
		jQuery(".text-right.fr.mt-2 a").addClass("page-link");

	});

	function reset_filter() {
		window.location.href="<?php echo base_url('consultant-list'); ?>"
	}
	jQuery("#client_id").change(function() {
		var filter_sel      = jQuery("#client_id").val();
		var consult_type_id = jQuery("#consult_type_id").val();
		if(filter_sel != "" || consult_type_id != "") {
			window.location.href = "<?php echo base_url('consultant-list'); ?>?con="+filter_sel+"&id="+consult_type_id;
		} else {
			window.location.href = "<?php echo base_url('consultant-list'); ?>?con="+filter_sel+"&id="+consult_type_id;
		}
	});
	jQuery("#consult_type_id").change(function() {
		var filter_sel      = jQuery("#client_id").val();
		var consult_type_id = jQuery("#consult_type_id").val();
		if(filter_sel != "" || consult_type_id != "") {
			window.location.href = "<?php echo base_url('consultant-list'); ?>?con="+filter_sel+"&id="+consult_type_id;
		} else {
			window.location.href = "<?php echo base_url('consultant-list'); ?>?con="+filter_sel+"&id="+consult_type_id;
		}
	});
	$(document).ready(function(){
		jQuery("#resetBtn").hide();
		//$('#searchCon').prop('selectedIndex',0);
		$("#searchCon").bind("change keyup keydown", function(event){
			if($.trim(this.value).length > 0) {
		       jQuery('#resetBtn').show()
			} else {
		       jQuery('#resetBtn').hide()
			}
		    var value = $(this).val().toLowerCase();
		    $("#consultantList tr").filter(function() {
		      	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

		    });
		});
		$("#resetBtn").on('click', function(){
			jQuery("#searchCon").val("");
   			jQuery(this).hide();
   			location.reload();
			
		});
	});
	//$(function () {
	//    $('select').selectpicker();
	//});
</script>
