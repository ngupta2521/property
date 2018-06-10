<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Propertymanager{
    private $CI;
    private $response;
    public function __construct() {
         $this->CI =& get_instance();
         $this->response = null;
    } 
    public function deleteProperty($user_id){
        $this->CI->load->model('property_model','property');
        $dateTime = date('Y-m-d H:i:s');
        return $this->CI->db->query("update `tbl_property` set deleted_at='$dateTime' where user_id=".$user_id." order by id desc limit 1" );
    }
    public function setProperty($data){
        $this->CI->load->model('property_model','property');
        return $property_id = $this->CI->property->insert($data);
    }

    public function getUserByField($array){
        $this->CI->load->model('user_model','user');
        $user_info = (array) $this->CI->user->as_array()->get_by($array);
         return $user_info;
    }


    public function getPropertyById($id){
        $this->CI->load->model('property_model','property');
        $property_info = (array) $this->CI->property->as_array()->get_by(
                array('id'=>$id)
            );
         return $property_info;
    }

    public function prepareSearchResult($user_id,$pagination=array()){
        $this->CI->load->library('reportmanager');
        $searchCriteria = $this->CI->reportmanager->getSearchCriteria($user_id);
        if(count($searchCriteria)>0){
            if($searchCriteria['user_type']==1){  
                $user_type = 2;
            }
            if($searchCriteria['user_type']==2){
                $user_type = 1;
            }
            if($searchCriteria['user_type']==3){
                $user_type = 4;
            }
            if($searchCriteria['user_type']==4){
                $user_type = 3;
            } 
            $searchCriteria['user_type'] = $user_type;
            
            if($searchCriteria['user_type']==1 || $searchCriteria['user_type']==3){
                return $this->reportList($searchCriteria,$pagination);
            }else{
                return $this->propertyList($searchCriteria,$pagination);
            }
        }else{
            return array();
        }
    }

    public function prepareSearchReport($searchCriteria,$pagination=array()){
        $this->CI->load->library('reportmanager');
            if($searchCriteria['user_type']==1 || $searchCriteria['user_type']==3){
                return $this->reportList($searchCriteria,$pagination);
            }else{
                return $this->propertyList($searchCriteria,$pagination);
            }
    }

    public function propertyList($passed_params,$pagination){
        $this->CI->load->library('paginatormanager','paginatormanager');
        $this->CI->load->model('property_model','property');
        $this->CI->load->model('user_model','user');
        $this->CI->db->start_cache();
        $this->CI->db->select('p.*,u.name as post_by');
        $this->CI->db->from('tbl_property p');
        $this->CI->db->join('tbl_user u', 'u.id = p.user_id', 'inner');
        $this->CI->db->where( array('p.property_type'=> $passed_params['property_type'],'p.postal_pin'=>$passed_params['postal_pin']));
        $this->CI->db->where('((p.budget_min_price <='.$passed_params['budget_min_price'].' AND p.budget_max_price >='.$passed_params['budget_min_price'].') OR (p.budget_min_price <='.$passed_params['budget_max_price'].' AND p.budget_max_price >='.$passed_params['budget_max_price'].') OR p.budget_max_price < '.$passed_params['budget_max_price'].')');
        
        if($passed_params['user_type']==2){
            $this->CI->db->where( array('(DATE(p.created_date) + INTERVAL 3 MONTH)  >='=>date('Y-m-d')));
        }
        if($passed_params['user_type']==4){
            $this->CI->db->where( array('(DATE(p.created_date) + INTERVAL 1 MONTH)  >='=>date('Y-m-d')));
        }
        $this->CI->db->where( array('p.city'=>$passed_params['city'],'p.user_type'=>$passed_params['user_type']));
        $this->CI->db->where( array('p.deleted_at='=>NULL));
        if($pagination['is_true']){
                  $property_list=  $this->CI->paginatormanager->loadPagination($this->CI->db,$pagination);
                }else{
                    $property_list = $this->CI->db->get()->result_array();
                }
        $this->CI->db->flush_cache();
        return $property_list;
        //echo $this->CI->db->last_query(); die;
    }
    
    public function reportList($passed_params,$pagination){
        $this->CI->load->library('paginatormanager','paginatormanager');
        $this->CI->load->model('report_model','report');
        $this->CI->load->model('user_model','user');
        $this->CI->db->start_cache();
        $this->CI->db->select('r.*,u.name as post_by');
        $this->CI->db->from('tbl_report r');
        $this->CI->db->join('tbl_user u', 'u.id = r.user_id', 'inner');
        $this->CI->db->where( array('r.property_type'=> $passed_params['property_type'],'r.postal_pin'=>$passed_params['postal_pin']));
        $this->CI->db->where('((r.budget_min_price <='.$passed_params['budget_min_price'].' AND r.budget_max_price >='.$passed_params['budget_min_price'].') OR (r.budget_min_price <='.$passed_params['budget_max_price'].' AND r.budget_max_price >='.$passed_params['budget_max_price'].') OR r.budget_max_price < '.$passed_params['budget_max_price'].')');
        $this->CI->db->where( array('r.city'=>$passed_params['city'],'r.user_type'=>$passed_params['user_type']));
        $this->CI->db->where( array('r.deleted_at='=>NULL));
         if($pagination['is_true']){
                  $report_list=  $this->CI->paginatormanager->loadPagination($this->CI->db,$pagination);
                }else{
                    $report_list = $this->CI->db->get()->result_array();
                }
        $this->CI->db->flush_cache();
        return $report_list;
    }
    
}