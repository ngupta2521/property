<div class="row">
	<div class="col-sm-6">
		<div class="widget-box ">
			<div class="widget-header">
				<h4 class="lighter smaller">
					<i class="icon-comment orange"></i>
					Conversation
				</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="slimScrollDiv" style="position: relative; overflow-y: scroll;overflow-x: hidden; width: auto; height: 300px;">
						<div class="dialogs" style="overflow: hidden; width: auto; height: auto;" id="chat_list" data-url="<?php echo site_url('message/lastadded/'.$message_key.'/0');?>">
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
						}else{
						?>
						
						<?php
						}
						?>

						</div>
						
					</div> 

					<form id="compose_message" name="compose" action="<?php echo site_url('message/compose/'.$property_id.'/'.$message_user_id);?>" method="post">
						<div class="form-actions">
							<div class="input-group">
								<input placeholder="Type your message here ..." type="text" class="form-control" name="message" value="" id="message_txt">
								<span class="input-group-btn">
									<button class="btn btn-sm btn-info no-radius" type="button" id="comment">
										<i class="icon-share-alt"></i>
										Send
									</button>
								</span>
							</div>
							
						</div>
					</form>
				</div><!-- /widget-main -->
			</div><!-- /widget-body -->
		</div>
	</div>
</div>

<style type="text/css">
	
.left.itemdiv>.body {
    width: auto;
    margin-left: 50px;
    margin-right: 12px;
    position: relative;
    border-left-width: 2px; 
}
.right.itemdiv>.body {
    width: auto;
    margin-right: 50px;
    margin-left: 12px;
    border-right-width: 2px;
    position: relative;
}
.left.itemdiv.dialogdiv>.body:before {
    content: "";
    display: block;
    position: absolute;
    left: -7px;
    top: 11px;
    width: 8px;
    height: 8px;
    border: 2px solid #dde4ed;
    border-width: 2px 0 0 2px;
    background-color: #FFF;
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
    -webkit-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
}

.right.itemdiv.dialogdiv>.body:before {
    content: "";
    display: block;
    position: absolute;
    right: -7px;
    top: 11px;
    width: 8px;
    height: 8px;
    border: 2px solid #dde4ed;
    border-width: 2px 0 0 2px;
    background-color: #FFF;
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
    -webkit-transform: rotate(131deg);
    -ms-transform: rotate(135deg);
    transform: rotate(135deg);
}
</style>

<script type="text/javascript">
$(document).ready(function(){
	$('.slimScrollDiv').animate({scrollTop: $('.slimScrollDiv')[0].scrollHeight}, 2000);
	loadChat();

	$('#message_txt').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
	    $('#comment').click();
	    return false;  
	  }
	});  
	
});

function goToPage(url){
	top.window.location.href=url;
}

function loadChat(){
	var data = '';
	if($('div.itemdiv').length>0){
		var url = $('div.itemdiv:last').data('url');
	}else{
		var url = $('#chat_list').data('url');
	}
	$.ajax({
		type: 'GET',
		url: url,
		data: data,
		cache: false,
		dataType: 'json',
		success: function(responce_data) {
			if(responce_data.status=='error'){
				if(responce_data.hasOwnProperty('login_link')) {
					goToPage(responce_data.login_link);
				}
			} else {
				if(responce_data.hasOwnProperty('htmlresponse')){
						$('#chat_list').append(responce_data.htmlresponse);
						$('.slimScrollDiv').animate({scrollTop: $('.slimScrollDiv')[0].scrollHeight}, 2000);
					}
			}
		}
	});
	setTimeout("loadChat()",10000);
	//}
}
		$(document).on('click','#comment',function(){
			var form ='#compose_message';
			var data = $(form).serialize();    
 			$('.form-group ul li', $(form)).html('');
 			var form_object = $(form);
			var url = $(form).attr('action');
			$.ajax({
				type: 'POST',
				url: url,
				data: data,
				cache: false,
				dataType: 'json',
				success: function(responce_data) {
					if(responce_data.status=='error'){
						if(responce_data.hasOwnProperty('login_link')) {
							goToPage(responce_data.login_link);
						}
						if(responce_data.hasOwnProperty('validation_error')) {
							$(form+' .form-actions').append(responce_data.validation_error);
						}
				    } else {
				    	$('#message_txt').val('');
				    	//var lastIdUrl = $('div.itemdiv:last').data('url');
						loadChat();
					}
				}
			});
		});
			
		</script>