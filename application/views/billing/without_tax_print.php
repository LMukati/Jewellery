<section class="dashbord stock_manage ">
    <div class="container-fluid" >
 	<div class="dashbord_main billing" id="doc">
<!--search bar & entrys start here-->
    <div class="row">

                 <div class="col-md-3 col-sm-4">
       <div class="bili-heding logo">
              <img src="<?php echo base_url('assets/image/logo3.png')?>"  alt="logo" class="img-fluid">
      </div>
     </div>
    <div class="col-md-6 col-sm-4">
      <div class="bili-heding">
       <h1>Sales Estimate</h1>
      </div>
     </div>
  
    <div class="col-md-3 col-sm-4">
      <div class="bili-heding">
      <span>Ritesh soni: (+91) 940-682-1163</span>
      <span>address:1/2 shripal marg, lakherwadi ujjain, (m.p)</span>
      </div>
     </div>

          <table align="center" style="border: 0px solid black;" style="width:100%;">
            <tr style="border: 0px solid black;">
              <td align="center" style="border: 0px solid black; background-color: #303030;">
             

              </td>
            </tr>
          </table>
    </div>
    <hr>
 
      <!--entrys end here-->
      
<div class="row">
  <div class="col-md-12">
    <div class="detail-left">
      <p>CUSTOMER NAME: <?php  echo $bill_info['customer_name'];?></p>
      <p>MO.NO. <?php echo $bill_info['customer_mobile_no'];?></p>
      <p>ADDRESS. <?php echo $bill_info['customer_address'];?></p>
    </div>
     <div class="detail-left right">
      <p>DATE: <?php echo date('d-m-Y',strtotime($bill_info['billing_date']));?></p>
      <p>BILL NO.<?php echo $bill_info['bill_no'];?></p>
    </div>
  </div>
  </div>
  <hr>
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
            <td><?php //echo $bill_info['sub_total_net_wt'];
            $sub_fine= $bill_info['sub_total_net_wt']; 
            echo number_format((float)$sub_fine, 2, '.', '');?></td>
            <td></td>
            <td></td>
            <td><?php //echo $bill_info['sub_total_fine'];
            $sub_fine= $bill_info['sub_total_fine']; 
            echo number_format((float)$sub_fine, 2, '.', '');?></td>
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
      <?php if(isset($bill_info['checked']) !="" && $bill_info['checked'] !=NULL){ ?>
      <table class="table table-responsive Labour">
      <thead>
        <tr><th colspan="3">Convert Labour To Fine</th></tr>
        <tr>
          <th scope="col">Rate</th>
          <th scope="col">Labour </th>
          <th scope="col">fine</th>
        </tr>
      </thead>
      <tbody>
        <tr scope="row">
          <td ><?php echo $bill_info['rate_for_fine']; ?></th>
          <td><?php echo number_format((float)$bill_info['sub_total_fine'], 2, '.', '');?></td>
          <td><?php echo $bill_info['labour_to_fine']; ?></td>
        </tr>
      </tbody>
    </table>
    <?php } ?>
      <?php
      $sumdeposit=0;
      foreach($payment as $v_payment){
      $sumdeposit +=$v_payment['v_jewellery_rate_diposit'];
      $sumfine +=$v_payment['v_fine_receive'];
      $sumlbr += $v_payment['v_diposit_lbr_amount'];
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
            <th scope="row"><?php //echo $bill_info['silver_receive'];
            $sub_fine= $bill_info['silver_receive']; 
            echo number_format((float)$sub_fine, 2, '.', '');?></th>
            <td><?php echo $bill_info['silver_purity'];?></td>
            <td><?php echo $sumfine;?></td>
          </tr>
        
        </tbody>
      </table>
      </div>
      <?php //echo "<pre>"; print_r($payment); ?>
      <!--received silver end here-->


      <!--received silver start here-->
      <div class="shorttable-right" style="padding: 0px 48px 0px 49px;">
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
            <th scope="row"><?php echo  number_format((float)$bill_info['silver_receive'], 2, '.', '')-$sumfine;?></th>
            <td><?php echo $bill_info['jewellery_current_rate'];?></td>
            <td><?php echo $bill_info['jewellery_rate'];?></td>
            <td><?php echo $bill_info['sub_total_labour_amount'];?></td>
          </tr>
          <?php //echo "<pre>"; print_r($bill_info);?>
            

          <tr>
            <td scope="row" class="bord-les2">grand total: </td>
            <td><?php $sub_fine= $bill_info['silver_receive']; 
             echo number_format((float)$sub_fine, 2, '.', '');?></td>
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

            <?php if($bill_info['jewellery_rate'] ==""){
              
              if(isset($bill_info['silver_receive']) && $bill_info['silver_receive'] != 'null' || $bill_info['silver_receive'] != "" )
                
            {
              $total_fine=number_format((float)$bill_info['silver_receive'], 2, '.', '');
              $remian_fine=$sumfine;
              $get_amt=$total_fine-$remian_fine;
              if($get_amt != 0){
          ?>
            <td class="bord-les3"><?php echo $get_amt;?>, udhar</td>
            <?php }
              else{ ?>
              <td class="bord-les3">0, complete</td>
              <?php }
              }else{?><td class="bord-les3">0, complete</td><?php }}else { ?> <td class="bord-les3">0, complete</td> <?php } ?>
            
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
              }else{?><td class="bord-les3">0, complete</td><?php }  ?>
            <?php if($bill_info['checked'] == ""){ if(isset($bill_info['sub_total_labour_amount']) && $bill_info['sub_total_labour_amount'] != "")
                
                {//echo $sumdeposit."<br>".$sumfine.'<br>'.$sumlbr;
                  $total_LBR=$bill_info['sub_total_labour_amount'];
                  $diposit_LBR=$sumlbr;
                  
                  $get_LBR=$total_LBR-$diposit_LBR;
                 
                  if($get_LBR != 0){
                    //echo $get_LBR;die;
                ?>
                <td class="bord-les3"><?php echo $get_LBR;?>, udhar</td>
                <?php }
                  else{ ?>
                  <td class="bord-les3">0, complete</td>
                  <?php }
              }else{?><td class="bord-les3">0, complete</td><?php } }else{?> 
              <td class="bord-les3">0, complete</td>
              <?php } ?>
          </tr>
        </tbody>
      </table>
</div>
<!--received silver end here-->


</div>


<div class="butn-boxs">
<hr>

     <button type="button" onclick="print_bill()" class="btn savbtn green print">print</button>
 
     <button type="submit" class="btn savbtn green acontview"><a href="<?php echo base_url('Mypdf?id='.$bill_info['id'])?>">share</a></button>
 
     <form>
</div>
 		</div>
     
 	</div>
 </section>