<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CC_Controller { 
    public function __construct() {
      parent::__construct();
        // Check Login Status
      $this->user_login_authentication();
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');	
      $this->load->model('admin_models/customer_model', 'customer_mdl'); 
      $this->load->model('admin_models/orders_model', 'orders_mdl');
      $this->load->model('admin_models/tasks_model', 'tasks_mdl');
	  $this->load->model('admin_models/agency_model', 'agency_mdl');
         
    }

    public function index() {
      $data = array();
      $data['title'] = 'Dashboard';
      $this->load->view('header');
	  $this->load->view('dashboard');
	  $this->load->view('footer');
    }		
  }