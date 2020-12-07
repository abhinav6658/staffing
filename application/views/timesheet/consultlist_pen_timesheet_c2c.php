<div class="heading-noborder">
	<font color="#C97B29"><?php echo $title; ?></font>
</div>
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

		</span></div></h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<th>Client Name</th>
						<th>Start Date</th>
						<th>Consultant Name</th>
						<th>Vendor</th>
						<th>COI Valid Till</th>
						<th>From</th>
						<th>To</th>
						<th>Frequency</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="consultantList">
					<?php
						if(!empty($timesheet)) {
							foreach($timesheet as $timesheet_val) {
					?>
								<tr>
									<td width="10%"><?php echo $timesheet_val['client_name']; ?></td>
									<td width="7%"><?php if($timesheet_val['start_date'] !=  "") { echo date("m/d/Y", strtotime($timesheet_val['start_date'])); } ?></td>
									<td width="21%"><?php echo $timesheet_val['consult_name']; ?></td>
									<td width="21%"><?php echo $timesheet_val['vendor_name']; ?></td>
									<td width="7%"><?php if($timesheet_val['coi_expiry'] != "") { echo date("m/d/Y", strtotime($timesheet_val['coi_expiry'])); } ?></td>
									<td width="7%"><?php if($timesheet_val['date_from'] != "") { echo date("m/d/Y", strtotime($timesheet_val['date_from'])); } ?></td>
									<td width="7%"><?php if($timesheet_val['date_to'] != "") { echo date("m/d/Y", strtotime($timesheet_val['date_to'])); } ?></td>
									<td width="10%">
										<?php
											if($timesheet_val['freuency'] == 1) { 
												echo "Weekly";
											} else if($timesheet_val['freuency'] == 2) {
												echo "Semi-Monthly";
											} else if($timesheet_val['freuency'] == 3) {
												echo "Monthly";
											}
										?>
									</td>
									<td width="10%"><a href="<?php echo base_url() ?>pending-timesheet-c2c/<?php echo $timesheet_val['consultant_id'] ?>/<?php echo $timesheet_val['date_from'] ?>"><img src="<?php echo base_url('/assets/images/icon'); ?>/action.svg" alt="Timesheet Upload"></a></td>
								</tr>
					<?php } } else {
						echo "<tr><td>No Record Found</td></tr>";
						} ?>
				</tbody>
			</table>
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
