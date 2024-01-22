<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Agent_login_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    }

    public function check_login_info() {
        $agent_email = $this->input->post('agent_email', true);
        $agent_password = $this->input->post('agent_password', true);
        $this->db->select('*')
                ->from('tbl_agent')
                ->where('agent_email',$agent_email)
                ->where('password', md5($agent_password))
                ->where('deletion_status', 0);
        $query_result = $this->db->get();
		$result = $query_result->row();
        return $result;
    }
}
