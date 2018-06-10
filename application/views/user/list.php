<div class="row">
	<div class="col-xs-12">
		<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile Number</th>
						<th>User Role</th>
						<th>Created Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php if (count($user)>0){
					foreach($user as $key=>$users){
				?>
					<tr>
						<td><?php echo $users['name'];?></td>
						<td><?php echo $users['email'];?></td>
						<td><?php echo $users['mobile_prefix'].' '.$users['mobile_number'];?></td>
						<td><?php echo $users['user_role'];?></td>
						<td><?php echo date('Y-m-d',strtotime($users['created_at']));?></td>
						<td><?php if($users['status']==1){ echo 'Active'; }else{ echo 'Inactive';} ?></td>
						<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<a href="<?php echo site_url('user/edit/'.$users['id']);?>" class="btn btn-xs btn-info" title="Edit User">
									<i class="icon-edit bigger-120"></i>
								</a>
								<a href="<?php echo site_url('user/delete/'.$users['id']);?>" class="btn btn-xs btn-danger" title="Delete User">
									<i class="icon-trash bigger-120"></i>
								</a>
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
						<a href="<?php echo site_url('user/register'); ?>" class="btn btn-xs btn-info" title="Add User">
							<i class="icon-plus bigger-120"></i>Add User
						</a>
					</div>
					<div class="col-sm-6">
						<?php if (count($user)>0){?>
						<div class="dataTables_paginate paging_bootstrap">
						<div class="dataTables_info col-sm-7" id="sample-table-2_info">Total Records: (<?php echo count($user);?>)</div>
							<div class="col-sm-5">
								<ul class="pagination">
									<li class="prev disabled"><a href="#"><i class="icon-double-angle-left"></i></a></li>
									<li class="active"><a href="#">1</a></li><li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li class="next"><a href="#"><i class="icon-double-angle-right"></i></a></li>
								</ul>
							</div>	
						</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div><!-- /.table-responsive -->
	</div>
</div>
