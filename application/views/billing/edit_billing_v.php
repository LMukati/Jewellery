<section class="dashbord stock_manage">
    <div class="container-fluid">
 	<div class="dashbord_main billing">
<!--search bar & entrys start here-->
 	<div class="row">
    <div class="col-md-12 col-sm-4">
      <div class="bili-heding">
       <h1>Billing(Entry)</h1>
      </div>
     </div>

    </div>
    <hr>
<!--search bar & entrys end here-->
<?php // echo "<pre>";print_r($bill_trans_info1);die;?>

      <form name="editBilling" method="post" action="<?php echo base_url('billing/update_billing')?>">
  <div class="form-row adstock">
    <div class="form-group col-md-3">
      <label for="">Customer Name</label>
      <input type="hidden" name="edit_id" value="<?php echo $billing_info['id'];?>">
      <input type="text" class="form-control" name="customer_name" value="<?php echo $billing_info['customer_name'];?>" id="" placeholder="Customer Name" required> 
    </div>
    <div class="form-group col-md-3 ">
      <label for="">Mo. No.</label>
      <input type="tel" class="form-control" maxlength="10" name="customer_mobile_no" value="<?php echo $billing_info['customer_mobile_no'];?>" id="" required placeholder="Mobile Number">
    </div>
      <div class="form-group col-md-3 ">
      <label for="">Address</label>
      <input type="text" class="form-control" name="customer_address" value="<?php echo $billing_info['customer_address'];?>" id="" required placeholder="Address">
    </div>
     <div class="form-group col-md-3 ">
      <label for="">date</label>
      <input type="date" class="form-control" name="billing_date" value="<?php echo $billing_info['billing_date'];?>" required  id="" placeholder="date.../.../...">
    </div>
  </div>


  


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
      <!-- <th scope="col">action</th> -->
    </tr>
  </thead>
  <tbody id="tbody_id">
  <?php
   $sno = 0;
   $cnt=1;
   foreach($bill_trans_info1 as $v_trans_info){
	   $sno++;
   ?>
    <tr id="tbody_id">
      <td scope="row"><?php echo $sno; ?></td>
      <td>
	  <input type="hidden" name="stock_id[]" id="stock_id<?php echo $cnt?>" value="<?php echo $v_trans_info['stock_id']?>">
	  <select name="item_name[]" id="item_name<?php echo $cnt?>"  class="form-control select2 required" id="size" placeholder="">
	   <option value="">Select Item</option>
		<?php 
		foreach($stock_info as $stock_info_v){
			$selected="";
			if($v_trans_info['stock_id'] == $stock_info_v['id']){
				$selected="selected";
			}
	 	?>
		  <option <?php echo $selected;?> value="<?php echo $stock_info_v['id']?>"><?php echo $stock_info_v['item_name']?></option>
		<?php
		}
		?>
	  </select>
	  </td>
    
	  <td><input type="text" name="g_weight[]" id="g_weight<?php echo $cnt; ?>" value="<?php echo $v_trans_info['g_weight'] ?>" class="form-control g_weight"  placeholder="G.WEIGHT" required></td>
      <td><input type="text" name="bags_qty[]" id="bags_qty<?php echo $cnt; ?>" value="<?php echo $v_trans_info['bags_qty'] ?>" class="form-control bags_qty"  placeholder="BAGS QTY" required></td>
      <td><input type="text" name="bags_weight[]" value="<?php echo $v_trans_info['bags_weight'] ?>" onkeyup="getvalues('<?php echo $cnt; ?>')" id="bags_weight<?php echo $cnt; ?>" class="form-control bags_weight"  placeholder="WT/BAG" required></td>
      <td><input type="text" name="total_bags_weight[]" value="<?php echo $v_trans_info['total_bags_weight'] ?>" id="total_bags_weight<?php echo $cnt; ?>" class="form-control total_bags_weight" value="0.00"  placeholder="TOTAL BAGS WT" required></td>
      <td><input type="text" name="net_weight[]" value="<?php echo $v_trans_info['net_weight'] ?>" id="net_weight<?php echo $cnt; ?>" value="0.00" class="form-control net_weight"  placeholder="NET WEIGHT" required></td>
      <td><input type="text" name="melting[]" value="<?php echo $v_trans_info['melting'] ?>" id="melting<?php echo $cnt; ?>"  class="form-control melting"  placeholder="Melting" required></td>
      <td> <input type="text" name="tunch[]"  value="<?php echo $v_trans_info['tunch'] ?>" id="tunch<?php echo $cnt; ?>" value="0.00"  class="form-control tunch" placeholder="Tunch" required></td>
      <td><input type="text" name="fine[]" value="<?php echo $v_trans_info['fine'] ?>" id="fine<?php echo $cnt; ?>" value="0.00" class="form-control fine"  placeholder="FINE" required></td>
     <td><input type="text" name="labour_pcs[]" value="<?php echo $v_trans_info['labour_pcs'] ?>" id="labour_pcs<?php echo $cnt; ?>" class="form-control labour_pcs"  placeholder="LABOUR/pcs"></td>
      <td><input type="text" name="labour_gm[]" value="<?php echo $v_trans_info['labour_gm'] ?>" id="labour_gm<?php echo $cnt; ?>" class="form-control labour_gm"  placeholder="LABOUR/gm"></td>
      <td><input type="text" name="amount[]" value="<?php echo $v_trans_info['lbr_amount'] ?>" id="amount<?php echo $cnt; ?>" value="0.00" class="form-control amount"  placeholder="AMOUNT" required></td>
      <!-- <td><?php //if($sno == count($bill_trans_info1)) { ?>
                     <a href="javascript:void(0);" class="btn btn-primary add">+</a>
                   <?php //} else { ?>
                     <a href="javascript:void(0);" class="btn btn-danger del">-</a>
                   <?php// } ?>
				   </td> -->
    </tr>
	<?php
	$cnt++;
     }
   ?>
    </tbody>
   


