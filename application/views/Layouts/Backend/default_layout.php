<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php if (isset($title)){ echo $title; } ?></title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="<?php echo base_url('assets/')?>images/favicon.ico" type="image/x-icon" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>css/all.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/')?>css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/')?>css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>css/mystyle.css">

	<script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/bootstrap.min.js"></script>
	<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<script>
		$(document).ready(function() {
			setTimeout(function() {
				$('body').addClass('loaded');
			}, 500);
			$(".js-example-basic-single").select2();
			
		});
	</script>
</head>
<body>
	<div id="loader-wrapper">
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
		<div class="loader-section section-right"></div>
	</div>
	<div class="page-wrapper" id="main-wrapper">
		<!-- Navigation -->
		<?php $this->load->view('Layouts/Backend/header'); ?>
		<!-- end Navigation -->
		<section class="mainBox-content">
			<div class="container-fluid percent">
				<div class="row percent">
					<!--Right sidebar content area start here -->
					<div class="col-lg-12 percent nopadding">
						<div class="inficare-scrollBar">
							<!-- Page Content -->
							<?php echo $contents; ?>
							<!-- Page Content -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php $this->load->view('Layouts/Backend/footer'); ?>
	</div>

<!-- plugins:js -->
<script src="<?php echo base_url('assets/'); ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>js/myscript.js"></script>
<script>
	$(document).ready(function() { 
		$("#accordian a").click(function() {
			var link = $(this);
			var closest_ul = link.closest("ul");
			var parallel_active_links = closest_ul.find(".active");
			var closest_li = link.closest("li");
			var link_status = closest_li.hasClass("active");
			var count = 0;

			closest_ul.find("ul").slideUp(function() {
				if (++count == closest_ul.find("ul").length)
					parallel_active_links.removeClass("active");
			});

			if (!link_status) {
				closest_li.children("ul").slideDown();
				closest_li.addClass("active");
			}
		});
	});
</script>
</body>
</html>