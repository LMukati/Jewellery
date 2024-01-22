<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_customer = 'tbl_customer';   
	
	public function get_customer_info($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		//$orderby = $search['orderby'];  
		//if($orderby == "" )  $orderby = "customer.firstname,customer.lastname";
		$orderby = "customer.firstname,customer.lastname"; 

		 $this->db->select('customer.*, tbl1.balance')
		->from('tbl_customer as customer') 
		->join("(select sum(credit_points-debit_points) as balance ,user_id from tbl_locadel_credit as loca_credit
		where user_type = 'customer' and is_revert = 0 group by user_id) as tbl1","tbl1.user_id = customer.customer_id","left") 
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("customer.customer_id = ".$search["customer_id"]);
		}// end if customer_id
		if($search["from_date"] != "" && $search["to_date"] != "")
		{
			$this->db->where("date_format(customer.date_added,'%Y-%m-%d') between '".$search["from_date"]."' and '".$search["to_date"]."'");
		}// end if date

		if($search["search"] != "")
		{
			$this->db->where("concat(customer.firstname,' ',customer.lastname) like '%".$search["search"]."%' or phone like '%".$search["search"]."%' or email like '%".$search["search"]."%'");
		}// end if search

		if($search["story_status"] != '')
		{
			$this->db->where("customer.is_story = ".$search["story_status"]);
		}// end if story_status

		if($search["balance"] != '')
		{
			$balance = explode("-",$search["balance"]);
			$this->db->where("tbl1.balance between '".$balance[0]."' and '".$balance[1]."'");
		}

		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_task

	public function get_customer_count($search) {          
		
		//$orderby = $search['orderby'];  
		//if($orderby == "" )  $orderby = "customer.firstname,customer.lastname";
		$orderby = "customer.firstname,customer.lastname"; 
		$this->db->select('customer.* , tbl1.balance')
		->from('tbl_customer as customer')
		->join("(select sum(credit_points-debit_points) as balance ,user_id from tbl_locadel_credit as loca_credit
		where user_type = 'customer' group by user_id) as tbl1","tbl1.user_id = customer.customer_id","left")   
		->order_by($orderby);
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("customer.customer_id = ".$search["customer_id"]);
		}// end if customer_id
		if($search["from_date"] != "" && $search["to_date"] != "")
		{
			$this->db->where("date_format(customer.date_added,'%Y-%m-%d') between '".$search["from_date"]."' and '".$search["to_date"]."'");
		}// end if date

		if($search["balance"] != '')
		{
			$balance = explode("-",$search["balance"]);
			$this->db->where("tbl1.balance between '".$balance[0]."' and '".$balance[1]."'");
		}

		if($search["search"] != "")
		{
			$this->db->where("concat(customer.firstname,' ',customer.lastname) like '%".$search["search"]."%' or phone like '%".$search["search"]."%' or email like '%".$search["search"]."%'");
		}// end if search

		if($search["story_status"] != '')
		{
			$this->db->where("customer.is_story = ".$search["story_status"]);
		}// end if story_status


		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}// end fucntion customer count
	
	public function update_customer($customer_id , $data)
	{
		$this->db->update("tbl_customer",$data,array('customer_id' => $customer_id));
		return $this->db->affected_rows();
	}// end fucntion update_customer

	public function get_customer_detail($search) {          
		
		//$orderby = $search['orderby'];  
		//if($orderby == "" )  $orderby = "customer.firstname,customer.lastname";
		$orderby = "customer.firstname,customer.lastname"; 

		 $this->db->select('customer.*')
		->from('tbl_customer as customer')  
		->order_by($orderby, 'asc');
		
		if($search["multi_customer_id"] != '')
		{
			$this->db->where("customer.customer_id in (".$search["multi_customer_id"].")");
		}
		if($search["customer_id"] > 0)
		{
			$this->db->where("customer.customer_id = ".$search["customer_id"]);
		}// end if customer_id
		if($search["from_date"] != "" && $search["to_date"] != "")
		{
			$this->db->where("date_format(customer.date_added,'%Y-%m-%d') between '".$search["from_date"]."' and '".$search["to_date"]."'");
		}// end if date

		if($search["search"] != "")
		{
			$this->db->where("concat(customer.firstname,' ',customer.lastname) like '%".$search["search"]."%' or phone like '%".$search["search"]."%' or email like '%".$search["search"]."%'");
		}// end if search

		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_customer_detail

	  
}// end class customer_model
