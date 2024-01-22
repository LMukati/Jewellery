<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Agency_login_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    }

    public function check_login_info() {
        $agency_email = $this->input->post('agency_email', true);
        $agency_password = $this->input->post('agency_password', true);

        $this->db->select('*')
                ->from('tbl_agency')
                ->where('email',$agency_email)
                ->where('password', md5($agency_password))
                ->where('deletion_status', 0);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
}
