<div class="dashboard-countBox">
	
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

		</span>
<div class="custome-box cpadding">
	<h2 class="infi-heading">Pending Timesheet Details</h2><br>
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
				<tbody>
					<?php
						if(!empty($timesheet)) {
							

							foreach($timesheet as $timesheet_val) {
					?>
								<tr>
									<td width="10%"><?php echo $timesheet_val['client_name']; ?></td>
									<td width="7%"><?php if($timesheet_val['start_date'] !=  "") { echo date("m/d/Y", strtotime($timesheet_val['start_date'])); } ?></td>
									<td width="21%"><?php echo $timesheet_val['consult_name']; ?></td>
									<td width="21%"><?php echo "W2"; ?></td>
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
									<td width="10%"><a href="<?php echo base_url() ?>pending-timesheet-w2/<?php echo $timesheet_val['consultant_id'] ?>/<?php echo $timesheet_val['date_from'] ?>"><img src="<?php echo base_url('/assets/images/icon'); ?>/action.svg" alt="Timesheet Upload"></a></td>
								</tr>
					<?php } } else {
						echo "<tr><td>No Record Found</td></tr>";
						} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- <div class="custome-box cpadding">
	<h2 class="infi-heading">Semi Monthly Pending Timesheet Details</h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<th>Consultant Name</th>
						<th>Date From</th>
						<th>Date To</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody> -->
					<?php //foreach($timesheet as $timesheet_val) { ?>
						<!-- <tr>
							<td><?php //echo $timesheet_val['consult_name'];?></td>
							<td><?php //echo $timesheet_val['date_from'];?></td>
							<td><?php //echo $timesheet_val['date_to'];?></td>
							<td><a href="#"><img src="<?php //echo base_url('/assets/images/icon'); ?>/document.svg" alt="Timesheet Upload"></a></td>
						</tr>	 -->
					<?php //} ?>
				<!-- </tbody>
			</table>
		</div>
	</div>
</div> -->

<!-- <div class="custome-box cpadding">
	<h2 class="infi-heading">Monthly Pending Timesheet Details</h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<th>Consultant Name</th>
						<th>Date From</th>
						<th>Date To</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody> -->
					<?php //foreach($timesheet as $timesheet_val) { ?>
					<!-- <tr>
						<td><?php //echo $timesheet_val['consult_name'];?></td>
						<td><?php// echo $timesheet_val['date_from'];?></td>
						<td><?php //echo $timesheet_val['date_to'];?></td>
						<td><a href="#"><img src="<?php// echo base_url('/assets/images/icon'); ?>/document.svg" alt="Timesheet Upload"></a></td>
					</tr> -->
					<?php //} ?>
				<!-- /tbody>
			</table>
		</div>
	</div>
</div> -->
<!--Main content box end here -->
