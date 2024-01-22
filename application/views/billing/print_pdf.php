<section class="dashbord stock_manage ">
    <div class="container-fluid" >
 	<div class="dashbord_main billing" id="doc">
<!--search bar & entrys start here-->
 	<div class="row">
          <div class="col-md-12 col-sm-4">
            <div class="bili-heding">
            <h1>Bill No.(<?php echo $bill_info['bill_no'];?>)</h1>
            </div>
          </div>

          </div>
          <hr>
      <!--search bar & entrys end here-->

      <?php //echo "<pre>"; print_r($bill_info);?>
            <form>
        <div class="form-row adstock">
          <div class="form-group col-md-3">
            <label for="">Customer Name</label>
            <label class="form-control" ><?php echo $bill_info['customer_name'];?></label>
          </div>
          <div class="form-group col-md-3 ">
            <label for="">Mo. No.</label>
            <label class="form-control" ><?php echo $bill_info['customer_mobile_no'];?></label>
          </div>
            <div class="form-group col-md-3 ">
            <label for="">Address</label>
            <label class="form-control" ><?php echo $bill_info['customer_address'];?></label>
          </div>
          <div class="form-group col-md-3 ">
            <label for="">date</label>
            <label class="form-control"><?php echo date("d-m-Y",strtotime($bill_info['billing_date']));?></label>
          </div>
        </div>

      </form>
        


      <!--table start here-->
      <table class="table table-responsive bil-table">
        <thead>
          <tr>
            <th scope="col">s.n</th>
            <th scope="col">Item name</th>
            <th scope="col">g.wt</th>
            <th scope="col">bags qty</th>
            <th scope="col">wt/bag </th>
            <th scope="col">total bags wt</th>
            <th scope="col">net wt</th>
            <th scope="col">MELTING</th>
            <th scope="col">tunch</th>
            <th scope="col">fine</th>
          <th scope="col">lbr/pcs</th>
            <th scope="col">lbr/gm</th>
            <th scope="col">lbr.amount</th>
            
          </tr>
        </thead>
        <tbody>
          <tr>
          <?php
        $sno = 0;
        $cnt=1;
        foreach($bill_info_trans_print as $v_trans_info){
          $sno++;
        ?>
          <tr id="tbody_id">
            <td scope="row"><?php echo $sno; ?></td>
            <td>
        <?php 
          foreach($stock_info as $stock_info_v){
            // $selected="";
            if($v_trans_info['stock_id'] == $stock_info_v['id']){
                      echo $stock_info_v['item_name'];
            }
              }
        ?>
        </td>
            <td><?php echo $v_trans_info['g_weight'] ?></td>
            <td><?php echo $v_trans_info['bags_qty'] ?></td>
            <td><?php echo $v_trans_info['bags_weight'] ?></td>
            <td><?php echo $v_trans_info['total_bags_weight'] ?></td>
            <td><?php echo $v_trans_info['net_weight'] ?></td>
            <td><?php echo $v_trans_info['melting'] ?></td>
            <td><?php echo $v_trans_info['tunch'] ?></td>
            <td><?php echo $v_trans_info['fine'] ?></td>
          <td><?php echo $v_trans_info['labour_pcs'] ?></td>
            <td><?php echo $v_trans_info['labour_gm'] ?></td>
            <td><?php echo $v_trans_info['lbr_amount'] ?></td>
            
          </tr>

          <?php }?>


      <!--billing table total counting area start here-->
      <!--billing table total counting area start here-->
      <!--billing table total counting area start here-->
          <tr>
            <th scope="row"></th>
            <td>totals</td>
            <td><?php echo $bill_info['sub_total_g_wt'];?></td>
            <td><?php echo $bill_info['sub_total_b_qty'];?></td>
            <td></td>
            <td><?php echo $bill_info['sub_total_b_wt'];?></td>
            <td><?php echo $bill_info['sub_total_net_wt'];?></td>
            <td></td>
            <td></td>
            <td><?php echo $bill_info['sub_total_fine'];?></td>
            <td><?php echo $bill_info['sub_total_labour_psc'];?></td>
            <td><?php echo $bill_info['sub_total_labour_gm'];?></td>
            <td><?php echo $bill_info['sub_total_labour_amount'];?></td>
        
          </tr>
      <!--billing table total counting area end here-->
      <!--billing table total counting area end here-->
      <!--billing table total counting area end here-->

        </tbody>
      </table>
      <!--table end here-->
      <?php
      $sumdeposit=0;
      foreach($payment as $v_payment){
      $sumdeposit +=$v_payment['jewellery_rate_diposit'];
      $sumfine +=$v_payment['fine_receive'];
      $sumlbr += $v_payment['diposit_lbr_amount'];
      }
      ?>
      <div class="coverd-tblbox">
      <!--received silver start here-->
      <div class="shorttable-left" style="margin-left: 18px;">
      <h1 class="zncsd" style="margin-right: 8px;margin-left: 0px;border-left: 1px solid #675a5a;">received silver</h1>
      <table class="table table-responsive">
        <thead>
          <tr>
            <th scope="col">silver weight silver</th>
            <th scope="col">purity </th>
            <th scope="col">fine wt</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php echo $bill_info['silver_receive'];?></th>
            <td><?php echo $bill_info['silver_purity'];?></td>
            <td><?php echo $sumfine;?></td>
          </tr>
        
        </tbody>
      </table>
      </div>
      <?php //echo "<pre>"; print_r($payment); ?>
      <!--received silver end here-->


      <!--received silver start here-->
      <div class="shorttable-right">
      <table class="table table-responsive">
        <thead>
          <tr>
            <th scope="col" class="bord-non1"> rate cut </th>
            <th scope="col"> fine</th>
            <th scope="col">rate </th>
            <th scope="col">amount</th>
            <th scope="col">lbr amount</th>
          <!--  <th scope="col">total balance</th> -->
          </tr>
        </thead>
        <tbody>
          <tr>
          
            <th scope="row" class="bord-non2">(fine)</th>
            <th scope="row"><?php echo $bill_info['silver_receive']-$sumfine;?></th>
            <td><?php echo $bill_info['jewellery_current_rate'];?></td>
            <td><?php echo $bill_info['jewellery_rate'];?></td>
            <td><?php echo $bill_info['sub_total_labour_amount'];?></td>
          </tr>
          <?php //echo "<pre>"; print_r($bill_info);?>
            <tr>
            <td class="bord-left">add:cgst</td>
            <td class="bord-les1"></td>
            <td class="bord-les1"><?php echo $bill_info['cgst_mp_per'];?>%</td>
            <td class="bord-les1"><?php echo $bill_info['cgst_mp_price'];?></td>
            <td class="bord-right"></td>
          
          </tr>

          <tr>
            <td scope="row" class="bord-left">add:sgst</td>
            <td class="bord-les1"></td>
            <td class="bord-les1"><?php echo $bill_info['sgst_mp_per'];?>%</td>
            <td class="bord-les1"><?php echo $bill_info['sgst_mp_price'];?></td>
            <td class="bord-right"></td> 
          </tr>

          <tr>
            <td scope="row" class="bord-les2">grand total: </td>
            <td><?php echo $bill_info['sub_total_fine'];?></td>
            <td></td>
            <td><?php echo $bill_info['grand_total'];?></td>
            <td></td>
          </tr>
          <tr>
            <td scope="row" class="bord-left">diposit</td>
            <td class="bord-les1"><?php echo $sumfine;?></td>
            <td class="bord-les1"></td>
            <td class="bord-les1"><?php echo $sumdeposit;?></td>
            <td class="bord-right"><?php echo $sumlbr;?></td> 
          </tr>
          <tr>
            <td scope="row" class="bord-left">udhar</td>
            <?php if(isset($bill_info['sub_total_fine']) && $bill_info['sub_total_fine'] != null)
                
            {
              $total_fine=$bill_info['sub_total_fine'];
              $remian_fine=$sumfine;
              $get_amt=$total_fine-$remian_fine;
              if($get_amt != 0){
          ?>
            <td class="bord-les3"><?php echo $get_amt;?>, udhar</td>
            <?php }
              else{ ?>
              <td class="bord-les3">0, complete</td>
              <?php }
          }  ?>
            
            <td class="bord-les3"></td>
            <?php if(isset($bill_info['grand_total']) && $bill_info['grand_total'] != null)
                
                {
                  $total_grand=$bill_info['grand_total'];
                  $diposit_jewellery=$sumdeposit;
                  $get_jewellery=$total_grand-$diposit_jewellery;
                  if($get_jewellery != 0){
                ?>
                <td class="bord-les3"><?php echo $get_jewellery;?>, udhar</td>
                <?php }
                  else{ ?>
                  <td class="bord-les3">0, complete</td>
                  <?php }
              }  ?>
            <?php if(isset($bill_info['sub_total_labour_amount']) && $bill_info['sub_total_labour_amount'] != null)
                
                {//echo $sumdeposit."<br>".$sumfine.'<br>'.$sumlbr;
                  $total_LBR=$bill_info['sub_total_labour_amount'];
                  $diposit_LBR=$sumlbr;
                  $get_LBR=$total_LBR-$diposit_LBR;
                  if($get_LBR != 0){
                ?>
                <td class="bord-les3"><?php echo $get_LBR;?>, udhar</td>
                <?php }
                  else{ ?>
                  <td class="bord-les3">0, complete</td>
                  <?php }
              }  ?>
          </tr>
        </tbody>
      </table>
</div>
<!--received silver end here-->


<div class="bank-detail">
<table class="table table-responsive">
   <thead>
    <tr>
      <th scope="col">
            hdfc bank a/c : 50200012094785 | ifsc-hdfc: 0002143
          </th>
     
    </tr>
  </thead>
</table>
</div>

</div>

<div class="butn-boxs">
    
     <button type="submit" class="btn savbtn green print">print</button>
   <form method="post" action="<?php echo base_url('mpdf/my_mPDF')?>"> 
     <button type="submit" class="btn savbtn green" onclick="//printDiv();">share</button>
  </form>
     <form>
</div>
 		</div>
 	</div>
 </section>