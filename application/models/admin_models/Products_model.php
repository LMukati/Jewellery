<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_product = 'dir_product';   
	
	public function get_product_info($page=1,$search="",$status='') {          

		if($page<1){
			$page=1;
		} 

		$offset = ($page - 1) * PAGINATION; 

		$this->db->select('product.*,users.first_name,users.last_name,users.email_address')
		->from('dir_product as product') 
		->join('tbl_users as users', 'product.user_id = users.user_id','left')
		->where('product.deletion_status', 0)
		->order_by('product.product_id', 'desc')
		->limit(PAGINATION,$offset);	

		$where=' 1=1 ';	

		if($search!=""){
			$where .= ' and product.product_name LIKE "%'.trim($search).'%" '; 
		} 	

		if($status!=""){
			if($status==1){  
			$where .= ' and product.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and product.publication_status ="0"  ';  
			}
		}

		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function get_product_count($search='',$status='') {          

		$this->db->select('product.*,users.first_name,users.last_name,users.email_address')
		->from('dir_product as product') 
		->join('tbl_users as users', 'product.user_id = users.user_id','left')
		->where('product.deletion_status', 0)
		->order_by('product.product_id', 'desc');	

		$where=' 1=1 ';	
		if($search!=""){
			$where .= ' and product.product_name LIKE "%'.trim($search).'%" '; 
		}
		if($status!=""){
			if($status==1){  
			$where .= ' and product.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and product.publication_status ="0"  ';  
			}
		}
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
    public function store_product($data) { 
        $this->db->insert($this->_product, $data); 
        return $this->db->insert_id(); 
    } 
	
	public function store_variant($variant){
		$this->db->insert('dir_product_detail', $variant); 
        return $this->db->insert_id();
	}
	
	public function delete_varient($product_id){
			$this->db->where('product_id', $product_id);
			$this->db->delete('dir_product_detail');
	  return TRUE;
	}
	
	public function store_import_product($data){
		$res = $this->db->insert_batch($this->_product,$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
	}
	
	 public function get_product_by_product_id($product_id) {
        $result = $this->db->get_where($this->_product, array('product_id' => $product_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_product_variant($product_id) {
        $result = $this->db->get_where('dir_product_detail', array('product_id' => $product_id));
        return $result->result_array();
    }

    public function published_product_by_id($product_id) {
        $this->db->update($this->_product, array('publication_status' => 1), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

    public function unpublished_product_by_id($product_id) {
        $this->db->update($this->_product, array('publication_status' => 0), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

    public function update_product($product_id, $data) {
        $this->db->update($this->_product, $data, array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

    public function remove_product_by_id($product_id) {
        $this->db->update($this->_product, array('deletion_status' => 1), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }

}
