<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Usermanager{
    private $CI;
    private $response;
    public function __construct() {
         $this->CI =& get_instance();
         $this->response = null;
    }

    public function checkUserRole($user_role){
        return checkUserRole($user_role);
    }

    public function doLogin($parameters){
        $this->CI->load->model('user_model','user');
        $user_info = (array) $this->CI->user->as_array()->get_by(
                array('email'=>$parameters['username'],'password'=>base64_encode($parameters['password']))
            );
        
        if(count($user_info)){
            $session_data = array(
            'id' => $user_info['id'],
            'email' => $user_info['email'],
            'name' => $user_info['name'],
            );
            $this->CI->session->set_userdata('user', $session_data);
            return true;
        }else{
            return false;
        }
    }

    public function getUserById($id){
        $this->CI->load->model('user_model','user');
        $user_info = (array) $this->CI->user->as_array()->get_by(
                array('id'=>$id)
            );
         return $user_info;
    }

    public function emailExist($email,$option){; 
        $this->CI->load->model('user_model','user');
        $this->CI->db->select('u.*');
        $this->CI->db->from('tbl_user u');
        $this->CI->db->where( array('u.email'=>$email));
        $user_info = $this->CI->db->get()->result_array();
        $flag = true;
        if($option=="edit"){
            if(count($user_info)>1){
             $flag = false;
            }       
        }else{
            if(count($user_info)>0){
             $flag = false;
            }
        }
         return $flag;
    }

    public function mobileExist($prefix,$mobile, $option){
        $this->CI->load->model('user_model','user');
        $this->CI->db->select('u.*');
        $this->CI->db->from('tbl_user u');
        $this->CI->db->where( array('u.mobile_number'=>$mobile,'u.mobile_prefix'=>$prefix));
        $user_info = $this->CI->db->get()->result_array();
        $flag = true;
        if($option=="edit"){
            if(count($user_info)>1){
             $flag = false;
            }       
        }else{
            if(count($user_info)>0){
             $flag = false;
            }
        }
        return $flag;
    }

    public function registerUser($data){
        $this->CI->load->model('user_model','user');
        return $user_id = $this->CI->user->insert($data);
    }

    public function updateUser($userId,$data){
        $this->CI->load->model('user_model','user');
        return $user_id = $this->CI->user->update($userId, $data);
    }

    public function userList($userId){
        $this->CI->load->model('user_model','user');
        $user_id = $userId;
        $user_info = (array) $this->CI->user->as_array()->get_by(
            array('id'=>$user_id)
        );

        if(count($user_info)){
            if($user_info['user_role']=="ADMINISTRATOR"){
                $user_list = (array) $this->CI->user->as_array()->get_many_by(
                    array('status'=>1,'created_at!='=>'0000-00-00 00:00:00')
                );
            }else{
                $user_list = (array) $this->CI->user->as_array()->get_many_by(
                    array('status'=>1,'user_role!='=>'ADMINISTRATOR','created_at!='=>'0000-00-00 00:00:00')
                );
            }
        }  
        return $user_list;
    }
}