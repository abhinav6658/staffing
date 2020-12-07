<div class="dashboard-countBox">
	<h3 class="black-headingCommon">Add Documents</h3>
	<div class="formBox">
		<?php echo form_open_multipart('documents/do_upload/' . $this->uri->segment(2) . '')?>
			<div class="infiform-inline">
				<div class="form-group">
					<label>Select Consultant</label>
					<select class="form-control" name="vendor_emp_id">
						<?php 
						//print_r($consultant_data);
						foreach ($consultant_data as $row) { ?>
						<option value="<?php echo $row[0]['guid'] ?>"><?php echo $row[0]['name'] ?> </option>
						<?php } ?>
					</select>
					<div class="alert alert-danger" id="cosultant_id_error" style="display: none;">
						<span>Please Select Consultant</span>
					</div>
				</div>
				<input type="hidden" name="doc_type" value="<?php echo 1; ?>">
				<div class="form-group">
					<label>Document Name</label>
					<input type="text" name="doc_temp_name" class="form-control" placeholder="Type document name">
				</div>
				<div class="form-group">
					<label>Valid From</label>
					<input type="text" id="datepicker6" name="valid_from" value="" class="form-control dateicon datepicker">
				</div>
				<div class="form-group">
					<label>Valid To</label>
					<input type="text" id="datepicker7" name="valid_to" value="" class="form-control dateicon datepicker">
				</div>
				<div class="form-group files">
					<label>Upload file</label>
					<input type="file" class="form-control" name="fileupload">
				</div>
				<div class="alert alert-danger" id="fileupload_error" style="display: none;">
					<span>Please Select a File First</span>
				</div>
				<div class="form-group">
					<input type="submit" value="Upload file" class="btn submit-btn" name="submit">
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<!--Main content box end here -->