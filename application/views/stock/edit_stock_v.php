<!--about start here-->
 <section class="dashbord adstock">
 	<div class="dashbord_main">
 		<div class="container">
 			<div class="row">
  <form name="addstock" method="post" action="<?php echo base_url('stock/update_stock')?>">
  <input type="hidden" name="edit_id" value="<?php echo $stock_info['id'] ?>">
   <div class="form-row">
     <div class="form-group col-md-3">
      <label for="">MERCHANT NAME</label>
      <input type="text" name="merchant_name" value="<?php echo $stock_info['merchant_name']?>" class="form-control"  placeholder="CUSTOMER NAME">
    </div>
    <div class="form-group col-md-3 ">
      <label for="">MERCHANT MO.NO.</label>
      <input type="number" name="merchant_mobile_no" value="<?php echo $stock_info['merchant_mobile_no']?>" class="form-control" id="" placeholder="MOBILE NUMBER">
    </div>
      <div class="form-group col-md-3">
      <label for="">MERCHANT ADDRESS</label>
      <input type="text" name="merchant_address" value="<?php echo $stock_info['merchant_address']?>" class="form-control" id="" placeholder="ADDRESS">
    </div>
     <div class="form-group col-md-3">
      <label for="">DATE</label>
      <input type="date" name="stock_date" value="<?php echo $stock_info['stock_date']?>" class="form-control" id="" placeholder="DATE.../.../...">
    </div>
   <div class="form-row">
    <div class="form-group col-md-4">
      <label for="">ITEM NAME</label>
      <input type="text" name="item_name" value="<?php echo $stock_info['item_name']?>" class="form-control" id="" placeholder="ITEM NAME">
    </div>
    <div class="form-group col-md-2 col-6">
      <label for="">G. WEIGHT</label>
      <input type="text" name="g_weight" value="<?php echo $stock_info['g_weight']?>" id="g_weight" class="form-control"  placeholder="G.WEIGHT">
    </div>
     <div class="form-group col-md-2 col-6">
      <label for="">BAGES QTY</label>
      <input type="text" name="bags_qty" value="<?php echo $stock_info['bags_qty']?>" id="bags_qty" class="form-control"  placeholder="BAGES QTY">
    </div>
      <div class="form-group col-md-2 col-6">
      <label for="">BAGES WEIGHT</label>
      <input type="text" name="bags_weight" value="<?php echo $stock_info['bags_weight']?>" id="bags_weight" class="form-control"  placeholder="BAGES WEIGHT">
    </div>
	<div class="form-group col-md-2 col-6">
      <label for="">TOTAL BAGS WT</label>
      <input type="text" name="total_bags_weight" value="<?php echo $stock_info['total_bags_weight']?>" id="total_bags_weight" class="form-control" value="0.00"  placeholder="TOTAL BAGS WT">
    </div>
      
  </div>

    <div class="form-row">
	<div class="form-group col-md-2 col-6">
      <label for="">NET WEIGHT</label>
      <input type="text" name="net_weight" value="<?php echo $stock_info['net_weight']?>" id="net_weight" value="0.00" class="form-control"  placeholder="NET WEIGHT">
    </div>
    <div class="form-group col-md-2 col-6">
      <label for="">MELTING</label>
      <input type="text" name="melting" value="<?php echo $stock_info['melting']?>" id="melting" class="form-control"  placeholder="MELTING">
    </div>
     <div class="form-group col-md-2 col-6">
      <label for="">TUNCH</label>
      <input type="text" name="tunch" value="<?php echo $stock_info['tunch']?>" id="tunch" class="form-control" placeholder="TUNCH">
    </div>
      <div class="form-group col-md-2 col-6">
      <label for="">FINE </label>
      <input type="text" name="fine" value="<?php echo $stock_info['fine']?>" id="fine" class="form-control"  placeholder="FINE">
    </div>
       <div class="form-group col-md-2 col-6">
      <label for="">LABOUR/pcs</label>
      <input type="text" name="labour_pcs" value="<?php echo $stock_info['labour_pcs']?>" id="labour_pcs" class="form-control"  placeholder="LABOUR/pcs">
    </div> 
    <div class="form-group col-md-2 col-6">
      <label for="">LABOUR/gm</label>
      <input type="text" name="labour_gm" value="<?php echo $stock_info['labour_gm']?>" id="labour_gm" class="form-control"  placeholder="LABOUR/gm">
    </div>
       <div class="form-group col-md-2 col-6">
      <label for="">AMOUNT</label>
      <input type="text" name="amount" value="<?php echo $stock_info['amount']?>" id="amount" value="0.00" class="form-control"  placeholder="AMOUNT">
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Update stock</button>
</form>
 			</div>
 		</div>
 	</div>
 </section>
