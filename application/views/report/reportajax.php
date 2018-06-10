<div class="table-responsive">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<?php 	
						if($user_type==2 || $user_type==4 || $user_type==""){
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
					</tr>
					<?php }}else{?>
					<tr>
						<td colspan="6" class="center">No records.</td>
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