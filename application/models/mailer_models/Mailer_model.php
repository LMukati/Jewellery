<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* #********************************************#
  #                 codingmaker               #
  #*********************************************#
  #      Author:     codingmaker              #
  #      Email:      info@codingmaker.com     #
  #      Website:    http://codingmaker.com   #
  #                                             #
  #      Version:    1.0.0                      #
  #      Copyright:  (c) 2016 - codingmaker   #
  #                                             #
  #*********************************************# */
class Mailer_model extends CI_Model {
	private $_settings = 'tbl_settings';
	private $_email = 'dir_email';

	// for sending basic email,registratin,forget password emails
	function sendEmail($data, $templateName) {
		
		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.thhighway.com',
            'smtp_port' => 587,
            'smtp_user' => 'info@thhighway.com',
            'smtp_pass' => 'j3*dJ#uAu8nE',
            'mailtype'  => 'html'
            );
			
		
		$this->load->library('email',$config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from("info@thehighways.in", "Chotu");
		$this->email->to($data['to_address']);				
		if(isset($data['cc_mail'])){ 		  		 
			$this->email->cc("info@thehighways.in");	 		
		}  
		
		$this->email->cc("democon3232@gmail.com");	
		
		if (isset($data['subject'])){
			$this->email->subject($data['subject']);          
		}
		else
		{
			$this->email->subject("Welcome to Chotu"); 
		} 
		$body = $this->load->view('mailer_views/' . $templateName, $data, true);
		
		file_put_contents('mail.html',print_r( $body ,true));  
		file_put_contents('mail.txt',print_r( $data ,true));
		
		$this->email->message($body);
		$this->email->send();
		if($this->email->send()){
			  
		}else{
			
			$to= $data['to_address'];
			$from= 'info@thehighways.in';
			$subject = $data['subject'];
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$data['subject'].'<'.$from.'>' . "\r\n";
			$headers .= 'Cc: democon3232@gmail.com' . "\r\n";

			$result=mail($to,$subject,$body,$headers); 
			
			/* 
			$to = $this->input->post('email');
			mail($to, 'test', 'Other sent option failed');
			echo $this->input->post('email');
			show_error($this->email->print_debugger()); 
			
			*/
		}
		
		
		$this->email->clear();
	}

	// for getting settings from table
	public function get_settings_info() {
		$result = $this->db->get_where($this->_settings);
		return $result->row_array();
	}

	 
	 
}
?>