<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>css/mystyle.css">
</head>
<body>
	<!-- Full page main wrapper start here and common all pages (include all page) -->
	<div class="page-wrapper" id="main-wrapper">


		<!-- Login and Regi page box start here -->
		<section class="loginReg">
			<div class="login-mainBox">
				<div class="login-row">
					<div class="login-logoBox">
						<img src="<?php echo base_url('assets/')?>images/icon/logo.svg" alt="logo">
					</div>
					<div class="login-formBox">
						<h5>Welcome! Please login to continue.</h5>
						<?php echo form_open('Authentication/login'); ?>
						<?php
				        if($this->session->flashdata('message')!=''){
				            $message    =   $this->session->flashdata('message');
				            if($message!=''){
				                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>!</strong> '.$message.'.</div>';
				            }
				            $this->session->unset_userdata('message');
				        }
				        ?>
						<!--<form action="authentication/login" method="post" id="loginform">-->
							<?php 
								if (isset($error_msg)) { ?>
									<div class="form-group col-md-12 alert alert-danger">
										<strong><?php echo $error_msg; ?></strong>
									</div>
								<?php }else if(isset($success_msg)) { ?>
									<div class="form-group col-md-12 alert alert-success">
										<strong><?php echo $success_msg; ?></strong>
									</div>
								<?php } else {
									echo "";
								}
								//echo "</div>";
							?>

							<div class="form-group icon-group">
								<input type="text" placeholder="UserName or email" name="userid" id="userid" class="form-control" required>
								<span class="form-icon"><img src="<?php echo base_url('assets/')?>images/icon/mail.svg" alt="Password Icon"></span>
							</div>
							<div class="form-group icon-group">
								<input type="password" placeholder="Password" name="password" id="password" class="form-control" required>
								<span class="form-icon"><img src="<?php echo base_url('assets/')?>images/icon/lock.svg" alt="Password Icon"></span>
							</div>
							<!-- <div class="form-group form-check">
							    <input type="checkbox" class="form-check-input" id="exampleCheck1">
							    <label class="form-check-label">Remember Me</label>
							    <label class="forgot-pass float-right"><a href="#">Forgot Password?</a></label>
							 </div> -->
							<div class="form-group">
								<input type="submit" value="Login" class="btn login-btn" name="btn_login">
							</div>
						<!--</form>-->
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</section>
		<!-- Login and Regi page box start here -->


	</div>
	<!-- Full page main wrapper End here and common all pages (include all page) -->
<script type="text/javascript" src="<?php echo base_url('assets/')?>js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/')?>js/bootstrap.min.js"></script>
</body>
</html>
