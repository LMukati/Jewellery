
<section  class="dashbord stock_manage">
    <div class="container-fluid">
 	    <div class="dashbord_main billing">
       <div class="form-row adstock">
        <div class="form-group col-md-3 col-sm-6">
          <label for="">Select Bill:-</label>
         <select id="ddlPassport" class="form-control select2">
            <option value="">--Select Bill--</option>
              <option value="Gst">Gst Bil</option>
              <option value="Plain">Kachha Bil</option>
         </select>
         <div>
        <div>
      <div>
        <div>
</section>
<section id="dvPassport" style="display: none" class="dashbord stock_manage">
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


      <form name="addBilling" method="post" action="<?php echo base_url('billing/create_billing')?>">
  <div class="form-row adstock">
    <div class="form-group col-md-3 col-sm-6">
      <label for="">Customer Name</label>
      <input type="text" class="form-control" name="customer_name" id="" placeholder="Customer Name" required> 
    </div>
    <div class="form-group col-md-3 col-sm-6">
      <label for="">Mo. No.</label>
      <input type="tel" class="form-control" maxlength="10" name="customer_mobile_no" id="" required placeholder="Mobile Number">
    </div>
      <div class="form-group col-md-3 col-sm-6">
      <label for="">Address</label>
      <input type="text" class="form-control" name="customer_address" id="" required placeholder="Address">
    </div>
     <div class="form-group col-md-3 col-sm-6">
      <label for="">date</label>
      <input type="date" class="form-control" name="billing_date" required  id="" placeholder="date.../.../...">
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
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody id="tbody_id">
    <tr id="tbody_id">
      <th scope="row">1</th>
      <td> <input type="hidden" name="stock_id[]" id="stock_id1" value="">
            <select name="item_name[]" id="item_name0"  class="form-control select2 required" id="size" placeholder="">
            <option value="">Select Item</option>
            <?php 
            foreach($stock_info as $stock_info_v){
            ?>
              <option value="<?php echo $stock_info_v['id'];?>"><?php echo $stock_info_v['item_name'];?></option>
            <?php
            }
            ?>
            </select>
      </td>

      <td><input type="text" name="g_weight[]" id="g_weight1" class="form-control g_weight"  placeholder="G.WEIGHT" required></td>
      <td><input type="text" name="bags_qty[]" id="bags_qty1" class="form-control bags_qty"  placeholder="BAGS QTY" required></td>
      <td><input type="text" name="bags_weight[]" id="bags_weight1" class="form-control bags_weight"  placeholder="WT/BAG" required></td>
      <td><input type="text" name="total_bags_weight[]" id="total_bags_weight1" class="form-control total_bags_weight" value="0.00"  placeholder="TOTAL BAGS WT" required></td>
      <td><input type="text" name="net_weight[]" id="net_weight1" value="0.00" class="form-control net_weight"  placeholder="NET WEIGHT" required></td>
      <td><input type="text" name="melting[]" id="melting1"  class="form-control melting"  placeholder="Melting" required></td>
      <td> <input type="text" name="tunch[]" id="tunch1" value="0.00"  class="form-control tunch" placeholder="Tunch" required></td>
      <td><input type="text" name="fine[]" id="fine1" value="0.00" class="form-control fine"  placeholder="FINE" required></td>
     <td><input type="text" name="labour_pcs[]" id="labour_pcs1" class="form-control labour_pcs"  placeholder="LABOUR/pcs"></td>
      <td><input type="text" name="labour_gm[]" id="labour_gm1" class="form-control labour_gm"  placeholder="LABOUR/gm"></td>
      <td><input type="text" name="amount[]" id="amount1" value="0.00" class="form-control amount"  placeholder="AMOUNT" required></td>
       <td><a href="javascript:void(0);" class="btn btn-primary add">+</a></td>
    </tr>
    </tbody>



    <!--billing table total counting area start here-->
    <!--billing table total counting area start here-->
    <!--billing table total counting area start here-->
    <tr>
      <th scope="row"></th>
      <td>totals</td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_g_weight1" id="table_total_g_weight1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_bags_qty1" id="table_total_bags_qty1" value="0.00"></td>
      <td></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_bags_weight1" id="table_total_bags_weight1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_net_weight1" id="table_total_net_weight1" value="0.00"></td>
      <td></td>
      <td></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_fine1" id="table_total_fine1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_labour_pcs1" id="table_total_labour_pcs1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_labour_gm1" id="table_total_labour_gm1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_amount1" id="table_total_amount1" value="0.00">
      TO FINE: <input type="checkbox" class="open_div"  name="convert_lbr_to_fine" id="convert_lbr_to_fine" value="1" onchange="valueChanged()">
      </td>
      <td></td>
    </tr>
    <!--billing table total counting area end here-->
    <!--billing table total counting area end here-->
    <!--billing table total counting area end here-->

  
