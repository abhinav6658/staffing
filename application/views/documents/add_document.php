<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $breathcum ?></h3>
	<div class="formBox">
		<?php //echo $this->uri->segment(2); 
			 $is_user_doc_type = $doc_type[0]['is_user_doc_type']; 
		
		?>
		<?php echo form_open_multipart('documents/do_upload/' . $this->uri->segment(2) . '/' .  $is_user_doc_type, array('id'=>'document_form')); ?>
		<?php if($this->uri->segment(3)){ ?>
			<div class="infiform-inline">
				<div class="form-group">
					<label>Select document type</label>
					<?php $doc_typeid = $this->uri->segment(3); ?>
					<select class="form-control" name="doc_type" id="doc_type" disabled>
						<?php foreach ($doc_type as $row) { ?>
							<option <?php if($doc_typeid == $row['doc_type_id']){ echo 'selected="selected"'; } ?> value="<?php echo $row['doc_type_id'] ?>"><?php echo $row['doc_type_name'] ?> </option>
						<?php } ?>
					</select>
					<div class="alert alert-danger" id="doc_type_error" style="display: none;">
						<span>Please Select Document Type</span>
					</div>
				</div>
				<input type="hidden" name="vendor_emp_id" value="<?php 
					if($con_data){
							echo $con_data[0]['guid'];
						} else {
							echo $vendor_data[0]['guid'];
						}
				 ?>">
				<div class="form-group">
					<label>Document Name</label>
					<input type="text" name="doc_temp_name" class="form-control" placeholder="Type document name">
				</div>
				<?php 
					//echo $doc_type[12]['doc_type_code'];
				$doctypeid = $this->uri->segment(3);
				foreach($doc_type as $doc_type_value){
					if($doc_type_value['doc_type_id'] == $doctypeid) {
						//if($doc_type_code == "COI" && $doc_type_code == "PPT" && $doc_type_code == "DLC" && $doc_type_code == "VISA" && $doc_type_code == "EVE") {
							$doc_type_code = $doc_type_value['doc_type_code']; 
						//}
					}
				}
				//echo $doc_type_code;
				if($doc_type_code == "COI" || $doc_type_code == "PPT" || $doc_type_code == "DLC" || $doc_type_code == "VISA" || $doc_type_code == "EVE") { ?>
					<div class="form-group">
						<label>Valid From</label>
						<input type="text" id="datepicker4" name="valid_from" value="" class="form-control dateicon datepicker" required>
					</div>
					<div class="alert alert-danger" id="valid_from_error" style="display: none;">
						<span>Please Enter Valid From Date</span>
					</div>
					<div class="form-group">
						<label>Valid To</label>
						<input type="text" id="datepicker5" name="valid_to" value="" class="form-control dateicon datepicker" required>
					</div>
					<div class="alert alert-danger" id="valid_to_error" style="display: none;">
						<span>Please Enter Valid To Date</span>
					</div>

				<?php } else { ?>
					<div class="form-group">
						<label>Valid From</label>
						<input type="text" id="datepicker44" name="valid_from" value="" class="form-control dateicon datepicker">
					</div>
					<div class="form-group">
						<label>Valid To</label>
						<input type="text" id="datepicker55" name="valid_to" value="" class="form-control dateicon datepicker">
					</div>

				<?php }  ?>
				
				<div class="form-group files">
					<label>Upload file</label>
					<input type="file" class="form-control" name="fileupload" id="fileupload">
					<!--<input class="btn btn-info" type="button" value="Upload File" />-->
				</div>
				<div class="alert alert-danger" id="fileupload_error" style="display: none;">
					<span>Please Select a File First</span>
				</div>
				<div class="form-group">
					<input type="submit" id="submit" value="Upload file" class="btn submit-btn" name="submit">
				</div>
			</div>
		<?php } else { ?>
			<div class="infiform-inline">
				<div class="form-group">
					<label>Select document type</label>
					<select class="form-control" name="doc_type" id="doc_type">
						<?php foreach ($doc_type as $row) {
							if($row['doc_type_id']!='24')
							{ ?>
								<option value="<?php echo $row['doc_type_id'] ?>"><?php echo $row['doc_type_name'] ?> </option>
						<?php }} ?>

						 ?>
						
					</select>
					<!--<input type="text" name="doc_type_code" id="doc_type_code" value="">-->
					<div class="alert alert-danger" id="doc_type_error" style="display: none;">
						<span>Please Select Document Type</span>
					</div>
				</div>
				<input type="hidden" name="vendor_emp_id" value="<?php 
					if($con_data) {
							echo $con_data[0]['guid'];
						} else {
							echo $vendor_data[0]['guid'];
						}

				 ?>">
				<div class="form-group">
					<label>Document Name</label>
					<input type="text" name="doc_temp_name" class="form-control" placeholder="Type document name">
				</div>

				<div class="form-group" id="doc1">
					<label>Valid From</label>
					<input type="text" id="datepicker6" name="valid_from" value="" class="form-control dateicon datepicker">
				</div>
				<div class="form-group" id="doc2">
					<label>Valid To</label>
					<input type="text" id="datepicker7" name="valid_to" value="" class="form-control dateicon datepicker">
				</div>
				<div class="form-group files">
					<label>Upload file </label>
					<input type="file" class="form-control" name="fileupload" id="fileupload">
				</div>
				<div class="alert alert-danger" id="fileupload_error" style="display: none;">
					<span>Please Select a File First</span>
				</div>
				<div class="form-group">
					<input type="submit" id="submit" value="Upload file" class="btn submit-btn" name="submit">
				</div>
			</div>
		<?php
			}
			echo form_close();
		?>
	</div>
