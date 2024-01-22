<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Jewellery_login_model extends CC_Model { 
    public function __construct() {
        parent::__construct();

    }

    public function check_login_info() {
        $jewl_password = $this->input->post('jewl_password', true);

        $this->db->select('*')
                ->from('tbl_users')
                ->where('password', md5($jewl_password))
                ->where('deletion_status', 0);
        $query_result = $this->db->get();
		//echo $this->db->last_query();exit();
        $result = $query_result->row();
		 
        return $result;
    }
}
