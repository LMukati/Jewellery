<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class CC_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users';   
	
	
	public function get_settings_info(){
        $result = $this->db->get($this->_settings); 
        return $result->row_array(); 
    }
	public function dir_main_categories() {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.parent_id',0) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc')
		->limit(12);	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_all_categories_order_by() {
		
        $this->db->select('cat.*, user.first_name, user.last_name')
        ->from('dir_categories as cat')
        ->join('tbl_users as user', 'cat.user_id = user.user_id')
        ->where('cat.deletion_status', 0)
        ->where('cat.publication_status', 1) 
        ->order_by('cat.parent_id', 'asc')
		->limit(12);	
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	public function get_all_categories_info() {
		
        $this->db->select('cat.*, user.first_name, user.last_name')
        ->from('dir_categories as cat')
        ->join('tbl_users as user', 'cat.user_id = user.user_id')
        ->where('cat.deletion_status', 0)
        ->where('cat.publication_status', 1) 
        ->order_by('cat.category_id', 'asc');
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
    }
	
	 
	
	public function get_product_info($product_id) {
		
		$result = $this->db->get_where('dir_product', array('product_id' => $product_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	

}
