<!-- Top main header start here -->

<?php 

			$user_type = $this->session->userdata['user_type'];
			// echo $user_type; die;
			if($user_type!='1'){
				$this->session->sess_destroy();
				$this->load->view('authentication/login');
           		// redirect(base_url().'authentication/logout');
        	}

		$email = $this->session->userdata['email'];

		$consultdatasole = $this->global_model->get_data('panel_consultanttbl', array('email'=> $email, 'order_by' => 'consultant_id', 'cond' => 'DESC'));


?>
<header>
	<nav class="navbar navbar-expand-lg navbar-light">
		<a class="navbar-brand" href="<?php echo base_url('dashboardsole'); ?>"><img src="<?php echo base_url('assets/')?>images/icon/logo.svg" class="top-logo" alt="logo"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="<?php echo base_url(); ?>dashboardsole"><span><img src="<?php echo base_url('assets/')?>images/menu-icon/dashboard.svg" alt="menu icon"></span> Dashboard <span class="sr-only">(current)</span></a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="#"><span><img src="assets/images/menu-icon/document.svg" alt="menu icon"></span> Documents</a>
				</li> -->
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() ?>document-list/<?php echo $consultdatasole[0]['consultant_id'] ?>"><span><img src="<?php echo base_url('assets/') ?>images/menu-icon/document.svg" alt="Document"></span> Upload Documents</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('time-sheet');?>"><span><img src="<?php echo base_url('assets/')?>images/menu-icon/timesheet.svg" alt="menu icon"></span> Time and expense</a>
				</li> -->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span><img src="<?php echo base_url('assets/')?>images/menu-icon/timesheet.svg" alt="menu icon"></span> Time & Expense
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<!--<a class="dropdown-item" href="#">Assign Consultant</a>
						<a class="dropdown-item" href="#">Add Consultant</a>
						<a class="dropdown-item" href="#">Add Vendor</a>-->
						<a class="dropdown-item" href="<?php echo base_url('timesheet-sole');?>">Add Time-expense</a>

						<a class="dropdown-item" href="<?php echo base_url('timesheet-report-sole');?>">Time-Expense Report</a>
						
						<!-- <a class="dropdown-item" href="<?php //echo base_url('association');?>">Mapping</a> -->
				     </div>
				 </li>
				 <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span><img src="<?php echo base_url('assets/')?>images/menu-icon/bills.svg" alt="menu icon"></span> Bills
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<!--<a class="dropdown-item" href="#">Assign Consultant</a>
						<a class="dropdown-item" href="#">Add Consultant</a>
						<a class="dropdown-item" href="#">Add Vendor</a>-->
						<a class="dropdown-item" href="<?php echo base_url('bills-sole');?>">Upload Bills</a>

						<a class="dropdown-item" href="<?php echo base_url('bills-sole-report');?>">Bills Report</a>
						
						<!-- <a class="dropdown-item" href="<?php //echo base_url('association');?>">Mapping</a> -->
				     </div>
				 </li>

				 
			</ul>
			<!-- Header right side user profile dropdown box start here-->
			<div class="my-2 my-lg-0">
				<ul class="navbar-nav">
					<!--<li class="nav-item">
						<a class="nav-link" href="#"><i class="far fa-bell"></i></a>
					</li>-->
					<li class="nav-item dropdown userdropdownlist">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="mr-2 d-none d-lg-inline text-gray-600 small">
								<?php if($this->session->userdata('email')!=NULL) { echo $this->session->userdata('email'); }?>
							</span>
							<img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
						</a>
						<!-- Dropdown - User Information -->
						<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
							<!-- <a class="dropdown-item" href="#">
								<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
								Profile
							</a>
							<div class="dropdown-divider"></div> -->
							<a class="dropdown-item" href="<?php echo base_url('login'); ?>">
								<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
								Logout
							</a>
						</div>
					</li>
				</ul>
			</div>
			<!-- Header right side user profile dropdown box End here-->
		</div>
	</nav>
</header>
<!-- Top main header end here -->

