<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Reportmanager{
    private $CI;
    private $response;
    public function __construct() {
         $this->CI =& get_instance();
         $this->response = null;
    }

    public function setReport($data){
        $this->CI->load->model('report_model','report');
        return $report_id = $this->CI->report->insert($data);
    }

    public function getSearchCriteria($user_id){
        $this->CI->load->model('report_model','report');
        $this->CI->db->select("r.*");
        $this->CI->db->from('tbl_report r');
        $this->CI->db->where( array('r.user_id'=> $user_id));
        $this->CI->db->where( array('r.deleted_at='=> NULL));
        $this->CI->db->order_by("r.id","desc");
        $this->CI->db->limit(1, 0);
        return $report = $this->CI->db->get()->row_array();
    }

    public function deleteReport($user_id){
        $this->CI->load->model('report_model','report');
        $dateTime = date('Y-m-d H:i:s');
        return $this->CI->db->query("update `tbl_report` set deleted_at='$dateTime' where user_id=".$user_id." order by id desc limit 1" );

    }
}