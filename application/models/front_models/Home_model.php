<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Home_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_agency = 'tbl_agency'; 
	private $_cat_relation = 'dir_categories_relation'; 
    
	
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
 	
	
    public function get_agency_info($page='1',$search="",$status='') {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('agency.*, town.town_name,sub.suburb_name')
                ->from('tbl_agency as agency')
				->join('town as town', 'town.id = agency.town_id','left')
				->join('suburb as sub', 'sub.id = agency.suburb_id','left')
                ->where('agency.deletion_status', 0) 
				->order_by('agency.id', 'asc')
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
	
	
	public function get_categories_info_tree($parent_id = 0) { 
		
        $this->db->select('cat.*, user.first_name, user.last_name')
                ->from('dir_categories as cat')
                ->join('tbl_users as user', 'cat.user_id = user.user_id','left')
                ->where('cat.deletion_status', 0) 
				->where('cat.publication_status', 1)
                ->order_by('cat.category_name', 'asc');
                if($parent_id > 0){
                    $this->db->where('cat.parent_id', $parent_id);
                } else {
                    $this->db->where('cat.parent_id', 0);
                }
				
        $query_result = $this->db->get();
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
	
	public function get_town_info($id,$page='1',$search="",$status=''){
		if($page<1){
			 $page=1;
		 } 
		$offset = ($page - 1) * PAGINATION;  
		$this->db->select('agent.*, town.town_name,sub.suburb_name')
                ->from('tbl_agent as agent')
				->join('town as town', 'town.id = agent.town_id','left')
				->join('suburb as sub', 'sub.id = agent.suburb_id','left')
				->where('agent.town_id', $id) 
                ->where('agent.deletion_status', 0) 
				->order_by('agent.id', 'asc')
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
	
	public function get_autosuggest_info($q){
	    $this->db->select('agency, concat(id,"_","agency") as agency_id');
		$this->db->from('tbl_agency');
		$this->db->like('agency', $q);
		$this->db->where('deletion_status',0);
		$query1 = $this->db->get_compiled_select();

		$this->db->select('agent_name, concat(id,"_","agent") as agency_id');
		$this->db->from('tbl_agent');
		$this->db->like('agent_name', $q);
		$this->db->where('deletion_status',0);
		$query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . ' UNION ' . $query2 .' ORDER BY agency');
		//echo $this->db->last_query();exit();
		return $query->result_array();
		
	}
	
	public function get_agent_autosuggest_info($q){
		
		$this->db->select('*');
		$this->db->from('tbl_agent');
		$this->db->where('deletion_status',0);
		$this->db->like('agent_name', $q);
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit();
        return $query_result->result_array();
	}
	
	public function get_agency_count($search="",$status='') {
		$this->db->select('*') 
                ->from('tbl_agency')  
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
	
	public function get_autosearch_data($search_id, $home_town_id, $home_suburbs_id, $user){
		
		if(!empty($search_id)){
			$arr=explode('_', $search_id);
			$id=$arr[0];
			$user=$arr[1];
			
			if($user == 'agent' ){
			    $agent_id=$id;	
				$this->db->where('agent.id', $agent_id);
			}
			
			if($user == 'agency'){
				$agency_id=$id;	
				$this->db->where('agent.agency_id', $agency_id);
			}
		}
		
		if($home_town_id > 0){
			$this->db->where('agent.town_id', $home_town_id);
		}
		
		if($home_suburbs_id > 0){
			$this->db->where('agent.suburb_id', $home_suburbs_id);
		}
		
		$this->db->select('agency.*,agent.id as agent_id,agent.agent_name as agent_name,
agent.cell as cell,agent.cell as cell,agent.create_date as create_date,sub.suburb_name') 
                ->from('tbl_agent as agent')
				->join('tbl_agency as agency', 'agency.id = agent.agency_id','left')
				->join('suburb as sub', 'sub.id = agent.suburb_id','left')
				->where('agent.deletion_status', 0) 
				->order_by('agent.id', 'asc');
		
	            /* $this->db->select('agency.*,agent.agent_name as agent_name,
agent.cell as cell,agent.cell as cell,agent.create_date as create_date,sub.suburb_name') 
                ->from('tbl_agent as agent')
				->join('tbl_agency as agency', 'agency.id = agent.agency_id','left')
				->join('suburb as sub', 'sub.id = agency.suburb_id','left')
                ->where('agent.agency_id', $id) 
                ->where('agent.deletion_status', 0) 
				->order_by('agent.id', 'asc');*/
		
		
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query_result->result_array();		
	}
	
	
	public function get_agent_info($agent_id){
	
       $this->db->select('agency.agency as agency_name,review.quick_rate as rate,review.slider0,
	   review.slider1,review.slider2,review.slider3,town.id as town_id,town.town_name,agent.id as agent_id,agent.agent_name as agent_name,
agent.cell as cell,agent.agent_photo,agent.create_date as create_date,agent.agent_email,sub.suburb_name') 
                ->from('tbl_agent as agent')
				->join('tbl_agency as agency', 'agency.id = agent.agency_id','left')
				->join('town as town', 'town.id = agent.town_id','left')
				->join('suburb as sub', 'sub.id = agent.suburb_id','left')
				->join('tbl_review as review', 'review.agent_id = agent.id','left')
				->where('agent.id', $agent_id)
				->where('agent.deletion_status', 0); 
				
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query_result->row_array();	
	}
	
	public function store_review($data){
		$this->db->insert('tbl_review', $data); 
		return $this->db->insert_id();
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

    public function get_agency_by_id($agency_id) {
        $result = $this->db->get_where($this->_agency, array('id' => $agency_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_town_by_id($town_id) {
        $result = $this->db->get_where('town', array('id' => $town_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_blog_detail($blog_id) {
        $result = $this->db->get_where('tbl_blog', array('id' => $blog_id, 'deletion_status' => 0));
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

    public function update_agency($agency_id, $data) {
        $this->db->update($this->_agency, $data, array('id' => $agency_id));
        return $this->db->affected_rows();
    }

    public function remove_agency_by_id($agency_id) {
        $this->db->update($this->_agency, array('deletion_status' => 1), array('id' => $agency_id));
        return $this->db->affected_rows();
    }
	
	public function check_email($email){
		$result = $this->db->get_where($this->_agency, array('email' => $email));
        return $result->row_array();
	}
	
	public function check_email_agent($agent_email){
		$result = $this->db->get_where('tbl_agent', array('agent_email' => $agent_email));
        return $result->row_array();
	}
	
	public function change_password($agency_id, $change_password) {
        $this->db->update($this->_agency, array('password' => md5($change_password)), array('id' => $agency_id));
        return $this->db->affected_rows();
    }
	
	public function agent_change_password($agent_id, $change_password) {
        $this->db->update('tbl_agent', array('password' => md5($change_password)), array('id' => $agent_id));
        return $this->db->affected_rows();
    }
	
}
