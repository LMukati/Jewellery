<style>
.complete{
  background-color: #fde66d;
}
.modal-body {
  /* position:fixed; */
}

</style>
<section class="dashbord stock_manage">
    <div class="container-fluid">
 	<div class="dashbord_main">
<!--search bar & entrys start here-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form>
        
                    <div class="btns-file">
                    <button type="button" class="btn file-btn acontview"><a href="<?php echo base_url('billing/exportCSV')?>">csv</a></button>
                </div>
            </form>
        </div>
    </div>
<!--search bar & entrys end here-->
<?php //echo "<pre>";print_r($billing_info);?> 
<!--table start here-->
<table id="example" class="table table-responsive ">
  <thead>
   
    <tr>
      <th scope="col">s.n</th>
	  <th scope="col">Bill No.</th>
      <th scope="col">Customer Name</th>
      <th scope="col">Mobile NO</th>
      <th scope="col">Address</th>
      <th scope="col">Bill Date</th>
      <th scope="col" >Profit</th>
      <th scope="col">Total Fine</th> 
      <th scope="col">Fine Receive</th> 
      <th scope="col">Fine Remain</th>   
      <th scope="col">Fine Rate</th>
      <th scope="col">Jewellery rate</th>
      <th scope="col">Rate Diposot</th>
      <th scope="col">LBR amount</th>
      <th scope="col">LBR Diposit</th>
	    <th scope="col">CGST-MP</th>
      <th scope="col">SGST-MP</th>
      <th scope="col">Grand Total</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
  <?php
  // foreach($v_billing_info as $v_payment){
  //   $sumdeposit1 +=$v_payment['d_jewellery_rate'];
  //   $sumfine1 +=$v_payment['recive_fine'];
  //   $sumlbr1 += $v_payment['d_lbr'];
  //  }
  $b=1;
  
  foreach($billing_info as $v_billing_info)
  {
    $CI =& get_instance();
    $gettrans=$CI->gettranslist($v_billing_info['bill_id']) ;
    $profit=0;
    foreach($gettrans as $v_gettrans){
   
    $profit +=$v_gettrans['profit'];
    }
  ?>
    <tr class="rocolor1">
       
      <th scope="row"><?php echo $b;?></th>
	    <td><?php echo $v_billing_info['bill_no']?></td>
      <td><?php echo $v_billing_info['customer_name']?></td>
      <td><?php echo $v_billing_info['customer_mobile_no']?></td>
      <td><?php echo $v_billing_info['customer_address']?></td>
	    <td><?php echo $v_billing_info['billing_date']?></td>
      <td style="background-color: #2ba246;"><?php echo $profit?></td>
      <?php //if($v_billing_info['fine_remain'] != ""){ ?>
      <td><?php echo number_format((float)$v_billing_info['silver_receive'], 2, '.', '');?></td>
      
      <td><?php echo $v_billing_info['fine_receive']?></td>
      <?php
        $completed1=number_format((float)$v_billing_info['silver_receive'], 2, '.', '')-$v_billing_info['fine_receive'];
  
   if($completed1 == 0 ){ ?>
      <td class="complete">
        <?php 
        echo number_format((float)$v_billing_info['silver_receive'], 2, '.', '')-$v_billing_info['fine_receive']?></td>
  <?php  }else{ ?>
    <td><?php echo number_format((float)$v_billing_info['silver_receive'], 2, '.', '')-$v_billing_info['fine_receive']?></td>
    <?php } ?>
      <td><?php echo $v_billing_info['jewellery_current_rate']?></td>
      <td><?php echo $v_billing_info['jewellery_rate']?></td>
      <?php
       $completed2=number_format((float)$v_billing_info['grand_total'], 2, '.', '')-$v_billing_info['jewellery_rate_diposit'];
       if($completed2 == 0 ){
      ?>
      <td class="complete"><?php echo $v_billing_info['jewellery_rate_diposit']?></td>
      <?php }else{?>
        <td ><?php echo $v_billing_info['jewellery_rate_diposit']?></td>
        <?php } ?>

      <td><?php echo $v_billing_info['sub_total_labour_amount']?></td>
      <?php 
      if($v_billing_info['checked'] !=""){?>
      <td class="complete"><?php echo $v_billing_info['diposit_lbr_amount']?></td>
      <?php } else{
      $completed3=number_format((float)$v_billing_info['sub_total_labour_amount'], 2, '.', '')-$v_billing_info['diposit_lbr_amount'];
      if($completed3 == 0){ ?>
      <td class="complete"><?php echo $v_billing_info['diposit_lbr_amount']?></td>
      <?php }else{ ?> 
      <td><?php echo $v_billing_info['diposit_lbr_amount']?></td>
     <?php }}
      ?>
      
      <td><?php echo $v_billing_info['cgst_mp_price']?></td>
      <td><?php echo $v_billing_info['sgst_mp_price']?></td>
      <td><?php echo $v_billing_info['grand_total']?></td>
      <?php // } ?>
      <td class="responsvv">
          <button type="submit" class="btn btn-primary acontview"><a href="<?php echo base_url('billing/edit_billing?id='.$v_billing_info['bill_id'])?>">Edit</a></button>
          <button type="submit" class="btn btn-primary"><a href="<?php echo base_url('billing/printbill/'.$v_billing_info['bill_id'])?>">Print Tax</a></button>
          <button type="submit" class="btn btn-primary acontview"><a href="<?php echo base_url('billing/printbill2/'.$v_billing_info['bill_id'])?>">Print</a></button>
          <button type="submit" class="btn btn-primary "><a href="<?php echo base_url('billing/getledgerlist/'.$v_billing_info['bill_id'])?>" target="_blank">Ledger</a></button>
          <button type="submit" class="btn btn-primary acontview"><a href="#delbill<?php echo $v_billing_info['bill_id']?>" class="trigger-btn" data-toggle="modal">Delete</a></button>
      </td>
  </tr>
	
	<!--Delete Model Box--->
	<div id="delbill<?php echo $v_billing_info['bill_id']?>" class="modal fade" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="icon-remove"></i> 
				</div>						
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete these Bill?.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger"><a href="<?php echo base_url('billing/remove_billing/'.$v_billing_info['bill_id'])?>">Delete</a></button>
			</div>
		</div>
	</div>
</div>
<!--Delete Model Box--->

	
	
  <?php $b++;} ?>

  </tbody>
</table>

<!--table end here-->

 		</div>
 	</div>
 </section>