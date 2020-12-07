<div class="heading-noborder">
	<font color="#C97B29">Consultants</font>
</div>
<!--<div class="dashboard-countBox">
	<div class="formBox">
		<div class="infiform-inline">
			<div class="form-group">
				<label>Search Consultants</label>
				<input class="form-control selectpicker" type="text" name="searchCon" id="searchCon" placeholder="Search.." size="300">
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
<!--<div id="collapse-16" class="collapse show" role="tabpanel" aria-labelledby="heading-16" data-parent="#accordion-6">
	<div class="card-body">
		<?php echo form_open_multipart(base_url(''), array('id'=>'form','autocomplete'=>'off','method'=>'get')); ?>
	
			<div class="infiform-inline">
				<div class="form-group">
					<label for="consult_name">Consultant Name</label>
					<select class="js-example-basic-single pr0 form-control" name="client_id" id="client_id">
						<option value="">Consultant</option>
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
						<option value="">Consultant Type</option>
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

			</span>	
		</div>
		<span class="message-heading"><div align="center">
		<a href="<?php echo base_url('add-consultant'); ?>"><img src="<?php echo base_url('assets/'); ?>images/icon/add.svg" alt="Add Icon"></a>
	</h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<!--<th>S No.</th>-->
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Consultant Type</th>
						<th>Project</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="consultantList">
					<?php
						$slno = 1;
						//print_r($mapping_data);
						if(!empty($con_data)) {
							foreach($con_data as $con_value) {
							 //print_r($mapping_data);
								foreach ($mapping_data as $mapping_data_val) {
									if($con_value[0]['guid'] == $mapping_data_val[0]['consultant_id']) {
										$project_name 	  = $mapping_data_val[0]['project_name'];
										$project_loc      = $mapping_data_val[0]['project_location'];
										$pro_start_date   = date('m/d/Y', strtotime($mapping_data_val[0]['start_date']));
										$project_end_date = date('m/d/Y', strtotime($mapping_data_val[0]['end_date']));
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
									<td width="15%"><?php echo $con_value[0]['name']; ?></td>
									<td width="25%"><?php echo $con_value[0]['email']; ?></td>
									<td width="10%"><?php echo $con_value[0]['phone']; ?></td>
									<td width="5%"><?php
										if($con_value[0]['consultant_type'] == "1"){
											echo "W2";
										} else if($con_value[0]['consultant_type'] == "2") {
											echo "C2C";
										} else if($con_value[0]['consultant_type'] == "3") {
											echo "1099";
										} else { echo "N/A"; } ?>
									</td>
									<td width="20%">
										<?php 
										echo $project_name;
										echo "<br>";
										echo $project_loc; ?>
									</td>
									<td width="10%">
										<?php echo $pro_start_date; ?>
									</td>
									<td width="10%">
										<?php echo $project_end_date; ?>
									</td>
									<td width="5%">
										<ul class="table-actionBtn">
											<li><a href="<?php echo base_url() ?>document-list/<?php echo $con_value[0]['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/document.svg" alt="Document"></a></li>
										
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
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(window).ready(function() {
	jQuery(".text-right.fr.mt-2 a").addClass("page-link");
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
	$( "#resetBtn" ).on('click', function(){
		jQuery("#searchCon").val("");
   		jQuery(this).hide();
		location.reload();
	});
});
</script>
