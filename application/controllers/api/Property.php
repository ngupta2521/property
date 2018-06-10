<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
require(APPPATH . 'libraries/REST_Controller.php');

class Property extends REST_Controller {
	public $rest_response = array('status'=>0);
		
	public function manage_get(){
		$this->load->library('usermanager');
		$this->load->library('propertymanager');
		$this->load->library('reportmanager');
		$user_id = $this->_allow->user_id;
		$searchCriteria = $this->reportmanager->getSearchCriteria($user_id);
		$property = $this->propertymanager->prepareSearchResult($user_id);
		if(count($searchCriteria)){
			$this->rest_response['status'] = true;
			$this->rest_response['message'] = "Get Property viewer and poster list based on criteria.";
			$this->rest_response['data'] = array('search_criteria'=>$searchCriteria,'property'=>$property);
			$this->response($this->rest_response, 200);	
		}
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "No search criteria found.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);
	}

	public function manage_post(){
		$this->load->library('usermanager');
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
		$this->reportmanager->deleteReport($user_id);
		$this->propertymanager->deleteProperty($user_id);
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

        $searchCriteria = $this->reportmanager->getSearchCriteria($user_id);
		$property = $this->propertymanager->prepareSearchResult($user_id);
		if(count($searchCriteria)){
			$this->rest_response['status'] = true;
			$this->rest_response['message'] = "Get property list successfully.";
			$this->rest_response['data'] = array('search_criteria'=>$searchCriteria,'property'=>$property);
			$this->response($this->rest_response, 200);	
		}
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "No properties found.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);
	}

	public function deleteproperty_get(){
		$this->load->library('propertymanager');
		$this->load->library('reportmanager');
		$user_id = $this->_allow->user_id;
		$this->propertymanager->deleteProperty($user_id);
		$this->reportmanager->deleteReport($user_id);
		$searchCriteria = $this->reportmanager->getSearchCriteria($user_id);
		$property = $this->propertymanager->prepareSearchResult($user_id);
		$this->rest_response['status'] = true;
		$this->rest_response['message'] = "Property deleted successfully.";				
		$this->rest_response['data'] = array();
		$this->response($this->rest_response, 200);
	} 
}
