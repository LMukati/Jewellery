<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Client_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_client = 'tbl_client'; 
	
    
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
	
	public function store_client($data) { 
        $this->db->insert($this->_client, $data); 
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
 	
	
    public function get_client_info($page='1',$search="",$status='') {
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('*')
                ->from('tbl_client')
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
	
	
	public function get_client_count($search="",$status='') {
		         $this->db->select('*') 
                ->from('tbl_blog')  
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
	
	
	public function get_categories_all_info() {
		
        $this->db->select('cat.*')
                ->from('dir_categories as cat') 
                ->where('cat.deletion_status', 0)
				->where('cat.publication_status', 1) 
                ->order_by('cat.category_name', 'asc');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	
	
	 public function get_sub_categories_info($parent_id,$page='1',$search="",$status='') {
		 
		 if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;
		
        $this->db->select('cat.*, user.first_name, user.last_name')
                ->from('dir_categories as cat')
                ->join('tbl_users as user', 'cat.user_id = user.user_id')
                ->where('cat.deletion_status', 0) 
				->where('cat.parent_id', $parent_id)
                ->order_by('cat.category_name', 'asc')
				->limit(PAGINATION,$offset);
				$where=' 1=1 ';	
		if($search!=""){
		 $where .= ' and cat.category_name LIKE "%'.trim($search).'%" ';  	
	/* 	$this->db->where( $where );  */	
		}				if($status!=""){ 		if($status==1){   			$where .= ' and (cat.publication_status ="1"  ) '; 		} else if($status==2){  			$where .= ' and (cat.publication_status ="0" ) ';  		} else if($status==5){	 			$where .= ' and cat.featured ="1"  ';		}  		}
		$this->db->where( $where );		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_sub_categories_info_count($parent_id,$search="",$status='') {  
        $this->db->select('cat.*, user.first_name, user.last_name')
                ->from('dir_categories as cat')
                ->join('tbl_users as user', 'cat.user_id = user.user_id')
                ->where('cat.deletion_status', 0) 
				->where('cat.parent_id', $parent_id)
                ->order_by('cat.category_name', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		$where .= ' and cat.category_name LIKE "%'.trim($search).'%" ';  		
		
		}				if($status!=""){ 		if($status==1){   			$where .= ' and (cat.publication_status ="1" ) '; 		} else if($status==2){  			$where .= ' and (cat.publication_status ="0" ) ';  		} else if($status==5){	 			$where .= ' and cat.featured ="1"  ';		}  		}
		$this->db->where( $where ); 			
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }

    public function get_client_by_id($client_id) {
        $result = $this->db->get_where($this->_client, array('id' => $client_id, 'deletion_status' => 0));
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

    public function update_client($client_id, $data) {
        $this->db->update($this->_client, $data, array('id' => $client_id));
        return $this->db->affected_rows();
    }

    public function remove_client_by_id($client_id) {
        $this->db->update($this->_client, array('deletion_status' => 1), array('id' => $client_id));
        return $this->db->affected_rows();
    }

}
