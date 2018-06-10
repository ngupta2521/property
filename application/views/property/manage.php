<div class="row">
	<div class="col-sm-12">
		<div class="widget-box">
			<div class="widget-header">
				<h4>Search Criteria</h4>
				<span class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="icon-chevron-up"></i>
					</a>
				</span>
			</div>

			<div class="widget-body"><div class="widget-body-inner" style="display: block;">
				<div class="widget-main">
					<form name="search" action="<?php echo site_url('property/manage');?>" method="post">
						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-12 col-sm-12">
								<label for="id-date-picker-1">User Type</label>
									<select class="form-control" name="user_type" id="form-field-select-1">
										<option value="">--Select User Type--</option>
										<option value="1" <?php echo (set_value('user_type')=='1'?'selected':($search_criteria['user_type']=='1')?'selected':'')?>>Buyer</option>
										<option value="2" <?php echo (set_value('user_type')=='2'?'selected':($search_criteria['user_type']=='2')?'selected':'')?>>Saler</option>
										<option value="3" <?php echo (set_value('user_type')=='3'?'selected':($search_criteria['user_type']=='3')?'selected':'')?>>Tenant</option>
										<option value="4" <?php echo (set_value('user_type')=='4'?'selected':($search_criteria['user_type']=='4')?'selected':'')?>>Landlord</option>
									</select>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-12 col-sm-12">
								<label for="id-date-picker-1">Property Type</label>
									<select class="form-control" name="property_type" id="form-field-select-1">
										<option value="">--Select Property Type--</option>
										<option value="1" <?php echo (set_value('property_type')=='1'?'selected':($search_criteria['property_type']=='1')?'selected':'')?>>Residential</option>
										<option value="2" <?php echo (set_value('property_type')=='2'?'selected':($search_criteria['property_type']=='2')?'selected':'')?>>Commercial</option>
										<option value="3" <?php echo (set_value('property_type')=='3'?'selected':($search_criteria['property_type']=='3')?'selected':'')?>>Industrial</option>
										<option value="4" <?php echo (set_value('property_type')=='4'?'selected':($search_criteria['property_type']=='4')?'selected':'')?>>Agricultural</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">Min Budget</label>
									<input type="text" name="budget_min_price" class="form-control" value="<?php echo (set_value('budget_min_price')!='')?set_value('budget_min_price'):$search_criteria['budget_min_price']; ?>">
								</div>
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">Max Budget</label>
									<input type="text" name="budget_max_price" class="form-control" value="<?php echo (set_value('budget_max_price')!='')?set_value('budget_max_price'):$search_criteria['budget_max_price']; ?>">
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">City</label>
									<input type="text" name="city" class="form-control" value="<?php echo (set_value('city')!='')?set_value('city'):$search_criteria['city']; ?>">
								</div>
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">Postal Pin</label>
									<input type="text" name="postal_pin" class="form-control" value="<?php echo (set_value('postal_pin')!='')?set_value('postal_pin'):$search_criteria['postal_pin']; ?>">
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<button class="btn btn-success" type="submit"><i class="icon-ok bigger-110"></i>Update</button>
								<?php 
								if($search_criteria['user_type']=="2" || $search_criteria['user_type']=="4")
								{
								?>
								<button class="btn btn-danger js_delete_btn" data-url="<?php echo site_url('property/deleteproperty');?>"><i class="icon-remove bigger-110"></i>Remove</button>
								<?php 
								}
								?>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<?php 
						if($search_criteria['user_type']==1 || $search_criteria['user_type']==3){
						?>
						<th>Posted By</th>
						<?php 
						}else{
						?>
						<th>Search By</th>	
						<?php } ?>
						<!--<th>Property Name</th>-->
						<th>Property Type</th>
						<th>Budget</th>
						<th>Postal Pin</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php if (count($data)>0){
					foreach($data as $key=>$prop){
				?>
					<tr>
						<td><?php echo $prop['post_by'];?></td>
						<!--<td><?php //echo $prop['name'];?></td>-->
						<td>
						<?php 
						$array=array('1'=>'residential','2'=>'commercial','3'=>'industrial','4'=>'agricultural');
							echo ucfirst($array[$prop['property_type']]);
						?>
						</td>
						<td><?php echo $prop['budget_min_price'].' - '.$prop['budget_max_price'];?></td>
						<td><?php echo $prop['postal_pin'];?></td>
						<td><?php echo date('Y-m-d',strtotime($prop['created_date']));?></td>
						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<?php 
								if($search_criteria['user_type']==1 || $search_criteria['user_type']==3){
								?>
								<a href="<?php echo site_url('message/compose/'.$prop['id'].'/'.$prop['user_id']);?>" class="btn btn-xs btn-info" title="Chat Now">
									<i class="icon-comment-alt bigger-120"></i>
								</a>
								<?php 
								}else{
								?>
								<a href="<?php echo site_url('message/compose/'.$search_criteria['property_id'].'/'.$prop['user_id']);?>" class="btn btn-xs btn-info" title="Chat Now">
									<i class="icon-comment-alt bigger-120"></i>
								</a>
								<?php } ?>
							</div>
						</td>
					</tr>
					<?php }}else{?>
					<tr>
						<td colspan="7" class="center">No records.</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="row">
					<div class="col-sm-6">
						<!--<a href="<?php //echo site_url('user/register'); ?>" class="btn btn-xs btn-info" title="Add User">
							<i class="icon-plus bigger-120"></i>Add User
						</a>-->
					</div>
					<div class="col-sm-6">
						<?php if ($count>0){?>
						<div class="dataTables_paginate paging_bootstrap">
						<div class="dataTables_info <?php echo ($pagination!='')? 'col-sm-7' : 'col-sm-12'?>" id="sample-table-2_info">Total Records: (<?php echo $count;?>)</div>
						<?php 
						if($pagination!=''){
						?>
							<div class="col-sm-5">
							<?php 
								echo $pagination;
							?>
							</div>	
						<?php } ?>	
						</div>
						<?php } ?>
					</div>
					</div>
				</div>
			</div>
		</div><!-- /.table-responsive -->
	</div>
</div>