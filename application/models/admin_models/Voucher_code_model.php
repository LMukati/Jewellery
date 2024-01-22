<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Voucher_code_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } // end function consturct 
    private $_vcode = 'tbl_voucher_code'; 
	
 	public function add_voucher_code($data) { 
        $this->db->insert($this->_vcode, $data); 
        return $this->db->insert_id(); 
    }// end fuction store_store
    
    public function get_voucher_code_detail($search="") {
		
		$this->db->select('*')
                ->from($this->_vcode)
                ->order_by('code', 'asc');
			$where=' 1=1 ';		
		
		if($search!=""){ 
			$where .= ' and code LIKE "%'.trim($search).'%" ';  
			 
        }// end if search
        
				 	
		$this->db->where( $where );  	
        $query_result = $this->db->get();
        
        $result = $query_result->result_array();
        return $result;
    }// end function store_detail

    public function get_voucher_code_info($page='1',$search="") {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('* ')
                ->from($this->_vcode)
                ->order_by('code', 'asc')
				->limit(PAGINATION,$offset);
			$where=' 1=1 ';		
		
		if($search["search"]!=""){ 
			$where .= ' and (code LIKE "%'.trim($search["search"]).'%" or description LIKE "%'.trim($search["search"]).'%" or discount LIKE "%'.trim($search["search"]).'%" )';  
			 
		}		
            
        if($search["use_status"]!=""){
            $where .= " and is_used = ".$search["use_status"]; 
        }//end if use_status		

		$this->db->where( $where );  	
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }// end function store_info
	
    public function get_vcode_info_by_id($vcode_id)
    {
        $result = $this->db->get_where($this->_vcode, array('id' => $vcode_id));
        return $result->row_array();
    }//end function get_store_info_by_id 

    public function update_voucher_code($vcode_id, $data) {
        $this->db->update($this->_vcode, $data, array('id' => $vcode_id));
        return $this->db->affected_rows();
    }// end fuction update_store

    public function remove_voucher_code_by_id($vcode_id) {
        $this->db->update($this->_vcode, array('id' => $vcode_id));
        return $this->db->affected_rows();
    }// end fucntion remove_store_by_id

}// end class store
