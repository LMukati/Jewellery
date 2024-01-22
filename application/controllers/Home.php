<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CC_Controller {
    public function __construct() {
        parent::__construct();

        //$logged_info = $this->session->userdata('logged_info');
        //if ($logged_info != FALSE) {
            //redirect('dashboard', 'refresh');
        //}
        $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
        $this->load->model('Jewellery_login_model', 'login_mdl');
	 }

    public function index() {
        $data = array();
        $data['title'] = 'Maa Gayatri jewellers';
		$this->load->view('login', $data);
	 }

    public function checkjewellerylogin(){
		//print_r("hi");die;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jewl_password', 'Password', 'required|min_length[6]');
        if ($this->form_validation->run() == FALSE)
		{
            $error_message = validation_errors();
			$this->session->set_flashdata('errormessage', $error_message);
			redirect(site_url('home'));
		}
		
		
        $logindata = $this->login_mdl->check_login_info($jewl_password);
		//print_r($logindata);die;
		 if (!empty($logindata)) {
		        $sdata['id'] = $logindata->user_id;
				$sdata['first_name'] = $logindata->first_name;
				$sdata['last_name'] = $logindata->last_name;
				$sdata['email'] = $logindata->email;
				$sdata['logged_info'] = TRUE;
				$this->session->set_userdata($sdata);
				redirect(site_url('dashboard'));
				
		 }
		  else {
			    $wrongdata = 'The <b>Password</b> you’ve entered doesn’t match any account !';
                $this->session->set_flashdata('logincheck', $wrongdata);
				redirect(site_url('home'));
          }	
		  
		
		 
	}
	
	public function checkagentlogin(){
		$this->load->helper('url');
		$result = $this->agent_login_mdl->check_login_info();
		 if ($result) {
		        $adata['agent_id'] = $result->id;
				$adata['agent_name'] = $result->agent_name;
				$adata['agent_cell'] = $result->cell;
				$adata['agent_email'] = $result->agent_email;
				$adata['agent_photo'] = $result->agent_photo;
				$adata['logged_info'] = TRUE;
				$this->session->set_userdata($adata);
				$json= json_encode(array('status'=>'true'));
		 }
		  else {
		        $adata['exception'] = 'The <b>Email</b> or <b>Password</b> you’ve entered doesn’t match any account !';
                //$this->session->set_userdata($adata);
				$json=json_encode(array('status'=>'false','message'=>'The <b>Username</b> or <b>Password</b> you’ve entered doesn’t match any account !'));
          }	
		  echo $json;
		
		
	}
	
	   public function get_suburbs(){
        $data = array();
        $id = $this->input->post('id',true);
        $suburb_info = $this->home_mdl->get_suburbs_info($id);
        $data["status"] = 'false';
        if(!empty($suburb_info))
        {
            $data["status"] = 'true';
            $data["suburb_info"] = $suburb_info;
        }// end if cat_info
       print_r(json_encode($data));
    }// end function  get_sub_category
	
	/* Autosuggest for Agent and  Agency */
	
	public function get_agency_agent(){
        $data = array();
        $id = $this->input->post('id',true);
        $suburb_info = $this->home_mdl->get_suburbs_info($id);
        $data["status"] = 'false';
        $q = $this->input->post('q',true);
	    $result_auto = $this->home_mdl->get_autosuggest_info($q);
        $res = array();
     	foreach($result_auto as $v_result_auto){
		  $res[] = array('id'=>$v_result_auto['agency_id'], 'label'=>$v_result_auto['agency']);
	    }
       if(!$res) {
         $res[0] = 'Not found!';
        }
       echo json_encode($res);
	}// end function  get_sub_category
	
	/* Autosuggest for Agent only */
	public function get_agent_autosuggest(){
		
		$data = array();
		$q = $this->input->post('q',true);
	    $result_auto = $this->home_mdl->get_agent_autosuggest_info($q);
        $res = array();
     	foreach($result_auto as $v_result_auto){
		if(!empty($v_result_auto['agent_photo'])){
		    $agent_photo=base_url('assets/uploads/agentphoto/').$v_result_auto['agent_photo'];
			$big_agent_photo='<img src='.$agent_photo.'>';
		 }
		 else {
			$agent_photo=base_url('assets/uploads/agentphoto/no_photo_available.png');
            $big_agent_photo='<img src='.$agent_photo.'>';			
		 }
		  $photo='<img src='.$agent_photo.' width="30">';
		  
		  $res[] = array('id'=>$v_result_auto['id'], 'label'=>$photo.$v_result_auto['agent_name'], 'value'=>$v_result_auto['agent_name'], 'agent_photo'=>$big_agent_photo);
	    }
       if(!$res) {
         $res[0] = 'Not found!';
        }
       echo json_encode($res);
	}
	
	
	public function searchresult(){
		$data = array();
		$data['get_towns_info']=$this->town_mdl->get_towns_info();
		$data['get_blog_info']=$this->blog_mdl->get_blog_info();
		$data['get_client_info'] = $this->client_mdl->get_client_info();
		
		$home_town_id = $this->input->post('home_town_id',true);
		$data['suburb_info'] = $this->home_mdl->get_suburbs_info($home_town_id);
		$home_suburbs_id = $this->input->post('home_suburbs_name',true);
		$search_id = $this->input->post('search_id',true);
		
		  //if(!empty($search_id)){
			   //$arr=explode('_', $search_id);
			  // $id=$arr[0];
			   //$user=$arr[1];
			   //if($user == 'agent' ){
				   $data['result_auto'] = $this->home_mdl->get_autosearch_data($search_id, $home_town_id, $home_suburbs_id,'agent');
			       //$data['data_content'] = 'agent';
			  // }
			   
			   //if($user == 'agency'){
				   //$data['result_auto'] = $this->home_mdl->get_autosearch_data($id, $home_town_id, $home_suburbs_id,'agency');
			      //$data['data_content'] = 'agency';
				//}
					$this->load->view('frontend_views/header');
					$this->load->view('frontend_views/search',$data);
					$this->load->view('frontend_views/searchcontent', $data);
					$this->load->view('frontend_views/footer', $data);
			//}
			//else {
			    //$this->index();
			//}
	}
	public function showagent(){
		    $agent_id=$this->uri->segment(3);
		    $data['agent_info'] = $this->home_mdl->get_agent_info($agent_id);
			$this->load->view('frontend_views/header');
			//$this->load->view('frontend_views/search',$data);
			$this->load->view('frontend_views/agentdetail', $data);
			$this->load->view('frontend_views/footer', $data);
        }
		
    public function review(){
		    $this->load->view('frontend_views/header');
			$this->load->view('frontend_views/review');
			$this->load->view('frontend_views/footer');
	}
	
	public function create_review(){
		    $data = array();
			$data['agent_id']=$this->input->post('auto_agent_id',true);
			if(!empty($this->input->post('quick_rate',true))){
				$data['quick_rate']=$this->input->post('quick_rate',true);
			}
			else {
				$data['quick_rate']=0;
			}
			$data['slider0']=$this->input->post('slider0',true);
			$data['slider1']=$this->input->post('slider1',true);
			$data['slider2']=$this->input->post('slider2',true);
			$data['slider3']=$this->input->post('slider3',true);
			$data['review']=$this->input->post('review',true);
			$data['desired_transaction']=$this->input->post('desired_transaction',true);
			$data['professional_again']=$this->input->post('professional_again',true);
			$data['service_month']=$this->input->post('service_month',true);
			$data['service_year']=$this->input->post('service_year',true);
			$data['service_help']=$this->input->post('service_help',true);
			$data['address']=$this->input->post('address',true);
			$data['zipcode']=$this->input->post('zipcode',true);
			$data['review_first_name']=$this->input->post('review_first_name',true);
			$data['review_last_name']=$this->input->post('review_last_name',true);
			$data['review_email']=$this->input->post('review_email',true);
			$data['review_confirm']=$this->input->post('review_confirm',true);
			$data['create_date']=date('Y-m-d h:i:s');
			$data['deletion_status']=0;
			
			$insert_id=$this->home_mdl->store_review($data);
			 if(!empty($insert_id)){
			   $this->session->set_flashdata('enquirySuccess', 'Review Add Successfully !');
				redirect('home/review', 'refresh');
			 }
			 else{
				$this->load->view('frontend_views/header');
				$this->load->view('frontend_views/review');
				$this->load->view('frontend_views/footer');
				 
			 }
	    }
		
		public function enquiry(){
		    $this->load->view('frontend_views/header');
			$this->load->view('frontend_views/enquiries');
			$this->load->view('frontend_views/footer');
	    }
		
		public function create_enquiry(){
			$user_name=$this->input->post('user_name',true);
			$user_email=$this->input->post('user_email',true);
			$user_message=$this->input->post('user_message',true);
			
			/*  Mail Function */
			$admin_email = 'info@rateagent.co.za';
			//get_general_info
			$subject = "New Enquiry";
			$email_body = '<h1 style="margin: 0px; padding: 0px; color:#464646; font-weight: 400; font-size: 25px;">Hello Admin,</h1>
			<p style="margin:15px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">New Enquiry 
			<br/>	
			New Enquiry Information</p>
			<p style="margin:15px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">
				Name = '.$user_name.'<br/>
				Email = '.$user_email.'<br/>
				Message = '.$user_message.'<br/>
			</p>';
			$this->send_email($admin_email , $subject , $email_body , 0);
			$this->session->set_flashdata('enquirySuccess', 'Enquiry Send Successfully!');
			redirect('home/enquiry', 'refresh');
		}
		
		public function blogdetail(){
			$blog_id=$this->uri->segment(3);
			$data['get_blog_info']=$this->home_mdl->get_blog_detail($blog_id);			
			$this->load->view('frontend_views/header');
			$this->load->view('frontend_views/blog_detail', $data);
			$this->load->view('frontend_views/footer');
		}
		
		
		public function showtownsagent(){
		    $town_id=$this->uri->segment(3);
			$data['town_info'] = $this->home_mdl->get_town_by_id($town_id);
			$data['town_agent_info'] = $this->home_mdl->get_town_info($town_id);
			$this->load->view('frontend_views/header');
			$this->load->view('frontend_views/towndetail', $data);
			$this->load->view('frontend_views/footer', $data);
        }
		
		public function whatrateagent(){
			$data = array();
			$data['title'] = 'Agency';
			$data['get_towns_info']=$this->town_mdl->get_towns_info();
			$data['get_blog_info']=$this->blog_mdl->get_blog_info();
			$data['get_client_info'] = $this->client_mdl->get_client_info();
			$data['get_testimonial_info'] = $this->testimonial_mdl->get_testimonial_info();
			$this->load->view('frontend_views/header');
			$this->load->view('frontend_views/search',$data);
			$this->load->view('frontend_views/whatrateagent', $data);
			$this->load->view('frontend_views/footer', $data);
		}
		
		public function getagentreview($agent_id){
		$review_info=$this->agency_agent_mdl->get_agent_review_by_id($agent_id); 
		if(!empty($review_info)){
			$totalrate=0;
			 $datacount=count($review_info);
			foreach($review_info as $v_review){
				//if($v_review['quick_rate'] == 0){
					
				     $totalrate +=(($v_review['slider0']/5)+($v_review['slider1']/5)+($v_review['slider2']/5)+($v_review['slider3']));
				//}
				//else {
					 //$rate=$v_review['quick_rate'];
				//}
				
			}
			//echo ceil($totalrate/$datacount);
			 return  ceil($totalrate/$datacount);
		}
	  }
	  
	  public function agencyforgetpassowrd(){
		  $data = array();
		  $data['title'] = 'Forget password';
		  $this->load->view('frontend_views/header');
		  $this->load->view('frontend_views/forgetpassword', $data);
		  $this->load->view('frontend_views/footer', $data);
		}
		
		public function checkemail(){
		  $data = array();
		  $data['title'] = 'Forget password';
		  
		  
		   $forget_password=$this->input->post('forget_password',true);
		  
		  if($forget_password == 'agentforgetpassowrd'){
			   $agent_email=$this->input->post('agent_email',true);
			  
			if(!empty($agent_email)){
			  $result = $this->home_mdl->check_email_agent($agent_email);
			  if(!empty($result)){
				  $agent_id=$result['id'];
				  $agent_email=$result['agent_id'];
				  $agent_name=$result['agent_name'];
				  
		    // Mail Send to the Agency 
			$link=base_url().'home/agentnewpassword/'.$agent_id;	  
		    $admin_email = $agent_email;
			//get_general_info
			$subject = "Change Password";
			$email_body = '<h1 style="margin: 0px; padding: 0px; color:#464646; font-weight: 400; font-size: 25px;">Hello '.$agent_name.',</h1>
			<p style="margin:15px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">Change Password 
			<br/>	
			Please click on the Link Below to change the password</p>
			<p style="margin:15px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">
				Link = '.$link.'<br/>
			</p>';
			$this->send_email($admin_email , $subject , $email_body , 0);
			
			$this->session->set_flashdata('checkemailinboxagent', 'Change Password link has been sent on Your registerd Email Address');
			redirect('home/agentforgetpassowrd', 'refresh');
			}
			  else {
				   $this->session->set_flashdata('checkemailerror', 'Our Records indicates that this email address not Exist!');
			       redirect('home/agentforgetpassowrd', 'refresh');
			  }
			}
		}
		  
		   if($forget_password == 'agencyforgetpassowrd'){
			  $agency_email=$this->input->post('agency_email',true);
			  
			if(!empty($agency_email)){
			  $result = $this->home_mdl->check_email($agency_email);
			  if(!empty($result)){
				  $agency_id=$result['id'];
				  $agency_email=$result['email'];
				  $agency=$result['agency'];
				  
		    // Mail Send to the Agency 
			$link=base_url().'home/newpassword/'.$agency_id;	  
		    $admin_email = $agency_email;
			//get_general_info
			$subject = "Change Password";
			$email_body = '<h1 style="margin: 0px; padding: 0px; color:#464646; font-weight: 400; font-size: 25px;">Hello '.$agency.' (Agency),</h1>
			<p style="margin:15px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">Change Password 
			<br/>	
			Please click on the Link Below to change the password</p>
			<p style="margin:15px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">
				Link = '.$link.'<br/>
			</p>';
			$this->send_email($admin_email , $subject , $email_body , 0);
			
			$this->session->set_flashdata('checkemailinbox', 'Change Password link has been sent on Your registerd Email Address');
			redirect('home/agencyforgetpassowrd', 'refresh');
			}
			  else {
				   $this->session->set_flashdata('checkemailerror', 'Our Records indicates that this email address not Exist!');
			       redirect('home/agencyforgetpassowrd', 'refresh');
			  }
			}
			  
		  }
		  
		  $this->load->view('frontend_views/header');
		  $this->load->view('frontend_views/forgetpassword', $data);
		  $this->load->view('frontend_views/footer', $data);
		}
	
	 public function newpassword(){
			$data['id']=$this->uri->segment(3);
			$this->load->view('frontend_views/header');
		    $this->load->view('frontend_views/newpassword', $data);
		    $this->load->view('frontend_views/footer', $data);
		}
		
	public function changepassword(){
		   $data['title']='change password';
		   $agency_id=$this->input->post('agency_id',true);
		   $change_password=$this->input->post('change_password',true);
		   $update_pass = $this->home_mdl->change_password($agency_id, $change_password);
		   if(!empty($update_pass)){
		        $this->session->set_flashdata('passwordsuccess', 'password has been changed');
		        redirect('home/newpassword', 'refresh');
		    }
		   else {
		   $this->load->view('frontend_views/header');
		   $this->load->view('frontend_views/newpassword', $data);
		   $this->load->view('frontend_views/footer', $data);
		   }
	      }	

      public function agentforgetpassowrd(){
		  $data = array();
		  $data['title'] = 'Forget password';
		  $this->load->view('frontend_views/header');
		  $this->load->view('frontend_views/forgetpassword', $data);
		  $this->load->view('frontend_views/footer', $data);
	   }

       public function agentnewpassword(){
		   
	        $data['id']=$this->uri->segment(3);
			$this->load->view('frontend_views/header');
		    $this->load->view('frontend_views/agentnewpassword', $data);
		    $this->load->view('frontend_views/footer', $data); 
		   
	   }
	   
	   public function agentchangepassword(){
		   $data['title']='Agent change password';
		   $agent_id=$this->input->post('agent_id',true);
		   $change_password=$this->input->post('change_password',true);
		   $update_pass = $this->home_mdl->agent_change_password($agent_id, $change_password);
		   if(!empty($update_pass)){
		        $this->session->set_flashdata('passwordsuccess', 'password has been changed');
		          redirect('home/agentnewpassword', 'refresh');
		    }
		   else {
		   $this->load->view('frontend_views/header');
		   $this->load->view('frontend_views/agentnewpassword', $data);
		   $this->load->view('frontend_views/footer', $data);
		}
	   }	
	}
