<!--Main content box start here -->
<section class="mainBox-content">
	<div class="container-fluid percent">
		<div class="row percent">
			<!--Right sidebar content area start here -->
			<div class="col-lg-12 percent nopadding">
				<div class="inficare-scrollBar">
					<div class="custome-box cpadding">
						<h2 class="infi-heading">Consultant Type<span class="rightAddbtn"><!--<a href="#"><img src="assets/images/icon/add.svg" alt="Add Icon"></a>--></span></h2>
						<div class="main-pagetable">
							<div class="table-responsive">
								<table class="table table-striped table-borderless">
									<thead>
										<tr>
											<th>Sl#</th>
											<th>Consultant Type</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
									<?php
										$slno = 1;
										//print_r($value);
										if(!empty($contype_data)){
											foreach($contype_data as $row){

									?>
										<tr>
											<td><?php echo $slno++; ?></td>
											<td><?php echo $row['consultant_type_name']; ?></td>
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
