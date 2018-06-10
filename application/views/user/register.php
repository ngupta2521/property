<?php 
$class = 'col-xs-12 col-sm-12';$classPrefix = 'col-xs-12 col-sm-12'; $classMobile = 'col-xs-12 col-sm-12'; 
?>
	<div id="login-box" class="login-box visible widget-box no-border">
		<div class="widget-body">
			<div class="widget-main">
				<h4 class="header blue lighter bigger">
					<i class="icon-coffee green"></i>
					Please register with your information
				</h4>
				<div class="space-6"></div>
				<span class="error red"><?php //echo (isset($error)?$error:'')?></span>
		<!-- PAGE CONTENT BEGINS -->
			<form class="form-horizontal" role="form" method="POST" action="<?php echo site_url("user/register"); ?>">
				<div class="form-group">
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="form-field-1"> Name </label>
						<input type="text" id="form-field-1" placeholder="Please enter name" class="<?php echo $class;?>" name="name" value="<?php echo set_value('name');  ?>" />
						<?php echo form_error('name', '<div class="error red">', '</div>'); ?>
					</div>
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="form-field-2"> Email </label>
						<input type="text" id="form-field-2" placeholder="Please enter email" class="<?php echo $class;?>" name="email" value="<?php echo set_value('email');  ?>" />
						<?php echo form_error('email', '<div class="error red">', '</div>'); ?>
					</div>
				</div>
				
				<div class="space-4"></div> 

				<div class="form-group">
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="form-field-3"> Password </label>
						<input type="password" id="form-field-3" placeholder="Please enter password" class="<?php echo $class;?>"  name="password" value="<?php echo set_value('password');  ?>" />
						<?php echo form_error('password', '<div class="error red">', '</div>'); ?>
					</div>
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="form-field-3"> City </label>
						<input type="text" id="form-field-3" placeholder="Please enter city" class="<?php echo $class;?>"  name="city" value="<?php echo set_value('city');  ?>" />
						<?php echo form_error('city', '<div class="error red">', '</div>'); ?>
					</div>
				</div>

				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="_form-field-4"> Mobile Prefix </label>
						<input type="text" id="form-field-4" placeholder="Enter Mobile Prefix" class="<?php echo $classPrefix;?>" name="prefix" value="<?php echo set_value('prefix');  ?>" />
						<?php echo form_error('prefix', '<div class="error red">', '</div>'); ?>
					</div>
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="_form-field-4"> Mobile Number </label>
						<input type="text" id="form-field-4" placeholder="Enter Mobile Number" class="<?php echo $classMobile;?>" name="mobile" value="<?php echo set_value('mobile');  ?>" />
						<?php echo form_error('mobile', '<div class="error red">', '</div>'); ?>
					</div>
				</div>
				<div class="space-4"></div>

				<div class="form-group">
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="_form-field-4"> User Type </label>
						<select class="form-control" name="user_type" id="form-field-select-1">
						<option value="">--Select User Type--</option>
						<option value="1" <?php echo (set_value('user_type')==1?'selected':'');?>>Buyer</option>
						<option value="2" <?php echo (set_value('user_type')==2?'selected':'');?>>Saler</option>
						<option value="3" <?php echo (set_value('user_type')==3?'selected':'');?>>Tenant</option>
						<option value="4" <?php echo (set_value('user_type')==4?'selected':'');?>>Landlord</option>
						</select>
						<?php echo form_error('user_type', '<div class="error red">', '</div>'); ?>
					</div>
					<div class="col-sm-6">
						<label class="control-label no-padding-right" for="_form-field-4"> Property Type </label>
						<select class="form-control" name="property_type" id="form-field-select-1">
						<option value="">--Select Property Type--</option>
						<option value="1" <?php echo (set_value('property_type')==1?'selected':'');?>>Residential</option>
						<option value="2" <?php echo (set_value('property_type')==2?'selected':'');?>>Commercial</option>
						<option value="3" <?php echo (set_value('property_type')==3?'selected':'');?>>Industrial</option>
						<option value="4" <?php echo (set_value('property_type')==4?'selected':'');?>>Agricultural</option>
						</select>
						<?php echo form_error('property_type', '<div class="error red">', '</div>'); ?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<div class="col-sm-6">
						<div class="row">
						<div class="col-sm-6">
						<label class="control-label no-padding-right" for="_form-field-4">Min Budget</label>
						<input type="text" name="budget_min_price" class="form-control" value="<?php echo set_value('budget_min_price');?>">
						<?php echo form_error('budget_min_price', '<div class="error red">', '</div>'); ?>
						</div>
						<div class="col-sm-6">
						<label class="control-label no-padding-right" for="_form-field-4">Max Budget</label>
						<input type="text" name="budget_max_price" class="form-control" value="<?php echo set_value('budget_max_price');?>">
						<?php echo form_error('budget_max_price', '<div class="error red">', '</div>'); ?>
						</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
						<div class="col-sm-12">
						<label class="control-label no-padding-right" for="_form-field-4"> Postal Pin </label>
						<input type="text" name="postal_pin" class="form-control" value="<?php echo set_value('postal_pin');?>">
						<?php echo form_error('postal_pin', '<div class="error red">', '</div>'); ?>
						</div>
						</div>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<input type="hidden" name="user_role" value="USER"/>
						<button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i>Submit</button>&nbsp; &nbsp; &nbsp;
						<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button>
					</div>
				</div>
			</form>
			
		</div><!-- /widget-main -->
		<div class="toolbar clearfix">
			<div>
				<a href="<?php echo site_url('user/forgot_password');?>" class="forgot-password-link">
					<i class="icon-arrow-left"></i>
					I forgot my password
				</a>
			</div>
			<div>
				<a href="<?php echo site_url('user/login');?>" class="user-signup-link">
					I want to Login
					<i class="icon-arrow-right"></i>
				</a>
			</div>
		</div>
	</div><!-- /widget-body -->
</div><!-- /login-box -->
<?php if($this->router->class=="user" && $this->router->method=="register"){ ?>
	<style type="text/css">
		.login-container {
	    width: 600px;
	    margin: 0 auto;
	}
	</style>
<?php } ?>