<?php 
$colorClass=array('1'=>'orange','2'=>'red','3'=>'default','4'=>'blue','5'=>'grey','6'=>'green','7'=>'pink');
?>
<div class="row">
	<div class="col-sm-6">
		<div class="widget-box ">
			<div class="widget-header">
				<h4 class="smaller lighter green">
					<i class="icon-list"></i>
					Message Lists
				</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="slimScrollDiv" style="position: relative;  width: auto; height: 300px; overflow-y: scroll;overflow-x: hidden;">
						<div class="dialogs" style="width: auto; <?php echo (count($list)==0)?'height: auto;':'height: 330px;'?>">
							<div id="task-tab" class="tab-pane active">
								<ul id="tasks" class="item-list ui-sortable">
								<?php
									if(count($list)>0) {
										foreach($list as $key=>$value){
											$colorIndex=(($key+1)%7);
								?>
									<li class="item-<?php echo $colorClass[$colorIndex];?> clearfix">
										<label class="inline unread">
											<span class="lbl blue"> <?php echo $value['messeged_user_name'].'::'.$value['messeged_property'];?></span>
											<span class="lbl message">(<?php echo $value['message'];?>) </span> 
										</label>
										<div class="pull-right action-buttons">
											<span class="vbar"></span>
											<a href="<?php echo site_url('message/delete/'.$value['messeged_user_id'].'/'.$value['property_id']);?>" class="red">
												<i class="icon-trash bigger-130"></i>
											</a>
											<span class="vbar"></span>
											<a href="<?php echo site_url('message/compose/'.$value['property_id'].'/'.$value['messeged_user_id']);?>" class="green">
												<i class="icon-eye-open bigger-130"></i>
											</a>
										</div>
									</li>
								<?php 
									}
								}else{
								?>
									<li class="item-default clearfix">
										<label class="inline">
											<span class="lbl"> No Message List.</span>
											 
										</label>
									</li>
								<?php 
								}
								?>
								</ul>
							</div>
						</div>
					</div> 
				</div><!-- /widget-main -->
			</div><!-- /widget-body -->
		</div>
	</div>
</div>

<style type="text/css">
.item-list>li label.unread {
    font-size: 13px;
    font-weight: bold;
}
.item-list>li label .message {
    margin-left: 10px;
}	
</style>