<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Brand_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } // end function consturct 
    private $_brand = 'tbl_brand'; 
	
 	public function add_brand($data) { 
        $this->db->insert($this->_brand, $data); 
        return $this->db->insert_id(); 
    }// end fuction store_store
    
    public function get_brand_detail($search="" , $category_id = 0) {
		
		$this->db->select('*')
                ->from('tbl_brand')
                ->where('deletion_status', 1)  
			    ->order_by('brand_name', 'asc');
			$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and brand_name LIKE "%'.trim($search).'%" ';  
        }		
        
        if($category_id > 0){
            $where .= ' and store.category = '.trim($category_id).'';  
        }// end if category_id
				 	
		$this->db->where( $where );  	
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }// end function store_detail

    public function get_brand_info($page='1',$search="") {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('*')
                ->from('tbl_brand')
				->where('deletion_status', 1) 
                ->order_by('brand_name', 'asc')
				->limit(PAGINATION,$offset);
			$where=' 1=1 ';		
		
		if($search["search"]!=""){ 
			$where .= ' and (brand_name LIKE "%'.trim($search["search"]).'%")';  
        }// end if search
        if($search["pay_status"]!=""){
            $where .= ' and ifnull(tbl1.balance,0) '.$search["pay_status"]; 
        }//end if pending balance		
        $this->db->where( $where );  	
        $query_result = $this->db->get();
        //echo $this->db->last_query();
		//exit();
        $result = $query_result->result_array();
        return $result;
    }// end function store_info

    function get_unique_shop_id(){
		$this->db->select_max('username');
		$result = $this->db->get($this->_store)->row();  
		return $result->username;
	}// end get_unique_shop_id
	 
	public function get_brand_count($search="",$status='') {
		
        $this->db->select('*') 
                ->from('tbl_brand')  
                ->order_by('brand_name', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		    $where .= ' and store.shop_name LIKE "%'.trim($search).'%" '; 
        }
        		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }// end fuction get_store_count
	
    public function get_brand_info_by_id($brand_id)
    {
        $result = $this->db->get_where($this->_brand, array('id' => $brand_id));
        return $result->row_array();
    }//end function get_brand_info_by_id 

    public function get_store_info_by_name($store_name)
    {
        $result = $this->db->get_where($this->_store, array('shop_name' => $store_name));
        return $result->row_array();
    }//end function get_store_info_by_id 

    public function update_brand($brand_id, $data) {
        $this->db->update($this->_brand, $data, array('id' => $brand_id));
        return $this->db->affected_rows();
    }// end fuction update_brand

    public function remove_brand_by_id($brand_id) {
        $this->db->update($this->_brand, array('deletion_status' => 0), array('id' => $brand_id));
        return $this->db->affected_rows();
    }// end fucntion remove_store_by_id

}// end class store
