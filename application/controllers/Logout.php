<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CC_Controller {
    /* #********************************************#
      #                   codingmaker             #
      #*********************************************#
      #      Author:     codingmaker              #
      #      Email:      info@codingmaker.com     #
      #      Website:    http://codingmaker.com   #
      #                                             #
      #      Version:    1.0.0                      #
      #      Copyright:  (c) 2018 - codingmaker   #
      #                                             #
      #*********************************************# */

    public function __construct() {
        parent::__construct();

        //Check Login Status
        //$this->user_login_authentication();
    }

    public function index() {
		
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('first_name');
        $this->session->unset_userdata('last_name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logged_info');
//      $this->session->sess_destroy();
        $sdata['success'] = "<b>Logout</b> successfully";
        $this->session->set_userdata($sdata);
        redirect('home', 'refresh');
    }
}
