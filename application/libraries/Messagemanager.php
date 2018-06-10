<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Messagemanager{
    private $CI;
    private $response;
    public function __construct() {
         $this->CI =& get_instance();
         $this->response = null;
    }

    public function getTotalMessageListCount($user_id){
        $this->CI->load->model('message_model','message');
        $query = $this->CI->db->query("select count(DISTINCT message_key) as total from `tbl_message` t1 where (t1.sender_deleted!=$user_id AND t1.receiver_deleted!=$user_id) AND (t1.sender_id=$user_id OR t1.receiver_id=$user_id)");
        return $events_total = (array)$query->result_array();
    }

    
    public function setMessage($data){
        $this->CI->load->model('message_model','message');
        return $inserted_id = $this->CI->message->insert($data);
    }
    public function getMessageList($user_id,$limit_start,$no_of_messages_to_show){
         $this->CI->load->model('message_model','message');
         $query = $this->CI->db->query("select t1.message_key,t1.property_id,t1.sender_id,t1.receiver_id,t1.message,t1.created_date from `tbl_message` t1 JOIN (SELECT max(id) as max_id from `tbl_message` t2 where (t2.sender_deleted!=$user_id AND t2.receiver_deleted!=$user_id) AND (t2.sender_id=$user_id OR t2.receiver_id=$user_id) GROUP BY message_key) t2 on t1.id = t2.max_id  order by id DESC limit $limit_start,".$no_of_messages_to_show);
            return $message = (array)$query->result_array();
    }
    public function getTotalMessageCount($passed_params,$user_id){
        $this->CI->load->model('message_model','message');
        if($user_id!=$passed_params['message_user_id']){
        $query = $this->CI->db->query("select count(*) as total from `tbl_message` t1 where (t1.sender_deleted!=$user_id AND t1.receiver_deleted!=$user_id) AND ((t1.sender_id=".$passed_params['message_user_id']." and t1.receiver_id=".$user_id.") OR (t1.sender_id=".$user_id." and t1.receiver_id=".$passed_params['message_user_id']." and t1.property_id=".$passed_params['property_id']."))");
        }else{
            $query = $this->CI->db->query("select count(*) as total from `tbl_message` t1 where (t1.sender_deleted!=$user_id AND t1.receiver_deleted!=$user_id) AND (t1.sender_id=".$user_id." or t1.receiver_id=".$user_id.") AND t1.property_id=".$passed_params['property_id']);   
        }
        return $events_total = (array)$query->result_array();
    }

    public function getMessage($passed_params,$user_id,$limit_start,$no_of_messages_to_show){
        $this->CI->load->model('message_model','message');
        if($user_id!=$passed_params['message_user_id']){
        $query = $this->CI->db->query("select * from `tbl_message` t1 where (t1.sender_deleted!=$user_id AND t1.receiver_deleted!=$user_id) AND ((t1.sender_id=".$passed_params['message_user_id']." and t1.receiver_id=".$user_id.") OR (t1.sender_id=".$user_id." and t1.receiver_id=".$passed_params['message_user_id']." and t1.property_id=".$passed_params['property_id'].")) ORDER BY id DESC limit $limit_start,".$no_of_messages_to_show);
            }else{
        $query = $this->CI->db->query("select * from `tbl_message` t1 where (t1.sender_deleted!=$user_id AND t1.receiver_deleted!=$user_id) AND (t1.sender_id=".$user_id." or t1.receiver_id=".$user_id." ) AND t1.property_id=".$passed_params['property_id']." ORDER BY id DESC limit $limit_start,".$no_of_messages_to_show);
            }
            return $message = (array)$query->result_array();
    }

    public function getLastMessage($message_key,$last_msg_id){
        $this->CI->load->model('message_model','message');
         $query = $this->CI->db->query("select * from `tbl_message` t1 where t1.message_key='$message_key' AND t1.id>'$last_msg_id'ORDER BY id DESC");
            return $message = (array)$query->result_array();
    }

    public function updateIsRead($passed_params,$user_id){
        $this->CI->load->model('message_model','message');
        return $this->CI->db->query("update `tbl_message` set is_read=1 where sender_id=".$passed_params['message_user_id']." and receiver_id = ".$user_id." and property_id =".$passed_params['property_id']);
    }

    public function removeSenderMessage($passed_params,$user_id){
        $this->CI->load->model('message_model','message');
        return $this->CI->db->query("update `tbl_message` set sender_deleted=".$user_id." where (sender_id=".$user_id." and receiver_id = ".$passed_params['message_user_id'].") OR (sender_id=".$passed_params['message_user_id']." and receiver_id = ".$user_id." and property_id=".$passed_params['property_id'].")");   
    }

    public function removeReceiverMessage($passed_params,$user_id){
        $this->CI->load->model('message_model','message');
        return $this->CI->db->query("update `tbl_message` set receiver_deleted=".$user_id." where (sender_id=".$user_id." and receiver_id = ".$passed_params['message_user_id'].") OR (sender_id=".$passed_params['message_user_id']." and receiver_id = ".$user_id." and property_id=".$passed_params['property_id'].")");
    }
}