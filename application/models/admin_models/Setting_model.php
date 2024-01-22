<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_brand = 'dir_brand';    
	private $_settings = 'tbl_settings';   
	private $_homesetting = 'dir_homesetting';   	
	private $_mobilesetting = 'dir_mobilesetting';   	
	
	public function get_general_info() {
        $result = $this->db->get_where($this->_settings, array('setting_id' => 1));
        return $result->row_array();
    }
	public function update_setting($data) {
        $this->db->update($this->_settings, $data, array('setting_id' => 1));
        return $this->db->affected_rows();
    }
	
	 
	public function get_homesetting_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('homesetting.*')
		->from('dir_homesetting as homesetting')  

		->order_by('homesetting.sort_order', 'asc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and homesetting.title LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and homesetting.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and homesetting.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_homesetting_count($search='',$status='') {          
		$this->db->select('homesetting.*')
		->from('dir_homesetting as homesetting')  

		->order_by('homesetting.sort_order', 'asc');	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and homesetting.title LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and homesetting.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and homesetting.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
	public function store_homesetting($data) { 
        $this->db->insert($this->_homesetting, $data); 
        return $this->db->insert_id(); 
    }  
	
	
	public function update_homesetting($setting_id,$data) {
        $this->db->update($this->_homesetting, $data, array('setting_id' => $setting_id));
        return $this->db->affected_rows();
    }
	
	public function get_homesetting_by_setting_id($setting_id) {
        $result = $this->db->get_where($this->_homesetting, array('setting_id' => $setting_id));
        return $result->row_array();
    }
	 
	public function published_homesetting_by_id($setting_id) {
        $this->db->update($this->_homesetting, array('publication_status' => 1), array('setting_id' => $setting_id));
        return $this->db->affected_rows();
    }

    public function unpublished_homesetting_by_id($setting_id) {
        $this->db->update($this->_homesetting, array('publication_status' => 0), array('setting_id' => $setting_id));
        return $this->db->affected_rows();
    }
	
	public function remove_homesetting_by_id($setting_id) {
        $this->db->delete($this->_homesetting,  array('setting_id' => $setting_id));
        return 1;
    }
	
	
	/****************************************************/
	/******************* mobile *************************/
	/****************************************************/
	
	
	public function get_mobilesetting_info($page=1,$search="",$status='') {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('mobilesetting.*')
		->from('dir_mobilesetting as mobilesetting')  

		->order_by('mobilesetting.sort_order', 'asc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and mobilesetting.title LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and mobilesetting.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and mobilesetting.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_mobilesetting_count($search='',$status='') {          
		$this->db->select('mobilesetting.*')
		->from('dir_mobilesetting as mobilesetting')  

		->order_by('mobilesetting.sort_order', 'asc');	 
		$where=' 1=1 ';	 
		if($search!=""){
			$where .= ' and mobilesetting.title LIKE "%'.trim($search).'%" '; 
		} 	 
		if($status!=""){
			if($status==1){  
			$where .= ' and mobilesetting.publication_status ="1"';  	 
			} else if($status==2){ 
			$where .= ' and mobilesetting.publication_status ="0"  ';  
			}
		} 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}
	
	
	public function store_mobilesetting($data) { 
        $this->db->insert($this->_mobilesetting, $data); 
        return $this->db->insert_id(); 
    }  
	
	
	public function update_mobilesetting($setting_id,$data) {
        $this->db->update($this->_mobilesetting, $data, array('setting_id' => $setting_id));
        return $this->db->affected_rows();
    }
	
	public function get_mobilesetting_by_setting_id($setting_id) {
        $result = $this->db->get_where($this->_mobilesetting, array('setting_id' => $setting_id));
        return $result->row_array();
    }
	 
	public function published_mobilesetting_by_id($setting_id) {
        $this->db->update($this->_mobilesetting, array('publication_status' => 1), array('setting_id' => $setting_id));
        return $this->db->affected_rows();
    }

    public function unpublished_mobilesetting_by_id($setting_id) {
        $this->db->update($this->_mobilesetting, array('publication_status' => 0), array('setting_id' => $setting_id));
        return $this->db->affected_rows();
    }
	
	public function remove_mobilesetting_by_id($setting_id) {
        $this->db->delete($this->_mobilesetting,  array('setting_id' => $setting_id));
        return 1;
    }
	
	
	
	
}