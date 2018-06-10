<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Property extends MY_Controller {
	public function __construct() {
         $this->data = null;
         parent::__construct();
    }
	 
	public function manage(){
		$this->load->library('usermanager');
		$this->load->library('propertymanager');
		$this->load->library('reportmanager');
		$passed_params = array(); 
 		$this->form_validation->set_rules('user_type', 'user type', 'trim|required');
        $this->form_validation->set_rules('property_type', 'property type', 'trim|required');
        $this->form_validation->set_rules('budget_min_price', 'min budget', 'trim|required|numeric');
        $this->form_validation->set_rules('budget_max_price', 'max budget', 'trim|required|numeric');
        $this->form_validation->set_rules('postal_pin', 'postal pin', 'trim|required|numeric|max_length[6]');
 		$this->form_validation->set_rules('city', 'city', 'trim|required');
 		$passed_params = $this->input->post();
 		if(isset($this->session->userdata['user'])){
 			$user_id = $this->session->userdata['user']['id'];
 		}else{
 			redirect('user/login');
 		}
 		if ($this->form_validation->run() === TRUE)
		{
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
		}
		$pagination['is_true']=true;
		$pagination['base_url']=$this->config->base_url().'index.php/property/manage';
		$pagination['page']=($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$pagination['no_of_records']=NO_OF_RECORD_PER_PAGE;
		$this->data = $this->propertymanager->prepareSearchResult($user_id,$pagination);
		$this->data['page_title'] = 'Manage property';
		$this->data['search_criteria'] = $this->reportmanager->getSearchCriteria($user_id);
		return $this->data;
	}

	public function deleteproperty(){
		$this->load->library('propertymanager');
		$this->load->library('reportmanager');
		if(isset($this->session->userdata['user'])){
 			$user_id = $this->session->userdata['user']['id'];
 		}else{
 			redirect('user/login');
 		}
		$this->propertymanager->deleteProperty($user_id);
		$this->reportmanager->deleteReport($user_id);
		redirect('property/manage');
	} 
}