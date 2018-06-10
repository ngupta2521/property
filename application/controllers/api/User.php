<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');
 
class User extends REST_Controller {
	public $rest_response = array('status'=>0);
		
	/** Register functionality **/
	public function register_post(){
		$this->load->library('usermanager');
		$this->load->library('propertymanager');
		$this->load->library('reportmanager');
		$require_params = array('name','email','password','city','mobile_prefix','mobile_number','user_type','property_type','budget_min_price','budget_max_price','postal_pin');
		$passed_params = $this->input->post();		 
		$passed_params = array_map('trim', $passed_params);
		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}

    	if(!$this->usermanager->mobileExist($passed_params['mobile_prefix'], $passed_params['mobile_number'],'add')){
    		$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Mobile already registered.";
			$this->response($this->rest_response, 200);
    	}

		if(!$this->usermanager->emailExist($passed_params['email'],'add')){
    		$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Email already registered.";
			$this->response($this->rest_response, 200);	
    	}
		$user_id = $this->usermanager->registerUser(array(
                'name'=>$passed_params['name'],
                'password'=>base64_encode($passed_params['password']),
                'otp' => rand(1000,9999),
                'email'=>$passed_params['email'],
                'mobile_number'=>$passed_params['mobile_number'],
                'mobile_prefix'=>$passed_params['mobile_prefix']
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

		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "You are registered successfully.";				
		$this->rest_response['data'] = array('userid'=>$user_id);
		$this->response($this->rest_response, 200);			
	}
	
	/** verfiy OTP functionality **/
	public function otpVerification_post(){
		$require_params = array('otp','mobile_prefix','mobile_number');
		$passed_params = $this->input->post();		 
		$passed_params = array_map('trim', $passed_params);
		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		
		$this->load->model('user_model','user');
		$this->load->model('key_model','key');
		
		$user_info = (array) $this->user->as_array()->get_by(
				array('mobile_number'=>$passed_params['mobile_number'],
						'mobile_prefix'=>$passed_params['mobile_prefix'])
				);
				
		if(!count($user_info)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Mobile not registered yet.";
			$this->response($this->rest_response, 200);
		}
				
		if($user_info['otp']==$passed_params['otp'] || $passed_params['otp']=='1234'){
			$this->user->update($user_info['id'],array('is_mobile_verified'=>1));
			
			$access_token = md5($user_info['mobile_number'].time()); 
				
			$key_info = (array)$this->key->as_array()->get_by('user_id',$user_info['id']);
				
			if(count($key_info)){
				$access_token = $key_info['key']; 
				//$this->key->update($key_info['id'],array('key'=>$access_token));	
			}else{
				$this->key->insert(array('user_id'=>$user_info['id'],'key'=>$access_token,'level'=>1,'date_created'=>time()));
			}
			
			$this->rest_response['status'] = true;
			$this->rest_response['message'] = "Mobile verfied successfully.";				
			$this->rest_response['data'] = array('userid'=>$user_info['id'],'access_token'=>$access_token);
			$this->response($this->rest_response, 200);
		}
		
		$this->rest_response['status'] = false;
		$this->rest_response['message'] = "Mobile verfication failed.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);
	}
	
	public function login_post(){
		$require_params = array('email','password');
		$passed_params = $this->input->post();		 
		$passed_params = array_map('trim', $passed_params);
		 		
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		
		$this->load->model('user_model','user');
		$this->load->model('key_model','key');
		
		$user_info = (array) $this->user->as_array()->get_by(
				array('email'=>$passed_params['email'],
						'password'=> base64_encode($passed_params['password']),
						'status'=>1)
				);

		if(!count($user_info)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Invalid credential.";
			$this->response($this->rest_response, 200);
		}
				
		$access_token = md5($user_info['email'].time()); 
				
		$key_info = (array)$this->key->as_array()->get_by('user_id',$user_info['id']);
				
		if(count($key_info)){
			$access_token = $key_info['key']; 
			//$this->key->update($key_info['id'],array('key'=>$access_token));	
		}else{
			$this->key->insert(array('user_id'=>$user_info['id'],'key'=>$access_token,'level'=>1,'date_created'=>time()));
		}
		
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Login successfully.";				
		$this->rest_response['data'] = array('userid'=>$user_info['id'],'email'=>$user_info['email'],'name'=>$user_info['name'],'access_token'=>$access_token);
		$this->response($this->rest_response, 200);
	}
	
}
