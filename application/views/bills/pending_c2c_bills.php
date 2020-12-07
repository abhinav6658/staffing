<div class="heading-noborder">
	<font color="#C97B29"><?php echo $title; ?></font>
</div>
<div class="custome-box cpadding">
	<h2 class="infi-heading"> 
		<div class="infiform-inline">
			<div class="form-group">
				<input class="form-control selectpicker" type="text" name="searchbills" id="searchbills" placeholder="Search.." size="300">
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
						<!--<th>S No.</th>-->
						<th>Name</th>
						<th>Bill From</th>
						<th>Bill To</th>
						<th>Total Hours</th>
						<th>Total Days</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="billsList">
					<?php
						//$slno = 1;
						//print_r($bills);
						if(!empty($bills)) {
							foreach($bills as $bills_value) {
								
					?>
								<tr>
									<!--<td><?php// echo $slno++; ?></td>-->
									<td width="12%"><?php echo $consult[0]['name']; ?></td>
									<td width="20%"><?php echo date('m/d/Y', strtotime($bills_value['start_date'])); ?></td>
									<td width="10%"><?php echo date('m/d/Y', strtotime($bills_value['end_date'])); ?></td>
									<td width="10%"><?php echo $bills_value['total_hrs']; ?></td>
									<td width="10%"><?php echo $bills_value['total_days']; ?></td>
									<td width="5%">
										<ul class="table-actionBtn">
											<li><a href="<?php echo base_url() ?>upload-c2c-pending-bills/<?php echo $consult[0]['consultant_id']; ?>/<?php echo $bills_value['id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/action.svg" alt="Document"></a></li>
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

	function reset_filter() {
		window.location.href="<?php echo base_url('pending-bills'); ?>"
	}
	$(document).ready(function(){
		jQuery("#resetBtn").hide();
		//$('#searchbills').prop('selectedIndex',0);
		$("#searchbills").bind("change keyup keydown", function(event){
			if($.trim(this.value).length > 0) {
		       jQuery('#resetBtn').show()
			} else {
		       jQuery('#resetBtn').hide()
			}
		    var value = $(this).val().toLowerCase();
		    $("#billsList tr").filter(function() {
		      	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

		    });
		});
		$("#resetBtn").on('click', function(){
			jQuery("#searchbills").val("");
   			jQuery(this).hide();
   			location.reload();
			
		});
	});
	//$(function () {
	//    $('select').selectpicker();
	//});
</script>
