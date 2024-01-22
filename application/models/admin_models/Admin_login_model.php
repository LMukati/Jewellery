<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_login_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    }

    public function check_login_info() {
        $username_or_email_address = $this->input->post('username_or_email_address', true);
        $password = $this->input->post('password', true);
        //print_r($username_or_email_address."===".$password);die;
        $this->db->select('*')
                ->from('tbl_users')
                ->where("(username = '$username_or_email_address' OR email_address = '$username_or_email_address')")
                ->where('password', md5($password))
                ->where("(access_label = '1' OR access_label = '2' OR access_label = '3')")
                ->where('activation_status', 1)
                ->where('deletion_status', 0)
                ->where('access_label <= ', 4);
        $query_result = $this->db->get();
        
        $result = $query_result->row();
        return $result;
    }
}
