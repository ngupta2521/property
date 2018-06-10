<div id="login-box" class="login-box visible widget-box no-border">
	<div class="widget-body">
							<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												Please Enter Your Information
											</h4>

											<div class="space-6"></div>
											<span class="error red"><?php echo (isset($error)?$error:'')?></span>
											<form name="login" action="<?php echo site_url('user/login');?>" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username"  name="username"/>
															<i class="icon-user"></i>

														</span>
														<?php echo form_error('username', '<span class="error red">', '</span>'); ?>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" name="password"/>
															<i class="icon-lock"></i>
														</span>
														<?php echo form_error('password', '<span class="error red">', '</span>'); ?>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<!--<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Remember Me</span>
														</label>-->

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															Login
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="<?php echo site_url('user/forgot_password');?>"  class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													I forgot my password
												</a>
											</div>

											<div>
												<a href="<?php echo site_url('user/register');?>" class="user-signup-link">
													I want to register
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->

								