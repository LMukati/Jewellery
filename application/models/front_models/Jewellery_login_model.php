<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Jewellery_login_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
		  $this->load->database(); 
    }

    public function check_login_info($jewl_password) {
		echo $jewl_password;
        $this->db->select('*')
                ->from('tbl_users')
                ->where('password', md5($jewl_password))
                ->where('deletion_status', 0);
        
		//echo $this->db->last_query();exit();
        $query_result = $this->db->get();
		$result = $query_result->result_array();
		//return $result;
		 echo "<pre>";
				print_r($result);
        //return $result;
    }
}