</div>
<script type="text/javascript">
	jQuery("#doc_type").keydown(function() {
		jQuery("#doc_type_error").hide();
	});
	jQuery("#datepicker4").keydown(function() {
		jQuery("#valid_from_error").hide();
	});
	jQuery("#datepicker5").keydown(function() {
		jQuery("#valid_to_error").hide();
	});
	jQuery("#fileupload_error").hide();

	jQuery(function ($) {        
	  $('form').bind('submit', function () {
	    $(this).find(':input').prop('disabled', false);
	  });
	});

	jQuery("#doc_type").change(function() {
		//alert();
		var select_doc_type = jQuery("#doc_type").val();
		jQuery.ajax({
			url: "<?php echo base_url('Documents/getDocType');?>",
			type: "GET",
			data: {
				doc_type_id: select_doc_type,
			},
			success: function(response) {
				//alert($.trim(response));
				//jQuery("#doc_type_code").val(response);
				if($.trim(response) == "COI" || $.trim(response) == "PPT" || $.trim(response) == "DLC" || $.trim(response) == "VISA" || $.trim(response) == "EVE") {
					//alert();
					//jQuery('#datepicker6').prop('required',false);
					jQuery("#datepicker6").attr('required', true);
					jQuery("#datepicker7").attr('required', true);
				} else {
					jQuery("#datepicker6").attr('required', false);
					jQuery("#datepicker7").attr('required', false);
				} 
			}
		});
	});
	jQuery("#submit").click(function(e) { 
		//alert();
		var doc_type 	 = jQuery("#doc_type").val();
		var valid_from   = jQuery("#datepicker4").val();
		var valid_to     = jQuery("#datepicker5").val();
		var fileupload   = jQuery("#fileupload").val();
			//alert("Fill all the fields.");
			if(doc_type != ""  && valid_from != ""  && valid_to != ""  && fileupload != "") {
				jQuery("#document_form").submit();
			} else {
				e.preventDefault();
				if(doc_type  == "") {
					jQuery("#doc_type_error").show();
				}
				if(valid_from == "") {
					jQuery("#valid_from_error").show();
				}
				if(valid_to == "") {
					jQuery("#valid_to_error").show();
				}
				if(fileupload == "") {
					jQuery("#fileupload_error").show();
				}
			}	
	});
</script>
<!--Main content box end here -->
