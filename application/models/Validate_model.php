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

class Validate_model extends CC_Model {

    public function __construct() {
        parent::__construct();
    }
	
	public function get_seo_page_name($tbl,$colum,$value,$id_colum='',$id='') {
		
		if($id!=''){
		
		 $this->db->select('*')
		->from(''.$tbl.'') 
		->where('deletion_status', 0)
		->where(''.$id_colum.'!=', $id )
		->where(''.$colum.'', $value );
			
		} else{
			
		$this->db->select('*')
		->from(''.$tbl.'') 
		->where('deletion_status', 0)
		->where(''.$colum.'', $value ); 
		}

		$seo_result = $this->db->get();
		$seo_page_name = $seo_result->result_array();
		if(isset($seo_page_name[0])){
			$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$value = $value."-".$s;
		}  
		return $value;
	}
	
	
}
?>