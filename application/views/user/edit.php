<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
			<form class="form-horizontal" role="form" method="POST" action="<?php echo site_url("user/edit/".$user['id']); ?>">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Username </label>
					<div class="col-sm-9">
						<input type="text" id="form-field-1" placeholder="Please enter username" class="col-xs-10 col-sm-5" name="username" value="<?php echo (set_value('username')!='')?set_value('username'):$user['name']; ?>" />
						<?php echo form_error('username', '<span class="error">', '</span>'); ?>
					</div>
				</div>
				<div class="space-4"></div> 
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Email </label>
					<div class="col-sm-9">
						<input type="text" id="form-field-2" placeholder="Please enter email" class="col-xs-10 col-sm-5" name="email" value="<?php echo (set_value('email')!='')?set_value('email'):$user['email']; ?>" />
						<?php echo form_error('email', '<span class="error">', '</span>'); ?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-3"> Password </label>
					<div class="col-sm-9">
						<input type="password" id="form-field-3" placeholder="Please enter password" class="col-xs-10 col-sm-5"  name="password" value="<?php echo (set_value('password')!='')?set_value('password'):$user['password']; ?>" />
						<?php echo form_error('password', '<span class="error">', '</span>'); ?>
					</div>
				</div>

				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="_form-field-4"> Mobile number </label>
					<div class="col-sm-9">
						<input type="text" id="form-field-4" placeholder="Prefix" class="col-xs-2 col-sm-1" name="prefix" value="<?php echo (set_value('prefix')!='')?set_value('prefix'):$user['mobile_prefix']; ?>" />
						<?php echo form_error('prefix', '<span class="error">', '</span>'); ?>
						&nbsp; &nbsp;
						
						<input type="text" id="form-field-4" placeholder="Number" class="col-xs-2 col-sm-4" name="mobile" value="<?php echo (set_value('mobile')!='')?set_value('mobile'):$user['mobile_number']; ?>" />
						<?php echo form_error('mobile', '<span class="error">', '</span>'); ?>
					</div>
				</div>
				<div class="space-4"></div>
				<?php //if ($user['user_role']!='SUPER_ADMIN'){?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-5"> User role </label>
					<div class="col-sm-9">
						<select class="col-sm-5" id="form-field-select-1" name="user_role">
							<option value="">--Select user role--</option>
							<option value="ADMINISTRATOR" <?php echo (set_value('user_role')=='ADMINISTRATOR'?'selected':($user['user_role']=='ADMINISTRATOR')?'selected':'')?>>Administrator</option>
							<option value="USER" <?php echo (set_value('user_role')=='USER'?'selected':($user['user_role']=='USER')?'selected':'')?>>User</option>
						</select>
						<?php echo form_error('user_role', '<span class="error">', '</span>'); ?>
					</div>
				</div>
				<div class="space-4"></div>
				<?php //}else{ ?>
				<!--<input type="hidden" name="user_role" value="SUPER_ADMIN">-->
				<?php //} ?>
				<input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i>Submit</button>&nbsp; &nbsp; &nbsp;
						<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button>
					</div>
				</div>
			</form>
		</div><!-- /.col -->
	</div>