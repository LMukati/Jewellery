<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Review_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_review = 'tbl_review'; 
	
    
	
	public function get_town_list() {          
		$this->db->select('town.*')
		->from('town as town')  
		->where('town.publication_status', 1)
		->where('town.deletion_status', 0)
		->order_by('town.id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function store_agency($data) { 
        $this->db->insert($this->_agency, $data); 
        return $this->db->insert_id(); 
    }
	
	public function categories_relation($category_id,$parent_id) { 
		 
		 $this->db->delete($this->_cat_relation, array('category_id' => $category_id));
		
		 $this->db->select('cat.*')
                ->from('dir_categories_relation as cat') 
				 ->where('cat.category_id', $parent_id) ;
        $query_result = $this->db->get();
        $results = $query_result->result_array();
		$level = 0;
 
		
		foreach($results as $result){ 
			$data=array();
			
			$data['level']=$result['level'];
			$data['category_id']=$category_id;
			$data['path_id']=$result['path_id']; 
			$this->db->insert($this->_cat_relation, $data);
		   
			$level=$level+1;
		}
		
		 $data=array();
		
		 $data['level']=$level;
		 $data['category_id']=$category_id;
		 $data['path_id']=$category_id; 
		
		 $this->db->insert($this->_cat_relation, $data); 
		
        return $this->db->insert_id();
    }
 	
	
    public function get_review_info($page='1',$search="",$status='') {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('review.*,agent.agent_name,town.town_name,sub.suburb_name')
                ->from('tbl_review as review')
				->join('tbl_agent as agent', 'agent.id = review.agent_id','left')
				->join('town as town', 'town.id = agent.town_id','left')
				->join('suburb as sub', 'sub.id = agent.suburb_id','left')
                ->order_by('review.id', 'asc')
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
		//echo $this->db->last_query();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_review_count($search="",$status='') {
		$this->db->select('*') 
                ->from('tbl_review')  
                ->order_by('id', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		$where .= ' and cat.category_name LIKE "%'.trim($search).'%" '; 
		}				if($status!=""){ 		if($status==1){   			$where .= ' and (cat.publication_status ="1"  ) '; 		} else if($status==2){  			$where .= ' and (cat.publication_status ="0" ) ';  		} else if($status==5){	 			$where .= ' and cat.featured ="1"  ';		}  		}		$this->db->where( $where ); 		
				
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
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
	
	
	
	

	
	
	
	 
	
	

    public function get_review_by_id($review_id) {
        $result = $this->db->get_where('tbl_review', array('id' => $review_id));
        return $result->row_array();
    }
	
	public function enable_review_by_id($review_id){
		$this->db->update('tbl_review', array('deletion_status' => 1), array('id' => $review_id));
        return $this->db->affected_rows();
	}
	
	public function disable_review_by_id($review_id){
		$this->db->update('tbl_review', array('deletion_status' => 0), array('id' => $review_id));
        return $this->db->affected_rows();
	}
	
	
	

    public function get_category_by_name($category_name) {
        $result = $this->db->get_where($this->_cat, array('category_name' => $category_name));
        return $result->row_array();
    }

    public function published_category_by_id($category_id) {
        $this->db->update($this->_cat, array('publication_status' => 1), array('category_id' => $category_id));
        return $this->db->affected_rows();
    }
	
	

    public function unpublished_category_by_id($category_id) {
        $this->db->update($this->_cat, array('publication_status' => 0), array('category_id' => $category_id));
        return $this->db->affected_rows();
    }

    public function update_agency($agency_id, $data) {
        $this->db->update($this->_agency, $data, array('id' => $agency_id));
        return $this->db->affected_rows();
    }

    public function remove_agency_by_id($agency_id) {
        $this->db->update($this->_agency, array('deletion_status' => 1), array('id' => $agency_id));
        return $this->db->affected_rows();
    }

}
