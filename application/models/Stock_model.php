<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Stock_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_stock = 'tbl_stock';
    private $_stock_m = 'tbl_stock_manage'; 
	
	
	public function store_stock($data) { 
        $this->db->insert($this->_stock, $data); 
        return $this->db->insert_id(); 
    }
    public function stock_manage($data) { 
        $this->db->insert($this->_stock_m, $data); 
        return $this->db->insert_id(); 
    }
	
	public function stock_info($page='1',$search="") {
		$PAGINATION=10;
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * $PAGINATION;  
		
        $this->db->select('*')
                ->from('tbl_stock')
				->where('deletion_status',0)
                ->order_by('id', 'desc')
				->limit($PAGINATION,$offset);
			$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and merchant_name LIKE "%'.trim($search).'%" ';  
			 
		}		
		$this->db->where( $where );  	
        $query_result = $this->db->get();
		//echo $this->db->last_query();exit();
        $result = $query_result->result_array();
        return $result;
    }
	public function get_stock_id($stock_id) {
        $result = $this->db->get_where('tbl_stock_manage', array('stock_id' => $stock_id, 'deletion_status' => 0));
        return $result->result_array();
    }
    public function get_stock_l_id($stock_id) {
        $result = $this->db->get_where('tbl_stock_manage', array('id' => $stock_id, 'deletion_status' => 0));
        return $result->result_array();
    }
	
	
	public function get_categories_count($search="",$status='') {
		
        $this->db->select('*') 
                ->from('tbl_main_category')
				->where('deletion_status',0)
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
	
	

    public function get_stock_by_id($stock_id) {
        $result = $this->db->get_where('tbl_stock', array('id' => $stock_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function update_stock($stock_id, $data) {
        $this->db->update('tbl_stock', $data, array('id' => $stock_id));
        return $this->db->affected_rows();
    }
    public function update_stock_l($stock_id, $data) {
        $this->db->update('tbl_stock_manage', $data, array('id' => $stock_id));
        return $this->db->affected_rows();
    }

    public function remove_stock_by_id($stock_id) {
        $this->db->update('tbl_stock', array('deletion_status' => 1), array('id' => $stock_id));
        $this->db->update('tbl_stock_manage', array('deletion_status' => 1), array('id' => $stock_id));
        return $this->db->affected_rows();
    }

}
