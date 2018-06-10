<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends MY_Controller {
	public function __construct() {
         $this->data = null;
         parent::__construct();
    }
	
	public function lastadded($message_key,$last_msg_id){
		$this->load->library('messagemanager');
		$this->load->library('usermanager');
		$this->layout=array();
		$this->view = FALSE;
		if(isset($this->session->userdata['user'])){
			$user_id = $this->session->userdata['user']['id'];
		}else{
			if ($this->input->is_ajax_request()) {
				$arr_response['status'] = 'error';
                $arr_response['login_link'] = site_url('user/login');
                   echo json_encode($arr_response);die;
			}else{
				redirect('user/login');
			}
		}
		$messages = $this->messagemanager->getLastMessage($message_key,$last_msg_id);
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
			}
			$this->data['list'] = $messages;
		$theHTMLResponse = $this->load->view('message/lastadded', $this->data, true);
    	$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('htmlresponse'=> $theHTMLResponse)));
		//return $this->data['list'] = $messages;
	}

	public function messagelist(){		
		$this->load->library('messagemanager');
		$this->load->library('propertymanager');
		$this->load->library('usermanager');
		$messages =array();
		if(isset($this->session->userdata['user'])){
			$user_id = $this->session->userdata['user']['id'];
		}else{
			redirect('user/login');
		}
		$passed_params = $this->input->get();
		
		$events_total = $this->messagemanager->getTotalMessageListCount($user_id);
		
		if(count($events_total)){
			$total_records = $events_total[0]['total'];
		}
		
		if(!array_key_exists('page',$passed_params) || $passed_params['page']<=0){
			$passed_params['page'] = 1;
		}
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
					$project_info = $this->propertymanager->getPropertyById($message['property_id']);
					$messages[$index]['messeged_user_id'] = $messagedUserId;					
					$messages[$index]['messeged_user_name'] = "";
					//$messages[$index]['messeged_user_picture'] = "";
					$messages[$index]['messeged_property'] = "";					
					if(count($user_info)){
						$messages[$index]['messeged_user_name'] = $user_info['name'];
						//$messages[$index]['messeged_user_picture'] = prepareImageUrl($user_info['profile_pic_URL']);
					} 

					/*if(count($project_info)){
						$messages[$index]['messeged_property'] = $project_info['name'];
					} */
					
					$messages[$index]['unread_count'] = $this->message->count_by(array('message_key'=>$message['message_key'],'is_read'=>0,'receiver_id'=>$user_id,'sender_id'=>$message['sender_id']));					   
				}
			}
		}
		$response['list'] = $messages;
		$response['page_title'] = 'Message List';
		return $this->data=$response;
	}


	public function compose($property_id, $message_user_id){
		//$this->view = FALSE;
		$this->load->library('messagemanager');
		$this->load->library('usermanager');
		$messages = array();
		if(isset($this->session->userdata['user'])){
			$user_id = $this->session->userdata['user']['id'];
		}else{
			if ($this->input->is_ajax_request()) {
				$arr_response['status'] = 'error';
                $arr_response['login_link'] = site_url('user/login');
                   echo json_encode($arr_response);die;
			}else{
				redirect('user/login');
			}
		}
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		$key_array = array($message_user_id,$user_id,$property_id);
		asort($key_array);
		$message_key = implode("_",$key_array);
		if ($this->form_validation->run() === TRUE)
		{
			$passed_params = $this->input->post();
			$passed_params = $this->input->post(); 
			$this->messagemanager->setMessage(array('message_key'=>$message_key,'sender_id'=>$user_id,'property_id'=>$property_id,'receiver_id'=>$message_user_id,'message'=>$passed_params['message']));
			if ($this->input->is_ajax_request()) {
				$arr_response['status'] = 'success';
                $arr_response['message'] = 'Message sent successfully.';
                 echo json_encode($arr_response);die;
			}
		}else{
			if ($this->input->is_ajax_request()) {
			$arr_response['status'] = 'error';
			$arr_response['validation_error'] = form_error('message', '<div class="error red">', '</div>'); 
			echo json_encode($arr_response);die;
            }
		}
		
		$passed_params['message_user_id']=$message_user_id;
		$passed_params['property_id']=$property_id;
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
			}
			
		}
		$response['page_title']='Compose Message';
		$response['property_id']=$property_id;
		$response['message_user_id']=$message_user_id;
		$response['list']=$messages;
		$response['message_key'] = $message_key;
		return $this->data=$response;
		//$theHTMLResponse = $this->load->view('message/compose', $this->data, true);
    	//$this->output->set_content_type('application/json');
		//$this->output->set_output(json_encode(array('htmlresponse'=> $theHTMLResponse)));
		//return $this->data=$response;
	}

	public function delete($message_user_id,$property_id){
		$this->load->library('messagemanager');
		$passed_params = array();
		if(isset($this->session->userdata['user'])){
			$user_id = $this->session->userdata['user']['id'];
		}else{
			if ($this->input->is_ajax_request()) {
				$arr_response['status'] = 'error';
                $arr_response['login_link'] = site_url('user/login');
                   echo json_encode($arr_response);die;
			}else{
				redirect('user/login');
			}
		}
		$passed_params['message_user_id'] = $message_user_id;
		$passed_params['property_id'] = $property_id;
		if($user_id>$passed_params['message_user_id']){
			//update in "sender_deleted"				
			$this->messagemanager->removeSenderMessage($passed_params,$user_id);
		}else{
			//update in "receiver_deleted"
			$this->messagemanager->removeReceiverMessage($passed_params,$user_id);
		}
		redirect('message/list');
	}
}