<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    
	public function get_order_info($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		$this->db->select('orders.* , group_concat(product_name) as item_name , group_concat(item_qty) as item_qty 
		, agent.agent_name , group_concat(marchent.shop_name) as marchent_name , 
		concat(customer.firstname," ",customer.lastname) as customer_name , customer.phone as customer_contact') 
		->from('tbl_order_master as orders')  
        ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent',"product.product_store = marchent.id","left outer")
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->join('tbl_customer as customer',"orders.user_id = customer.customer_id","left outer")
		->group_by("orders.id")
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);

		//->group_by("task.task_id");	 
		
        if($search["order_id"] > 0)
		{
			$this->db->where("orders.id = ".$search["order_id"]);
		}// end if customer_id
        
        if($search["search"] != "")
		{
            $this->db->where("orders.bill_no like '%".$search["search"]."%' or (select 1 as count from dir_product where 
			product_id = order_detail.item_id and product_name like '%".$search["search"]."%' ) or orders.total_amount like '%".$search["search"]."%'
			or orders.delivery_amount like '%".$search["search"]."%' or orders.item_amount like '%".$search["search"]."%' or concat(customer.firstname,' ',customer.lastname) like '%".$search["search"]."%'");
        }// endi if search
		if($search["status"] != '')
		{
			$this->db->where("orders.is_complete = ".$search["status"]);
		}// end if status
		if($search["in_progress"] != '')
		{
			$this->db->where("orders.in_progress = ".$search["in_progress"]);
		}
		if($search["agent_task"] > 0)
		{
			$this->db->where("orders.agent = ".$search["agent_task"]);
		}// end if agent
		if($search["marchent"] > 0)
		{
			$this->db->where("marchent.id = ".$search["marchent"]);
		}// end if marchent

		if($search["amount"] != '')
		{
			$balance = explode("-",$search["amount"]);
			$this->db->where("orders.item_amount between '".$balance[0]."' and '".$balance[1]."'");
		}

		if($search["del_amount"] != '')
		{
			$balance = explode("-",$search["del_amount"]);
			$this->db->where("orders.delivery_amount between '".$balance[0]."' and '".$balance[1]."'");
		}

		if($search["total_amount"] != '')
		{
			$balance = explode("-",$search["total_amount"]);
			$this->db->where("orders.total_amount between '".$balance[0]."' and '".$balance[1]."'");
		}
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_task

	public function get_order_count($search) {          
		
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		 $this->db->select('orders.*')
        ->from('tbl_order_master as orders')  
		->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent',"product.product_store = marchent.id","left outer")
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->group_by("orders.id")
		->order_by($orderby);
		
		if($search["search"] != "")
		{
            $this->db->where("orders.bill_no like '%".$search["search"]."%' or (select 1 as count from dir_product where 
            product_id = order_detail.item_id and product_name like '%".$search["search"]."%' ) ");
       }// endi if search
		if($search["status"] != '')
		{
			$this->db->where("orders.is_complete = ".$search["status"]);
		}// end if customer_id
		if($search["in_progress"] != '')
		{
			$this->db->where("orders.in_progress = ".$search["in_progress"]);
		}
		
		if($search["agent_task"] > 0)
		{
			$this->db->where("orders.agent = ".$search["agent_task"]);
		}// end if agent
		if($search["marchent"] > 0)
		{
			$this->db->where("marchent.id = ".$search["marchent"]);
		}// end if marchent

		if($search["amount"] != '')
		{
			$balance = explode("-",$search["amount"]);
			$this->db->where("orders.item_amount between '".$balance[0]."' and '".$balance[1]."'");
		}

		if($search["del_amount"] != '')
		{
			$balance = explode("-",$search["del_amount"]);
			$this->db->where("orders.delivery_amount between '".$balance[0]."' and '".$balance[1]."'");
		}

		if($search["total_amount"] != '')
		{
			$balance = explode("-",$search["total_amount"]);
			$this->db->where("orders.total_amount between '".$balance[0]."' and '".$balance[1]."'");
		}
		
		  
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
    }// end function get_order_count
    
    public function update_order($order_id , $data)
	{
		$this->db->update("tbl_order_master",$data,array('id' => $order_id));
		return $this->db->affected_rows();
	}// end fucntion update_customer

	public function get_total_order_revenue(){
		$this->db->select('sum(orders.total_amount) as  total_amount')
		->from('tbl_order_master as orders');
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result;
	}
	  
}// end class Tasks_model
