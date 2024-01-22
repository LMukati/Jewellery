<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Agent_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } // end function consturct 
    private $_agent = 'tbl_agent'; 
	
 	public function store_agent($data) { 
        $this->db->insert($this->_agent, $data); 
        return $this->db->insert_id(); 
    }// end fuction store_agent
    
    public function get_agent_detail($search="") {
		
		$this->db->select('agent.*')
                ->from('tbl_agent as agent')
                ->where('agent.deletion_status', 0) 
			    ->order_by('agent.agent_name', 'asc');
			$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and agent.agent_name LIKE "%'.trim($search).'%" ';  
			 
		}		
				 	
					$this->db->where( $where );  	
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }// end function aget_detail

    public function get_agent_info($page='1',$search="") {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('agent.*')
                ->from('tbl_agent as agent')
                ->where('agent.deletion_status', 0) 
			    ->order_by('agent.agent_name', 'asc')
				->limit(PAGINATION,$offset);
			$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and (agent.agent_name LIKE "%'.trim($search).'%" or agent.phone LIKE "%'.trim($search).'%" or agent.email LIKE "%'.trim($search).'%")';  
			 
		}		
				 	
					$this->db->where( $where );  	
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }// end function aget_info
	
	 
	public function get_agent_count($search="",$status='') {
		
        $this->db->select('agent.*') 
                ->from('tbl_agent as agent')  
                ->where('agent.deletion_status', 0) 
				->order_by('agent.agent_name', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		    $where .= ' and agent.agent_name LIKE "%'.trim($search).'%" '; 
        }
        		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }// end fuction get_agent_count
	
    public function get_agent_info_by_id($agent_id)
    {
        $result = $this->db->get_where($this->_agent, array('id' => $agent_id, 'deletion_status' => 0));
        return $result->row_array();
    }//end function get_agent_info_by_id 

    public function update_agent($agent_id, $data) {
        $this->db->update($this->_agent, $data, array('id' => $agent_id));
        return $this->db->affected_rows();
    }// end fuction update_agent

    public function remove_agent_by_id($agent_id) {
        $this->db->update($this->_agent, array('deletion_status' => 1), array('id' => $agent_id));
        return $this->db->affected_rows();
    }// end fucntion remove_agent_by_id

}// end class agent
