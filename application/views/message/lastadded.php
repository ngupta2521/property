<?php 
							$user_id = $this->session->userdata['user']['id'];
							if(count($list)){
								foreach ($list as $key => $value) {
									if($value['receiver_id']!=$user_id){
										$class='left';
									}else{
										$class='right';
									}
									$name = $value['sender_name'];
						?>
							<div class="<?php echo $class;?> itemdiv dialogdiv" data-url="<?php echo site_url('message/lastadded/'.$value['message_key'].'/'.$value['id']);?>">
								<div class="body">
									<div class="time">
										<i class="icon-time"></i>
										<span class="green"><?php echo $value['created_at']; ?></span>
									</div>
									<div class="name">
										<a href="javascript:void(0);"><?php echo $name;?></a>
									</div>
									<div class="text">
										<?php echo $value['message'];?>
									</div>
									
								</div>
							</div>
						<?php
						}	
						}?>