<div class="heading-noborder">
	<font color="#C97B29">Old TimeSheet Report</font>
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

		</span></div>
	</h2>
	<div class="main-pagetable">
		<div class="table-responsive">
			<table class="table table-striped table-borderless">
				<thead>
					<tr>
						<!--<th>S No.</th>-->
						<th>Name</th>
						<th>Email</th>
						<th style="min-width: 120px;">Consultant Type</th>
						<th>Vendor</th>
						<th>Start Date (M/D/Y)</th>
						<th>End Date (M/D/Y)</th>
						<th>Total Hours</th>
						<th>View/Download</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="timesheetreport">
					<?php
						//$slno = 1;
						// print_r($mapping_data);
						if(!empty($con_data)) {
							$modal_id=1;
							foreach($con_data as $con_value) {
								foreach ($mapping_data as $mapping_data_val) {
									if($con_value['consultant_id'] == $mapping_data_val['guid']) {
										
										$vendor_name      = $mapping_data_val['vendor_name'];
										break;
									} else {
										$vendor_name      = "";
										
									}
								}
					?>
								<tr>
									<!--<td><?php// echo $slno++; ?></td>-->
									<td width="12%"><?php echo $mapping_data_val['name']; ?></td>
									<td width="15%"><?php echo $mapping_data_val['email']; ?></td>
									<td width="5%"><?php
										if($mapping_data_val['consultant_type'] == "1"){
											echo "W2";
										} else if($mapping_data_val['consultant_type'] == "2") {
											echo "C2C";
										} else if($mapping_data_val['consultant_type'] == "3") {
											echo "1099";
										}?>
									</td>
									<td width="10%"><?php echo $vendor_name; ?></td>
									<td width="10%">
										<?php echo date("m/d/Y", strtotime($con_value['start_date'])); ?>
									</td>
									<td width="10%">
										<?php echo date("m/d/Y", strtotime($con_value['end_date'])); ?>
									</td>
									<td width="10%">
										<?php echo $con_value['total_hrs']; ?>
									</td>
									<td>
										<?php 
									//echo $bills_data_value['file_path'];
									/* File view Link */
									$pathinfo = array_filter( explode('/', $con_value['file_path']));
									$file_folder_name = array_pop($pathinfo);

									$fileName = basename($file_folder_name);
									$TfileName = array_filter( explode('FILE_', $fileName));	
									$TempfileName = array_pop($TfileName);
									
									$file_ext = array_filter( explode('.', $con_value['file_name'] ));
									$fileExt = array_pop($file_ext);
									/* File view Link */

									?>
									<ul class="table-actionBtn">
										
										<li><a href="<?=base_url('assets/uploads/'.$file_folder_name .'/' . $TempfileName .'.'. $fileExt)?>" target="_blank" data-toggle="modal" data-target="#TimeSheetModel_<?php echo $modal_id; ?>">
											<img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="View"></a> / <a href="<?=base_url('assets/uploads/'.$file_folder_name .'/' . $TempfileName .'.'. $fileExt)?>" target="_blank">Download File</a>
										</li>

										<!--<li><a href="#"><img src="<?php echo base_url('assets/'); ?>images/icon/delete.svg" alt="Delete"></a></li>-->

									</ul>
								</td>
									<td width="5%">
										<ul class="table-actionBtn">
											<li>
												 <a style="color: blue;" href="<?php echo base_url('Timesheet/delete_timesheet'); ?>?action=edit&id=<?php echo $con_value['id']; ?>" onclick="return confirm('Are you sure?')"><img src="<?php echo base_url('assets/') ?>images/icon/delete.svg" alt="View"></a>
												 </li>
											<!--
											<li><a href="#"><img src="assets/images/icon/delete.svg" alt="Delete"></a></li>-->
											
											
										</ul>
									</td>
								</tr>
							<?php 
							$modal_id++;
						}
					} else {
						echo "<tr><td>No records found</td></tr>";
					}
					?>
				</tbody>
			</table>
			
		</div>
	</div>
</div>


<?php
$i = 0;
$fName_array = array();
foreach($con_data as $con_value) {

	/* File view Link */
	$pathinfo = array_filter( explode('/', $con_value['file_path']));
	$file_folder_name = array_pop($pathinfo);

	$fileName = basename($file_folder_name);
	$TfileName = array_filter( explode('FILE_', $fileName));	
	$TempfileName = array_pop($TfileName);

	$file_ext = array_filter( explode('.', $con_value['file_name'] ));
	$fileExt = array_pop($file_ext);

	/* File view Link */

	$fName_array[$i] = array(
		'file_folder_name' => $file_folder_name,
		'TempfileName'=> $TempfileName,
		'fileExt'		  => $fileExt
	);
	$i++;
	//print_r($fName_array);
	//foreach($dName_array as $doc_full_name) {
		//echo $doc_full_name['docExt'];
}
$mod_id = 1;
	//print_r($fName_array);
foreach ($fName_array as $fName_array_value) {
	$arr_file_folder_name  = $fName_array_value['file_folder_name'];
	$arr_TempfileName = $fName_array_value['TempfileName'];
	$arr_fileExt           = $fName_array_value['fileExt'];

	?>

	<!--pop up bills for document view -->
	<div class="modal fade billsModal-modal-lg" id="TimeSheetModel_<?php echo $mod_id; ?>" tabindex="-1" role="dialog" aria-labelledby="timesheetModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="timesheetModalLabel">TimeSheet View</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php if($arr_fileExt == 'pdf'){ ?>
						<iframe src="<?=base_url('assets/uploads/'.$arr_file_folder_name .'/' . $arr_TempfileName .'.'. $arr_fileExt)?>" style="width:100%; height:500px;" style="overflow: hidden; "frameborder="0" marginheight="0" marginwidth="0"></iframe>

					<?php } else { ?>

						

						<iframe src="https://docs.google.com/viewer?url=<?=base_url('assets/uploads/'.$arr_file_folder_name .'/' . $arr_TempfileName .'.'. $arr_fileExt)?>&embedded=true" style="width:100%; height:500px;" style="overflow: hidden; "frameborder="0" marginheight="0" marginwidth="0"></iframe>

					<?php } ?>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<!--pop up modal for bills view ends here-->
	<?php $mod_id++; } ?>

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
		    $("#timesheetreport tr").filter(function() {
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
