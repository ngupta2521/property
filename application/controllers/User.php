<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct() {
         $this->data = null;
         parent::__construct();
    }
	public function register() {
		$this->load->library('usermanager');
        $this->load->library('propertymanager');
        $this->load->library('reportmanager');
		$this->form_validation->set_rules('name', 'name', 'trim|required|max_length[42]');
 		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_email_exists[add]');
 		$this->form_validation->set_rules('password', 'password', 'trim|required');
        $this->form_validation->set_rules('city', 'city', 'trim|required');
 		$this->form_validation->set_rules('prefix', 'prefix', 'trim|required');
 		$this->form_validation->set_rules('mobile', 'mobile', 'trim|required|numeric|max_length[10]|callback_mobile_exists[add]');
 		$this->form_validation->set_rules('user_type', 'user type', 'trim|required');
        $this->form_validation->set_rules('property_type', 'property type', 'trim|required');
        $this->form_validation->set_rules('budget_min_price', 'min budget', 'trim|required|numeric');
        $this->form_validation->set_rules('budget_max_price', 'max budget', 'trim|required|numeric');
        $this->form_validation->set_rules('postal_pin', 'postal pin', 'trim|required|numeric|max_length[6]');
        $this->form_validation->set_message('valid_email', 'Invalid %s format.');
        $this->layout = 'layouts/login';

		if ($this->form_validation->run() === TRUE)
		{
			$passed_params = $this->input->post();
			$user_id = $this->usermanager->registerUser(array(
                'name'=>$passed_params['name'],
                'password'=>base64_encode($passed_params['password']),
                'otp' => rand(1000,9999),
                'email'=>$passed_params['email'],
                'mobile_number'=>$passed_params['mobile'],
                'mobile_prefix'=>$passed_params['prefix']
            ));
            if($passed_params['user_type']==2 || $passed_params['user_type']==4){
                $property_id = $this->propertymanager->setProperty(array('user_id'=>$user_id,
                    'user_type'=>$passed_params['user_type'],
                    'property_type'=>$passed_params['property_type'],
                    'budget_min_price'=>$passed_params['budget_min_price'],
                    'budget_max_price'=>$passed_params['budget_max_price'],
                    'postal_pin'=>$passed_params['postal_pin'],
                    'city'=>$passed_params['city']
                 ));
            }

            $reportData = array('user_id'=>$user_id,
                'user_type'=>$passed_params['user_type'],
                'property_type'=>$passed_params['property_type'],
                'budget_min_price'=>$passed_params['budget_min_price'],
                'budget_max_price'=>$passed_params['budget_max_price'],
                'postal_pin'=>$passed_params['postal_pin'],
                'city'=>$passed_params['city']
                );
            if($passed_params['user_type']==2 || $passed_params['user_type']==4){
                $reportData['property_id']=$property_id;
            }
            $report_id = $this->reportmanager->setReport($reportData);
            
            redirect('user/login');
		}
		return $this->data=array('page_title'=>'Register your detail');
		
    }
    
    function email_exists($email, $option){;
        if(!$this->usermanager->emailExist($email,$option)){
            $this->form_validation->set_message('email_exists', '%s already registered.');
            return false;
        }
        return true;
    }

    function mobile_exists($mobile,$option){
    	$prefix = $this->input->post('prefix');
    	if(!$this->usermanager->mobileExist($prefix, $mobile, $option)){
    		$this->form_validation->set_message('mobile_exists', '%s already registered.');
        	return false;
    	}
        return true;
    }

    /*function user_role($user_role){
    	if(!$this->usermanager->checkUserRole($user_role)){
    		$this->form_validation->set_message('user_role', 'User Role must be ("ADMINISTRATOR","USER").');
        	return false;
    	}
        return true;
    }

    public function list() {
		$this->load->library('usermanager');
		$user_list = $this->usermanager->userList($this->session->userdata['user']['id']);//$this->_allow->user_id);
		return $this->data=array('page_title'=>'User List','user'=>$user_list);
    }*/

    public function login() {
        $this->load->library('usermanager');
        $this->data = array();
        $this->layout = 'layouts/login';
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        if ($this->form_validation->run() === TRUE)
        {
            $paramaters = $this->input->post();
            if($this->usermanager->doLogin($paramaters)){
                redirect('property/manage');
            }else{
                $this->data = array('error'=>'Invalid credentials');
            }
        }
        return $this->data;
    }

    public function logout(){
        $sess_array =array('user'=>'');
        $this->session->unset_userdata('user', $sess_array);
        redirect('user/login'); 
    }

    public function forgot_password() {
        $this->load->library('usermanager');
        $this->load->library('emailmanager');
        $this->data = array();
        $this->layout = 'layouts/login';
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_message('email', 'Invalid %s');
        if ($this->form_validation->run() === TRUE)
        {
            $parameter = $this->input->post();
            $this->emailmanager->setToEmail($parameter['email']);
            $this->emailmanager->setEmailSubject('Forgot Password');
            $this->emailmanager->setEmailBody('This is you password <b>'.uniqid().'</b>');
            $status = $this->emailmanager->sendEmail();
            if($status){
                return $this->data=array('status'=>true,'message'=>'Password has sent on your email.');
            }else{
                return $this->data=array('status'=>false,'message'=>'Mail not sent');
            }
        }
    }

    /*public function edit($userid) {
        $this->load->library('usermanager');
        $user_info = $this->usermanager->getUserById($userid);
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[42]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_exists[edit]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('prefix', 'Prefix', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|max_length[10]|callback_mobile_exists[edit]');
        $this->form_validation->set_rules('user_role', 'User Role', 'trim|required|callback_user_role');
        $this->form_validation->set_message('valid_email', 'Invalid %s format.');

        if ($this->form_validation->run() === TRUE)
        {
            $passed_params = $this->input->post();
            $data = array(
                'name'=>$passed_params['username'],
                'password'=>base64_encode($passed_params['password']),
                'email'=>$passed_params['email'],
                'mobile_number'=>$passed_params['mobile'],
                'mobile_prefix'=>$passed_params['prefix'],
                'user_role'=>$passed_params['user_role']
            );
            $user_id = $this->usermanager->updateUser($passed_params['user_id'],$data);
            if($user_id>0){
                redirect('user/list');
            }
        }
        return $this->data=array('page_title'=>'Edit user detail','user'=>$user_info);
    }

    public function delete($user_id) {
        $this->load->library('usermanager');
        $data = array('created_at'=>'0000-00-00 00:00:00');
        $this->usermanager->updateUser($user_id, $data);
        redirect('user/list/');
    }*/
}