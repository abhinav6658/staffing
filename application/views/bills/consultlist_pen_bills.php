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
						<!--<th>S No.</th>-->
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Vendor</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="consultantList">
					<?php
						//$slno = 1;
						//print_r($vendor);
						if(!empty($consult_data)) {
							foreach($consult_data as $consult_data_value) {
								foreach ($mapping_data as $mapping_data_val) {
									if($consult_data_value['guid'] == $mapping_data_val['consultant_id']) {
										$vendor_name      = $mapping_data_val['vendor_name'];
										break;
									}
								}
								
					?>
								<tr>
									<!--<td><?php// echo $slno++; ?></td>-->
									<td width="12%"><?php echo $consult_data_value['name']; ?></td>
									<td width="20%"><?php echo $consult_data_value['email']; ?></td>
									<td width="10%"><?php echo $consult_data_value['phone']; ?></td>
									<td width="10%"><?php echo $vendor_name; ?></td>
									<td width="5%">
										<ul class="table-actionBtn">
											<li><a href="<?php echo base_url() ?>pending-bills/<?php echo $consult_data_value['consultant_id'] ?>"><img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="Document"></a></li>
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
