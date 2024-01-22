<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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

class Dashboard_model extends CC_Model {

    public function __construct() {
        parent::__construct();
    }

 
    private $_cat = 'dir_categories';
    private $_city = 'dir_cities';
 
 
    
    public function count_total_users() {
        $result = $this->db->get_where($this->_users, array('deletion_status' => 0));
        return $result->num_rows();
    }
	  
    
    public function count_total_categories() {
        $result = $this->db->get_where($this->_cat, array('deletion_status' => 0));
        return $result->num_rows();
    } 

}
