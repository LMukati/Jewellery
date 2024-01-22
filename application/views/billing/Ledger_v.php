<section class="dashbord stock_manage">
    <div class="container-fluid" style="background-color: white;">
 	    <div class="dashbord_main">
         <div class="row">
          <div class="col-md-12 col-sm-4">
            <div class="bili-heding">
            
            <h1 class="left">Bill No.(<?php echo $payment_info[0]['bill_no'];?>)</h1>
            </div>
          </div>

          </div>
          <hr>
           <form name="deposit" method="post" action="<?php echo base_url('billing/savedeposit/')?>">
          <div class="row">
         
           
              <div class="md-form mb-1 col-sm-3">
              <input type="hidden" name="bill_id" value="<?php echo  $payment_info[0]['bill_id']?>">
              <input type="hidden" name="grand_total" value="<?php echo $payment_info[0]['grand_total']?>">
              <input type="hidden" name="sub_total_fine" value="<?php echo $payment_info[0]['sub_total_fine']?>">
              <input type="hidden" name="sub_total_labour_amount" value="<?php echo $payment_info[0]['sub_total_labour_amount']?>">
              <input type="hidden" name="fine_remain" value="<?php echo $fbalance?>">

                  <input type="text" id="defaultForm"  name="jewellery_rate_diposit" placeholder="Rate Diposit" class="form-control">
                  </div>

                  <div class="md-form mb-1 col-sm-3">
                    <input type="text" id="defaultForm"  name="diposit_lbr_amount" placeholder="LBR Diposit" class="form-control">
                  </div>

                  <div class="md-form mb-1 col-sm-3">
                    <input type="text" id="defaultForm" name="fine_receive" placeholder="Fine Diposit" class="form-control">

                  </div>
                   <div class="mb-1 col-sm-3">
                    <button type="submit" class="btn savbtn">Save changes</button>
                  </div>

            
          
		  </div>
  </form>

 <hr>

    <table id="example" class="table table-responsive ">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Date</th>
                    <th scope="col">Rate Total</th>
                    <th scope="col">Rate Diposit</th>
                    <th scope="col">Rate Balance</th>
                    <th scope="col">Fine Total</th>
                    <th scope="col">Fine Diposit</th>
                    <th scope="col">Fine Balance</th>
                    <th scope="col">LBR Total</th>
                    <th scope="col">LBR Diposit</th>
                    <th scope="col">LBR Balance</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
            $sumdeposit=0;
                $sumfine=0;
                $sumlbr=0;
                $i=0;
                foreach($payment_info as $v_payment){
                  $i++;
                 // print_r($v_payment);
                  $sumdeposit +=$v_payment['v_jewellery_rate_diposit'];
                  $sumfine +=$v_payment['v_fine_receive'];
                  $sumlbr += $v_payment['v_diposit_lbr_amount'];
                  //echo $sumfine;
                      ?>
                <tr>
                    <td scope="col"><?php echo $i?></td>
                    <td scope="col"> <?php
                    echo date('d-m-Y',strtotime($v_payment['v_deposit_date']));
                    ?></td>
                    <td scope="col"><?php echo $v_payment['v_grand_total']?></td>
                    <td scope="col"><?php echo $v_payment['v_jewellery_rate_diposit']?></td>
                    <td scope="col"><?php  
                      if($v_payment['v_grand_total'] !=''){
                        $balance=$v_payment['v_grand_total']-$sumdeposit;
                    echo number_format((float)$balance, 2, '.', '');
                      }
                  ?></td>
                    <td ><?php echo number_format((float)$v_payment['v_sub_total_fine'], 2, '.', '');?></td>
                    <td scope="col"><?php echo $v_payment['v_fine_receive']?></td>
                    <td scope="col"><?php  
                      if($v_payment['v_sub_total_fine'] !=''){
                        //echo $sumfine;
                        $fbalance=number_format((float)$v_payment['v_sub_total_fine'], 2, '.', '')-$sumfine;
                    echo number_format((float)$fbalance, 2, '.', '');
                      }
                  ?></td>
                    <td scope="col"><?php echo $v_payment['v_sub_total_labour_amount']?></td>
                    <td scope="col"><?php  $lbrbalance=$v_payment['v_diposit_lbr_amount'];
                    echo number_format((float)$lbrbalance, 2, '.', '');
                    ?></td>
                    <td scope="col"><?php  
                      if($v_payment['v_sub_total_labour_amount'] !=''){
                        $lbrbalance=$v_payment['v_sub_total_labour_amount']-$sumlbr;
                    echo number_format((float)$lbrbalance, 2, '.', '');
                      }
                  ?></td>
                </tr>
                <?php } ?>

            </tbody>
          </table>
          </div>
         

        </div>
    </div>
</section>