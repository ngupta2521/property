<a class="menu-toggler" id="menu-toggler" href="#">
	<span class="menu-text"></span>
</a>
<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<!--<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>-->
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<!--<li>
							<a href="<?php echo site_url('welcome'); ?>">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> Dashboard </span>
							</a>
						</li>
						<li <?php if ($this->router->class=="user"){?>class="active" <?php } ?> >
							<a href="#" class="dropdown-toggle">
								<i class="icon-user"></i>
								<span class="menu-text"> User </span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="<?php echo site_url('user/register'); ?>">
										<i class="icon-double-angle-right"></i>
										User Register
									</a>
								</li>
								<li>
									<a href="<?php echo site_url('user/list'); ?>">
										<i class="icon-double-angle-right"></i>
										User List
									</a>
								</li>
							</ul>
						</li> -->
						<li <?php if ($this->router->class=="property"){?>class="active" <?php } ?>>
							<a href="<?php echo site_url('property/manage'); ?>" class="dropdown-toggle">
								<i class="icon-home"></i>
								<span class="menu-text"> Manage Property </span>
							</a>
						</li>
						<li <?php if ($this->router->class=="report"){?>class="active" <?php } ?>>
							<a href="<?php echo site_url('report/reportlist'); ?>" class="dropdown-toggle">
								<i class="icon-barcode"></i>
								<span class="menu-text"> View Report </span>
							</a>
						</li>

						<li <?php if ($this->router->class=="message"){?>class="active" <?php } ?>>
							<a href="<?php echo site_url('message/messagelist'); ?>" class="dropdown-toggle">
								<i class="icon-comment-alt"></i>
								<span class="menu-text"> Message List </span>
								
							</a>
						</li>
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>