<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiData_model extends CC_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'tbl_users'; 
	private $_cat = 'dir_categories'; 
	private $_customer = 'tbl_customer'; 
	
	public function get_user_detail()
	{
		$result = $this->db->get_where($this->_users, array('username' => 'admin'));
        return $result->row_array();
	}// end function get_user_detail
	
	public function get_all_categories() {          
		
		$this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.parent_id',0) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	     
		 
	public function get_user_data_by_phone($phone) { 
		$result = $this->db->get_where($this->_customer, array('phone' => $phone, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	public function get_otp($phone) { 

		$result = $this->db->get_where($this->_customer, array('phone' => $phone , 'deletion_status' => 0, 'activation_status' => 1));
        return $result->row_array();
    }

	public function verify_user($phone,$verify_number) { 
		//,'verify_number' => $verify_number
		$result = $this->db->get_where($this->_customer, array('phone' => $phone  , 'deletion_status' => 0, 'activation_status' => 1));
        return $result->row_array();
    }
	
	public function get_customer_info($customer_id) {
        $result = $this->db->get_where($this->_customer, array('customer_id' => $customer_id, 'activation_status' => 1, 'deletion_status' => 0));
        return $result->row_array();

    }
	
	public function get_customer_info_by_id($customer_id,$otp) {
        $result = $this->db->get_where($this->_customer, array('customer_id' => $customer_id,/*'verify_number' => $otp,*/ 'activation_status' => 1, 'deletion_status' => 0));
        return $result->row_array();

    }
	
	
	public function update_user($customer_id, $data) {   
        $this->db->update($this->_customer, $data, array('customer_id' => $customer_id)); 
        return $this->db->affected_rows(); 
    }// end update_user

    public function user_fcm_update($fcm_token)
	{
		$this->db->update($this->_customer, array("fcm_token" => ""), array('fcm_token' => $fcm_token)); 
        return $this->db->affected_rows(); 
	}// end if agent fcm update
	
	
	public function store_user_registration_info($data){
		$this->db->insert($this->_customer, $data);
		return $this->db->insert_id();
	}	 
	
	/* order detail */
	function get_bill_no()
	{
		$this->db->select('max(bill_no) as bill_no')
		->from('tbl_order_master');  
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result;
	}//end function get_bill_no

	public function insert_order($data){
		$this->db->insert("tbl_order_master", $data);
		return $this->db->insert_id();
	}// end function insert_task

	public function insert_order_detail($data){
		$this->db->insert("tbl_order_detail", $data);
		return $this->db->insert_id();
	}// end function insert_task

	public function get_all_order($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		$this->db->select('orders.* , group_concat(product_name) as item_name , group_concat(item_qty) as item_qty , group_concat(item_price) as item_price , agent.agent_name') 
		->from('tbl_order_master as orders')  
        ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
        ->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->group_by("orders.id")
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		//->group_by("task.task_id");	 
		if($search["customer_id"] > 0)
		{
			$this->db->where("orders.user_id = ".$search["customer_id"]);
		}// end if customer_id

        if($search["order_id"] > 0)
		{
			$this->db->where("orders.id = ".$search["order_id"]);
		}// end if customer_id
        
        if($search["search"] != "")
		{
            $this->db->where("orders.bill_no like '%".$search["search"]."%' or (select 1 as count from dir_product where 
            product_id = order_detail.item_id and product_name like '%".$search["search"]."%' ) ");
        }// endi if search
		if($search["status"] != '')
		{
			$this->db->where("orders.is_complete = ".$search["status"]);
		}// end if status
		if($search["agent_task"] > 0)
		{
			$this->db->where("orders.agent = ".$search["agent_task"]);
		}// end if agent

		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_task

	public function get_all_order_count($search) {          
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		 $this->db->select('orders.*')
        ->from('tbl_order_master as orders')  
        ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->order_by($orderby, $order_by);
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("orders.user_id = ".$search["customer_id"]);
		}// end if customer_id

		if($search["search"] != "")
		{
            $this->db->where("orders.bill_no like '%".$search["search"]."%' or (select 1 as count from dir_product where 
            product_id = order_detail.item_id and product_name like '%".$search["search"]."%' ) ");
       }// endi if search
		if($search["status"] != '')
		{
			$this->db->where("orders.is_complete = ".$search["status"]);
		}// end if customer_id

		if($search["agent_task"] > 0)
		{
			$this->db->where("orders.agent = ".$search["agent_task"]);
		}// end if agent
		
		  
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}

	/* order detail */
	/*task*/
	
	public function insert_task($data){
		$this->db->insert("tbl_task", $data);
		return $this->db->insert_id();
	}// end function insert_task
	
	public function update_task($task_id, $data) {   
		$this->db->update("tbl_task", $data, array('id' => $task_id));
	    return $this->db->affected_rows(); 
    }// end function update_task
	
	public function insert_taskitem_detail($data){
		//$sql = $this->db->set($data)->get_compiled_insert('tbl_task');
		//echo $sql;exit;
	
		$this->db->insert("tbl_task_item", $data);
		return $this->db->insert_id();
	}// end function insert_taskitem_detail
	
	public function update_taskitem_detail($id, $data) {   
        $this->db->update("tbl_task_item", $data, array('id' => $id)); 
        return $this->db->affected_rows(); 
    }
	
	public function get_task_info($task_id) {
		
		$result = $this->db->get_where('tbl_task', array('id' => $task_id));
        return $result->row_array();
    }//end function get_product_info
	
	public function get_taskitem_info($task_id) {
		
		$result = $this->db->get_where('tbl_task_item', array('task_id' => $task_id));
        return $result->result_array();
    }//end function get_product_info
	

	public function get_all_task($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "task.id";
		 
		 $this->db->select('task.* , group_concat(item_name) as item_name , group_concat(qty) as item_qty , agent.agent_name')
		->from('tbl_task as task')  
		->join('tbl_task_item as task_item',"task.id = task_item.task_id","left outer")
		->join('tbl_agent as agent',"task.agent = agent.id","left outer")
		->group_by("task.id")
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		//->group_by("task.task_id");	 
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("entryby = ".$search["customer_id"]);
		}// end if customer_id
		if($search["is_reccuring"] > 0)
		{
			$this->db->where("reccuring_order = 1");
		} else {
			$this->db->where("DATE_FORMAT(entrydate,'%Y-%m-%d') <= '".date("Y-m-d")."'");
		} // end if is_reccuring
		
		if($search["is_favorite"] > 0)
		{
			$this->db->where("is_favorite = 1");
		}// end if is_favorite

		if($search["is_cancel"] > 0)
		{
			$this->db->where("is_cancel = 1");
		}else {
			$this->db->where("is_cancel = 0");
		}// end if is_cancel
		
		if($search["agent"] > 0)
		{
			$this->db->where("agent = ".$search["agent"]);
		}// end if is_cancel
		

		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_task

	public function get_all_task_count($search) {          
		
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "task.id";
		 
		 $this->db->select('task.*')
		->from('tbl_task as task')  
		->order_by($orderby, $order_by);
		
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("entryby = ".$search["customer_id"]);
		}// end if customer_id
		if($search["is_reccuring"] > 0)
		{
			$this->db->where("reccuring_order = 1");
		}// end if is_reccuring
		
		if($search["is_favorite"] > 0)
		{
			$this->db->where("is_favorite = 1");
		}// end if is_favorite	 

		if($search["is_cancel"] > 0)
		{
			$this->db->where("is_cancel = 1");
		}else {
			$this->db->where("is_cancel = 0");
		}// end if is_cancel

		if($search["agent"] > 0)
		{
			$this->db->where("agent = ".$search["agent"]);
		}// end if is_cancel
		
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}

	/*task*/	

	/* Story */
	
	public function insert_story($data){
		$this->db->insert("tbl_story", $data);
		return $this->db->insert_id();
	}// end function insert_task

	public function update_story($id, $data) {   
        $this->db->update("tbl_story", $data, array('id' => $id)); 
        return $this->db->affected_rows(); 
	}// end if update_story
	
	public function get_all_story($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "story.id";
		 
		 $this->db->select('story.* , tbl_customer.firstname as username ')
		->from('tbl_story as story') 
		->join('tbl_customer',"story.create_by = tbl_customer.customer_id",'left outer') 
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		//->group_by("task.task_id");	 
		
		if($search["story_id"] != "")
		{
			$this->db->where("story.id = ".$search["story_id"]);
		}// end if story_id

		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_story

	public function get_all_story_count($search) {          
		
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "story.id";
		 
		 $this->db->select('story.*')
		->from('tbl_story as story')  
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		
		if($search["story_id"] != "")
		{
			$this->db->where("story.id = ".$search["story_id"]);
		}// end if story_id
		
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}// end fucntion story count


	/* Story */
	
	/*product*/ 
	
	public function get_filter_products($search,$page=1,$order_by='desc') { 
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$filter_orderby = 'product.product_id';
		$filter_order = 'desc';
		 
		 $this->db->select('product.* , GROUP_CONCAT(tbl_store.store_name ORDER BY tbl_store.store_name) as store_name')
		->from('dir_product as product')  
		->join('tbl_store','FIND_IN_SET(tbl_store.id, product_store) > 0','left')
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->group_by('product.product_id')
		->order_by($filter_orderby, $filter_order)
		->limit($PAGINATION,$offset);	 
		
		
		$where = ' 1=1'; 
		
		/**/
			if($category_id){
			    $query_path="SELECT * FROM dir_categories_relation where path_id IN (".$category_id.") ";
				$sql_path = $this->db->query($query_path);
				$result_path=$sql_path->result_array();  
				foreach($result_path as $path){
				  $categories_relation=$path['category_id'];
				  $filter_category[]=$categories_relation; 
				}
			    $filter_category[]= $category_id;
			}
			
			if(!empty($filter_category)) 
			{ 
				$condition='';  
				foreach($filter_category as $filter){  
					$condition .=" FIND_IN_SET('".$filter."',product.product_category ) OR"; 
				}
				$condition=trim($condition,"OR"); 
				$where =' ('.$condition.') ';   
				$this->db->where( $where );
			}
		/**/ 
		
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array(); 
        return $result; 
    }
	
	
	
	public function get_filter_products_count($search) { 
		
		
		
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$filter_orderby = 'product.product_id';
		$filter_order = 'desc';
		
		 
		 $this->db->select('product.*')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		
		->order_by($filter_orderby, $filter_order);	 
		
		
		$where = ' 1=1'; 
		
		/**/
			if($category_id){
			    $query_path="SELECT * FROM dir_categories_relation where path_id IN (".$category_id.") ";
				$sql_path = $this->db->query($query_path);
				$result_path=$sql_path->result_array();  
				foreach($result_path as $path){
				  $categories_relation=$path['category_id'];
				  $filter_category[]=$categories_relation; 
				}
			    $filter_category[]= $category_id;
			}
			
			if(!empty($filter_category)) 
			{ 
				$condition='';  
				foreach($filter_category as $filter){  
					$condition .=" FIND_IN_SET('".$filter."',product.product_category ) OR"; 
				}
				$condition=trim($condition,"OR"); 
				$where =' ('.$condition.') ';   
				$this->db->where( $where );
			}
		/**/ 
		
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array(); 
     
		 
	 
		
        return count($result); 
    }
	
	public function get_product_info($product_id) {
		
		$result = $this->db->get_where('dir_product', array('product_id' => $product_id, 'deletion_status' => 0));
        return $result->row_array();
    }
	
	/*product*/
	 
	/**agent detail */
	public function check_agent_login_info($data) {
         
        $this->db->select('*')
                ->from('tbl_agent')
                ->where("email = '".$data["username"]."'")
                ->where('password', md5($data["password"]))
				->where('deletion_status', 0);
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
        $result = $query_result->row();
        return $result;
	}// end function agent login
	
	public function agent_update($agent_id , $data)
	{
		$this->db->update('tbl_agent', $data, array('id' => $agent_id)); 
        return $this->db->affected_rows(); 
	}// end if agent update

	public function agent_fcm_update($fcm_token)
	{
		$this->db->update('tbl_agent', array("fcm_token" => ""), array('fcm_token' => $fcm_token)); 
        return $this->db->affected_rows(); 
	}// end if agent fcm update

	public function verify_agent($email,$token) { 
		$result = $this->db->get_where('tbl_agent', array('email' => $email,'token' => $token , 'deletion_status' => 0));
		return $result->row_array();
	}// end function verify_agent
	
	public function task_location_store($data)
	{
		$this->db->insert('tbl_task_location', $data);
		return $this->db->insert_id();	
	}// end function task_location_store

	public function get_task_location($task_id)
	{
		$this->db->select('*')
		->from('tbl_task_location')
		->where("task_id = ".$task_id)
		->order_by('id', 'desc')
		->limit(1);
		$result = $this->db->get();
		return $result->row_array();	 
	}// end function get_task_location

	public function get_active_task($agent_id)
	{
		$this->db->select('*')
		->from('tbl_task')
		->where(array("agent" => $agent_id , "is_task_active" => "1", "is_agent_complete" => "0"));
		
		$result = $this->db->get();
		return $result->result_array();	 
	}

	/**agent detail */ 
	
}
?>