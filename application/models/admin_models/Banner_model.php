<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } // end function consturct 
    private $_banner = 'tbl_banner'; 
	
	public function get_main_category_info(){
		$this->db->select('*')
                ->from('tbl_main_category')
                ->order_by('id', 'asc');
		$where=' 1=1 ';	
        $query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;			
	}
	
 	public function add_banner($data) { 
        $this->db->insert($this->_banner, $data); 
        return $this->db->insert_id(); 
    }// end fuction store_store
    
    public function get_store_detail($search="" , $category_id = 0) {
		
		$this->db->select('brand.*, main.name as maincategoryname')
                ->from('tbl_brand brand')
				->join('tbl_main_category as main', 'main.id = brand.m_category_id', 'left')
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

    public function get_banner_info($page='1',$search="") {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('banner.*, brand.brand_name as brandname, cat.category_name' )
                ->from('tbl_banner banner')
				->join('tbl_brand as brand', 'brand.id = banner.brand_id', 'left')
				->join('dir_categories as cat', 'cat.category_id = banner.category_id', 'left')
				->where('banner.deletion_status', 1) 
                ->order_by('banner.id', 'desc')
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
	 
	public function get_banner_count($search="",$status='') {
		
        $this->db->select('*') 
                ->from('tbl_banner')  
                ->order_by('id', 'asc');
						$where=' 1=1 ';	
		if($search!=""){
		    //$where .= ' and store.shop_name LIKE "%'.trim($search).'%" '; 
        }
        		
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }// end fuction get_store_count
	
    public function get_banner_info_by_id($banner_id)
    {
        $result = $this->db->get_where($this->_banner, array('id' => $banner_id));
        return $result->row_array();
    }//end function get_brand_info_by_id 

    public function get_store_info_by_name($store_name)
    {
        $result = $this->db->get_where($this->_store, array('shop_name' => $store_name));
        return $result->row_array();
    }//end function get_store_info_by_id 

    public function update_banner($banner_id, $data) {
        $this->db->update($this->_banner, $data, array('id' => $banner_id));
        return $this->db->affected_rows();
    }// end fuction update_brand
	
	public function update_banner_image($updatedata, $insert_id) {
        $this->db->update($this->_banner, $updatedata, array('id' => $insert_id));
        return $this->db->affected_rows();
    }// end fuction update_brand
	
	public function remove_banner_by_id($banner_id) {
        $this->db->update($this->_banner, array('deletion_status' => 0), array('id' => $banner_id));
        return $this->db->affected_rows();
    }// end fucntion remove_banner_by_id
	
	
	public function get_categories_info_tree(){
		$this->db->select('cat.*')
				->from('dir_categories as cat') 
				->where('cat.parent_id !=', 0)
				->where('cat.deletion_status', 0)
				->where('cat.publication_status', 1)
				->order_by('cat.category_name', 'asc');				
				$query_result = $this->db->get();
        $result = $query_result->result_array();
        return $result;
	}

}// end class store
