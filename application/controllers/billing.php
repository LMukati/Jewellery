<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CC_Controller { 
    public function __construct() {
      parent::__construct();
        // Check Login Status
      $this->user_login_authentication();
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');
      $this->load->model('billing_model', 'bill_mdl');	  
      $this->load->model('stock_model', 'stk_mdl');
      
    }

    public function index() {
      $data = array();
      $data['title'] = 'billing';
      $this->load->view('header');
	$data['billing_info'] = $this->bill_mdl->billing_info();
	//$this->load->model('billing_model', 'bill_mdl');	
	  $this->load->view('billing/billmanage_v',$data);
	  $this->load->view('footer');
    }	
	public function getpaymentlist($bill_id){
		$result = $this->bill_mdl->getpaymentlist($bill_id);
		return $result; 
  	}
	public function getledgerlist($bill_id){
		$data = array();
		$data['title'] = 'ledger';
		$this->load->view('header');
	  $data['payment_info'] =$this->bill_mdl->getledgerlist($bill_id);
	  //print_r($data['payment_info'][0]['bill_no']);die;
	  //$this->load->model('billing_model', 'bill_mdl');	
		$this->load->view('billing/ledger_v',$data);
		$this->load->view('footer');
		//$result = 
		//return $result; 
  	}	
	  public function gettranslist($bill_id){
		$result = $this->bill_mdl->gettranslist($bill_id);
		return $result; 
  	}
	function upload(){
			$rand = rand(0,9999); 
			move_uploaded_file($_FILES['pdf']['tmp_name'], base_url("assets/uploads/bill".$rand.".pdf"));
			echo base_url("assets/uploads/bill".$rand.".pdf") ;
	}
    public function get_ajax_stock(){
        //$id = $this->input->post('id',true);	
        //$data['billing_info'] $stock_id= $this->stk_mdl->stock_info();
		$stock_id= $this->stk_mdl->stock_info();
		$i=0;
		foreach($stock_id as $sid){
			if($sid['net_weight'] <= "200.00"){
				$data['stock_id']=$sid['id'];
				$data['stock_net']=$sid['net_weight'];
				$data['stock_MSG']= "You have insuficent stock. Please update your stock";
				//echo $sid['net_weight'];
			}
			$i++;
		}
		
		
        echo json_encode($data);		  
    }	  
  
  public function addbilling(){
	  $data = array();
      $data['title'] = 'Add billing';
      $this->load->view('header');
      $data['stock_info'] = $this->stk_mdl->stock_info();
	  //$this->load->view('billing/add_billing_v', $data);
	  $this->load->model('stock_model', 'stk_mdl');	 
	  $this->load->view('billing/billing_v',$data);
	  $this->load->view('footer');
    }
	
  public function create_billing(){
	 
           /*
         array(
                'field' => 'seo_title',
                'label' => 'seo title',
                'rules' => 'trim|required|max_length[250]'
            ), 
			
			array(
                'field' => 'seo_url',
                'label' => 'seo url',
                'rules' => 'trim|required|max_length[250]'
            ),
         */
		
        $config = array(
            array(
                'field' => 'customer_name',
                'label' => 'customer name',
                'rules' => 'trim|required|max_length[250]'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->addbilling();
		 } else {
			$fourRandomDigit = mt_rand(1000,9999);
			$bill_no="KI".$fourRandomDigit;  
			$data['bill_no'] = $bill_no;
			$data['customer_name'] = $this->input->post('customer_name', TRUE); 
			$data['customer_mobile_no'] = $this->input->post('customer_mobile_no', TRUE); 
			$data['customer_address'] = $this->input->post('customer_address', TRUE); 
			$data['billing_date'] = $this->input->post('billing_date', TRUE);
			$data['sub_total_g_wt'] = $this->input->post('table_total_g_weight1', TRUE);
			$data['sub_total_b_qty'] = $this->input->post('table_total_bags_qty1', TRUE);
			$data['sub_total_b_wt'] = $this->input->post('table_total_bags_weight1', TRUE);
			$data['sub_total_net_wt'] = $this->input->post('table_total_net_weight1', TRUE);
			$data['sub_total_fine'] = $this->input->post('table_total_fine1', TRUE);
			$data['sub_total_labour_psc'] = $this->input->post('table_total_labour_pcs1', TRUE);
			$data['sub_total_labour_gm'] = $this->input->post('table_total_labour_gm1', TRUE);
			$data['sub_total_labour_amount'] = $this->input->post('table_total_amount1', TRUE);
			$data['checked'] = $this->input->post('convert_lbr_to_fine', TRUE);
			$data['rate_for_fine'] = $this->input->post('rate_for_fine', TRUE);
			$data['labour_to_fine'] = $this->input->post('labour_to_fine', TRUE);
			$data['silver_receive'] = $this->input->post('silver_receive', TRUE);
			$data['silver_purity'] = $this->input->post('purity', TRUE);
			$data['fine_receive'] = $this->input->post('fine_receive', TRUE);
			$data['fine_remain'] = $this->input->post('fine_remain', TRUE);
			$data['jewellery_current_rate'] = $this->input->post('jewellery_current_rate', TRUE);
			$data['jewellery_rate'] = $this->input->post('jewellery_rate', TRUE);
			$data['jewellery_rate_diposit'] = $this->input->post('jewellery_rate_diposit', TRUE);
			$data['diposit_lbr_amount'] = $this->input->post('diposit_lbr_amount', TRUE);
			$data['cgst_mp_per'] = $this->input->post('cgst', TRUE);
			$data['cgst_mp_price'] = $this->input->post('MPGSTvalue', TRUE);
			$data['sgst_mp_per'] = $this->input->post('sgst', TRUE);
			$data['sgst_mp_price'] = $this->input->post('MPSGSTvalue', TRUE);
			if($this->input->post('grand_total', TRUE) == ""){
				$data['grand_total'] = $this->input->post('jewellery_rate', TRUE);
			}else{
				$data['grand_total'] = $this->input->post('grand_total', TRUE);
			}
			
			$data['created_date']=date('Y-m-d h:i:s');
  		    $data['deletion_status']=0;
			
			  //echo "<pre>";print_r($this->input->post());die;
			
			$insert_id = $this->bill_mdl->store_bill($data); 
			
			$payment['bill_id']=$insert_id;
			$payment['v_sub_total_fine'] = $this->input->post('silver_receive', TRUE);
			$payment['v_fine_remain'] = $this->input->post('fine_remain', TRUE);
			$payment['v_fine_receive'] = $this->input->post('fine_receive', TRUE);
			$payment['v_jewellery_rate_diposit'] = $this->input->post('jewellery_rate_diposit', TRUE);
			$payment['v_sub_total_labour_amount'] = $this->input->post('table_total_amount1', TRUE);
			$payment['v_diposit_lbr_amount'] = $this->input->post('diposit_lbr_amount', TRUE);
			if($this->input->post('grand_total', TRUE) == ""){
				$payment['v_grand_total'] = $this->input->post('jewellery_rate', TRUE);
			}else{
				$payment['v_grand_total'] = $this->input->post('grand_total', TRUE);
			}
			
			$payment['v_deposit_date']=date('Y-m-d h:i:s');
			
			$payment_id = $this->bill_mdl->store_payment($payment);
			
			$stock_id = $this->input->post('item_name', TRUE);
			$g_weight = $this->input->post('g_weight', TRUE);
			$bags_qty = $this->input->post('bags_qty', TRUE);
			$bags_weight = $this->input->post('bags_weight', TRUE);
			$total_bags_weight = $this->input->post('total_bags_weight', TRUE);
			$net_weight = $this->input->post('net_weight', TRUE);
		    $melting = $this->input->post('melting', TRUE);
			$tunch = $this->input->post('tunch', TRUE);
			$fine = $this->input->post('fine', TRUE);
			$labour_pcs = $this->input->post('labour_pcs', TRUE);
			$labour_gm = $this->input->post('labour_gm', TRUE);
			$amount = $this->input->post('amount', TRUE);
			
			$bill_id=$insert_id;
			$i=0;
			foreach($stock_id as $sid){
				
				   $billdata['bill_id']=$bill_id;
				   $billdata['stock_id']=$sid;
				   $billdata['g_weight']=$g_weight[$i];
				   $billdata['bags_qty']=$bags_qty[$i];
				   $billdata['bags_weight']=$bags_weight[$i];
				   $billdata['total_bags_weight']=$total_bags_weight[$i];
				   $billdata['net_weight']=$net_weight[$i];

				   $billdata['melting']=$melting[$i];
				   $billdata['tunch']=$tunch[$i];
				   $billdata['profit']= $tunch[$i] - $melting[$i];
				   $billdata['fine']=$fine[$i];
				   $billdata['labour_pcs']=$labour_pcs[$i];
				   $billdata['labour_gm']=$labour_gm[$i];
				   $billdata['lbr_amount']=$amount[$i];

				   if(isset($net_weight[$i]) && $net_weight[$i] !=''){
					$stock_info = $this->stk_mdl->get_stock_by_id($sid);
						//print_r($stock_info['net_weight'].'<br>'.$net_weight[$i].'<br>'.$sid);die;
					$data_net['net_weight']=$stock_info['net_weight']-$net_weight[$i];
					$result_stock_update =$this->stk_mdl->update_stock($sid, $data_net);
					if(!empty($result_stock_update)){
						//print_r($result_stock_update);die;
						$insert_id = $this->bill_mdl->store_tras_bill($billdata); 
					}
				   }
				
				   //echo "<pre>";print_r($tunch[$i] - $melting[$i]);

				  
				   $i++;
			}
			
			if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully. ';
                $this->session->set_userdata($sdata);
				redirect('billing', 'refresh');
			 } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('billing/addbilling', 'refresh');
            }
          }// Else Ends Here.....
      }	 

        public function edit_billing() {
			//echo $_GET['id'];die;
			$edit_billing=$_GET['id'];
			$data = array();
			$data['stock_info'] = $this->stk_mdl->stock_info();
			$data['bill_trans_info1'] = $this->bill_mdl->billing_trans($edit_billing);
			$data['billing_info'] = $this->bill_mdl->get_billing_by_id($edit_billing);
			$data['payment'] = $this->bill_mdl->getpaymentlist($edit_billing);
			//echo "";
			if (!empty($data['billing_info'])) {
				 $data['title'] = 'Edit billing';
			     $this->load->view('header');
	             $this->load->view('billing/edit_billing_v',$data);
	             $this->load->view('footer');
			} else {
				$sdata['exception'] = 'Content not found !';
				$this->session->set_userdata($sdata);
				redirect('billing', 'refresh');
			}
    }

        public function update_billing() {	
		  $billing_id = $this->input->post('edit_id', TRUE); 
			//echo "";print_r($billing_id);die;
		  $billing_info = $this->bill_mdl->get_billing_by_id($billing_id);
        if (!empty($billing_info)) {
            /*
            array(
					'field' => 'seo_title',
					'label' => 'seo title',
					'rules' => 'trim|required|max_length[250]'
				), 
				array(
					'field' => 'seo_url',
					'label' => 'seo url',
					'rules' => 'trim|required|max_length[250]'
				),
            */    
            
            $config = array(
				array(
					'field' => 'customer_name',
					'label' => 'customer name',
					'rules' => 'trim|required|max_length[250]'
                )
			);
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->edit_billing($billing_id);
            } else {
				
				$data['customer_name'] = $this->input->post('customer_name', TRUE); 
				$data['customer_mobile_no'] = $this->input->post('customer_mobile_no', TRUE); 
				$data['customer_address'] = $this->input->post('customer_address', TRUE); 
				$data['billing_date'] = $this->input->post('billing_date', TRUE);
				$data['sub_total_g_wt'] = $this->input->post('table_total_g_weight1', TRUE);
				$data['sub_total_b_qty'] = $this->input->post('table_total_bags_qty1', TRUE);
				$data['sub_total_b_wt'] = $this->input->post('table_total_bags_weight1', TRUE);
				$data['sub_total_net_wt'] = $this->input->post('table_total_net_weight1', TRUE);
				$data['sub_total_fine'] = $this->input->post('table_total_fine1', TRUE);
				$data['sub_total_labour_psc'] = $this->input->post('table_total_labour_pcs1', TRUE);
				$data['sub_total_labour_gm'] = $this->input->post('table_total_labour_gm1', TRUE);
				$data['sub_total_labour_amount'] = $this->input->post('table_total_amount1', TRUE);
				$data['checked'] = $this->input->post('convert_lbr_to_fine', TRUE);
				$data['rate_for_fine'] = $this->input->post('rate_for_fine', TRUE);
				$data['labour_to_fine'] = $this->input->post('labour_to_fine', TRUE);
				$data['silver_receive'] = $this->input->post('silver_receive', TRUE);
				$data['silver_purity'] = $this->input->post('purity', TRUE);
				$data['fine_receive'] = $this->input->post('fine_receive', TRUE);
				$data['fine_remain'] = $this->input->post('fine_remain', TRUE);
				$data['jewellery_current_rate'] = $this->input->post('jewellery_current_rate', TRUE);
				$data['jewellery_rate'] = $this->input->post('jewellery_rate', TRUE);
				$data['jewellery_rate_diposit'] = $this->input->post('jewellery_rate_diposit', TRUE);
				$data['diposit_lbr_amount'] = $this->input->post('diposit_lbr_amount', TRUE);
				$data['cgst_mp_per'] = $this->input->post('cgst', TRUE);
				$data['cgst_mp_price'] = $this->input->post('MPGSTvalue', TRUE);
				$data['sgst_mp_per'] = $this->input->post('sgst', TRUE);
				$data['sgst_mp_price'] = $this->input->post('MPSGSTvalue', TRUE);
				
				if($this->input->post('grand_total', TRUE) == ""){
					$data['grand_total'] = $this->input->post('jewellery_rate', TRUE);
				}else{
					$data['grand_total'] = $this->input->post('grand_total', TRUE);
				}
				$data['created_date']=date('Y-m-d h:i:s');
				  $data['deletion_status']=0;
				
				  //echo "<pre>";print_r($this->input->post());die;
				
				$result = $this->bill_mdl->update_billing($billing_id, $data); 
				
				//$payment['bill_id']=$insert_id;
				$payment['v_fine_receive'] = $this->input->post('fine_receive', TRUE);
				$payment['v_jewellery_rate_diposit'] = $this->input->post('jewellery_rate_diposit', TRUE);
				$payment['v_diposit_lbr_amount'] = $this->input->post('diposit_lbr_amount', TRUE);
				if($this->input->post('grand_total', TRUE) == ""){
					$payment['v_grand_total'] = $this->input->post('jewellery_rate', TRUE);
				}else{
					$payment['v_grand_total'] = $this->input->post('grand_total', TRUE);
				}
				$payment['v_deposit_date']=date('Y-m-d h:i:s');
				
				$payment_id = $this->bill_mdl->update_payment($billing_id,$payment);
				
				//$stock_name = $this->input->post('item_name', TRUE);
				$stock_id = $this->input->post('stock_id', TRUE);
				$g_weight = $this->input->post('g_weight', TRUE);
				$bags_qty = $this->input->post('bags_qty', TRUE);
				$bags_weight = $this->input->post('bags_weight', TRUE);
				$total_bags_weight = $this->input->post('total_bags_weight', TRUE);
				$net_weight = $this->input->post('net_weight', TRUE);
				$melting = $this->input->post('melting', TRUE);
				$tunch = $this->input->post('tunch', TRUE);
				$fine = $this->input->post('fine', TRUE);
				$labour_pcs = $this->input->post('labour_pcs', TRUE);
				$labour_gm = $this->input->post('labour_gm', TRUE);
				$amount = $this->input->post('amount', TRUE);
				
				//$bill_id=$insert_id;
				if (!empty($result)) {
					//echo "<pre>";print_r($stock_id);die;
					$result = $this->bill_mdl->del_trans_by_id($billing_id);
					
						$i=0;
						foreach($stock_id as $sid){
							
							$billdata['bill_id']=$billing_id;
							$billdata['stock_id']=$sid;
							$billdata['g_weight']=$g_weight[$i];
							$billdata['bags_qty']=$bags_qty[$i];
							$billdata['bags_weight']=$bags_weight[$i];
							$billdata['total_bags_weight']=$total_bags_weight[$i];
							$billdata['net_weight']=$net_weight[$i];
							$billdata['melting']=$melting[$i];
							$billdata['tunch']=$tunch[$i];
							$billdata['profit']= $tunch[$i] - $melting[$i];
							$billdata['fine']=$fine[$i];
							$billdata['labour_pcs']=$labour_pcs[$i];
							$billdata['labour_gm']=$labour_gm[$i];
							$billdata['lbr_amount']=$amount[$i];
							//echo "<pre>";print_r($sid);
							if(isset($net_weight[$i]) && $net_weight[$i] !=''){
								$stock_info = $this->stk_mdl->get_stock_by_id($sid);
								$data['net_weight']=$stock_info-$net_weight[$i];
								$result_stock_update = $this->stk_mdl->update_stock($sid, $data);
								if(!empty($result_stock_update)){
									print_r($result_stock_update);
									$insert_id = $this->bill_mdl->store_tras_bill($billdata);
								}
							   }
							 
							$i++;
						}
						//die;
						//echo "<pre>";print_r($insert_id);die;
					$sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
				   redirect('billing', 'refresh');
				}else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('billing', 'refresh');
                }
			  }// Else Ends Here.....
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('billing', 'refresh');
        }
	 }
	 public function savedeposit(){
		//print_r($this->input->post());
		 $id=$this->input->post('bill_id');
		$fine= $this->input->post('fine_receive');
		$lbr= $this->input->post('diposit_lbr_amount');
		$jwe=$this->input->post('jewellery_rate_diposit');
		$payment['bill_id']=$this->input->post('bill_id', TRUE);
		$payment['v_grand_total']=$this->input->post('grand_total', TRUE);

		$payment['v_jewellery_rate_diposit']=$jwe;
		$payment['v_diposit_lbr_amount']=$lbr;
		$payment['v_sub_total_labour_amount']=$this->input->post('sub_total_labour_amount', TRUE);
		$payment['v_sub_total_fine']=$this->input->post('sub_total_fine', TRUE);
		$payment['v_fine_receive']=$fine;
		$payment['v_fine_remain']=$this->input->post('fine_remain', TRUE)- $fine;
		$payment['v_deposit_date']=date('Y-m-d h:i:s');
		$bill_gets=$this->bill_mdl->get_billing_by_id($id);
		//echo "<pre>";print_r($bill_gets).'<br>'. print_r($payment);die;
		if(isset($jwe) && $jwe != ""){
			$bill['jewellery_rate_diposit']= $jwe+$bill_gets['jewellery_rate_diposit'];
			$result = $this->bill_mdl->update_billing($id, $bill);
		}else{
			$bill['jewellery_rate_diposit']= $bill_gets['jewellery_rate_diposit'];
			$result = $this->bill_mdl->update_billing($id, $bill);
		}
		if(isset($fine) && $fine !=""){
			$bill['fine_receive']= $fine+$bill_gets['fine_receive'];
			//$bill['']
			$result = $this->bill_mdl->update_billing($id, $bill);
		}else{
			$bill['fine_receive']= $bill_gets['fine_receive'];
			$result = $this->bill_mdl->update_billing($id, $bill);
		}
		if(isset($lbr) && $lbr != "" ){
			$bill['diposit_lbr_amount']=$lbr+$bill_gets['diposit_lbr_amount'];
			$result = $this->bill_mdl->update_billing($id, $bill);
		}
		//print_r($bill);die;
		$result = $this->bill_mdl->store_payment($payment);
		//$this->load->view('billing/ledger_v',$data);
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url,'refresh');
 }
	  public function remove_billing() {
        
		$billing_id=$this->uri->segment('3');		
		 $billing_info = $this->bill_mdl->get_billing_by_id($billing_id);
        if (!empty($billing_info)) {
            $result = $this->bill_mdl->remove_billing_by_id($billing_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('billing?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('billing?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('billing?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }
	public function printbill($id){
		$data = array();
		
			   $data['stock_info'] = $this->stk_mdl->stock_info();
			   $data['bill_info_trans_print'] = $this->bill_mdl->billing_trans($id);
			   $data['bill_info'] = $this->bill_mdl->get_billing_by_id($id);
			  // echo "<pre>";print_r($data['bill_info']);die;
			   $data['payment'] = $this->bill_mdl->getpaymentlist($id);
			   //print_r($id);die;
			   if (!empty($data['bill_info'])) {
					$data['title'] = 'Print Bill';
					$this->load->view('header');
					$this->load->view('billing/print',$data);
					$this->load->view('footer');
			   } else {
				   $sdata['exception'] = 'Content not found !';
				   $this->session->set_userdata($sdata);
				   redirect('billing', 'refresh');
			   }
	   }
	   public function printbill2($id){
		$data = array();
		
			   $data['stock_info'] = $this->stk_mdl->stock_info();
			   $data['bill_info_trans_print'] = $this->bill_mdl->billing_trans($id);
			   $data['bill_info'] = $this->bill_mdl->get_billing_by_id($id);
			  // echo "<pre>";print_r($data['bill_info']);die;
			   $data['payment'] = $this->bill_mdl->getpaymentlist($id);
			   //print_r($id);die;
			   if (!empty($data['bill_info'])) {
					$data['title'] = 'Print Bill';
					$this->load->view('header');
					$this->load->view('billing/without_tax_print',$data);
					$this->load->view('footer');
			   } else {
				   $sdata['exception'] = 'Content not found !';
				   $this->session->set_userdata($sdata);
				   redirect('billing', 'refresh');
			   }
	   }
	   public function exportCSV(){ 
		// file name 
		$filename = 'bill_'.date('Y-m-d h:i:s').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
	   
		// get data 
		$billing_info = $this->bill_mdl->billing_info_export();
	 
		// file creation 
		$file = fopen('php://output', 'w');
	  
		$header = array("Id","Bill No","Customer Name","Mobile No","Address","Bill Date","Total g_wt","Total b_qty","Total b_wt","Total net_wt","Total Fine","Total labour_psc","Total labour_gm","LBR amount","Silver receive","Silver purity","Fine Receive","Fine Remain","Current Rate","Fine rate","Rate Diposit","LBR Diposit","Cgst %","CGST-MP price","Sgst %","SGST-MP price","Grand Total","Created date","Status"); 
		fputcsv($file, $header);
		foreach ($billing_info as $key=>$line){ 
		  fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	   }
  }
  