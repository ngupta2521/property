<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Login Page - Ace Admin</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo asset_url().'assets/css/bootstrap.min.css';?>" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo asset_url().'assets/css/font-awesome.min.css';?>" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo asset_url().'assets/css/font-awesome-ie7.min.css';?>" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="<?php echo asset_url().'assets/css/ace-fonts.css';?>" />

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo asset_url().'assets/css/ace.min.css';?>" />
		<link rel="stylesheet" href="<?php echo asset_url().'assets/css/ace-rtl.min.css';?>" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo asset_url().'assets/css/ace-ie.min.css';?>" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo asset_url().'assets/js/html5shiv.js';?>"></script>
		<script src="<?php echo asset_url().'assets/js/respond.min.js';?>"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">Ace</span>
									<span class="white">Application</span>
								</h1>
								<h4 class="blue">&copy; Company Name</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<?php echo $yield;?>
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo asset_url()."assets/js/jquery-2.0.3.min.js";?>'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo asset_url()."assets/js/jquery-1.10.2.min.js";?>'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo asset_url()."assets/js/jquery.mobile.custom.min.js";?>'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>
	</body>
</html>
