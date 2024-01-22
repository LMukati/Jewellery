<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CC_Controller extends CI_Controller {

    function __construct() {
        parent::__construct(); 
        date_default_timezone_set('Asia/Dhaka');
        //ob_start();
		$this->load->model('CC_Model');
		
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        ob_clean();
    }

	public function get_settings_info() {
        
		$settings_info = $this->CC_Model->get_settings_info(); 
		return $settings_info;
    }
     

    public function user_login_authentication() {
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('', 'refresh');
        }
    }

    public function super_admin_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label != 1) {
            redirect('dashboard', 'refresh');
        }
    }

    public function super_admin_news_editor_and_news_reporter_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 2 || $access_label == 3) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    public function super_admin_and_news_editor_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 2) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    public function super_admin_and_news_reporter_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 3) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    public function super_admin_and_comment_reviewer_authentication_only() {
        $access_label = $this->session->userdata('access_label');
        if ($access_label == 1 || $access_label == 4) {
            return True;
        } else {
            redirect('admin-dashboard', 'refresh');
        }
    }

    function send_email($to , $subject, $mailbody , $is_debug = 0 , $attachment = array() ,$attach_path = "uploads/mail_attachment/" , $str_attach = ""){
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
        // SMTP configuration
        if($is_debug == 1) { 
            $mail->SMTPDebug = 3;
        }
        $mail->isSMTP();
        $mail->Host     = 'mail.buildwebsite.co.in';
        
        $mail->SMTPAuth = true;
        $mail->Username = 'info@buildwebsite.co.in';
        $mail->Password = 'gpSOx)cIp^mR';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        /*$mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );*/
/**<table cellpadding="0" cellspacing="0" style="width: 100%; margin: 0px auto; background-color: #024D39;">
                    <tr>
                        <td>
                            <div style="width: 100%; float: left; padding: 10px 25px; box-sizing: border-box;">
                                <img src="" alt="" style="max-width: 125px;">
                            </div>
                        </td>
                    </tr>
                </table> */
        $body = '<table cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0px auto; font-family: 
        \'Poppins\' !important ;">
        <tr>
            <td>
                

                <table cellpadding="0" cellspacing="0" style="width: 100%;  margin: 0px auto;">
                    <tr>
                        <td>
                            <div style="width: 100%; float: left; padding: 20px 25px; background-color:#e0fff7; box-sizing: border-box;">
                                '.$mailbody.'
                                <p style="margin:25px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">Thanks  </p>
                                <p style="margin:25px 0px 0px; padding: 0px; font-size: 14px; color:#595858;">Agent Rate Team</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';    
		  
		  
          foreach($attachment as $row)
		  {
				$mail->addAttachment($attach_path.$row);
		  }// end if file attachment			
        			
        
        $mail->setFrom('info@buildwebsite.co.in', 'Agent Rate');
        $mail->addReplyTo('info@buildwebsite.co.in', 'Agent Rate');
        
        $to = explode(',',$to);
        // Add a recipient
        for($i=0;$i<count($to);$i++)
        {
            $mail->addAddress($to[$i]);
        }// end for
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $subject;//'Password for Boss Admin';
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $body;//$mailbody;
        
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            //echo 'Message has been sent';
        }
    }// end function send_email

}
