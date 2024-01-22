<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Store_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } // end function consturct 
    private $_store = 'tbl_marchent'; 
	
 	public function add_store($data) { 
        $this->db->insert($this->_store, $data); 
        return $this->db->insert_id(); 
    }// end fuction store_store
    
    public function get_store_detail($search="" , $category_id = 0) {
		
		$this->db->select('store.*')
                ->from('tbl_marchent as store')
                ->where('store.activation_status', 1) 
			    ->order_by('store.shop_name', 'asc');
			$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and store.shop_name LIKE "%'.trim($search).'%" ';  
        }		
        
        if($category_id > 0){
            $where .= ' and store.category = '.trim($category_id).'';  
        }// end if category_id
				 	
		$this->db->where( $where );  	
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }// end function store_detail

    public function get_store_info($page='1',$search="") {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('store.* , tbl1.balance')
                ->from('tbl_marchent as store')
                ->join("(select sum(credit_points-debit_points) as balance ,user_id from tbl_locadel_credit as loca_credit
                where user_type = 'marchent' and is_revert = 0 group by user_id) as tbl1","tbl1.user_id = store.id","left")
                ->where('store.activation_status', 1) 
			    ->order_by('store.shop_name', 'asc')
				->limit(PAGINATION,$offset);
			$where=' 1=1 ';		
		
		if($search["search"]!=""){ 
			$where .= ' and (store.shop_name LIKE "%'.trim($search["search"]).'%" or store.shop_contact_number LIKE "%'.trim($search["search"]).'%" or store.email_id LIKE "%'.trim($search["search"]).'%")';  
        }// end if search
        if($search["pay_status"]!=""){
            $where .= ' and ifnull(tbl1.balance,0) '.$search["pay_status"]; 
        }//end if pending balance		
        $this->db->where( $where );  	
        $query_result = $this->db->get();
        //echo $this->db->last_query();
        $result = $query_result->result_array();
        return $result;
    }// end function store_info

    function get_unique_shop_id(){
		$this->db->select_max('username');
		$result = $this->db->get($this->_store)->row();  
		return $result->username;
	}// end get_unique_shop_id
	 
	public function get_store_count($search="",$status='') {
		
        $this->db->select('store.*') 
                ->from('tbl_marchent as store')  
                ->where('store.activation_status', 1) 
				->order_by('store.shop_name', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		    $where .= ' and store.shop_name LIKE "%'.trim($search).'%" '; 
        }
        		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }// end fuction get_store_count
	
    public function get_store_info_by_id($store_id)
    {
        $result = $this->db->get_where($this->_store, array('id' => $store_id, 'activation_status' => 1));
        return $result->row_array();
    }//end function get_store_info_by_id 

    public function get_store_info_by_name($store_name)
    {
        $result = $this->db->get_where($this->_store, array('shop_name' => $store_name));
        return $result->row_array();
    }//end function get_store_info_by_id 

    public function update_store($store_id, $data) {
        $this->db->update($this->_store, $data, array('id' => $store_id));
        return $this->db->affected_rows();
    }// end fuction update_store

    public function remove_store_by_id($store_id) {
        $this->db->update($this->_store, array('activation_status' => 0), array('id' => $store_id));
        return $this->db->affected_rows();
    }// end fucntion remove_store_by_id

}// end class store
