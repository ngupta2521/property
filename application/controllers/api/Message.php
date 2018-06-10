<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');


class Message extends REST_Controller {
	public $rest_response = array('status'=>0);
	
	public function lastadded_post(){
		$this->load->library('messagemanager');
		$this->load->library('usermanager');
		$require_params = array('message_key','last_msg_id');
		$user_id = $this->_allow->user_id;
		$passed_params = $this->input->post();
		$passed_params = array_map('trim', $passed_params);		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		$messages = $this->messagemanager->getLastMessage($passed_params['message_key'],$passed_params['last_msg_id']);

		if(count($messages)){
				$messages = array_reverse($messages);
				
				foreach($messages as $index=>$message){
					$sender_info = $this->usermanager->getUserById($message['sender_id']);
					$receiver_info = $this->usermanager->getUserById($message['receiver_id']);
					if(count($sender_info)){
						$messages[$index]['sender_name']=$sender_info['name'];
					}
					if(count($receiver_info)){
						$messages[$index]['receiver_name']=$receiver_info['name'];
					}
					$messages[$index]['created_at'] = getBeforeDates($message['created_date']);
					$messages[$index]['my_message'] = ($message['sender_id']==$user_id ? true : false);   
				}
				$this->rest_response['status'] = true;
				$this->rest_response['message'] = "New message.";				
				$this->rest_response['data'] = $messages;
				$this->response($this->rest_response, 200);
		}else{
				$this->rest_response['status'] = false;
				$this->rest_response['message'] = "No new message.";				
				$this->rest_response['data'] = array();
				$this->response($this->rest_response, 200);
		}
	}

	public function detail_post(){
		$this->load->library('messagemanager');
		$require_params = array('message_user_id','property_id');
		$user_id = $this->_allow->user_id;
		$passed_params = $this->input->post();
		$passed_params = array_map('trim', $passed_params);		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		$events_total =  $this->messagemanager->getTotalMessageCount($passed_params, $user_id);
		
		if(count($events_total)){
			$total_records = $events_total[0]['total'];
		}
		
		if(!array_key_exists('page',$passed_params) || $passed_params['page']<=0){
			$passed_params['page'] = 1;
		}
		
		$response = array('total'=>$total_records,'page'=>0,'max_page'=>0);
		if($total_records){		
			$response['page'] = $passed_params['page']; 
			$response['max_page'] = ceil($total_records/NO_OF_MESSAGES_TO_SHOW); 
			$limit_start = ( $passed_params['page']-1)*NO_OF_MESSAGES_TO_SHOW;
			
		$messages = $this->messagemanager->getMessage($passed_params, $user_id, $limit_start, NO_OF_MESSAGES_TO_SHOW);
			
			if(count($messages)){
				$messages = array_reverse($messages);
				
				foreach($messages as $index=>$message){
					$messages[$index]['created_at'] = getBeforeDates($message['created_date']);
					$messages[$index]['my_message'] = ($message['sender_id']==$user_id ? true : false);   
				}
			}
			
			$response['list'] = $messages;
		}
		
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Messages retrieved successfully.";				
		$this->rest_response['data'] = $response;
		$this->response($this->rest_response, 200);	
	}
	
	public function markAsRead_post(){
		$this->load->library('messagemanager');
		$require_params = array('message_user_id','property_id');
		$user_id = $this->_allow->user_id;
		$passed_params = $this->input->post();
		$passed_params = array_map('trim', $passed_params);		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		
		$this->messagemanager->updateIsRead($passed_params,$user_id); 
		
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Messages status updated successfully.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);		
	}
	
	public function list_post(){		
		$this->load->library('messagemanager');
		$this->load->library('usermanager');
		$user_id = $this->_allow->user_id;
		$passed_params = $this->input->post();
		
		$events_total = $this->messagemanager->getTotalMessageListCount($user_id);
		
		if(count($events_total)){
			$total_records = $events_total[0]['total'];
		}
		
		if(!array_key_exists('page',$passed_params) || $passed_params['page']<=0){
			$passed_params['page'] = 1;
		}
		
		//$this->load->model('user_model','user');
		//$this->load->model('message_model','message');
		$response = array('total'=>$total_records,'page'=>0,'max_page'=>0);
		if($total_records){		
			$response['page'] = $passed_params['page']; 
			$response['max_page'] = ceil($total_records/NO_OF_MESSAGES_TO_SHOW_IN_LIST); 
			$limit_start = ( $passed_params['page']-1)*NO_OF_MESSAGES_TO_SHOW_IN_LIST;
			$messages = $this->messagemanager->getMessageList($user_id, $limit_start,NO_OF_MESSAGES_TO_SHOW_IN_LIST);
			
			if(count($messages)){
				foreach($messages as $index=>$message){
					$timestamp =strtotime($message['created_date']);
					$messages[$index]['created_at'] = date("d M",$timestamp);
					$today = date("ymd");
					
					if(date("y",$timestamp)*1<date("y")*1){
						$messages[$index]['created_at'] = date("m/d/Y",$timestamp);
					} else if(date("ymd",$timestamp)*1==$today*1){
						$messages[$index]['created_at'] = date("H:i a",$timestamp);		
					} 
					
					$messagedUserId = $message['sender_id'];
					if($message['receiver_id']!=$user_id){
						$messagedUserId = $message['receiver_id'];
					}
					$user_info = $this->usermanager->getUserById($messagedUserId);
					
					$messages[$index]['messeged_user_id'] = $messagedUserId;					
					$messages[$index]['messeged_user_name'] = "";
					//$messages[$index]['messeged_user_picture'] = "";					
					if(count($user_info)){
						$messages[$index]['messeged_user_name'] = $user_info['name'];
						//$messages[$index]['messeged_user_picture'] = prepareImageUrl($user_info['profile_pic_URL']);
					} 
					
					$messages[$index]['unread_count'] = $this->message->count_by(array('message_key'=>$message['message_key'],'is_read'=>0,'receiver_id'=>$user_id,'sender_id'=>$message['sender_id']));					   
				}
			}
			
			$response['list'] = $messages;
		}
		
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Messages list retreived successfully.";				
		$this->rest_response['data'] = $response;
		$this->response($this->rest_response, 200);		
	}
	
	public function compose_post(){
		$this->load->library('messagemanager');
		$require_params = array('message_user_id','message','property_id');
		$user_id = $this->_allow->user_id;
		$passed_params = $this->input->post();
		$passed_params = array_map('trim', $passed_params);		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		 
		//$this->load->model('message_model','message');
		
		$key_array = array($passed_params['message_user_id'],$user_id,$passed_params['property_id']);
		asort($key_array);
		$message_key = implode("_",$key_array); 
		$this->messagemanager->setMessage(array('message_key'=>$message_key,'sender_id'=>$user_id,'property_id'=>$passed_params['property_id'],'receiver_id'=>$passed_params['message_user_id'],'message'=>$passed_params['message']));
		//$this->message->insert();  
		
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Message sent successfully.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);		
	}
	
	public function delete_post(){
		$this->load->library('messagemanager');
		$require_params = array('message_user_id','property_id');
		$user_id = $this->_allow->user_id;
		$passed_params = $this->input->post();
		$passed_params = array_map('trim', $passed_params);		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}		
		
		if($user_id>$passed_params['message_user_id']){
			//update in "sender_deleted"				
			$this->messagemanager->removeSenderMessage($passed_params,$user_id);
		}else{
			//update in "receiver_deleted"
			$this->messagemanager->removeReceiverMessage($passed_params,$user_id);
		}
		
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Messages deleted successfully.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);
	}
}