<!--billing table total counting area start here-->
<!--billing table total counting area start here-->
<!--billing table total counting area start here-->
    <tr>
      <th scope="row"></th>
      <td>totals</td>
      <td><input type="text" readonly="readonly"  class="form-control" name="table_total_g_weight1" id="table_total_g_weight1" value="<?php echo $billing_info['sub_total_g_wt'];?>"></td>
      
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_bags_qty1" id="table_total_bags_qty1" value="<?php echo $billing_info['sub_total_b_qty'];?>"></td>
      <td></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_bags_weight1" id="table_total_bags_weight1" value="<?php echo $billing_info['sub_total_b_wt'];?>"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_net_weight1" id="table_total_net_weight1" value="<?php echo $billing_info['sub_total_net_wt'];?>"></td>
      <td></td>
      <td></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_fine1" id="table_total_fine1" value="<?php echo number_format((float)$billing_info['sub_total_fine'], 2, '.', '');?>"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_labour_pcs1" id="table_total_labour_pcs1" value="<?php echo $billing_info['sub_total_labour_psc'];?>"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_labour_gm1" id="table_total_labour_gm1" value="<?php echo $billing_info['sub_total_labour_gm'];?>"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_amount1" id="table_total_amount1" value="<?php echo $billing_info['sub_total_labour_amount'];?>">
      
      <?php// if($billing_info['checked'] !="" ){?>
      <!-- <input type="checkbox"  name="labour_to_fine" id="labour_to_fine"  value="1" Checked> -->
        <?php //}else{?>
          <!-- <input type="checkbox"  name="labour_to_fine" id="labour_to_fine" onchange="valueChanged()" value="1"></td> -->

          <?php //} ?>
    </td>
     
    </tr>
<!--billing table total counting area end here-->
<!--billing table total counting area end here-->
<!--billing table total counting area end here-->

  
</table>
<!--table end here-->
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
          <td ><input type="text" class="form-control" name="rate_for_fine" id="rate_for_fine" value="<?php echo $billing_info['rate_for_fine']; ?>"></th>
          <td><input type="text" class="form-control lbr_total_amount12" name="labour_amount_for_fine" id="labour_amount_for_fine" readonly  value="<?php echo number_format((float)$billing_info['sub_total_labour_amount'], 2, '.', '');?>"></td>
          <td><input type="text" class="form-control" name="labour_to_fine" id="labour_to_fine" onchange="valueChanged()" value="<?php echo $billing_info['labour_to_fine']; ?>"></td>
        </tr>
      </tbody>
    </table>
