<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MY_Controller {
	public function __construct() {
         $this->data = null;
         parent::__construct();
    }
	
	public function reportlist(){
		$this->load->library('reportmanager');
		$this->load->library('propertymanager');
		$passed_params = array();
		$property_list = array();
		$this->data['data'] = $property_list;
		$this->data['count'] = 0;
		$this->data['pagination'] = '';
		$this->data['user_type'] = '';
 		$this->form_validation->set_rules('user_type', 'user type', 'trim|required');
        $this->form_validation->set_rules('property_type', 'property type', 'trim|required');
        $this->form_validation->set_rules('budget_min_price', 'min budget', 'trim|required|numeric');
        $this->form_validation->set_rules('budget_max_price', 'max budget', 'trim|required|numeric');
        $this->form_validation->set_rules('postal_pin', 'postal pin', 'trim|required|numeric|max_length[6]');
 		$this->form_validation->set_rules('city', 'city', 'trim|required');
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
 		$pagination['uri_segment']=3;
		$pagination['base_url']= $this->config->base_url().'index.php/report/reportlist';
		$pagination['page']=($this->uri->segment(3)) ? $this->uri->segment(3) :$this->input->get('page');
		$pagination['is_true']=true;
		$pagination['target']='#report';
		$pagination['link_func']='report';
		$pagination['is_ajax_pagination']=true;
		$pagination['no_of_records']=1;//NO_OF_RECORD_PER_PAGE;
 		if ($this->form_validation->run() === TRUE)
		{
			$passed_params = $this->input->post();
			$this->data = $this->propertymanager->prepareSearchReport($passed_params,$pagination);
			$this->data['user_type']=$passed_params['user_type'];
		}
		if ($this->input->is_ajax_request()) {
			$passed_params = $this->input->get();
			unset($passed_params['_']);
			$this->data = $this->propertymanager->prepareSearchReport($passed_params,$pagination);
			$this->data['user_type']=$passed_params['user_type'];
			$this->view = FALSE;
			$theHTMLResponse = $this->load->view('report/reportajax', $this->data, true);
    		$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('htmlresponse'=> $theHTMLResponse)));
		}
		$this->data['page_title'] = 'Report';
		return $this->data;
	}
}