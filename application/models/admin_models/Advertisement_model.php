<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Advertisement_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_advertisement = 'tbl_advertisement'; 
	
	public function get_advertisement_list() {          
		
		$this->db->select('*')
		->from('tbl_advertisement')  
		->order_by('id', 'desc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function store_advertisement($data) { 
        $this->db->insert($this->_advertisement, $data); 
        return $this->db->insert_id(); 
    }
	
	public function get_advertisement_info($page='1',$search="",$status='') {
		
		if($page<1){
			 $page=1;
		 } 
		 $offset = ($page - 1) * PAGINATION;  
		
        $this->db->select('tbl_advertisement.* , tbl_brand.brand_name as brand_name')
                ->from($this->_advertisement)
                ->join('tbl_brand',"tbl_brand.id = tbl_advertisement.brand_id","left")
                ->order_by('id', 'desc')
				->limit(PAGINATION,$offset);
			$where=' 1=1 ';		
            
            if($search != ""){
                $where .= " and (tbl_brand.brand_name like '%".$search."%' or date_format(tbl_advertisement.start_date,'%d-%m-%Y') like '%".$search."%' or date_format(tbl_advertisement.end_date,'%d-%m-%Y') like '%".$search."%')";
            }
    
            if($status!=""){ 			
                $where .= ' and (tbl_advertisement.isActive ="'.$status.'"  ) ';
            }		
	    $this->db->where( $where );  	
        $query_result = $this->db->get();
        //echo $this->db->last_query();
        $result = $query_result->result_array();
        return $result;
    }
	
	
 	public function get_advertisement_count($search="",$status='') {
		
        $this->db->select('*') 
                ->from($this->_advertisement)  
                ->order_by('id', 'desc');
						$where=' 1=1 ';	
		 
				
        $query_result = $this->db->get();
        $result = $query_result->result_array();
        return count($result);
    }
	

    public function get_advertisement_by_id($advertisement_id) {
        $result = $this->db->get_where($this->_advertisement, array('id' => $advertisement_id));
        return $result->row_array();
    }

    public function update_advertisement($advertisement_id, $data) {
        $this->db->update($this->_advertisement, $data, array('id' => $advertisement_id));
        return $this->db->affected_rows();
    }

    public function update_advertisement_inactive() {
        $this->db->where("date_format(end_date,'%Y-%m-%d') < '".date("Y-m-d")."'");
        $this->db->where("isActive = 1");
        $this->db->update($this->_advertisement, array("isActive" => "0"));
        return $this->db->affected_rows();
    }
 

}
