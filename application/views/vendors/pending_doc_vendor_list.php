<div class="heading-noborder">
	<font color="#C97B29">Vendors</font>
</div>
<!--<div id="collapse-16" class="collapse show" role="tabpanel" aria-labelledby="heading-16" data-parent="#accordion-6">
	<div class="card-body">
		<?php echo form_open_multipart(base_url(''), array('id'=>'form','autocomplete'=>'off','method'=>'get')); ?>
		
			<div class="infiform-inline">
				<div class="form-group">
					<label for="consult_name">Vendor Name</label>
					<select class="js-example-basic-single w-100 pr0 form-control" style="width:100%;" name="vendor_id" id="vendor_id">
						<option value="">Vendor</option>
						<?php 
							foreach($filt_ven as $filt_ven_val) {
								$s = '';
								if($filt_ven_val['guid'] == $_GET['ven']) {
									$s ='selected';
								}
						?>
								<option value="<?php echo $filt_ven_val['guid']; ?>" <?php echo $s; ?> ><?php echo $filt_ven_val['name']; ?></option>
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
<!--<div class="dashboard-countBox">
	<div class="formBox">
		<div class="infiform-inline">
			<div class="form-group">
				<label>Search Vendors</label>
				<input class="form-control" id="searchVendor" type="text" placeholder="Search..">
			</div>
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
<div class="custome-box cpadding">
<h2 class="infi-heading">
		<div class="infiform-inline">
			<div class="form-group">
				<!--<label>Search Vendors</label>-->
				<input class="form-control" id="searchVendor" type="text" placeholder="Search.." size ="300">
			</div>
			<div class="form-group">
				<!--<label>&nbsp;</label>-->
				<div class="form-group">
					<button type="button" class="btn btn-warning" id="resetBtn" name="resetBtn">
						<i class="fa fa-undo" aria-hidden="true" title="Reset"></i>
					</button>
				</div>
			</div>
		
 	<span class="message-heading"><div align="center">
	<?php if($this->session->flashdata('success_message')){ ?>
		<div class="col-md-12 alert alert-success">
			<strong><?php echo $this->session->flashdata('success_message'); ?></strong>
		</div>
	<?php } else if($this->session->flashdata('error_message')) { ?>
		<div class="col-md-12 alert alert-danger">
			<strong><?php echo $this->session->flashdata('error_message'); ?></strong>
		</div>	
		<?php } ?></div>
	</span></div> <span class="rightAddbtn"><a href="add-vendor"><img src="<?php echo base_url(); ?>/assets/images/icon/add.svg" alt="Add Icon"></a></span></h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<!--<th>S No.</th>-->
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th class="text-center">HR Contact
						<table class="table inner-table">
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
							</tr>
						</table>
						</th>
						<th class="text-center">Accounts Contact
						<table class="table inner-table">
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
							</tr>
						</table></th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="vendorList">
					<?php 
						//$slno = 1;
						if(!empty($vendor_data)) {
							foreach($vendor_data as $vendor_value) {
								foreach ($vendor_con1 as $vendor_con_val1) {
									// print_r($vendor_con_value);
									if($vendor_value['guid'] == $vendor_con_val1['vendor_id']) {
										$contact1_name  = $vendor_con_val1['name'];
										$contact1_email = $vendor_con_val1['email'];
										$contact1_phone = $vendor_con_val1['phone'];
										break;
									} else {
										$contact1_name  = '';
										$contact1_email = '';
										$contact1_phone = '';
									}
								}

								foreach ($vendor_con2 as $key => $vendor_con_val2) {
									if($vendor_value['guid'] == $vendor_con_val2['vendor_id']) {
										$contact2_name  = $vendor_con_val2['name'];
										$contact2_email = $vendor_con_val2['email'];
										$contact2_phone = $vendor_con_val2['phone'];
										break;
									} else {
										$contact2_name  = '';
										$contact2_email = '';
										$contact2_phone = '';
									}
								}
					?>
								<tr>
									<!--<td><?php //echo $slno++; ?></td>-->
									<td width="10%"><a href="<?php echo base_url() ?>consult-list/<?php echo $vendor_value['vendor_id'] ?>"><?php echo $vendor_value['name']; ?></a></td>
									<td width="10%"><?php echo $vendor_value['email']; ?></td>
									<td width="11%"><?php echo $vendor_value['phone']; ?></td>
									<td width="32%">
										<table class="table inner-table">
											<tr>
												<?php if($contact1_name != "") { ?>
													<td><?php echo $contact1_name; ?></td>
												<?php } if($contact1_email != "") { ?>
													<td><?php echo $contact1_email; ?></td>
												<?php } if($contact1_phone != "") { ?>
													<td><?php echo $contact1_phone; ?></td>
												<?php } ?>
											</tr>
										</table>
									</td>
									<td width="32%">
										<table class="table inner-table">
											<tr>
												<?php if($contact2_name != "") { ?>
													<td><?php echo $contact2_name; ?></td>
												<?php } if($contact2_email != "") { ?>
													<td><?php echo $contact2_email; ?></td>
												<?php } if($contact2_phone != "") { ?>
													<td><?php echo $contact2_phone; ?></td>
												<?php } ?>
											</tr>
										</table>
									</td>
									<td width="5%">
										<ul class="table-actionBtn">
											<!--<li><a href="#"><img src="assets/images/icon/view.svg" alt="View"></a></li>-->
											<li><a href="<?php echo base_url() ?>doc-list/<?php echo $vendor_value['vendor_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/document.svg" alt="Document"></a></li>
												
											<li>
												<!-- <a href="<?php //echo base_url() ?>edit-vendor/<?php //echo $vendor_value['vendor_id'] ?>" data-toggle="modal" data-target="#vendorModal_<?php //echo $vendor_value['vendor_id'] ?>"><img src="<?php //echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a> -->

												<!--<a href="<?php //echo base_url() ?>edit-vendor/<?php //echo $vendor_value['vendor_id'] ?>"><img src="<?php //echo base_url('assets/') ?>images/icon/edit.svg" alt="Edit"></a>-->
											</li>
										</ul>
									</td>
								</tr>
					<?php
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
<script type="text/javascript">
	jQuery("#vendor_id").change(function() {
		var filter_sel      = jQuery("#vendor_id").val();
		if(filter_sel != "") {
			window.location.href = "<?php echo base_url('document-pending'); ?>?ven=" + filter_sel;
		} else {
			window.location.href = "<?php echo base_url('document-pending'); ?>?ven=" + filter_sel;
		}
	});
	function reset_filter() {
		window.location.href="<?php echo base_url('vendor-list'); ?>"
	}
	$(document).ready(function(){
		jQuery("#resetBtn").hide();
		//$('#searchVendor').prop('selectedIndex',0);
		$("#searchVendor").bind("change keyup keydown", function(event){
			if($.trim(this.value).length > 0) {
		       jQuery('#resetBtn').show()
			} else {
			       jQuery('#resetBtn').hide()
			}
		    var value = $(this).val().toLowerCase();
		    $("#vendorList tr").filter(function() {
		      	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

		    });
		});
		$( "#resetBtn" ).on('click', function(){
			jQuery("#searchVendor").val("");
   			jQuery(this).hide();
			location.reload();
		});
	});
</script>