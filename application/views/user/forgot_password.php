<div id="forgot-box" class="forgot-box widget-box no-border visible">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form name="forgot_password" action="<?php echo site_url('user/forgot_password');?>" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="email" class="form-control" placeholder="Email" />
															<i class="icon-envelope"></i>
														</span>
														<?php echo form_error('email', '<span class="error red">', '</span>'); ?>
													</label>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>
															Send Me!
														</button>
													</div>
												</fieldset>
											</form>
											<?php 
											if(isset($status)){
												if($status){?>
													<span class="success green"><?php echo $message;?></span>
												<?php
												}else{?>
													<span class="error red"><?php echo $message;?></span>
												<?php
												}
											}
											?>	
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="<?php echo site_url('user/login');?>" class="back-to-login-link">
												Back to login
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->
