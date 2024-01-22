<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CC_Controller { 
    public function __construct() {
      parent::__construct();
        // Check Login Status
      $this->user_login_authentication();
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');
      $this->load->model('stock_model', 'stk_mdl');	  
      
    }

    public function index() {
      $data = array();
      $data['title'] = 'Stock';
      $this->load->view('header');
		  $page = $_REQUEST['currentpage']; 
		  $search = $_REQUEST['search'];
	  $data['stock_info'] = $this->stk_mdl->stock_info($page,$search);
	  $this->load->view('stock/manage_stock_v',$data);
	  $this->load->view('footer');
    }
	public function stock_manage_l($id) {
		$data = array();
		$data['title'] = 'Stock';
		$this->load->view('header');
			// $page = $_REQUEST['currentpage']; 
			// $search = $_REQUEST['search'];
		$data['stock_info'] = $this->stk_mdl->get_stock_id($id);
		//print_r($data['stock_info']);
		$this->load->view('stock/stock_manage_ladger_v',$data);
		$this->load->view('footer');
	  }		
  
  
  public function addstock(){
	  $data = array();
      $data['title'] = 'Add Stock';
      $this->load->view('header');
	  $this->load->view('stock/addstock_v');
	  $this->load->view('footer');
    }
	
  public function create_stock(){
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
                'field' => 'merchant_name',
                'label' => 'Merchant name',
                'rules' => 'trim|required|max_length[250]'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->addstock();
		 } else {
			
			//print_r( $this->input->post('add_stock_id',TRUE));die;
			$add_stock_id=$this->input->post('add_stock_id',TRUE);
			if($add_stock_id =="" || $add_stock_id == null){
			$data['merchant_name'] = $this->input->post('merchant_name', TRUE); 
			$data['merchant_mobile_no'] = $this->input->post('merchant_mobile_no', TRUE); 
			$data['merchant_address'] = $this->input->post('merchant_address', TRUE); 
			$data['stock_date'] = $this->input->post('stock_date', TRUE);
			$data['bill_no'] = $this->input->post('bill_no', TRUE);
			$data['item_name'] = $this->input->post('item_name', TRUE);
			$data['g_weight'] = $this->input->post('g_weight', TRUE);
			$data['bags_qty'] = $this->input->post('bags_qty', TRUE);
			$data['bags_weight'] = $this->input->post('bags_weight', TRUE);
			$data['total_bags_weight'] = $this->input->post('total_bags_weight', TRUE);
			$data['net_weight'] = $this->input->post('net_weight', TRUE);
		    $data['melting'] = $this->input->post('melting', TRUE);
			$data['tunch'] = $this->input->post('tunch', TRUE);
			$data['fine'] = $this->input->post('fine', TRUE);
			if(!empty($this->input->post('labour_pcs', TRUE))){
			    $data['labour_pcs'] = $this->input->post('labour_pcs', TRUE);
			}
			else {
				$data['labour_pcs']=0.00;
			}
			
			if(!empty($this->input->post('labour_gm', TRUE))){
			$data['labour_gm'] = $this->input->post('labour_gm', TRUE);
			}
			else {
				$data['labour_gm']=0.00;
			}
			$data['amount'] = $this->input->post('amount', TRUE);
			$data['created_date']=date('Y-m-d h:i:s');
  		    $data['deletion_status']=0;
			
				$insert_id = $this->stk_mdl->store_stock($data); 
				//print_r($insert_id);die;
				$data['stock_id'] = $insert_id;
			$data['merchant_name'] = $this->input->post('merchant_name', TRUE); 
			$data['merchant_mobile_no'] = $this->input->post('merchant_mobile_no', TRUE); 
			$data['merchant_address'] = $this->input->post('merchant_address', TRUE); 
			$data['stock_date'] = $this->input->post('stock_date', TRUE);
			$data['bill_no'] = $this->input->post('bill_no', TRUE);
			$data['item_name'] = $this->input->post('item_name', TRUE);
			$data['g_weight'] = $this->input->post('g_weight', TRUE);
			$data['bags_qty'] = $this->input->post('bags_qty', TRUE);
			$data['bags_weight'] = $this->input->post('bags_weight', TRUE);
			$data['total_bags_weight'] = $this->input->post('total_bags_weight', TRUE);
			$data['net_weight'] = $this->input->post('net_weight', TRUE);
		    $data['melting'] = $this->input->post('melting', TRUE);
			$data['tunch'] = $this->input->post('tunch', TRUE);
			$data['fine'] = $this->input->post('fine', TRUE);
			if(!empty($this->input->post('labour_pcs', TRUE))){
			    $data['labour_pcs'] = $this->input->post('labour_pcs', TRUE);
			}
			else {
				$data['labour_pcs']=0.00;
			}
			
			if(!empty($this->input->post('labour_gm', TRUE))){
			$data['labour_gm'] = $this->input->post('labour_gm', TRUE);
			}
			else {
				$data['labour_gm']=0.00;
			}
			$data['amount'] = $this->input->post('amount', TRUE);
			$data['created_date']=date('Y-m-d h:i:s');
  		    $data['deletion_status']=0;
			  $insert_stock = $this->stk_mdl->stock_manage($data); 
			}else{
				//echo "<pre>";print_r($this->input->post());die;//print_r( $this->input->post('add_stock_id',TRUE));die;
			$data['stock_id'] = $add_stock_id;
			$data['merchant_name'] = $this->input->post('merchant_name', TRUE); 
			$data['merchant_mobile_no'] = $this->input->post('merchant_mobile_no', TRUE); 
			$data['merchant_address'] = $this->input->post('merchant_address', TRUE); 
			$data['stock_date'] = $this->input->post('stock_date', TRUE);
			$data['bill_no'] = $this->input->post('bill_no', TRUE);
			$data['item_name'] = $this->input->post('item_name', TRUE);
			$data['g_weight'] = $this->input->post('g_weight', TRUE);
			$data['bags_qty'] = $this->input->post('bags_qty', TRUE);
			$data['bags_weight'] = $this->input->post('bags_weight', TRUE);
			$data['total_bags_weight'] = $this->input->post('total_bags_weight', TRUE);
			$data['net_weight'] = $this->input->post('net_weight', TRUE);
		    $data['melting'] = $this->input->post('melting', TRUE);
			$data['tunch'] = $this->input->post('tunch', TRUE);
			$data['fine'] = $this->input->post('fine', TRUE);
			if(!empty($this->input->post('labour_pcs', TRUE))){
			    $data['labour_pcs'] = $this->input->post('labour_pcs', TRUE);
			}
			else {
				$data['labour_pcs']=0.00;
			}
			
			if(!empty($this->input->post('labour_gm', TRUE))){
			$data['labour_gm'] = $this->input->post('labour_gm', TRUE);
			}
			else {
				$data['labour_gm']=0.00;
			}
			$data['amount'] = $this->input->post('amount', TRUE);
			$data['created_date']=date('Y-m-d h:i:s');
  		    $data['deletion_status']=0;

		    $insert_id = $this->stk_mdl->stock_manage($data); 
				if (!empty($insert_id)) {
						$stock_info = $this->stk_mdl->get_stock_by_id($add_stock_id);
						$data_net['net_weight']=$stock_info['net_weight']+ $this->input->post('net_weight', TRUE);
						$result_stock_update =$this->stk_mdl->update_stock($add_stock_id, $data_net);
				}
			}
			if (!empty($insert_id)) {
                $sdata['success'] = 'Add successfully . ';
                $this->session->set_userdata($sdata);
				redirect('stock', 'refresh');
			 } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('stock', 'refresh');
            }
          }// Else Ends Here.....
      }	 

        public function edit_stock() {
			$edit_stock=$this->uri->segment('3');
			$data = array();
			$data['stock_info'] = $this->stk_mdl->get_stock_by_id($edit_stock);
			if (!empty($data['stock_info'])) {
				 $data['title'] = 'Edit Stock';
			     $this->load->view('header');
	             $this->load->view('stock/edit_stock_v',$data);
	             $this->load->view('footer');
			} else {
				$sdata['exception'] = 'Content not found !';
				$this->session->set_userdata($sdata);
				redirect('stock', 'refresh');
			}
    }
	public function edit_stock_l() {
		$edit_stock=$this->uri->segment('3');
		$data = array();
		$data['stock_info'] = $this->stk_mdl->get_stock_l_id($edit_stock);
		
		if (!empty($data['stock_info'])) {
			 $data['title'] = 'Edit Stock';
			 $this->load->view('header');
			 $this->load->view('stock/edit_stock_m_v',$data);
			 $this->load->view('footer');
		} else {
			$sdata['exception'] = 'Content not found !';
			$this->session->set_userdata($sdata);
			redirect('stock', 'refresh');
		}
}

        public function update_stock() {	
		  $stock_id = $this->input->post('edit_id', TRUE); 
		  $stock_id1 = $this->input->post('edit_id_m', TRUE);
		  $stock_info1 = $this->stk_mdl->get_stock_l_id($stock_id1); 
		  
		  $stock_info = $this->stk_mdl->get_stock_by_id($stock_id);
        if (!empty($stock_info)) {
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
					'field' => 'merchant_name',
					'label' => 'Merchant name',
					'rules' => 'trim|required|max_length[250]'
                )
			);
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $this->edit_stock($stock_id);
            } else {
			$data['merchant_name'] = $this->input->post('merchant_name', TRUE); 
			$data['merchant_mobile_no'] = $this->input->post('merchant_mobile_no', TRUE); 
			$data['merchant_address'] = $this->input->post('merchant_address', TRUE); 
			$data['stock_date'] = $this->input->post('stock_date', TRUE);
			$data['bill_no'] = $this->input->post('bill_no', TRUE);
			$data['item_name'] = $this->input->post('item_name', TRUE);
			$data['g_weight'] = $this->input->post('g_weight', TRUE);
			$data['bags_qty'] = $this->input->post('bags_qty', TRUE);
			$data['bags_weight'] = $this->input->post('bags_weight', TRUE);
			$data['total_bags_weight'] = $this->input->post('total_bags_weight', TRUE);
			$data['net_weight'] = $this->input->post('net_weight', TRUE);
			$data['melting'] = $this->input->post('melting', TRUE);
			$data['tunch'] = $this->input->post('tunch', TRUE);
			$data['fine'] = $this->input->post('fine', TRUE);
			if(!empty($this->input->post('labour_pcs', TRUE))){
			    $data['labour_pcs'] = $this->input->post('labour_pcs', TRUE);
			}
			else {
				$data['labour_pcs']=0.00;
			}
			
			if(!empty($this->input->post('labour_gm', TRUE))){
			$data['labour_gm'] = $this->input->post('labour_gm', TRUE);
			}
			else {
				$data['labour_gm']=0.00;
			}
			$data['amount'] = $this->input->post('amount', TRUE);
            $result = $this->stk_mdl->update_stock($stock_id, $data);
				
			    if (!empty($result)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
				   redirect('stock', 'refresh');
				 } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('stock', 'refresh');
                }
            }
        }elseif(!empty($stock_info1)){
			
			$data['merchant_name'] = $this->input->post('merchant_name', TRUE); 
			$data['merchant_mobile_no'] = $this->input->post('merchant_mobile_no', TRUE); 
			$data['merchant_address'] = $this->input->post('merchant_address', TRUE); 
			$data['stock_date'] = $this->input->post('stock_date', TRUE);
			$data['bill_no'] = $this->input->post('bill_no', TRUE);
			$data['item_name'] = $this->input->post('item_name', TRUE);
			$data['g_weight'] = $this->input->post('g_weight', TRUE);
			$data['bags_qty'] = $this->input->post('bags_qty', TRUE);
			$data['bags_weight'] = $this->input->post('bags_weight', TRUE);
			$data['total_bags_weight'] = $this->input->post('total_bags_weight', TRUE);
			$data['net_weight'] = $this->input->post('net_weight', TRUE);
			$data['melting'] = $this->input->post('melting', TRUE);
			$data['tunch'] = $this->input->post('tunch', TRUE);
			$data['fine'] = $this->input->post('fine', TRUE);
			if(!empty($this->input->post('labour_pcs', TRUE))){
			    $data['labour_pcs'] = $this->input->post('labour_pcs', TRUE);
			}
			else {
				$data['labour_pcs']=0.00;
			}
			
			if(!empty($this->input->post('labour_gm', TRUE))){
			$data['labour_gm'] = $this->input->post('labour_gm', TRUE);
			}
			else {
				$data['labour_gm']=0.00;
			}
			$data['amount'] = $this->input->post('amount', TRUE);
			$stock_info = $this->stk_mdl->get_stock_by_id($stock_info1[0]['stock_id']);
			
				if (!empty($stock_info1)) {
				
						$data_net1['net_weight']=$stock_info['net_weight']- $stock_info1[0]['net_weight'];
						
						$data_net['net_weight']=$data_net1['net_weight']+ $this->input->post('net_weight', TRUE);
						
						$result_stock_update =$this->stk_mdl->update_stock($stock_info1[0]['stock_id'], $data_net);
						$insert_id = $this->stk_mdl->update_stock_l($stock_id1,$data); 
				}
				
			    if (!empty($insert_id)) {
                    $sdata['success'] = 'Update successfully .';
                    $this->session->set_userdata($sdata);
				   redirect('stock', 'refresh');
				 } else {
                    $sdata['exception'] = 'Operation failed !';
                    $this->session->set_userdata($sdata);
                    redirect('stock', 'refresh');
                }
		} else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('stock', 'refresh');
        }
	 }
	 
	  public function remove_stock() {
        
		$stock_id=$this->uri->segment('3');		
		 $stock_info = $this->stk_mdl->get_stock_by_id($stock_id);
        if (!empty($stock_info)) {
            $result = $this->stk_mdl->remove_stock_by_id($stock_id);
            if (!empty($result)) {
                $sdata['success'] = 'Remove successfully .';
                $this->session->set_userdata($sdata);
                redirect('stock?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            } else {
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata);
                redirect('stock?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
            }
        } else {
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata);
            redirect('stock?currentpage='.$_REQUEST['currentpage'].'', 'refresh');
        }
    }
  }
  