<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Agency_agent_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    }
    private $_agent = 'tbl_agent'; 
    public function store_agent($data) { 
        $this->db->insert($this->_agent, $data); 
        return $this->db->insert_id(); 
    }
	
	 public function get_agent_info($page='1',$search="",$status='',$agency_id) {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('agent.*, town.town_name,sub.suburb_name')
                ->from('tbl_agent as agent')
				->join('tbl_agency as agency', 'agency.id = agent.agency_id','left')
				->join('town as town', 'town.id = agent.town_id','left')
				->join('suburb as sub', 'sub.id = agent.suburb_id','left')
                ->where('agent.agency_id', $agency_id)
				->where('agent.deletion_status', 0) 
				->order_by('agent.id', 'desc')
				->limit(PAGINATION,$offset);
		$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and cat.category_name LIKE "%'.trim($search).'%" ';  
			 
		}		
					if($status!=""){ 			
						if($status==1){   				
						$where .= ' and (cat.publication_status ="1"  ) '; 			
						} else if($status==2){  				
						$where .= ' and (cat.publication_status ="0"  ) ';  			
						} else if($status==5){	 				
						$where .= ' and cat.featured ="1"  ';			
						}  		
					}		
					
		$this->db->where( $where );  	
        $query_result = $this->db->get();
		//echo $this->db->last_query(); exit();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_agent_count($search="",$status='',$agency_id) {
		$this->db->select('*') 
                ->from('tbl_agent') 
                ->where('agency_id', $agency_id)				
                ->where('deletion_status', 0) 
				->order_by('id', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		$where .= ' and cat.category_name LIKE "%'.trim($search).'%" '; 
		}				if($status!=""){ 		if($status==1){   			$where .= ' and (cat.publication_status ="1"  ) '; 		} else if($status==2){  			$where .= ' and (cat.publication_status ="0" ) ';  		} else if($status==5){	 			$where .= ' and cat.featured ="1"  ';		}  		}		$this->db->where( $where ); 		
				
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }
	
	public function update_agent_photo($data, $insert_id){
		$this->db->update('tbl_agent', $data, array('id' => $insert_id));
        return $this->db->affected_rows();
	}
	
	public function get_agent_info_by_id($agent_id){
		$result = $this->db->get_where('tbl_agent', array('id' => $agent_id, 'deletion_status' => 0));
        return $result->row_array();
		
	}
	
	public function get_suburbs_info($id){
		       $this->db->select('suburb.*')
                ->from('suburb as suburb')
				->where('suburb.deletion_status', 0)
				->where('suburb.town_id', $id)
                ->order_by('suburb.id', 'desc');
				$query_result = $this->db->get();
		 $result = $query_result->result_array();
        return $result;
	}
	
	public function update_agent($data,$edit_id) {
        $this->db->update('tbl_agent', $data, array('id' => $edit_id));
        return $this->db->affected_rows();
    }
	
	public function remove_agent_by_id($agent_id){
	  $this->db->update('tbl_agent', array('deletion_status' => 1), array('id' => $agent_id));
      return $this->db->affected_rows();
	}
	
	
	    public function get_agent_review_by_id($agent_id) {
        $this->db->select('*')
                ->from('tbl_review')
				->where('deletion_status', 1)
				->where('agent_id', $agent_id);
                $query_result = $this->db->get();
		 $result = $query_result->result_array();
        return $result;
    }
}
