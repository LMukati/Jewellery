<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Tasks_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_customer = 'tbl_customer';   
	
	public function get_tasks_info($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "task.id";
		 
		 $this->db->select('task.* , group_concat(item_name) as item_name , group_concat(qty) as item_qty , agent.agent_name , 
		 concat(customer.firstname," ",customer.lastname) as customer_name , customer.phone as customer_contact')
		->from('tbl_task as task')  
		->join('tbl_task_item as task_item',"task.id = task_item.task_id","left outer")
		->join('tbl_agent as agent',"task.agent = agent.id","left outer")
		->join('tbl_customer as customer',"task.entryby = customer.customer_id","left outer")
		->group_by("task.id")
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		//->group_by("task.task_id");	 
		
		if($search["search"] != "")
		{
			$this->db->where("task.from_address like '%".$search["search"]."%' or task.to_address like '%".$search["search"]."%' or task.priority like '%".$search["search"]."%' or task.task_type like '%".$search["search"]."%' or concat(customer.firstname,' ',customer.lastname) like '%".$search["search"]."%'");
		}// endi if search
		if($search["status"] != '')
		{
			$this->db->where("task.is_complete = ".$search["status"]);
		}// end if status
		if($search["in_progress"] != '')
		{
			$this->db->where("task.is_task_active = ".$search["in_progress"]);
		}//end if 
		if($search["agent_task"] > 0)
		{
			$this->db->where("task.agent = ".$search["agent_task"]);
		}// end if agent

		if($search["task_type"] != "")
		{
			$this->db->where("task.task_type = '".$search["task_type"]."'");
		}// end if agent

		if($search["priority"] != "")
		{
			$this->db->where("task.priority = '".$search["priority"]."'");
		}// end if agent

		if($search["assign_status"] != '')
		{
			$this->db->where("ifnull(task.agent,0) ".$search["assign_status"]);
		}

		if($search["task_id"] > 0)
		{
			$this->db->where("task.id = ".$search["task_id"]);
		}// end if customer_id
		if($search["is_favorite"] > 0)
		{
			$this->db->where("is_favorite = 1");
		}// end if is_favorite

		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_task

	public function get_tasks_count($search) {          
		
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "task.id";
		 
		 $this->db->select('task.*')
		->from('tbl_task as task')  
		->join('tbl_task_item as task_item',"task.id = task_item.task_id","left outer")
		->join('tbl_agent as agent',"task.agent = agent.id","left outer")
		->join('tbl_customer as customer',"task.entryby = customer.customer_id","left outer")
		->group_by("task.id")
		->order_by($orderby);
		
		if($search["search"] != "")
		{
			$this->db->where("task.from_address like '%".$search["search"]."%' or task.to_address like '%".$search["search"]."%' or task.priority like '%".$search["search"]."%' or task.task_type like '%".$search["search"]."%' or concat(customer.firstname,' ',customer.lastname) like '%".$search["search"]."%'");
		}// endi if search
		if($search["status"] != '')
		{
			$this->db->where("task.is_complete = ".$search["status"]);
		}// end if customer_id

		if($search["in_progress"] != '')
		{
			$this->db->where("task.is_task_active = ".$search["in_progress"]);
		}//end if 

		if($search["agent_task"] > 0)
		{
			$this->db->where("task.agent = ".$search["agent_task"]);
		}// end if agent

		if($search["task_type"] != "")
		{
			$this->db->where("task.task_type = '".$search["task_type"]."'");
		}// end if agent

		if($search["priority"] != "")
		{
			$this->db->where("task.priority = '".$search["priority"]."'");
		}// end if agent
		
		if($search["assign_status"] != '')
		{
			$this->db->where("ifnull(task.agent,0) ".$search["assign_status"]);
		}

		if($search["customer_id"] > 0)
		{
			$this->db->where("entryby = ".$search["customer_id"]);
		}// end if customer_id
		if($search["is_favorite"] > 0)
		{
			$this->db->where("is_favorite = 1");
		}// end if is_favorite	 
		
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
    }// end function get_tasks_count
    
    public function update_task($task_id , $data)
	{
		$this->db->update("tbl_task",$data,array('id' => $task_id));
		return $this->db->affected_rows();
	}// end fucntion update_customer

	public function get_total_tasks_revenue(){
		$this->db->select('sum(task.total_amount) as  total_amount')
		->from('tbl_task as task');
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result;
	}
	  
}// end class Tasks_model
