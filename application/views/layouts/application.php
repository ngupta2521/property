<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($this->session->userdata['user'])) {
	redirect("user/login");
}
?>
	<head>
		<meta charset="utf-8" />
		<title>Dashboard - Ace Admin</title>
		<meta name="description" content="overview &amp; stats" />
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
		<link rel="stylesheet" href="<?php echo asset_url().'assets/css/ace-skins.min.css';?>" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo asset_url().'assets/css/ace-ie.min.css';?>" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="<?php echo asset_url().'assets/js/ace-extra.min.js';?>"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo asset_url().'assets/js/html5shiv.js';?>"></script>
		<script src="<?php echo asset_url().'assets/js/respond.min.js';?>"></script>
		<![endif]-->
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
		<script src="<?php echo asset_url().'assets/js/bootstrap.min.js';?>"></script>
		<script src="<?php echo asset_url().'assets/js/bootbox.min.js';?>"></script>
	</head>

	<body>
		<?php include 'component/_top_header.php'; ?>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				

				<?php include 'component/_left_sidebar_menu.php'; ?>

				<div class="main-content">
					<?php include 'component/_breadcrumbs.php'; ?>
					<div class="page-content">
						<?php include 'component/_page_header.php'; ?>
						<?php echo $yield;?>
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<div id="modal-table" class="modal fade" tabindex="-1"></div>
		<!-- PAGE CONTENT ENDS -->
		<!--<div id="placeholder" class="demo-placeholder"></div>-->
				<script src="<?php echo asset_url().'assets/js/typeahead-bs2.min.js';?>"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo asset_url().'assets/js/excanvas.min.js';?>"></script>
		<![endif]-->
		<script src="<?php echo asset_url().'assets/js/jquery-ui-1.10.3.custom.min.js';?>"></script>
		<!--<script src="<?php //echo asset_url().'assets/js/jquery.ui.touch-punch.min.js';?>"></script>
		<script src="<?php //echo asset_url().'assets/js/jquery.slimscroll.min.js';?>"></script>
		<script src="<?php //echo asset_url().'assets/js/jquery.easy-pie-chart.min.js';?>"></script>
		<script src="<?php //echo asset_url().'assets/js/jquery.sparkline.min.js';?>"></script>
		<script src="<?php //echo asset_url().'assets/js/flot/jquery.flot.min.js';?>"></script>
		<script src="<?php //echo asset_url().'assets/js/flot/jquery.flot.pie.min.js';?>"></script>
		<script src="<?php //echo asset_url().'assets/js/flot/jquery.flot.resize.min.js';?>"></script>-->

		<!-- ace scripts -->

		<script src="<?php echo asset_url().'assets/js/ace-elements.min.js';?>"></script>
		<script src="<?php echo asset_url().'assets/js/ace.min.js';?>"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
		$(document).on('click', '.js_delete_btn',function(e){
		e.preventDefault();
		var data_url= $(this).data('url');
		bootbox.dialog(
				{
					message:'Are you sure you want to delete this record.',
					buttons: {								
						success:{ 
							label: 'Confirm',
							className: 'btn btn-success',
							callback:function (result) {					
								if (result) {
										location.href=data_url;
									}
								}
						},
						danger:{
							label: 'Cancel',
							className: 'btn btn-danger',
						}							
		}});
	});
		</script>
	</body>
</html>