<div class="coverd-tblbox">
    <!--received silver start here-->
    <div class="shorttable-left" style="margin-left: 18px;">
      
    <h1 class="zncsd">received silver</h1>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th scope="col">silver weight</th>
          <th scope="col">purity </th>
          <th scope="col">fine wt</th>
        </tr>
      </thead>
      <tbody>
      <?php
$sumdeposit=0;
foreach($payment as $v_payment){
$sumdeposit +=$v_payment['v_jewellery_rate_diposit'];
$sumfine +=$v_payment['v_fine_receive'];
$sumlbr += $v_payment['v_diposit_lbr_amount'];
$subtotalfine=$v_payment['v_sub_total_fine'];
}
?>
        <tr scope="row">
          <td ><input type="text" class="form-control" name="silver_receive" id="silver_receive" value="<?php echo number_format((float)$billing_info['silver_receive'], 2, '.', '');?>"></th>
          <td><input type="text" readonly class="form-control" name="purity" id="purity"  value="100"></td>
          <td><input type="text" class="form-control" name="fine_receive" id="fine_receive" value="<?php echo $sumfine; ?>"></td>
        </tr>
      </tbody>
    </table>
    </div>
</div>
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
      <th scope="row"><input type="text" readonly="readonly" class="form-control" name="fine_remain" id="fine_remain" placeholder="Remain Fine" value="<?php echo $billing_info['fine_remain'];?>"></th>
      <td><input type="text" class="form-control" name="jewellery_current_rate" id="current_rate" value="" placeholder="Rate"></td>
      <td><input type="text" class="form-control" readonly="readonly" name="jewellery_rate" id="jewellery_rate" value="0.00" placeholder="Jewellery Rate">
      
      </td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_amount1" id="lbr_total_amount12" value="<?php echo $billing_info['sub_total_labour_amount'];?>">
      </td>
    </tr>
      <tr>
      <td class="bord-left">add:cgst</td>
      <td class="bord-les1"></td>
      <td class="bord-les1"><input type="text" class="form-control" name="cgst" id="cgst" value="" placeholder="CGST IN %"></td>
      <td class="bord-les1"><input type="text" readonly="readonly" class="form-control" name="MPGSTvalue" id="MPGSTvalue" value="" placeholder="CGST IN %"></td>
      <td class="bord-right"></td>
    
    </tr>

     <tr>
      <td scope="row" class="bord-left">add:sgst</td>
      <td class="bord-les1"></td>
      <td class="bord-les1"><input type="text" class="form-control" name="sgst" id="sgst" value="" placeholder="SGST IN %"></td>
      <td class="bord-les1"><input type="text" readonly="readonly" class="form-control" name="MPSGSTvalue" id="MPSGSTvalue" value="" placeholder="SGST IN %"></td>
      <td class="bord-right"></td> 
    </tr>
<!-- 
         <tr>
      <td scope="row" class="bord-left"></td>
      <td class="bord-les1">less(-)</td>
      <td class="bord-les1"></td>
      <td class="bord-les1"></td>
      <td class="bord-right"></td>
   <td>0, complete</td> 
    </tr> -->
     <tr>
      <td scope="row" class="bord-les2">total :  </td>
      <td></td>
      <td class="bord-les3" colspan="3"><input type="text" readonly="readonly" class="form-control" name="grand_total" id="grand_total" value="" placeholder="Grand Total"></td>
     </tr>
     
    <tr>
      <td scope="row" class="bord-les2">Amount diposit:  </td>
     
      <td class="bord-les3"colspan="3"> <input type="text" class="form-control" name="jewellery_rate_diposit" id="jewellery_rate_diposit" value="" placeholder="Diposit Rate"> </td>
      <td class="bord-les3" ><input type="text" class="form-control" placeholder="Diposit LBR Amount" name="diposit_lbr_amount" id="diposit_lbr_amount" value=""></td>
      <!-- <td class="bord-les4"></td> -->
      
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
    <button type="submit" class="btn savbtn">save</button>
    </form>
     <!-- <button type="submit" class="btn savbtn green acontview">edit</button> -->
     <!-- <button type="submit" class="btn savbtn acontview">print</button> -->
     <!-- <button type="submit" class="btn savbtn green acontview">cancel</button> -->
</div>

 		</div>
 	</div>
 </section>