<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
require(APPPATH . 'libraries/REST_Controller.php');

class Report extends REST_Controller {
	public $rest_response = array('status'=>0);

	public function reportlist_post(){
		$this->load->library('propertymanager');
		$this->load->library('reportmanager');
		$require_params = array('user_type','property_type','budget_min_price','budget_max_price','postal_pin','city');
		$passed_params = $this->input->post();		 
		$passed_params = array_map('trim', $passed_params);
		$empty_params = checkRequireParams($passed_params,$require_params);
		
		if(count($empty_params)){
			$this->rest_response['status'] = false;
			$this->rest_response['message'] = "Require params (".implode(",",$empty_params).") are empty or not set.";
			$this->response($this->rest_response, 200);
		}
		$user_id = $this->_allow->user_id;
		$property = $this->propertymanager->prepareSearchReport($passed_params);
		if(count($property)){
			$this->rest_response['status'] = true;
			$this->rest_response['message'] = "Search Property list.";
			$this->rest_response['data'] = array('user_type'=>$passed_params['user_type'],'property'=>$property);
			$this->response($this->rest_response, 200);	
		}
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "No properties found.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);
	}
}