</table>
<!--table end here-->

    <table class="table table-responsive Labour" style="display:none;">
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
          <td ><input type="text" class="form-control" name="rate_for_fine" id="rate_for_fine" value=""></th>
          <td><input type="text" class="form-control lbr_total_amount12" name="labour_amount_for_fine" id="labour_amount_for_fine" readonly  value=""></td>
          <td><input type="text" class="form-control" name="labour_to_fine" id="labour_to_fine" onchange="valueChanged()" value="0.00"></td>
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
        <tr scope="row">
          <td ><input type="text" class="form-control" name="silver_receive" id="silver_receive" value="0.00"></th>
          <td><input type="text" class="form-control" name="purity" id="purity" readonly  value="100"></td>
          <td><input type="text" class="form-control" name="fine_receive" id="fine_receive" value="0.00"></td>
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
      <th scope="row"><input type="text" readonly="readonly" class="form-control" name="fine_remain" id="fine_remain" placeholder="Remain Fine" value=""></th>
      <td><input type="text" class="form-control" name="jewellery_current_rate" id="current_rate" value="" placeholder="Rate"></td>
      <td><input type="text" class="form-control" readonly="readonly" name="jewellery_rate" id="jewellery_rate" value="0.00" placeholder="Jewellery Rate">
      
      </td>
      <td><input type="text" readonly="readonly" class="form-control lbr_total_amount12" name="table_total_amount1" id="" value="0.00">
      </td>
    </tr>
      <tr>
      <td class="bord-left"></td>
      <td class="bord-les1">add:cgst</td>
      <td class="bord-les1"><input type="text" class="form-control" name="cgst" id="cgst" value="" placeholder="CGST IN %"></td>
      <td class="bord-les1"><input type="text" readonly="readonly" class="form-control" name="MPGSTvalue" id="MPGSTvalue" value="" placeholder="CGST IN %"></td>
      <td class="bord-right"></td>
    
    </tr>

     <tr>
      <td scope="row" class="bord-left"></td>
      <td class="bord-les1">add:sgst</td>
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
      <td scope="row" class="bord-les2">grand total :  </td>
      <td class="bord-les3" colspan="4"><input type="text" readonly="readonly" class="form-control" name="grand_total" id="grand_total" value="" placeholder="Grand Total"></td>
      
      
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
 
<section id="dvPassport1" style="display: none" class="dashbord stock_manage">
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


      <form name="addBilling" method="post" action="<?php echo base_url('billing/create_billing')?>">
  <div class="form-row adstock">
    <div class="form-group col-md-3 col-sm-6">
      <label for="">Customer Name</label>
      <input type="text" class="form-control" name="customer_name" id="" placeholder="Customer Name" required> 
    </div>
    <div class="form-group col-md-3 col-sm-6">
      <label for="">Mo. No.</label>
      <input type="tel" class="form-control" maxlength="10" name="customer_mobile_no" id="" required placeholder="Mobile Number">
    </div>
      <div class="form-group col-md-3 col-sm-6">
      <label for="">Address</label>
      <input type="text" class="form-control" name="customer_address" id="" required placeholder="Address">
    </div>
     <div class="form-group col-md-3 col-sm-6">
      <label for="">date</label>
      <input type="date" class="form-control" name="billing_date" required  id="" placeholder="date.../.../...">
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
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody id="tbody_id">
    <tr id="tbody_id">
      <th scope="row">1</th>
      <td> <input type="hidden" name="stock_id[]" id="stock_id1" value="">
            <select name="item_name[]" id="item_name0"  class="form-control select2 required" id="size" placeholder="">
            <option value="">Select Item</option>
            <?php 
            foreach($stock_info as $stock_info_v){
            ?>
              <option value="<?php echo $stock_info_v['id'];?>"><?php echo $stock_info_v['item_name'];?></option>
            <?php
            }
            ?>
            </select>
      </td>

      <td><input type="text" name="g_weight[]" id="g_weight1" class="form-control g_weight"  placeholder="G.WEIGHT" required></td>
      <td><input type="text" name="bags_qty[]" id="bags_qty1" class="form-control bags_qty"  placeholder="BAGS QTY" required></td>
      <td><input type="text" name="bags_weight[]" id="bags_weight1" class="form-control bags_weight"  placeholder="WT/BAG" required></td>
      <td><input type="text" name="total_bags_weight[]" id="total_bags_weight1" class="form-control total_bags_weight" value="0.00"  placeholder="TOTAL BAGS WT" required></td>
      <td><input type="text" name="net_weight[]" id="net_weight1" value="0.00" class="form-control net_weight"  placeholder="NET WEIGHT" required></td>
      <td><input type="text" name="melting[]" id="melting1"  class="form-control melting"  placeholder="Melting" required></td>
      <td> <input type="text" name="tunch[]" id="tunch1" value="0.00"  class="form-control tunch" placeholder="Tunch" required></td>
      <td><input type="text" name="fine[]" id="fine1" value="0.00" class="form-control fine"  placeholder="FINE" required></td>
     <td><input type="text" name="labour_pcs[]" id="labour_pcs1" class="form-control labour_pcs"  placeholder="LABOUR/pcs"></td>
      <td><input type="text" name="labour_gm[]" id="labour_gm1" class="form-control labour_gm"  placeholder="LABOUR/gm"></td>
      <td><input type="text" name="amount[]" id="amount1" value="0.00" class="form-control amount"  placeholder="AMOUNT" required></td>
       <td><a href="javascript:void(0);" class="btn btn-primary add">+</a></td>
    </tr>
    </tbody>



    <!--billing table total counting area start here-->
    <!--billing table total counting area start here-->
    <!--billing table total counting area start here-->
    <tr>
      <th scope="row"></th>
      <td>totals</td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_g_weight1" id="table_total_g_weight1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_bags_qty1" id="table_total_bags_qty1" value="0.00"></td>
      <td></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_bags_weight1" id="table_total_bags_weight1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_net_weight1" id="table_total_net_weight1" value="0.00"></td>
      <td></td>
      <td></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_fine1" id="table_total_fine1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_labour_pcs1" id="table_total_labour_pcs1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_labour_gm1" id="table_total_labour_gm1" value="0.00"></td>
      <td><input type="text" readonly="readonly" class="form-control" name="table_total_amount1" id="table_total_amount1" value="0.00">
      TO FINE: <input type="checkbox" class="open_div"  name="convert_lbr_to_fine" id="convert_lbr_to_fine" value="1" onchange="valueChanged()">
      </td>
      <td></td>
    </tr>
    <!--billing table total counting area end here-->
    <!--billing table total counting area end here-->
    <!--billing table total counting area end here-->

  
