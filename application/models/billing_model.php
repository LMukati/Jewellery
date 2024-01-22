<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Billing_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_billing = 'tbl_billing'; 
	
	
	public function store_bill($data) { 
        $this->db->insert($this->_billing, $data); 
        return $this->db->insert_id(); 
    }
	public function store_tras_bill($billdata) { 
        $this->db->insert('tbl_trans_bill', $billdata); 
        return $this->db->insert_id(); 
    }
	
	public function store_payment($payment){ 
        $this->db->insert('tbl_payment', $payment); 
        return $this->db->insert_id(); 
    }
    public function update_payment($billing_id, $data) {
        $this->db->update('tbl_payment', $data, array('bill_id' => $billing_id));
        return $this->db->affected_rows();
    }
	public function billing_info() {
		$this->db->select('bill.*, trans.*, stock.*,payment.*')
                ->from('tbl_billing as bill')
				->join('tbl_trans_bill as trans', 'bill.id = trans.bill_id')
				->join('tbl_stock as stock', 'trans.stock_id = stock.id')
                ->join('tbl_payment as payment', 'bill.id = payment.bill_id')
				->where('bill.deletion_status',0)
				->group_by('trans.bill_id')
                ->order_by('bill.id', 'desc');
				 	
        $query_result = $this->db->get();
		//echo $this->db->last_query();exit();
        $result = $query_result->result_array();
        return $result;
    }
    public function billing_info_export() {
		$this->db->select('bill.*')
                ->from('tbl_billing as bill')
				// ->join('tbl_trans_bill as trans', 'bill.id = trans.bill_id')
				// ->join('tbl_stock as stock', 'trans.stock_id = stock.id')
                // ->join('tbl_payment as payment', 'bill.id = payment.bill_id')
				->where('bill.deletion_status',0)
				//->group_by('bill.bill_id')
                ->order_by('bill.id', 'desc');
				 	
        $query_result = $this->db->get();
		//echo $this->db->last_query();exit();
        $result = $query_result->result_array();
        return $result;
    }
    public function getpaymentlist($bill_id){
		
        $result = $this->db->get_where('tbl_payment', array('bill_id' => $bill_id));
       return $result->result_array();
       
   }
   public function getledgerlist($bill_id){
		
   $this->db->select('bill.*,payment.*')
                       ->from('tbl_payment as payment')
                       ->join('tbl_billing as bill', 'bill.id = payment.bill_id')
				      
                       ->order_by('bill.id', 'desc')
                       ->where('payment.bill_id',$bill_id);
                       $query_result = $this->db->get();
                       //echo $this->db->last_query();exit();
                       $result = $query_result->result_array();
                       return $result;
   
}
   public function gettranslist($bill_id){
    $result = $this->db->get_where('tbl_trans_bill', array('bill_id' => $bill_id));
    return $result->result_array();
   }
    public function billing_trans($edit_billing) {
		$this->db->select('bill.*, trans.*, stock.id,stock.item_name')
                ->from('tbl_billing as bill')
				->join('tbl_trans_bill as trans', 'bill.id = trans.bill_id')
				->join('tbl_stock as stock', 'trans.stock_id = stock.id')
               // ->join('tbl_payment as payment', 'bill.id = payment.id')
				->where('bill.deletion_status',0)
				->where('bill.id',$edit_billing);
				 	
        $query_result = $this->db->get();
		//echo $this->db->last_query();exit();
        $result = $query_result->result_array();
        return $result;
    }
	
    public function del_trans_by_id($bill_id) {
        $this->db-> where('bill_id', $bill_id);
        $this->db-> delete('tbl_trans_bill');
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
	
	

    public function get_billing_by_id($billing_id) {
        $result = $this->db->get_where('tbl_billing', array('id' => $billing_id, 'deletion_status' => 0));
        return $result->row_array();
    }

    public function update_billing($billing_id, $data) {
        $this->db->update('tbl_billing', $data, array('id' => $billing_id));
        return $this->db->affected_rows();
    }

    public function remove_billing_by_id($billing_id) {
        $this->db->delete('tbl_trans_bill',  array('bill_id' => $billing_id));
        $this->db->delete('tbl_payment', array('bill_id' => $billing_id));
        $this->db->delete('tbl_billing', array('id' => $billing_id));
        return $this->db->affected_rows();
    }

}
