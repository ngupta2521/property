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
					<form name="search" action="<?php echo site_url('report/reportlist');?>" method="post">
						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-12 col-sm-12">
								<label for="id-date-picker-1">User Type</label>
									<select class="form-control" name="user_type" id="user_type">
										<option value="">--Select User Type--</option>
										<option value="1" <?php echo (set_value('user_type')=='1'?'selected':'')?>>Buyer</option>
										<option value="2" <?php echo (set_value('user_type')=='2'?'selected':'')?>>Saler</option>
										<option value="3" <?php echo (set_value('user_type')=='3'?'selected':'')?>>Tenant</option>
										<option value="4" <?php echo (set_value('user_type')=='4'?'selected':'')?>>Landlord</option>
									</select>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-12 col-sm-12">
								<label for="id-date-picker-1">Property Type</label>
									<select class="form-control" name="property_type" id="property_type">
										<option value="">--Select Property Type--</option>
										<option value="1" <?php echo (set_value('property_type')=='1'?'selected':'')?>>Residential</option>
										<option value="2" <?php echo (set_value('property_type')=='2'?'selected':'')?>>Commercial</option>
										<option value="3" <?php echo (set_value('property_type')=='3'?'selected':'')?>>Industrial</option>
										<option value="4" <?php echo (set_value('property_type')=='4'?'selected':'')?>>Agricultural</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">Min Budget</label>
									<input type="text" name="budget_min_price" id="budget_min_price" class="form-control" value="<?php echo (set_value('budget_min_price')!='')?set_value('budget_min_price'):''; ?>">
								</div>
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">Max Budget</label>
									<input type="text" name="budget_max_price" id="budget_max_price" class="form-control" value="<?php echo (set_value('budget_max_price')!='')?set_value('budget_max_price'):''; ?>">
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">City</label>
									<input type="text" name="city" class="form-control"  id="city" value="<?php echo (set_value('city')!='')?set_value('city'):''; ?>">
								</div>
								<div class="input-group col-xs-6 col-sm-6">
								<label for="id-date-picker-1">Postal Pin</label>
									<input type="text" name="postal_pin" class="form-control" id="postal_pin" value="<?php echo (set_value('postal_pin')!='')?set_value('postal_pin'):''; ?>">
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<button class="btn btn-success" type="submit"><i class="icon-ok bigger-110"></i>Search</button>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12" id="report_data">
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
		</div><!-- /.table-responsive -->
	</div>
</div>

<script type="text/javascript">
	function goToPage(url){
	top.window.location.href=url;
	}

	function report(page){
        	var data = {'user_type':$('#user_type').val(),'property_type':$('#property_type').val(),'budget_min_price':$('#budget_min_price').val(),'budget_max_price':$('#budget_max_price').val(),
        	'city':$('#city').val(),'postal_pin':$('#postal_pin').val()};
        	var url = $('#pagination_report').data('url')+'/'+page;  
        	$.ajax({
				type: 'GET',
				url: url,
				data: data,
				dataType: 'json',
				cache: false,
				success: function(responce_data) {
					if(responce_data.status=='error'){
						if(responce_data.hasOwnProperty('login_link')) {
							goToPage(responce_data.login_link);
						}
				    } else {
			     		$('#report_data').html(responce_data.htmlresponse);
			     		//$('#modal-table').modal('show');
					}
				}
			});
        }

</script>