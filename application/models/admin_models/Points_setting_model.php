<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Points_setting_model extends CC_Model { 
    public function __construct() {
        parent::__construct();
    } 
    private $_settings = 'tbl_credit_request';   
	
	 
	public function get_request_info($page=1,$search="") {          
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 
		$this->db->select('request.* , concat(firstname," ",lastname) as customer_name , tbl_customer.phone')
		->from($this->_settings.' as request')  
		->join('tbl_customer','request.user_id = tbl_customer.customer_id','left')
		->order_by('request.id', 'desc')
		->limit(PAGINATION,$offset);	 
		$where=' 1=1 ';	 
		if($search["search"] != ""){
			$where .= " and (concat(firstname,' ',lastname) like '%".$search["search"]."%' or tbl_customer.phone like '%".$search["search"]."%' or request.payMode like '%".$search["search"]."%')";
		}//end if search

		if($search["status"]!=""){
			$where .= ' and request.is_approve ="'.$search["status"].'"';  	 
		} 

		$this->db->where( $where ); 
		$query_result = $this->db->get();
		
		$result = $query_result->result_array();
		return $result;
	}// end get_request_info
	
	public function get_request_count($search='') {          
		$this->db->select('*')
		->from($this->_settings)  
		->order_by('id', 'desc');	 
		$where=' 1=1 ';	 
		if($search["status"]!=""){
			$where .= ' and is_approve ="'.$search["status"].'"';  	 
		} 
 
		$this->db->where( $where ); 
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return count($result);
	}// end get_request_count

	public function get_request_info_by_id($recharge_id)
    {
        $result = $this->db->get_where($this->_settings, array('id' => $recharge_id));
        return $result->row_array();
	}//end function get_store_info_by_id 
	
	public function update_request($recharge_id, $data) {
        $this->db->update($this->_settings, $data, array('id' => $recharge_id));
        return $this->db->affected_rows();
	}// end fuction update_store
	
	public function insert_locadel($data){
		$this->db->insert('tbl_locadel_credit', $data);
		return $this->db->insert_id();
	}// end insert_marchent

	public function update_locadel($request_id,$data){
		$this->db->update('tbl_locadel_credit', $data,array('request_id'=>$request_id , 'request_type' => 'online'));
		return $this->db->affected_rows();
	}// end insert_marchent

	public function update_locadel_by_marchent($marchent_id,$data){
		$this->db->update('tbl_locadel_credit', $data,array('user_id'=>$marchent_id , 'request_type' => 'online' , 'user_type' => 'marchent' , 'revert_off' => 0));
		return $this->db->affected_rows();
	}// end insert_marchent

	public function get_balance($search) {          
		
		$this->db->select('sum(credit_points-debit_points) as balance')
	   ->from('tbl_locadel_credit as loca_credit') 
	   ->where('is_revert',0) 
	   ->group_by("user_id");
	   
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
   }// end fucntion get_balance

   public function get_all_customer_transaction($page=1,$search)
	{
		if($page<1){ 
			$page=1; 
		}  
		$offset = ($page - 1) * PAGINATION; 

		
		/*$this->db->select('tbl_locadel_credit.id,user_id,user_type,request_type ,request_id,created_at , is_revert , group_concat(credit_points) as cr_point , 
		group_concat(debit_points) as dr_point , GROUP_CONCAT(concat(tbl_customer.firstname," ",tbl_customer.lastname)) as customer_name , 
		group_concat(tbl_marchent.shop_name) as shop_name , group_concat(tbl_customer.phone) as customer_phone')
		->from('tbl_locadel_credit') 
		->join("tbl_customer","tbl_customer.customer_id = tbl_locadel_credit.user_id and user_type = 'customer'","left") 
		->join("tbl_marchent","tbl_marchent.id = tbl_locadel_credit.user_id and user_type = 'marchent'","left") 
		->group_by('request_id, request_type')
		->order_by('tbl_locadel_credit.id', 'desc')
		->limit(PAGINATION,$offset);*/

		$this->db->select(' find_in_set(1,revert_off) as revert_off , id,user_id,user_type,request_type ,request_id,created_at , is_revert , cr_point , 
		dr_point , customer_name , shop_name ,  shop_id ,  customer_phone
		from (
			select group_concat(tbl_locadel_credit.revert_off) as revert_off , tbl_locadel_credit.id,user_id,user_type,request_type ,request_id,created_at , is_revert , group_concat(credit_points) as cr_point , 
			group_concat(debit_points) as dr_point , GROUP_CONCAT(concat(tbl_customer.firstname," ",tbl_customer.lastname)) as customer_name , 
			group_concat(tbl_marchent.shop_name) as shop_name , group_concat(tbl_marchent.id) as shop_id , group_concat(tbl_customer.phone) as customer_phone
			FROM tbl_locadel_credit
			left join tbl_customer on tbl_customer.customer_id = tbl_locadel_credit.user_id and user_type = \'customer\'
			left join tbl_marchent on tbl_marchent.id = tbl_locadel_credit.user_id and user_type = \'marchent\'
			group by request_id, request_type
			order by tbl_locadel_credit.id asc) tbl1')
			->limit(PAGINATION,$offset);

		
		if($search["customer_id"] > 0)
		{
			$this->db->where("user_id = ".$search["customer_id"]);
		}// end if customer_id
		if($search["marchent"] > 0)
		{
			$where = " find_in_set('".$search["marchent"]."',shop_id) = 1";
			$this->db->where($where);
			//$this->db->where("tbl_marchent.id = ".$search["marchent"]);
		}// end if customer_id

		if($search["request_type"] != "")
		{
			$this->db->where('request_type ="'.$search["request_type"].'"');
		}// end if request_type

		if($search["search"] != "")
		{
			//concat(tbl_customer.firstname," ",tbl_customer.lastname) LIKE "%'.trim($search["search"]).'%" or 
			//$where .= ' (credit_points = "'.trim($search["search"]).'" or debit_points = "'.trim($search["search"]).'")';  
			$where = "(customer_name like '%".$search["search"]."%' or  find_in_set('".$search["search"]."',cr_point) = 1 or find_in_set('".$search["search"]."',dr_point) = 1 )";
			$this->db->where( $where ); 
		}// end if request_type

	 
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return $result;
	}//end if function get_all_marchent_transaction

	public function get_all_customer_transaction_count($search)
	{
		$this->db->select('user_id,user_type,request_type ,request_id,created_at , group_concat(credit_points) as cr_point , 
		group_concat(debit_points) as dr_point , GROUP_CONCAT(concat(tbl_customer.firstname," ",tbl_customer.lastname)) as customer_name , 
		group_concat(tbl_marchent.shop_name) as shop_name')
		->from('tbl_locadel_credit') 
		->join("tbl_customer","tbl_customer.customer_id = tbl_locadel_credit.user_id and user_type = 'customer'","left") 
		->join("tbl_marchent","tbl_marchent.id = tbl_locadel_credit.user_id and user_type = 'marchent'","left") 
		->group_by('request_id, request_type')
		->order_by('tbl_locadel_credit.id', 'desc');



		//select tbl_locadel_credit.* , GROUP_CONCAT(concat(tbl_customer.firstname,' ',tbl_customer.lastname)) as customer_name , group_concat(tbl_marchent.shop_name) as shop_name from 
//tbl_locadel_credit 
//left join tbl_customer on tbl_customer.customer_id = tbl_locadel_credit.user_id and user_type = 'customer'
//left join tbl_marchent on tbl_marchent.id = tbl_locadel_credit.user_id and user_type = 'marchent'
//group by request_id, request_type
		
		if($search["customer_id"] > 0)
		{
			$this->db->where("user_id = ".$search["customer_id"]);
		}// end if customer_id

		if($search["request_type"] != "")
		{
			$this->db->where('request_type ="'.$search["request_type"].'"');
		}// end if request_type

		if($search["search"] != "")
		{
			$where .= ' (concat(tbl_customer.firstname," ",tbl_customer.lastname) LIKE "%'.trim($search["search"]).'%" or credit_points = "'.trim($search["search"]).'" or debit_points = "'.trim($search["search"]).'")';  
			$this->db->where( $where ); 
		}// end if request_type
		  
		$query_result = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query_result->result_array();
		return count($result);
	}//end if function get_all_marchent_transaction

	public function get_max_id_direct_payment()
	{
		$this->db->select('max(request_id) as request_id')
		->from('tbl_locadel_credit as loca_credit') 
		->where("request_type = 'direct'");
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result["request_id"];
	}//end if

	public function get_transaction_by_request_id($request_id) {
		$this->db->select('*')
		->from('tbl_locadel_credit as loca_credit') 
		->where('request_id',$request_id)
		->where("request_type = 'online'");
		$query_result = $this->db->get();
		$result = $query_result->row_array();
		return $result;	
	}

	 
}// end class