<div class="heading-noborder">
	<font color="#C97B29">Old Bills Report</font>
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
							<th>Vendor Name</th>
							<th>Consultant Name</th>
							<th>Date From</th>
							<th>Date To</th>
							<th>Timesheet Hours</th>
							<th>Bill Hours</th>
							<th>View/Download</th>
							<th>Delete</th>
						</tr>
				</thead>
				<tbody  id="billreport">
						<?php 
				// print_r($bills_data); die;
				echo $timesheet[0]['total_hrs'];
						if(!empty($bills_data)) {
							$modal_id = 1;
							foreach($bills_data as $bills_data_value) {


							 ?>
								<tr>

									<td><?php if($bills_data_value['vendor_name']) { echo $bills_data_value['vendor_name']; } else { echo "W2 Consultant"; } ?></td>
									<td><?php echo $bills_data_value['consult_name'] ?></td>
									<td><?php if($bills_data_value['date_from']) { echo date('m-d-Y', strtotime($bills_data_value['date_from'])); }?></td>
									<td><?php if($bills_data_value['date_to']) { echo date('m-d-Y', strtotime($bills_data_value['date_to'])); } ?></td>
									<td><?php /*if($timesheet[0]['vendor_id'] == $bills_data_value['vendor_id'] && $timesheet[0]['consultant_id'] == $bills_data_value['consultant_id']) {
										echo $timesheet[0]['total_hrs'];
									}*/
									echo $bills_data_value['ts_total_hrs'];
									?></td>
									<td><?php echo $bills_data_value['bill_total_hrs']; ?></td>
									<td><?php 
									//echo $bills_data_value['file_path'];
									/* File view Link */
									$pathinfo = array_filter( explode('/', $bills_data_value['file_path']));
									$file_folder_name = array_pop($pathinfo);

									$fileName = basename($file_folder_name);
									$TfileName = array_filter( explode('FILE_', $fileName));	
									$TempfileName = array_pop($TfileName);
									
									$file_ext = array_filter( explode('.', $bills_data_value['file_name'] ));
									$fileExt = array_pop($file_ext);
									/* File view Link */

									?>
									<ul class="table-actionBtn">
										
										<li><a href="<?=base_url('assets/uploads/'.$file_folder_name .'/' . $TempfileName .'.'. $fileExt)?>" target="_blank" data-toggle="modal" data-target="#billsModal_<?php echo $modal_id; ?>"><img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="View"></a> / <a href="<?=base_url('assets/uploads/'.$file_folder_name .'/' . $TempfileName .'.'. $fileExt)?>" target="_blank">Download File</a>
										</li>

										<!--<li><a href="#"><img src="<?php echo base_url('assets/'); ?>images/icon/delete.svg" alt="Delete"></a></li>-->

									</ul>
								</td>
							
								<td>
										<ul class="table-actionBtn">
											<li>
												 <a style="color: blue;" href="<?php echo base_url('Billssole/delete_bills'); ?>?action=edit&id=<?php echo $bills_data_value['bill_id']; ?>" onclick="return confirm('Are you sure?')"><img src="<?php echo base_url('assets/') ?>images/icon/delete.svg" alt="View"></a>
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
foreach($bills_data as $bills_data_value) {

	/* File view Link */
	$pathinfo = array_filter( explode('/', $bills_data_value['file_path']));
	$file_folder_name = array_pop($pathinfo);

	$fileName = basename($file_folder_name);
	$TfileName = array_filter( explode('FILE_', $fileName));	
	$TempfileName = array_pop($TfileName);

	$file_ext = array_filter( explode('.', $bills_data_value['file_name'] ));
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
	<div class="modal fade billsModal-modal-lg" id="billsModal_<?php echo $mod_id; ?>" tabindex="-1" role="dialog" aria-labelledby="billsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="billsModalLabel">Billls View</h5>
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
		window.location.href="<?php echo base_url('bills-report'); ?>"
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
		    $("#billreport tr").filter(function() {
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
