<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonial_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_testimonial = 'tbl_testimonial'; 
	
    
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
	
	public function store_testimonial($data) { 
        $this->db->insert($this->_testimonial, $data); 
        return $this->db->insert_id(); 
    }
	
	 public function get_testimonial_info($page='1',$search="",$status='') {
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('*')
                ->from('tbl_testimonial')
				->where('deletion_status', 0) 
				->order_by('id', 'asc')
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
	
		public function get_testimonial_count($search="",$status='') {
		         $this->db->select('*') 
                ->from('tbl_testimonial')  
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
	
	public function get_testimonial_by_id($testimonial_id) {
        $result = $this->db->get_where('tbl_testimonial', array('id' => $testimonial_id, 'deletion_status' => 0));
        return $result->row_array();
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

    public function update_testimonial($testimonial_id, $data) {
        $this->db->update('tbl_testimonial', $data, array('id' => $testimonial_id));
        return $this->db->affected_rows();
    }

    public function remove_testimonial_info_by_id($testimonial_id) {
        $this->db->update('tbl_testimonial', array('deletion_status' => 1), array('id' => $testimonial_id));
        return $this->db->affected_rows();
    }

}
