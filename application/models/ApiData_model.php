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
	
	public function get_main_categories(){
		$this->db->select('*')
			->from('tbl_main_category'); 
			$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_all_brands(){
		$this->db->select('*')
			->from('tbl_brand') 
			->where('deletion_status', 1);
			$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
		
	}
	
	public function get_brand_name($brand_id){
		$this->db->select('brand_name,id')
			->from('tbl_brand') 
			->where('id', $brand_id);
			$query_result = $this->db->get();
		return $query_result->row_array();
	}
	
	public function get_all_banners(){
		$this->db->select('*')
			->from('tbl_banner') 
			->where('deletion_status', 1);
			$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}
	
	
	public function get_m_categories($mid){
		$this->db->select('name,id')
			->from('tbl_main_category') 
			->where('id', $mid);
			$query_result = $this->db->get();
		
		
		return $query_result->row_array();
	}
	
	public function get_all_categories($parent_id = 0 , $marchent_category = '') {          
		
		if((int)$parent_id > 0){ 
  		       $this->db->where('cat.m_category_id',$parent_id); 
					   }
		else {  
		    $this->db->where('cat.parent_id',0); 
		  }  
		 $this->db->select('cat.*')
		->from('dir_categories as cat')  
		->where('cat.publication_status', 1) 
		->where('cat.deletion_status',0) 
		->order_by('cat.category_id', 'asc');	 
		if($marchent_category != '')  {    $this->db->where('cat.category_id in ('.$marchent_category.')');  }
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	public function check_category_product($cat_id,$shop_id){
		$this->db->select('product.product_id')
		->from('dir_product as product')  
		->where('product.product_store', $shop_id) 
		->where('product.product_sub_category',$cat_id);
		$query_result = $this->db->get();
		
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_all_advertisement() {          
		//advertisement
		$this->db->select('tbl_advertisement.* , tbl_brand.id as brand_id, tbl_brand.brand_name as brand_name')
		->from('tbl_advertisement')  
		->join('tbl_brand','tbl_brand.id = tbl_advertisement.brand_id','left')
		->where('isActive',1)
		->where("date_format(now(),'%Y-%m-%d') between date_format(start_date,'%Y-%m-%d') and date_format(end_date,'%Y-%m-%d')")
		->order_by('id', 'desc');	 
		 
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
		$result = $this->db->get_where($this->_customer, array('phone' => $phone ,'verify_number' => $verify_number  , 'deletion_status' => 0, 'activation_status' => 1));
        return $result->row_array();
    }
	
	/*public function get_customer_info($customer_id) {
        $result = $this->db->get_where($this->_customer, array('customer_id' => $customer_id, 'activation_status' => 1, 'deletion_status' => 0));
        return $result->row_array();

    }*/
	
	public function get_customer_info_by_id($customer_id,$otp) {
		//,'verify_number' => $otp
        $result = $this->db->get_where($this->_customer, array('customer_id' => $customer_id ,'verify_number' => $otp , 'activation_status' => 1, 'deletion_status' => 0));
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

	public function user_fcm_update_ios($fcm_token)
	{
		$this->db->update($this->_customer, array("fcm_token_ios" => ""), array('fcm_token_ios' => $fcm_token)); 
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

	public function update_order($order_id, $data) {   
		$this->db->update("tbl_order_master", $data, array('id' => $order_id));
		return $this->db->affected_rows(); 
	}// end function update_task
	
	public function get_order_info($order_id) {
		$result = $this->db->select('orders.* , concat(customer.firstname," ",customer.lastname) as customer_name , customer.address as customer_address ,
		customer.phone as customer_contact ,  group_concat(product_name) as item_name 
		, group_concat(item_qty) as item_qty , group_concat(item_price) as item_price , agent.agent_name
		,group_concat(marchent.shop_name) as shop_name , group_concat(marchent.shop_contact_number) as shop_contact , group_concat(marchent.address SEPARATOR "##") as shop_address') 
		->from('tbl_order_master as orders')  
        ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent','product.product_store = marchent.id','left outer')
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->join('tbl_customer as customer','customer.customer_id = orders.user_id','let outer')
		->where('orders.id' , $order_id)
		->group_by("orders.id")->get();
		//$result = $this->db->get_where('tbl_order_master', array('id' => $order_id));
        return $result->row_array();
	}//end function get_order_info
	
	public function get_active_order($agent_id)
	{
		$this->db->select('*')
		->from('tbl_order_master')
		->where(array("agent" => $agent_id , "in_progress" => "2", "is_agent_complete" => "0"));
		$result = $this->db->get();
		return $result->result_array();	 
	}

	public function get_all_order($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		$this->db->select('orders.* ,product.discount_price, product.short_desc, product.variant_detail, product.product_images, product.gallery_featured, concat(customer.firstname," ",customer.lastname) as customer_name , customer.address as customer_address ,customer.landmark_of_address as flat_no,
		customer.phone as customer_contact , group_concat(item_id) as item_id,  group_concat(product_name) as item_name 
		, group_concat(item_qty) as item_qty , group_concat(item_price) as item_price , group_concat(item_variant) as item_variant, group_concat(item_id) as item_id, agent.agent_name
		,group_concat(marchent.shop_name) as shop_name , group_concat(marchent.shop_contact_number) as shop_contact , group_concat(marchent.address SEPARATOR "##") as shop_address') 
		->from('tbl_order_master as orders')  
        ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent','product.product_store = marchent.id','left outer')
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->join('tbl_customer as customer','customer.customer_id = orders.user_id','left outer')
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
		
		if($search["is_cancel"] > 0)
		{
			$this->db->where("orders.is_cancel = ".$search["is_cancel"]);
		}// end if agent
		
		if($search["is_complete"] > 0)
		{
			$this->db->where("orders.is_complete = ".$search["is_complete"]);
		}// end if agent
		//$this->db->where("orders.is_cancel = 0 ");
		
        $query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}// end fucntion get_all_task

	public function get_all_order_count($search) {          
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		$this->db->select('orders.* , group_concat(product_name) as item_name 
		, group_concat(item_qty) as item_qty , group_concat(item_price) as item_price , agent.agent_name') 
		->from('tbl_order_master as orders')  
        ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
        ->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->group_by("orders.id");
		
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
		
		if($search["is_cancel"] > 0)
		{
			$this->db->where("orders.is_cancel = ".$search["is_cancel"]);
		}// end if agent
		
		if($search["is_complete"] > 0)
		{
			$this->db->where("orders.is_complete = ".$search["is_complete"]);
		}// end if agent
		
		//$this->db->where("orders.is_cancel = 0 ");  
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}

	public function get_all_marchent_order($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		$this->db->select('orders.* , group_concat(product_name) as item_name 
		, group_concat(item_qty) as item_qty , group_concat(item_price) as item_price , agent.agent_name') 
		->from('tbl_order_master as orders')  
		->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent',"product.product_store = marchent.id","inner")
		->join('tbl_agent as agent',"orders.agent = agent.id","left outer")
		->group_by("orders.id")
		->order_by($orderby, $order_by)
		->limit($PAGINATION,$offset);
		//->group_by("task.task_id");	 
		if($search["marchent_id"] > 0)
		{
			$this->db->where("marchent.id = ".$search["marchent_id"]);
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

	public function get_all_marchent_order_count($search) {          
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "orders.id";
		 
		 $this->db->select('orders.*')
        ->from('tbl_order_master as orders')  
		->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent',"product.product_store = marchent.id","inner")
		->group_by("orders.id")
		->order_by($orderby);
		
		if($search["marchent_id"] > 0)
		{
			$this->db->where("marchent.id = ".$search["marchent_id"]);
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

	public function marchent_order_count($search) {          
		 
		 $this->db->select('orders.*')
        ->from('tbl_order_master as orders')  
		->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
		->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
		->join('tbl_marchent as marchent',"product.product_store = marchent.id","inner")
		->where("marchent.id = ".$search["marchent_id"])
		->where("product.product_id is not null ")
		->group_by("orders.id");
		
		
		if($search["status"] == 1)
		{
			$this->db->where("ifnull(orders.in_progress,0) = 0");
		}// end if customer_id
		if($search["status"] == 2)
		{
			$this->db->where("ifnull(orders.in_progress,0) = 1");
		}// end if customer_id

	 	if($search["is_agent_complete"] == 1)
		{
			$this->db->where("orders.is_agent_complete = 1");
		}// end if customer_id

		if($search["status"] == 3)
		{
			$this->db->where("DATE_FORMAT(orders.bill_date, '%Y-%m-%d') = '".date("Y-m-d")."'");
		}// end if customer_id
 		  
		$query_result = $this->db->get();
		 
		$result = $query_result->result_array();
		return count($result);
	}

	public function marchent_total_revenue($search) {          
		 
		$this->db->select('sum(order_detail.item_price) as total_price')
	   ->from('tbl_order_master as orders')  
	   ->join('tbl_order_detail as order_detail',"orders.id = order_detail.order_id","left outer")
	   ->join('dir_product as product',"order_detail.item_id = product.product_id","left outer")
	   ->join('tbl_marchent as marchent',"product.product_store = marchent.id","inner")
	   ->where("marchent.id = ".$search["marchent_id"]);
	   
	   $query_result = $this->db->get();
	   $result = $query_result->row_array();
	   return $result;
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
		$result =  $this->db->select('task.* , group_concat(item_name) as item_name , group_concat(qty) as item_qty , agent.agent_name 
		, concat(customer.firstname," ",customer.lastname) as customername , customer.phone as customer_contact , 
		customer.landmark_of_address as flat_no')
	   ->from('tbl_task as task')  
	   ->join('tbl_task_item as task_item',"task.id = task_item.task_id","left outer")
	   ->join('tbl_agent as agent',"task.agent = agent.id","left outer")
	   ->join('tbl_customer as customer','task.entryby = customer.customer_id' , 'let outer')
	   ->group_by("task.id")
	   ->where('task.id' , $task_id)->get();
		//$result = $this->db->get_where('tbl_task', array('id' => $task_id));
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
		 
		 $this->db->select('task.* , group_concat(item_name) as item_name , group_concat(qty) as item_qty , agent.agent_name 
		 , concat(customer.firstname," ",customer.lastname) as customername , customer.phone as customer_contact , customer.landmark_of_address as flat_no')
		->from('tbl_task as task')  
		->join('tbl_task_item as task_item',"task.id = task_item.task_id","left outer")
		->join('tbl_agent as agent',"task.agent = agent.id","left outer")
		->join('tbl_customer as customer','task.entryby = customer.customer_id' , 'let outer')
		->group_by("task.id")
		->order_by($orderby, $order_by);
		//->limit($PAGINATION,$offset);
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
			//$this->db->where("is_cancel = 0");
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
		->order_by($orderby);
		
		
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
	
	public function get_story_info($story_id) {
		$result = $this->db->get_where('tbl_story', array('id' => $story_id));
        return $result->row_array();
    }//end function get_product_info

	public function get_all_story($search,$page=1,$order_by='desc') {          
		
		if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$orderby = $search['orderby'];  
		if($orderby == "" )  $orderby = "story.id";
		 
		 $this->db->select('story.* , tbl_customer.firstname as username , tbl_marchent.shop_name , tbl_marchent.category ,tbl_marchent.shop_unique_id  , if(user_type = "marchent" , create_by , 0) as shop_id ')
		->from('tbl_story as story') 
		->join('tbl_customer',"story.create_by = tbl_customer.customer_id and story.user_type = 'customer'",'left outer') 
		->join('tbl_marchent',"story.create_by = tbl_marchent.id and user_type = 'marchent'",'left outer') 
		->where('create_date >= NOW() - INTERVAL 1 DAY')
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
		->where('create_date >= NOW() - INTERVAL 1 DAY')
		->order_by($orderby);
		
		if($search["story_id"] != "")
		{
			$this->db->where("story.id = ".$search["story_id"]);
		}// end if story_id
		
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}// end fucntion story count

	public function remove_story_by_id($story_id) {
		$this->db->where('id' , $story_id);
		$this->db->delete('tbl_story');
        return $this->db->affected_rows();
    }


	/* Story */
	
	/*product*/ 
	
	public function get_top_product_by_marchent($search) { 
		$category_id = $search['category_id'];
	
		if((int)$search['marchent_id'] > 0)
		{
			$this->db->where('product.product_store',$search['marchent_id']);
		}
		 $this->db->select('product.* , GROUP_CONCAT(tbl_marchent.shop_name ORDER BY tbl_marchent.shop_name) as store_name')
		->from('dir_product as product')  
		->join('tbl_marchent','FIND_IN_SET(tbl_marchent.id, product_store) > 0','left')
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->group_by('product.product_id')
		->order_by('product.product_id', 'desc')
		->limit(3);	 
		
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
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
        return $result; 
	}//end get_top_product_by_marchent
	
	
	public function get_new_products($search,$page=1,$order_by='desc') { 
	  if($page<1){
		 $page=1;
		}  
		$PAGINATION = PAGINATION_FRONT;
		$offset = ($page - 1) * $PAGINATION; 
		
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$filter_orderby = 'product.product_id';
		$filter_order = 'desc';
		$limit=7;
		//$start=
		
	    $this->db->select('product.*, (stock_qty-sum(item_qty)) as new_qty')
		->from('dir_product as product')  
	    ->join('tbl_order_detail','product.product_id = tbl_order_detail.id','left')
		->join('tbl_order_master','tbl_order_master.id = tbl_order_detail.order_id and tbl_order_master.is_cancel =0','left')
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->group_by('product.product_id')
		->order_by($filter_orderby, $filter_order)
		->limit($limit);
		//->limit($PAGINATION,$offset);	 
		
		
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
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
        return $result; 
    }
	
	
	public function get_filter_products($search,$page=1,$order_by='desc') { 
		if($page<1){
		     $page=1;
		}  
		 $PAGINATION = PAGINATION_FRONT;
		 $offset = ($page - 1) * $PAGINATION; 
		
		
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$filter_orderby = 'product.product_id';
		$filter_order = $search['orderby'];
		
		if((int)$search['marchent_id'] > 0)
		{
			$this->db->where('tbl_marchent.id',$search['marchent_id']);
		}
		
		$all_offer = $search['all_offer'];
		if(!empty($all_offer) && $all_offer == 'offer'){
			$this->db->where('product.discount!=',0);
		}
		
		if($search['brand_id'] > 0){
			$this->db->where('product.brand_id',$search['brand_id']);
		}
		
		if(!empty($search['productstr'])){
			$this->db->where("product.product_name LIKE '%".$search['productstr']."%'");
		}
		
	   if(!empty($search['size'])){
			$searchValues=$search['size'];
			$wh_size = '';
				foreach($searchValues as $value)
				{
				  $wh_size = " pro_detail.variant_desc = '".$value."' or ";
				}
			$wh_size = '('.trim($wh_size , ' or ').')';
			$this->db->where($wh_size);
		}
		
		if($search['max_price'] > 0){
			$wh_price = " pro_detail.our_price <= '".$search['max_price']."'";
			$this->db->where($wh_price);
		}
		
		$this->db->select("product.* , GROUP_CONCAT(tbl_marchent.shop_name ORDER BY tbl_marchent.shop_name) as store_name
		 , GROUP_CONCAT(tbl_marchent.shop_unique_id ORDER BY tbl_marchent.shop_name) as shop_unique_id
		 , GROUP_CONCAT(tbl_marchent.id ORDER BY tbl_marchent.shop_name) as shop_id 
		 , concat('[',group_concat(concat('{\"id\" : \"',pro_detail.variant_id,'\" , \"Variant_desc\" : \"',pro_detail.variant_desc,'\" , \"stock_qty\" : \"',pro_detail.stock_qty,'\" , \"variant_price\" : \"',pro_detail.variant_price,'\" , \"our_price\" : \"',pro_detail.our_price,'\" }')),']') as variant_detail_new")
		->from('dir_product as product')  
		->join('dir_product_detail as pro_detail','pro_detail.product_id = product.product_id','left')
		->join('tbl_marchent','FIND_IN_SET(tbl_marchent.id, product_store) > 0','left')
		->join('tbl_order_detail','product.product_id = tbl_order_detail.id','left')
		->join('tbl_order_master','tbl_order_master.id = tbl_order_detail.order_id and tbl_order_master.is_cancel =0','left')
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
			
			if(!empty($search['m_category_id'])){
			$searchValues=$search['m_category_id'];
				$m_condition='';
				foreach($searchValues as $value)
				{
				  $m_condition .=" FIND_IN_SET('".$value."',product.m_category_id ) OR";
				}
				$m_condition=trim($m_condition,"OR"); 
				$where =' ('.$m_condition.') ';   
				$this->db->where( $where );
		}
		
		/**/ 
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
        return $result; 
    }
	
    public function get_filter_products_count($search) { 
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$filter_orderby = 'product.product_id';
		$filter_order = 'desc';
		
		if((int)$search['marchent_id'] > 0)
		{
			$this->db->where('product.product_store',$search['marchent_id']);
		}
		$all_offer = $search['all_offer'];
		if(!empty($all_offer) && $all_offer == 'offer'){
			$this->db->where('product.discount!=',0);
		}
		
		if($search['brand_id'] > 0){
			$this->db->where('product.brand_id',$search['brand_id']);
		}
		
		if(!empty($search['productstr'])){
			$this->db->where("product.product_name LIKE '%".$search['productstr']."%'");
		}
		
		if(!empty($search['size'])){
			$searchValues=$search['size'];
			$wh_size = '';
				foreach($searchValues as $value)
				{
				  $wh_size = " pro_detail.variant_desc = '".$value."' or ";
				}
			$wh_size = '('.trim($wh_size , ' or ').')';
			$this->db->where($wh_size);
		}
		
		if($search['max_price'] > 0){
			$wh_price = " pro_detail.our_price <= '".$search['max_price']."'";
			$this->db->where($wh_price);
		}
		
		 $this->db->select('product.* , sub_category.category_name as sub_category')
		->from('dir_product as product')
        ->join('dir_product_detail as pro_detail','pro_detail.product_id = product.product_id','left')		
		->join('dir_categories as sub_category',"product.product_sub_category = sub_category.category_id","left outer")
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
			
			if(!empty($search['m_category_id'])){
			$searchValues=$search['m_category_id'];
				$m_condition='';
				foreach($searchValues as $value)
				{
				  $m_condition .=" FIND_IN_SET('".$value."', product.m_category_id ) OR";
				}
				$m_condition=trim($m_condition,"OR"); 
				$where =' ('.$m_condition.') ';   
				$this->db->where( $where );
		}
		/**/ 
		
		 
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
     
        return count($result); 
    }
     /*   Size */	
	public function getSizeList(){
		$this->db->select('DISTINCT(Variant_desc)')
		->from('dir_product_detail') ; 
		 $query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
		return $result;
	}
	 /* Size */
	 
	 /* Price Range*/
	 public function getPriceRange(){
		$this->db->select('MAX(our_price) as max_price');
		$query = $this->db->get('dir_product_detail');

		return $query->row();
		 
	 }
	/*  Price Range */
	 
	public function get_autocomplete_products($search){
		$this->db->select('product.product_id,product.product_name')
		->from('dir_product as product')  
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->where("product.product_name LIKE '%".$search['productstr']."%'");
		 $query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
		return $result;
    }
	
	public function get_product_stock($product_id ){
		/*$this->db->select('product.product_name ,  (stock_qty-sum(item_qty)) as stock_qty')
		->from('dir_product as product')  
		->join('tbl_marchent','FIND_IN_SET(tbl_marchent.id, product_store) > 0','left')
		->join('tbl_order_detail','product.product_id = tbl_order_detail.id','left')
		->join('tbl_order_master','tbl_order_master.id = tbl_order_detail.order_id and tbl_order_master.is_cancel =0','left')
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->where('product.product_id',$product_id)
		->group_by('product.product_id');*/
		$this->db->select("product.product_name, product.product_images, product.gallery_featured, product.type, product.discount_price, product.short_desc,  concat('[',group_concat(concat('{\"id\" : \"',pro_detail.variant_id,'\" , \"Variant_desc\" : \"',pro_detail.variant_desc,'\" , \"stock_qty\" : \"',pro_detail.stock_qty,'\" , \"variant_price\" : \"',pro_detail.variant_price,'\" , \"our_price\" : \"',pro_detail.our_price,'\" }')),']') as variant_detail_new")
		->from('dir_product as product')  
		->join('dir_product_detail as pro_detail','pro_detail.product_id = product.product_id','left')
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->where('product.product_id',$product_id);
		 $query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->row_array(); 
		return $result;
	}//end function get_product_stock
	
	public function get_product_rating($product_id){
		$this->db->select('*')
		->from('tbl_rating')  
		->where('product_id', $product_id); 
	    $query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}
	
	public function get_customer_product_rating($product_id, $customer_id){
		$this->db->select('*')
		->from('tbl_rating')  
		->where('product_id', $product_id)
        ->where('user_id', $customer_id);		
	    $query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->row_array(); 
		return $result;
	}


	
	public function store_product($data) { 
        $this->db->insert('dir_product', $data); 
        return $this->db->insert_id(); 
	} 
	
	public function update_product($product_id, $data) {
        $this->db->update('dir_product', $data, array('product_id' => $product_id));
        return $this->db->affected_rows();
    }
	
	public function update_product_stock($product_id, $variant_id, $data) {
        $this->db->update('dir_product_detail', $data, array('product_id' => $product_id, 'variant_id' => $variant_id ));
        return $this->db->affected_rows();
    }

	 
	public function get_product_info($product_id) {
		$this->db->select("product.*, concat('[',group_concat(concat('{\"id\" : \"',pro_detail.variant_id,'\" , \"Variant_desc\" : \"',pro_detail.variant_desc,'\" , \"stock_qty\" : \"',pro_detail.stock_qty,'\" , \"variant_price\" : \"',pro_detail.variant_price,'\" , \"our_price\" : \"',pro_detail.our_price,'\" }')),']') as variant_detail_new")
		->from('dir_product as product')  
		->join('dir_product_detail as pro_detail','pro_detail.product_id = product.product_id','left')
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0)
		->where('product.product_id',$product_id);
		 $query_result = $this->db->get();
		
		//$result = $this->db->get_where('dir_product', array('product_id' => $product_id, 'deletion_status' => 0));
        return $query_result->row_array();
	}
	
	public function get_cart_qty($user_id,$product_id){
		$this->db->select('*')
		->from('tbl_cart')
		->where('product_id',$product_id) 
		->where('user_id', $user_id) ;
		$query_result = $this->db->get();
         //echo $this->db->last_query();exit;       
	   return  $query_result->result_array(); 
	}
	
	public function get_cart_qty_by_variant_id($user_id,$product_id,$variant_id){
		$this->db->select('quantity')
		->from('tbl_cart')
		->where('product_id',$product_id)
        ->where('variant_id',$variant_id)		
		->where('user_id', $user_id);
		$query_result = $this->db->get();
         //echo $this->db->last_query();exit;       
	   return  $query_result->row_array();
	}
	
	public function get_related_product_info($product_id, $category_id){
		$pro_id=$product_id;
		$cat_id=$category_id;
		$limit=4;
		$this->db->select('product.*, (stock_qty-sum(item_qty)) as new_qty')
		->from('dir_product as product')  
		->join('tbl_order_detail','product.product_id = tbl_order_detail.id','left')
		->join('tbl_order_master','tbl_order_master.id = tbl_order_detail.order_id and tbl_order_master.is_cancel =0','left')
		->where('product.product_id!=', $pro_id) 
		->where('product.product_category', $cat_id) 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->group_by('product.product_id')
		->order_by('product.product_id', 'desc')
		->limit($limit);
		
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
        return $result; 
		
	}
	
	public function remove_product_by_id($product_id) {
        $this->db->update('dir_product', array('deletion_status' => 1), array('product_id' => $product_id));
        return $this->db->affected_rows();
    }
    /*product*/
	
    /* add to cart Product */
	public function add_to_cart_product($data) { 
        $this->db->insert('tbl_cart', $data); 
        return $this->db->insert_id(); 
	}
	/* add to cart Product */
	
	/* Get Items From Cart */
	public function getProductfromCart($user_id){
		$this->db->select("tbl_cart.*, tbl_product.*, concat('[',group_concat(concat('{\"id\" : \"',pro_detail.variant_id,'\" , \"Variant_desc\" : \"',pro_detail.variant_desc,'\" , \"stock_qty\" : \"',pro_detail.stock_qty,'\" , \"variant_price\" : \"',pro_detail.variant_price,'\" , \"our_price\" : \"',pro_detail.our_price,'\" }')),']') as variant_detail_new")
                ->from('tbl_cart as tbl_cart')
				->join('dir_product as tbl_product','tbl_product.product_id = tbl_cart.product_id','left')
                ->join('dir_product_detail as pro_detail','pro_detail.product_id = tbl_product.product_id','left')
				->where('tbl_cart.user_id', $user_id)
				->where('tbl_product.publication_status', 1)
				->where('tbl_product.deletion_status', 0)
				->group_by('tbl_product.product_id')
				->group_by('tbl_cart.cart_id');
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
        $result = $query_result->result_array(); 
        return $result;
	}
	/* Get Items From Cart */
	
	public function product_in_cart($data){
		$this->db->select('*')
                ->from('tbl_cart')
                ->where('user_id',$data['user_id'])
                ->where('product_id', $data['product_id'])
				->where('variant_id', $data['variant_id'])
				->where('status', 1);
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
        $result = $query_result->row();
        return $result;
	   
	}
	/* Remove all items from cart */
	public function cart_empty($user_id,$search, $cart_id) {
		if((int)$search['product_id'] > 0 &&  (int)$search['varient_id'] > 0){
		   $this->db->where('user_id' , $user_id);
		   $this->db->where('variant_id' , $search['varient_id']);
		   $this->db->where('product_id', $search['product_id']);
		}
		
		else {
			$this->db->where('user_id' , $user_id);
		}
		
		if((int)$cart_id > 0){
			$this->db->where('cart_id' , $cart_id);
		}
		$this->db->delete('tbl_cart');
        return $this->db->affected_rows();
    }
	
	/* Get Items From Cart */
	public function update_cart($data, $qty) {
        $this->db->update('tbl_cart', array('quantity' => $qty), array('user_id' => $data['user_id'], 'product_id' => $data['product_id'], 'variant_id' => $data['variant_id']));
        echo $this->db->last_query();exit;
		return $this->db->affected_rows();
    }
	
	/* Update Cart */
	public function update_cart_byid($user_id,$product_id,$variant_id,$quantity,$cart_id) {
		if($cart_id > 0){
			$this->db->update('tbl_cart', array('quantity' => $quantity, 'variant_id' =>$variant_id), array('cart_id' => $cart_id));
		}
		else {
        //$this->db->update('tbl_cart', array('quantity' => $quantity, 'variant_id' =>$variant_id), array('cart_id'=>$cart_id1));
        }
		return $this->db->affected_rows();
    }
	
	public function update_cart_productdetailid($user_id,$product_id,$variant_id,$quantity,$cart_id){
		
		$this->db->update('tbl_cart', array('quantity' => $quantity, 'variant_id' =>$variant_id), array('cart_id'=>$cart_id));
	   return $this->db->affected_rows();
	}
	
	public function get_cart_update_id($user_id,$product_id,$variant_id){
		$result = $this->db->get_where('tbl_cart', array('user_id'=>$user_id, 'product_id' => $product_id, 'variant_id'=>$variant_id));
        return $result->row_array();
	}
	
	/* Remove Product from the Cart Table after Create Order */
	public function remove_product_cart($customer_id,$item_id){
		$this->db->where('user_id', $customer_id);
		$this->db->where('product_id', $item_id);
		$this->db->delete('tbl_cart');	
	}
	
	/* Check For Review Already given */ 
	public function check_product_review($data) {
		$result = $this->db->get_where('tbl_customer_review', array('customer_id' => $data['user_id'] ,'product_id' => $data['product_id'] , 'status' => 0));
        return $result->row_array();
    }
	
	/* Add Review */
	public function add_review($data){
		$this->db->insert('tbl_customer_review', $data); 
        return $this->db->insert_id(); 	
	}
	
	/* Add To Wishlist*/
	public function add_to_wishlist($data) { 
        $this->db->insert('tbl_wishlist', $data); 
        return $this->db->insert_id(); 
	}
	/* Add To Wishlist*/
	
	
	/* Remove Product From wishlist*/
	public function remove_product_from_wishlist($user_id,$product_id) {
        $this->db->update('tbl_wishlist', array('deletion_status' => 1), array('user_id' => $user_id, 'product_id' => $product_id));
        return $this->db->affected_rows();
    }
	/* Remove Product From wishlist*/
	
	
	public function get_wishlist_products($search,$page=1,$order_by='desc') { 
		if($page<1){
		     $page=1;
		}  
		 $PAGINATION = PAGINATION_FRONT;
		 $offset = ($page - 1) * $PAGINATION; 
		
		$user_id = $search['user_id'];
		
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$filter_orderby = 'product.product_id';
		$filter_order = $search['orderby'];
		
		if((int)$search['marchent_id'] > 0)
		{
			$this->db->where('tbl_marchent.id',$search['marchent_id']);
		}
		
		$all_offer = $search['all_offer'];
		if(!empty($all_offer) && $all_offer == 'offer'){
			$this->db->where('product.discount!=',0);
		}
		
		if($search['brand_id'] > 0){
			$this->db->where('product.brand_id',$search['brand_id']);
		}

		 $this->db->select('product.* ,wishlist.*')
		->from('tbl_wishlist as wishlist')
		->join('dir_product as product','product.product_id = wishlist.product_id','left')
		
	    ->where('wishlist.deletion_status',0)
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0)
		->where('wishlist.user_id',$user_id)
        ->group_by('wishlist.product_id')
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
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
        return $result; 
    }
	
    public function get_wishlist_products_count($search) { 
		$category_id = $search['category_id'];
		$orderby = $search['orderby'];  
		
		$user_id = $search['user_id'];
		
		
		
		$filter_orderby = 'product.product_id';
		$filter_order = 'desc';
		
		if((int)$search['marchent_id'] > 0)
		{
			$this->db->where('product.product_store',$search['marchent_id']);
		}
		$all_offer = $search['all_offer'];
		if(!empty($all_offer) && $all_offer == 'offer'){
			$this->db->where('product.discount!=',0);
		}
		
		if($search['brand_id'] > 0){
			$this->db->where('product.brand_id',$search['brand_id']);
		}
		 
		 $this->db->select('product.* ,wishlist.*')
		->from('tbl_wishlist as wishlist')
		->join('dir_product as product','product.product_id = wishlist.product_id','left') 
		->where('wishlist.deletion_status',0)
		->where('product.product_category!=', "") 
		->where('product.publication_status', 1) 
		->where('product.deletion_status',0) 
		->where('wishlist.user_id',$user_id)
        ->group_by('wishlist.product_id')
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
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array(); 
			
        return count($result); 
    }
	
    public function add_addresses($data) { 
        $this->db->insert('tbl_customer_address', $data); 
        return $this->db->insert_id(); 
	}
	
	public function update_addresses($data,$address_id) { 
        $this->db->update('tbl_customer_address', $data, array('id' => $address_id)); 
        return $this->db->affected_rows(); 
	}

    /* Get User addresses*/
    public function get_addresses($user_id)
	{
		 $this->db->select('*')
		->from('tbl_customer_address')
		->where(array("user_id" => $user_id , "deletion_status" => "0"));
		
		$result = $this->db->get();
		//echo $this->db->last_query();exit;
		return $result->result_array();	 
	}

	
	/* Get User addresses*/
	public function get_customer_address($user_id){
		$this->db->select('*')
		->from('tbl_customer')
		->where(array("customer_id" => $user_id , "deletion_status" => "0", "activation_status" => "1"));
		$result = $this->db->get();
		//echo $this->db->last_query();exit;
		return $result->row_array();
	}
	
	public function get_customer_profile($user_id){
		$this->db->select('*')
		->from('tbl_customer')
		->where(array("customer_id" => $user_id , "deletion_status" => "0", "activation_status" => "1"));
		$result = $this->db->get();
		//echo $this->db->last_query();exit;
		return $result->row_array();
	}
	
	/* Get User Profile */
	public function update_profile($data, $user_id){
		$this->db->update('tbl_customer', $data, array('customer_id' => $user_id)); 
        return $this->db->affected_rows(); 
	}
	
	/* Remove address */
	public function remove_addresse($user_id,$address_id){
	 $this->db->update('tbl_customer_address', array('deletion_status' => 1), array('user_id' => $user_id, 'id'=> $address_id));
        return $this->db->affected_rows();
       
	}
	/* Remove address */
	
	
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

	public function agent_fcm_update_ios($fcm_token)
	{
		$this->db->update('tbl_agent', array("fcm_token_ios" => ""), array('fcm_token_ios' => $fcm_token)); 
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

	public function get_task_location($task_id , $loc_type)
	{
		$this->db->select('*')
		->from('tbl_task_location')
		->where("task_id = ".$task_id)
		->where("loc_type = '".$loc_type."'")
		->order_by('id', 'desc')
		->limit(1);
		$result = $this->db->get();
		return $result->row_array();	 
	}// end function get_task_location

	public function get_active_task($agent_id)
	{
		$this->db->select('*')
		->from('tbl_task')
		->where(array("agent" => $agent_id , "is_task_active" => "2", "is_agent_complete" => "0"));
		
		$result = $this->db->get();
		return $result->result_array();	 
	}

	/**agent detail */ 

	/**Marchent Detail */
	private $_marchent = 'tbl_marchent';
	
	function get_unique_shop_id(){
		$this->db->select_max('username');
		$result = $this->db->get($this->_marchent)->row();  
		return $result->username;
	}// end get_unique_shop_id

	public function insert_marchent($data){
		$this->db->insert($this->_marchent, $data);
		return $this->db->insert_id();
	}// end insert_marchent

	public function marchent_fcm_update($fcm_token)
	{
		$this->db->update($this->_marchent, array("fcm_token" => ""), array('fcm_token' => $fcm_token)); 
        return $this->db->affected_rows(); 
	}// end if agent fcm update

	public function marchent_fcm_update_ios($fcm_token)
	{
		$this->db->update($this->_marchent, array("fcm_token_ios" => ""), array('fcm_token_ios' => $fcm_token)); 
        return $this->db->affected_rows(); 
	}// end if agent fcm update	


	public function get_customer_info($customer_id) {
        $result = $this->db->get_where($this->_customer, array('customer_id' => $customer_id, 'activation_status' => 1, 'deletion_status' => 0));
        return $result->row_array();
	}// end get_marchent_info

	public function get_marchent_info_by_unique_id($unique_id) {
        $result = $this->db->get_where($this->_marchent, array('shop_unique_id' => $unique_id, 'activation_status' => 1));
        return $result->row_array();
	}// end get_marchent_info

	public function get_all_marchent($search)
	{
		$this->db->select('*')
		->from($this->_marchent)
		->where(array('activation_status' => 1));
		if($search['category_id'] > 0)
		{
			$this->db->where("find_in_set(".$search['category_id'].",category) !=",0);
			
		}
		$result = $this->db->get();
		//echo $this->db->last_query();exit;
		return $result->result_array();	 
	}
	
	public function check_marchent_login_info($data) {
         
        $this->db->select('*')
                ->from($this->_marchent)
                ->where("username = '".$data["username"]."'")
                ->where('password', md5($data["password"]))
				->where('activation_status', 1);
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
        $result = $query_result->row();
        return $result;
	}// end function agent login
	
	public function customer_update($customer_id , $data)
	{
		$this->db->update($this->_customer, $data, array('customer_id' => $customer_id)); 
        return $this->db->affected_rows(); 
	}// end if agent update

	public function verify_marchent($username,$token) { 
		$result = $this->db->get_where($this->_marchent, array('username' => $username,'token' => $token , 'activation_status' => 1));
		return $result->row_array();
	}// end function verify_marchent
	
	public function add_notification($data){
		$this->db->insert('tbl_notification', $data);
		return $this->db->insert_id();
	}

	public function get_notifications_info($customer_id)
	{
		
		/*notification_clear*/
		$userinfo = $this->get_customer_info($customer_id);
		
		$notification_view = $userinfo['notification_view'];
		$notification_clear = $userinfo['notification_clear']; 
		
		$this->db->select('*')
		->from('tbl_notification')  
		->where('user_id = '.$customer_id)
		->order_by('date_added', 'desc');
		 
		 $where=' 1=1 ';	
		if($notification_clear!=""){  
			$where .= ' and   `date_added`> "'.$notification_clear.'" ';  
		}	
		$this->db->where( $where ); 
		 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result;
	}

	/**Marchent Detail */
	
	/**Payment Detail */
	public function get_balance($search) {          
		
		 $this->db->select('sum(credit_points-debit_points) as balance')
		->from('tbl_locadel_credit as loca_credit')  
		->where('is_revert',0)
		->group_by("user_id");
		//->group_by("task.task_id");	 
		
		if($search["user_id"] > 0)
		{
			$this->db->where("user_id = ".$search["user_id"]);
		}// end if customer_id
		if($search["user_type"] != '')
		{
			$this->db->where("user_type = '".$search["user_type"]."'");
		}// end if customer_id
		 
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result["balance"];
	}// end fucntion get_all_task

	public function store_recharge($data){
		$this->db->insert('tbl_credit_request', $data);
		return $this->db->insert_id();
	}// end insert_marchent

	public function insert_locadel($data){
		$this->db->insert('tbl_locadel_credit', $data);
		return $this->db->insert_id();
	}// end insert_marchent
	
	public function get_max_id_online_payment()
	{
		$this->db->select('max(request_id) as request_id')
		->from('tbl_locadel_credit as loca_credit') 
		->where("request_type = 'online'");
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result["request_id"];
	}//end if


	public function get_all_marchent_transaction($search)
	{
		$this->db->select('loca_credit.* ,  tbl1.customer_name')
		->from('tbl_locadel_credit as loca_credit') 
		->join("(select concat(firstname,' ',lastname) as customer_name , request_id ,request_type
		from tbl_customer left join tbl_locadel_credit on
		 tbl_customer.customer_id = tbl_locadel_credit.user_id
		 where user_type = 'customer' group by request_id , request_type
		) as tbl1","tbl1.request_id = loca_credit.request_id and tbl1.request_type = loca_credit.request_type","join")
		->where("user_type = 'marchent'")
		->where('loca_credit.is_revert',0);
		
		if($search["marchent_id"] > 0)
		{
			$this->db->where("user_id = ".$search["marchent_id"]);
		}// end if customer_id
		  
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}//end if function get_all_marchent_transaction
 
	public function get_all_customer_transaction($search)
	{
		$this->db->select('loca_credit.*,tbl1.shop_name as marchent_name')
		->from('tbl_locadel_credit as loca_credit') 
		->join("(select shop_name , request_id ,request_type
		from tbl_marchent left join tbl_locadel_credit on
		tbl_marchent.id = tbl_locadel_credit.user_id
		 where user_type = 'marchent' group by request_id , request_type
		) as tbl1","tbl1.request_id = loca_credit.request_id and tbl1.request_type = loca_credit.request_type","left") 
		->where("user_type = 'customer'")
		->where('loca_credit.is_revert',0)
		->order_by('loca_credit.id', 'desc');;
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("user_id = ".$search["customer_id"]);
		}// end if customer_id
		  
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}//end if function get_all_marchent_transaction

	/**Payment Detail */

	public function get_general_info() {
        $result = $this->db->get_where($this->_settings, array('setting_id' => 1));
        return $result->row_array();
	}
	
	/**Voucher Code */
	public function check_valid_voucher($search)
	{
		$this->db->select('tbl_voucher_code.* , ifnull(tbl_used_voucher_code.customer_id , 0) as customer_id')
		->from('tbl_voucher_code') 
		->join('tbl_used_voucher_code','tbl_used_voucher_code.vcode_id = tbl_voucher_code.id','left')
		->where("code = '".$search['voucher_code']."'")
		->where('is_used = 0');
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result;
	}

	public function store_used_voucher($data) { 
        $this->db->insert('tbl_used_voucher_code', $data); 
        return $this->db->insert_id(); 
	} 
	
	public function update_voucher($voucher_id, $data) {
        $this->db->update('tbl_voucher_code', $data, array('id' => $voucher_id));
        return $this->db->affected_rows();
    }
	
	public function add_rating($data){
		$this->db->insert('tbl_rating', $data); 
        return $this->db->insert_id(); 
	}
	
	public function update_rating($data,$rate_id) {
        $this->db->update('tbl_rating', $data, array('id' => $rate_id));
        return $this->db->affected_rows();
    }
	
	public function check_product_rating($data) {
		$result = $this->db->get_where('tbl_rating', array('user_id' => $data['user_id'] ,'product_id' => $data['product_id'] , 'status' => 1));
        return $result->row_array();
    }
	
	public function get_ratings($user_id){
		 $this->db->select('*')
                ->from('tbl_rating')
                ->where('user_id', $user_id)
				->where('status', 1);
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
    }
	
	public function get_all_reviews($product_id){
		     $this->db->select('tbl_customer_review.*, tbl_rating.rate as starrating, tbl_rating.fit, tbl_rating.length,  concat(tbl_customer.firstname," ",tbl_customer.lastname) as customer_names, 
			     tbl_order_detail.id as table_order_detail_id, tbl_order_detail.order_id, tbl_order_detail.item_id, tbl_order_detail.item_variant')
                ->from('tbl_customer_review')
				->join('tbl_customer','tbl_customer_review.customer_id = tbl_customer.customer_id','left')
				
				->join('tbl_order_master','tbl_order_master.user_id = tbl_customer_review.customer_id and tbl_order_master.is_cancel =0','left')
                ->join('tbl_order_detail','tbl_order_master.id = tbl_order_detail.order_id and tbl_order_detail.item_id=tbl_customer_review.product_id','left')
				//->join('tbl_order_master','tbl_order_master.id = tbl_order_detail.order_id and tbl_order_master.is_cancel =0','left')
				->join('tbl_rating','tbl_rating.product_id = tbl_customer_review.product_id and tbl_rating.user_id=tbl_customer_review.customer_id','left')
				->where('tbl_customer_review.product_id', $product_id)
				->where('tbl_customer_review.status', 0)
				->group_by ('tbl_customer_review.id');
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
    }
	
	
	public function update_change_mobile_number($data, $customer_id) {
        $this->db->update('tbl_customer', $data, array('customer_id' => $customer_id));
        return $this->db->affected_rows();
    }
	
}
?>