</table>
<!--table end here-->

    <table class="table table-responsive Labour" style="display:none;">
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
          <td ><input type="text" class="form-control" name="rate_for_fine" id="rate_for_fine" value=""></th>
          <td><input type="text" class="form-control lbr_total_amount12" name="labour_amount_for_fine" id="labour_amount_for_fine" readonly  value=""></td>
          <td><input type="text" class="form-control" name="labour_to_fine" id="labour_to_fine" onchange="valueChanged()" value="0.00"></td>
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
        <tr scope="row">
          <td ><input type="text" class="form-control" name="silver_receive" id="silver_receive" value="0.00"></th>
          <td><input type="text" class="form-control" name="purity" id="purity" readonly  value="100"></td>
          <td><input type="text" class="form-control" name="fine_receive" id="fine_receive" value="0.00"></td>
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
      <th scope="row"><input type="text" readonly="readonly" class="form-control" name="fine_remain" id="fine_remain" placeholder="Remain Fine" value=""></th>
      <td><input type="text" class="form-control" name="jewellery_current_rate" id="current_rate" value="" placeholder="Rate"></td>
      <td><input type="text" class="form-control" readonly="readonly" name="jewellery_rate" id="jewellery_rate" value="0.00" placeholder="Jewellery Rate">
      
      </td>
      <td><input type="text" readonly="readonly" class="form-control lbr_total_amount12" name="table_total_amount1" id="" value="0.00">
      </td>
    <!-- </tr>
      <tr>
      <td class="bord-left"></td>
      <td class="bord-les1">add:cgst</td>
      <td class="bord-les1"><input type="text" class="form-control" name="cgst" id="cgst" value="" placeholder="CGST IN %"></td>
      <td class="bord-les1"><input type="text" readonly="readonly" class="form-control" name="MPGSTvalue" id="MPGSTvalue" value="" placeholder="CGST IN %"></td>
      <td class="bord-right"></td>
    
    </tr>

     <tr>
      <td scope="row" class="bord-left"></td>
      <td class="bord-les1">add:sgst</td>
      <td class="bord-les1"><input type="text" class="form-control" name="sgst" id="sgst" value="" placeholder="SGST IN %"></td>
      <td class="bord-les1"><input type="text" readonly="readonly" class="form-control" name="MPSGSTvalue" id="MPSGSTvalue" value="" placeholder="SGST IN %"></td>
      <td class="bord-right"></td> 
    </tr> -->
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
      <td scope="row" class="bord-les2">grand total :  </td>
      <td class="bord-les3" colspan="4"><input type="text" readonly="readonly" class="form-control" name="grand_total" id="grand_total" value="" placeholder="Grand Total"></td>
      
      
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