<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo base_url();?>">
				<i class="ti-home menu-icon"></i>
				<span class="menu-title">Dashboard</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
				<i class="ti-palette menu-icon"></i>
				<span class="menu-title">Clients</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="ui-basic">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?php echo site_url('clients/manage_clients/Client-List'); ?>">Manage Clients</a></li>
					<li class="nav-item"> <a class="nav-link" href="<?php echo site_url('clients/add_clients/Add-Client'); ?>">Add Clients</a></li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
				<i class="ti-view-list menu-icon"></i>
				<span class="menu-title">Scheduling</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="ui-advanced">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?php echo site_url('clients/create_schedule/Manage-Schedule'); ?>">Manage Schedule</a></li>
					<li class="nav-item"> <a class="nav-link" href="#" onclick="add_schedule()">Add Schedule</a></li>
				</ul>
			</div>
		</li>
		<?php/*<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
				<i class="ti-clipboard menu-icon"></i>
				<span class="menu-title">Accounting</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="form-elements">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"><a class="nav-link" href="#.">New Billing</a></li>                
					<li class="nav-item"><a class="nav-link" href="#.">Manage Billing</a></li>
				</ul>
			</div>
		</li>*/?>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
				<i class="ti-eraser menu-icon"></i>
				<span class="menu-title">Reports</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="editors">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('report/caregivers_expire_docs/Documents'); ?>">Caregiver Expired Docs</a></li>
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('report/today_appoi_report/Todays-Appointment'); ?>">Today's Appointment</a></li>
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('report/today_no_appoi_report/Todays-no-Appointment'); ?>"> No Schedule for Today</a></li>
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('report/dmas_report/DMAS-Report'); ?>">Provider Records</a></li>
					<!-- <li class="nav-item"><a class="nav-link" href="<?php //echo site_url('report/cms/CMS-1500'); ?>">CMS 1500</a></li> -->
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('report/download_fillable_form/Forms'); ?>">Downloadable and Fillable Form</a></li>
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('report/completed/Schedule'); ?>">Completed Schedule Report</a></li>
				</ul>
			</div>
		</li>
		<?php if($contact->is_primary == 1) { ?>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
				<i class="ti-bar-chart-alt menu-icon"></i>
				<span class="menu-title">Users</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="charts">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="<?php echo site_url('users/manage_user/User-List'); ?>">Manage Users</a></li>
					<li class="nav-item"> <a href="<?php echo base_url('users/add_user/Add-CareGiver');?>"class="nav-link">Add CareGiver</a></li>
				</ul>
			</div>
		</li>
		<!-- <li class="nav-item">
			<a class="nav-link" href="<?php echo site_url('clients/other_activity/Other-Activities'); ?>">
				<i class="ti-home menu-icon"></i>
				<span class="menu-title">Other Activities</span>
			</a>
		</li> -->
		<?php } ?>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#claims" aria-expanded="false" aria-controls="claims">
				<i class="ti-notepad menu-icon"></i>
				<span class="menu-title">Claims</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="claims">
				<ul class="nav flex-column sub-menu">
					<!-- <li class="nav-item"> <a class="nav-link" href="<?php //echo site_url('users/manage_user/User-List'); ?>">Manage Users</a></li> -->
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url('claims/claim/Claims'); ?>">Claims</a></li>
				</ul>
			</div>
		</li>
		
    </ul>
</nav>
<script>
	function add_schedule() {
		$('#title').html('Add Schedule');
		$('#add_schedule').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
</script>