<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//use \mpdf\mpdf;
class Mypdf extends CI_Controller {

    function __construct() { parent::__construct(); // add library of Pdf 
       // $this->load->library('Pdf');
      // $this->user_login_authentication();
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');
      $this->load->model('billing_model', 'bill_mdl');	  
      $this->load->model('stock_model', 'stk_mdl');
}
    public function index()
    {
        $mpdf = new \Mpdf\Mpdf();
        
        $data['stock_info'] = $this->stk_mdl->stock_info();
		$data['bill_info_trans_print'] = $this->bill_mdl->billing_trans($_GET['id']);
		$data['bill_info'] = $this->bill_mdl->get_billing_by_id($_GET['id']);
       $bill_no= $this->bill_mdl->get_billing_by_id($_GET['id']);
		$data['payment'] = $this->bill_mdl->getpaymentlist($_GET['id']);
        //$data['id']=$bill_info['bill_no'];
        $bill="bill-".$bill_no['bill_no'];
       //echo"<pre>";print_r($data['payment']);die;
        $html = $this->load->view('html_to_pdf',$data,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output($bill.'.pdf','D'); // opens in browser
        //$mpdf->Output('invoice.pdf','Dt will work as normal download
    }
    public function pdf2()
    {
        $mpdf = new \Mpdf\Mpdf();
        
        $data['stock_info'] = $this->stk_mdl->stock_info();
		$data['bill_info_trans_print'] = $this->bill_mdl->billing_trans($_GET['id']);
		$data['bill_info'] = $this->bill_mdl->get_billing_by_id($_GET['id']);
       $bill_no= $this->bill_mdl->get_billing_by_id($_GET['id']);
		$data['payment'] = $this->bill_mdl->getpaymentlist($_GET['id']);
        //$data['id']=$bill_info['bill_no'];
        $bill="bill-".$bill_no['bill_no'];
       //echo"<pre>";print_r($data['payment']);die;
        $html = $this->load->view('html_to_pdf2',$data,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output($bill.'.pdf','D'); // opens in browser
        //$mpdf->Output('invoice.pdf','Dt will work as normal download
    }

        
  
}