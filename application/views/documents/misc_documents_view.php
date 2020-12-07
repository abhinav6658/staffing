<div class="dashboard-countBox">
	<h3 class="black-headingCommon"><?php echo $breathcum; ?></h3>
</div>
<?php
// print_r($doc_type);
// echo "<br>";
// echo "<pre>";
//print_r($mapping_consul_data);
?>
<div class="document-leftPanel">
	<div class="document-row">
		<div class="cols3">
			<div class="document-listBox">
				<div class="user-center">
					<?php 
					//print_r($doc_data);
					//print_r($mapping_consul_data);
					if($doc_data){

						
						foreach($doc_data as $row) { ?>
							<div class="form-group">
								<?php echo "Welcome , ".$row['name'];
								echo "<br />";
								echo "Email : ".$row['email'];
								echo "<br>";
								echo "Contact : ".$row['phone'];
								$consult_type_var = $row['consultant_type'];
							} 
							if(!empty($mapping_consul_data)) { 
								foreach($mapping_consul_data as $map_value) { ?>
								<!--<div class="form-group" style="">-->
									<?php 
									echo "<br>";
									echo "Project : ".$map_value['project_name'];
									echo "<br>";
									echo "Location : ".$map_value['project_location']; 
								}
							}  ?>
							</div>
					<?php } else {
						foreach($vendor_data as $row) { ?>
							<div class="form-group">
								<?php echo $row['name'];
								echo "<br />";
								echo $row['email'];
								echo "<br>";
								echo $row['phone'];
								?> 
							</div>
						<?php	}
					}
					?>
				</div>
				<ul>
					<?php
					// print_r($documents); die;
					if(empty($documents)) {
						$success_var = 2;
					}
					// print_r($documents);
					foreach($doc_type as $doc_type_value){

						if($doc_type_value['doc_type_id']==24 &&$doc_type_value['doc_type_code']=='MSC')
						{ ?>
							<a href="<?php echo base_url('/') ?>miscellaneous-uploaded-list/<?php echo $this->uri->segment(2) ?>/<?php echo $doc_type_value['doc_type_id'] ?>">
						<li>		
							<?php
								foreach ($documents as $key => $doc_value) {
									//print_r($doc_value['doc_type']);
									// echo "<pre>";
									// print_r($doc_value);
									//print_r($documents);
									//echo "<br>".$doc_value['doc_type'];
									//echo "<br>".$doc_type_value['doc_type_id'];
									if($doc_value['doc_type'] == $doc_type_value['doc_type_id']){ 
										$today = date("Y-m-d H:i:s");
										if(strtotime($doc_value['valid_to']) > strtotime($today) || strtotime($doc_value['valid_to']) == '') { 
											$success_var = 1;
										} else { 
										//if(strtotime($doc_value['valid_to']) < strtotime($today)){ 
											$success_var = 0;
										} 
										unset($documents[$key]); 	
										$found = 1;
									} else {
										if($found == 0) {
											$success_var = 2;
										}
									}
								}
								//echo $success_var;
								// print_r($documents);
								// if(empty($documents)) {
								// 	$success_var = 10;
								// 	echo "<br>" . $success_var;
								// }
								?>

								<?php
								//$success_var = 2;
								if($success_var == 1) { ?>
									<img src="<?php echo base_url('assets/') ?>images/icon/circle-right.svg" alt="icon"> 
								<?php } else if($success_var == 0) { ?>
									<img src="<?php echo base_url('assets/') ?>images/icon/Expired.svg" alt="icon">
								<?php } else { ?>
									<img src="<?php echo base_url('assets/') ?>images/icon/required_icon.svg" alt="icon">
								<?php } //$success_var = 2; ?>

								<span><?php echo $doc_type_value['doc_type_name']; ?></span>		
						</li>

					</a>
					<?php	}
						else
						{ ?>
							<a href="<?php echo base_url('/') ?>document-list/<?php echo $this->uri->segment(2) ?>/<?php echo $doc_type_value['doc_type_id'] ?>">
						<li>		
							<?php
								foreach ($documents as $key => $doc_value) {
									//print_r($doc_value['doc_type']);
									// echo "<pre>";
									// print_r($doc_value);
									//print_r($documents);
									//echo "<br>".$doc_value['doc_type'];
									//echo "<br>".$doc_type_value['doc_type_id'];
									if($doc_value['doc_type'] == $doc_type_value['doc_type_id']){ 
										$today = date("Y-m-d H:i:s");
										if(strtotime($doc_value['valid_to']) > strtotime($today) || strtotime($doc_value['valid_to']) == '') { 
											$success_var = 1;
										} else { 
										//if(strtotime($doc_value['valid_to']) < strtotime($today)){ 
											$success_var = 0;
										} 
										unset($documents[$key]); 	
										$found = 1;
									} else {
										if($found == 0) {
											$success_var = 2;
										}
									}
								}
								//echo $success_var;
								// print_r($documents);
								// if(empty($documents)) {
								// 	$success_var = 10;
								// 	echo "<br>" . $success_var;
								// }
								?>

								<?php
								//$success_var = 2;
								if($success_var == 1) { ?>
									<img src="<?php echo base_url('assets/') ?>images/icon/circle-right.svg" alt="icon"> 
								<?php } else if($success_var == 0) { ?>
									<img src="<?php echo base_url('assets/') ?>images/icon/Expired.svg" alt="icon">
								<?php } else { ?>
									<img src="<?php echo base_url('assets/') ?>images/icon/required_icon.svg" alt="icon">
								<?php } //$success_var = 2; ?>

								<span><?php echo $doc_type_value['doc_type_name']; ?></span>		
						</li>

					</a>
					<?php	}
					 ?>
					
					
					<?php
						$success_var = 2;
						$found = 0;
						} 

					?>

				</ul>
			</div>
		</div>
		<div class="cols9">
			<div class="main-pagetable">

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
				<h2 class="infi-heading">Misc Uploaded Documents


				<div class="document-uploadBox">
					<a href="<?php echo base_url('/') ?>miscdoc-upload-page/<?php echo $this->uri->segment(2) ?>/<?php 
					foreach($doc_type as $row){
						$id=$this->uri->segment(3);
						if($row['doc_type_id']==$id){
							echo $row['doc_type_id']; } else{
								echo "";
							}
						}


						?>" class="submit-btn" id="upload">Upload</a>
					</div>
				</h2>

				<div class="table-responsive">
					<table class="table table-striped table-borderless">
						<thead>
							<tr>
								<th>Name</th>
								<th>Uploaded Date</th>
								<th>View/ Download</th>
								<th>Move Document</th>
								<th style="text-align: center;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$doc_typeid = $doc_type_filter[0]['doc_type'];
							if(!empty($this->uri->segment(3))) {
								$modal_id = 1;
								foreach($doc_type_filter as $filtered_data) {
									if($this->uri->segment(3) == $filtered_data['doc_type']){
										?>
										<tr>
											<?php 
								//print_r($doc_type_filter);
											/* Document view Link */
											$pathinfo = array_filter( explode('/', $filtered_data['doc_path'] ));
											$doc_folder_name = array_pop($pathinfo);
								//echo $doc_folder_name;
								//echo "<br>";
											$fileName = basename($doc_folder_name);
											$docfileName = array_filter( explode('DOC_', $fileName));	
											$documentfileName = array_pop($docfileName);
											$realdocfilename = $filtered_data['doc_name']; 
								//echo $documentfileName;
								//echo "<br>";
											$doc_ext = array_filter( explode('.', $filtered_data['doc_name'] ));
											$docExt = array_pop($doc_ext);
								//echo $docExt;
											/* Document view Link */
											$docName = basename($filtered_data['doc_name']);
											$doc_name = preg_replace("/\.[^.]+$/", "", $docName);
											
								//echo $doc_name;
											?>
											<td><?php
													if($filtered_data['doc_temp_name'] == NULL) {
														echo $doc_name;
													} else {
														echo $filtered_data['doc_temp_name'];
													}
											 ?></td>

											<?php 
											$valid_from_timestamp = strtotime($filtered_data['valid_from']);
											$valid_from = date('M j, Y', $valid_from_timestamp);
                                	//echo $valid_from;
											$valid_to_timestamp = strtotime($filtered_data['valid_to']);
											$valid_to = date('M j, Y', $valid_to_timestamp);

											?>
											
											<td><?php 
												$uploaded_date = strtotime($filtered_data['uploaded_on']);
											echo date('M j, Y', $uploaded_date); ?></td>
											<td>
												<ul class="table-actionBtn">
													<!--<a href="<?=base_url('assets/uploads/'.$doc_folder_name .'/' . $documentfileName .'.'. $docExt)?>" target="_blank">Download</a>-->

													<li><a href="<?php echo base_url() ?>document-list/<?php echo $filtered_data['doc_id'] ?>" target="_blank" data-toggle="modal" data-target="#documentModal_<?php echo $modal_id; ?>"><img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="View"></a>
														 / <a href="<?=base_url('assets/uploads/'.$doc_folder_name .'/' . $realdocfilename)?>" target="_blank">Download File
												</a>
													</li>
												</ul>
											</td>
											<td>
											<?php
                           
                                $action =   base_url()."Documents/move_misc_document";
                            
                            echo form_open_multipart($action);
                           			?>

										<input type="hidden" name="uri2" id="uri2" value="<?php echo $this->uri->segment(2) ?>">

										<input type="hidden" name="uri3" id="uri3" value="<?php echo $this->uri->segment(3) ?>">

										<input type="hidden" name="id" id="id" value="<?php echo $filtered_data['doc_id']; ?>">

										<input type="hidden" name="doc_id" id="doc_id" value="<?php echo $row['doc_type_id'] ?>">
												
												<ul class="table-actionBtn">

													<li>
														<div class="infiform-inline">
															<div class="form-group" style="width: 100%">
																
																<select class="form-control" name="doc_type" id="doc_type">
																	<?php foreach ($doc_type as $row) { ?>
																	<option value="<?php echo $row['doc_type_id'] ?>"><?php echo $row['doc_type_name'] ?> </option>
																	<?php } ?>
																</select>
																
															</div>
														</div>
													</li>
												
												<li>
													<button class="action-button submit-btn move_doc" style="margin-top: 0px;border: none;" >Move</button>
												
												</li>
											
												</ul>
												<?php echo form_close(); ?>
											</td>
											<td width="5%">
												<ul class="table-actionBtn">
												<li>
													 <a style="color: blue;" href="<?php echo base_url('Documents/delete_misc_document'); ?>/<?php echo $this->uri->segment(2) ?>/<?php echo $this->uri->segment(3) ?>?action=edit&id=<?php echo $filtered_data['doc_id']; ?>" onclick="return confirm('Are you sure?')"><img src="<?php echo base_url('assets/') ?>images/icon/delete.svg" alt="View"></a>
													 </li>
											
											
											
												</ul>
											</td>


										</tr>

										<?php	
									}
									$modal_id++;								
								}

							}else if(!empty($doc_type_filter) && $this->uri->segment(3) == NULL) { 
								$consult_id = $this->uri->segment(2);
								$consult_guid  = $doc_data[0]['guid'];
								// foreach($data['doc_data'] as $consult_value) { 
								// 	$consult_type_var = $consult_value['consultant_type']; 
								// }
								// echo $consult_type_var;
								$modal_id = 1;
						//print_r($doc_type_filter);
								foreach($doc_type_filter as $documents_value){


									/* Document view Link */
									$pathinfo = array_filter( explode('/', $documents_value['doc_path'] ));
									$doc_folder_name = array_pop($pathinfo);
								//echo $doc_folder_name;
								//echo "<br>";
									$fileName = basename($doc_folder_name);
									$docfileName = array_filter( explode('DOC_', $fileName));	
									$documentfileName = array_pop($docfileName);
								//echo $documentfileName;
								//echo "<br>";
									$doc_ext = array_filter( explode('.', $documents_value['doc_name'] ));
									$docExt = array_pop($doc_ext);
								//echo $docExt;
									/* Document view Link */

									$docName = basename($documents_value['doc_name']);
									$doc_name = preg_replace("/\.[^.]+$/", "", $docName);
							 	//echo $doc_name; 
									?>
									<tr>
										<td><?php
												if($documents_value['doc_temp_name'] == NULL) {
													echo $doc_name;
												} else {
													echo $documents_value['doc_temp_name'];
												}
										?></td>
										<?php 
										$valid_from_timestamp = strtotime($documents_value['valid_from']);
										$valid_from = date('M j, Y', $valid_from_timestamp);
                                	//echo $valid_from;
										$valid_to_timestamp = strtotime($documents_value['valid_to']);
										$valid_to = date('M j, Y', $valid_to_timestamp);
										?>
										<td><?php if($documents_value['valid_from']){ echo $valid_from; }  ?></td>
										<td><?php if($documents_value['valid_to']){ echo $valid_to; } ?></td>
										<td><?php 
												$uploaded_date = strtotime($documents_value['uploaded_on']);
											echo date('M j, Y', $uploaded_date); ?></td>
										<td>
											<ul class="table-actionBtn">
												<!--<a href="<?=base_url('assets/uploads/'.$doc_folder_name .'/' . $documentfileName .'.'. $docExt)?>" target="_blank">Download</a>-->

												<li><a href="<?=base_url('assets/uploads/'.$doc_folder_name .'/' . $documentfileName .'.'. $docExt)?>" target="_blank" data-toggle="modal" data-target="#documentModal_<?php echo $modal_id; ?>"><img src="<?php echo base_url('assets/') ?>images/icon/view.svg" alt="View">
												</a> / <a href="<?=base_url('assets/uploads/'.$doc_folder_name .'/' . $documentfileName .'.'. $docExt)?>" target="_blank">Download File
												</a>
												</li>
											</ul>
										</td>
										<td width="5%">
										<ul class="table-actionBtn">
											<li>
												 <a style="color: blue;" href="<?php echo base_url('Documents/delete_document'); ?>/<?php echo $this->uri->segment(2) ?>?action=edit&id=<?php echo $documents_value['doc_id']; ?>" onclick="return confirm('Are you sure?')"><img src="<?php echo base_url('assets/') ?>images/icon/delete.svg" alt="View"></a>
												 </li>
											<!--
											<li><a href="#"><img src="assets/images/icon/delete.svg" alt="Delete"></a></li>-->
											
											
												</ul>
										</td>
									</tr>
									<?php
									$modal_id++;
							//}
								}
							} 
							else {
								echo "<tr><td>No records found</td></tr>";
							}
							?>
						</tbody>
					</table>
					<?php echo $pagination; 
	//echo $total_rows;
					?>
				</div>
			</div>

			<?php
	// print_r($doc_type_filter);
			$i = 0;
			$dName_array = array();
			foreach($doc_type_filter as $documents_value){


				/* Document view Link */
				$pathinfo = array_filter( explode('/', $documents_value['doc_path'] ));
				$doc_folder_name = array_pop($pathinfo);
								//echo $doc_folder_name;
								//echo "<br>";
				$fileName = basename($doc_folder_name);
				$docfileName = array_filter( explode('DOC_', $fileName));	
				// $documentfileName = array_pop($docfileName);
				$realdocfilename = $documents_value['doc_name']; 
								//echo $documentfileName;
								//echo "<br>";
				$doc_ext = array_filter( explode('.', $documents_value['doc_name'] ));
				$docExt = array_pop($doc_ext);
								//echo $docExt;
				/* Document view Link */

				$dName_array[$i] = array(
					'doc_folder_name' => $doc_folder_name,
					'documentfileName'=> $realdocfilename,
					'docExt'		  => $docExt
				);
				$i++;
	//print_r($dName_array);
	//foreach($dName_array as $doc_full_name) {
		//echo $doc_full_name['docExt'];
			}
			$mod_id = 1;
	//print_r($dName_array);
			foreach ($dName_array as $dName_array_value) {
				$arr_doc_folder_name  = $dName_array_value['doc_folder_name'];
				$arr_documentfileName = $dName_array_value['documentfileName'];
				$arr_docExt           = $dName_array_value['docExt'];

				?>
				<!--pop up modal for document view -->
				<div class="modal fade documentModal-modal-lg" id="documentModal_<?php echo $mod_id; ?>" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="documentModalLabel">Document View</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?php if($arr_docExt == 'pdf'){ ?>
									<iframe src="<?=base_url('assets/uploads/'.$arr_doc_folder_name .'/' . $arr_documentfileName)?>" style="width:100%; height:500px;" style="overflow: hidden; "frameborder="0" marginheight="0" marginwidth="0"></iframe>

								<?php } else { ?>
									<iframe src="http://docs.google.com/gview?url=<?=base_url('assets/uploads/'.$arr_doc_folder_name .'/' . $arr_documentfileName .'.'. $arr_docExt)?>" style="width:100%; height:500px;" style="overflow: hidden; "frameborder="0" marginheight="0" marginwidth="0"></iframe>

								<?php } ?>
								<!--<iframe width="100%" height="500" style="overflow: hidden;" src="http://docs.google.com/gview?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>-->
							</div>
							<div class="modal-footer">
						<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<a href="download-file" target="_blank" class="btn btn-info">Download</a>-->

						</div>
					</div>
				</div>
			</div>
			<!--pop up modal for document view ends here-->
			<?php $mod_id++; } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(".move_doc").click(function(e) {
		e.preventDefault();
		alert('abhinav');

		var doc_type       = jQuery("#doc_type").val();
		var uri2       = jQuery("#uri2").val();
		var uri3       = jQuery("#uri3").val();
		var id       = jQuery("#id").val();
		var doc_id       = jQuery("#doc_id").val();

		alert('doc_type'); die;

	}
</script>