<!--Main content box start here -->
<section class="mainBox-content">
	<div class="container-fluid percent">
		<div class="row percent">
			<!--Right sidebar content area start here -->
			<div class="col-lg-12 percent nopadding">
				<div class="inficare-scrollBar">
					<div class="custome-box cpadding">
						<h2 class="infi-heading">Documents Type<span class="rightAddbtn"><!--<a href="#"><img src="assets/images/icon/add.svg" alt="Add Icon"></a>--></span></h2>
						<div class="main-pagetable">
							<div class="table-responsive">
								<table class="table table-striped table-borderless">
									<thead>
										<tr>
											<th>Documents Type</th>
											<th width="10%">Document Type Code</th>
											<th>User Type</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
									<?php
										$slno = 1;
										//print_r($value);
										if(!empty($doc_data)){
											foreach($doc_data as $row){

									?>
										<tr>
											<!--<td><?php echo $slno++; ?></td>-->
											<td><?php echo $row['doc_type_name']; ?></td>
											<td><?php echo $row['doc_type_code']; ?></td>
											<td><?php if($row['is_user_doc_type'] == '1') {
												echo "W2 Consultant";
											} else if($row['is_user_doc_type'] == '2') {
												echo "C2C Consultant";
											} else if($row['is_user_doc_type'] == '3'){
												echo "1099";
											} else if($row['is_user_doc_type'] == '4'){
												echo "Vendor Documents";
											} else if($row['is_user_doc_type'] == '5'){
												echo "Company Documents";
											} else {
												echo " ";
											}
											?></td>
											<!--
											<td>
												<ul class="table-actionBtn">
													<li><a href="#"><img src="assets/images/icon/view.svg" alt="View"></a></li>
													<li><a href="#"><img src="assets/images/icon/edit.svg" alt="Edit"></a></li>
												</ul>
											</td>
										-->
										</tr>
									<?php }
										} else {
												echo "No records found";
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Right sidebar content area end here -->
		</div>
	</div>
</section>
<!--Main content box end here -->
