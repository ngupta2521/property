<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//include(APPPATH. 'config/constants.php');

class Paginatormanager{
    private $CI;
    private $response;
    public function __construct() {
         $this->CI =& get_instance();
         $this->response = null;
         $this->paginator =null;
    }

    public function loadPagination($dbQuery,$param){
        $config=array();
        $paginate = array();
        if(isset($param['is_ajax_pagination'])){
            $this->CI->load->library('ajaxpagination','ajaxpagination');
            $this->paginator = $this->CI->ajaxpagination;
            $config['target'] = $param['target'];
        }else{
            $this->CI->load->library('pagination','pagination');
            $this->paginator = $this->CI->pagination;
        }
        $config = $this->preparePaginationHtml($param);
        $config['base_url'] = $param['base_url'];

        if(isset($param['uri_segment'])){
            $config["uri_segment"] = $param['uri_segment'];
        }

        if(isset($param['link_func'])){
            $config["link_func"] = $param['link_func'];
        }
        /*if(isset($param['page_query_string'])){
            $config['page_query_string'] = $param['page_query_string'];
        }

        if(isset($param['suffix'])){
            $config['suffix'] = $param['suffix'];
        }*/

        $page = $param['page'];
        $config['per_page'] = $param['no_of_records'];
        $result = $this->getResult($dbQuery,$page,$config['per_page']);
        $paginate['data'] = $result['result'];
        $paginate['count'] = $result['count'];
        $config['total_rows'] = $result['count'];
        $this->paginator->initialize($config); 
        $paginate['pagination'] = $this->paginator->create_links();
        return $paginate;
    }

    public function preparePaginationHtml($param){
        $config = array();
        $config['full_tag_open'] = '<ul class="pagination">';
        if(isset($param['is_ajax_pagination'])){
           $config['full_tag_open'] = '<ul class="pagination" id="pagination_'.$param['link_func'].'" data-url="'.$param['base_url'].'">';
        }
        
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //$config['first_link'] = '&laquo;';
        //$config['first_tag_open'] = '<li class="prev disable">';
        //$config['first_tag_close'] = '</li>';
        //$config['last_link'] = '&raquo;';
        //$config['last_tag_open'] = '<li class="next disable">';
        //$config['last_tag_close'] = '</li>';
        return $config;
    }

    /*public function getBaseUrl(){
        return $this->CI->config->base_url().'index.php/'.$this->CI->uri->segment(1).'/'.$this->CI->uri->segment(2);
    }*/

    public function getResult($dbQuery,$page,$record_per_page){
        $array =array();
        $this->CI->db->stop_cache();
        $array['count'] = $dbQuery->get()->num_rows();
        if($array['count']>0){
            $dbQuery->limit($record_per_page, $page);
            $array ['result']= $dbQuery->get()->result_array();
        }else{
            $array ['result']=array();
        }
        $dbQuery->flush_cache();
        return $array;  
    }
}