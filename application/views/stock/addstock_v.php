<!--about start here-->
 <section class="dashbord adstock">
 	<div class="dashbord_main">
 		<div class="container">
 			<div class="row">
  <form name="addstock" method="post" action="<?php echo base_url('stock/create_stock')?>">
  <input type="hidden" name="add_stock_id" value="<?php echo $this->uri->segment('3'); ?>">
 
   <div class="form-row">
     <div class="form-group col-md-2">
      <label for="">BILL NO.</label>
      <input type="text" name="bill_no" class="form-control" id="" placeholder="BILL NO..." required>
    </div>
     <div class="form-group col-md-2">
      <label for="">MERCHANT NAME</label>
      <input type="text" name="merchant_name" class="form-control"  placeholder="CUSTOMER NAME" required>
    </div>
    <div class="form-group col-md-2 ">
      <label for="">MERCHANT MO.NO.</label>
      <input type="number" name="merchant_mobile_no" class="form-control" id="" placeholder="MOBILE NUMBER" required>
    </div>
      <div class="form-group col-md-2 ">
      <label for="">MERCHANT ADDRESS</label>
      <input type="text" name="merchant_address" class="form-control" id="" placeholder="ADDRESS" required>
    </div>
     <div class="form-group col-md-3 ">
      <label for="">DATE</label>
      <input type="date" name="stock_date" class="form-control" id="" placeholder="DATE.../.../..." required>
    </div>
   <div class="form-row">
   
    <div class="form-group col-md-3">
      <label for="">ITEM NAME</label>
      <input type="text" name="item_name" class="form-control" id="" placeholder="ITEM NAME" required>
    </div>
    <div class="form-group col-md-2 col-6">
      <label for="">G. WEIGHT</label>
      <input type="text" name="g_weight" id="g_weight" class="form-control"  placeholder="G.WEIGHT" required>
    </div>
     <div class="form-group col-md-2 col-6">
      <label for="">BAGS QTY</label>
      <input type="text" name="bags_qty" id="bags_qty" class="form-control"  placeholder="BAGS QTY" required>
    </div>
      <div class="form-group col-md-2 col-6">
      <label for="">WT/BAG</label>
      <input type="text" name="bags_weight" id="bags_weight" class="form-control"  placeholder="WT/BAG" required>
    </div>
	<div class="form-group col-md-2 col-6">
      <label for="">TOTAL BAGS WT</label>
      <input type="text" name="total_bags_weight" id="total_bags_weight" class="form-control" value="0.00"  placeholder="TOTAL BAGS WT" required>
    </div>
     
  </div>

    <div class="form-row">
	 <div class="form-group col-md-2 col-6">
      <label for="">NET WEIGHT</label>
      <input type="text" name="net_weight" id="net_weight" value="0.00" class="form-control"  placeholder="NET WEIGHT" required>
    </div>
    
    <div class="form-group col-md-2 col-6">
      <label for="">MELTING</label>
      <input type="text" name="melting" id="melting"  class="form-control"  placeholder="Melting" required>
    </div>
     <div class="form-group col-md-2 col-6">
      <label for="">TUNCH</label>
      <input type="text" name="tunch" id="tunch" value="0.00"  class="form-control" placeholder="Tunch" required>
    </div>
      <div class="form-group col-md-2 col-6">
      <label for="">FINE </label>
      <input type="text" name="fine" id="fine" value="0.00" class="form-control"  placeholder="FINE" required>
    </div>
       <div class="form-group col-md-2 col-6">
      <label for="">LABOUR/pcs</label>
      <input type="text" name="labour_pcs" id="labour_pcs" class="form-control"  placeholder="LABOUR/pcs">
    </div> 
    <div class="form-group col-md-2 col-6">
      <label for="">LABOUR/gm</label>
      <input type="text" name="labour_gm" id="labour_gm" class="form-control"  placeholder="LABOUR/gm">
    </div>
<div class="form-group col-md-2 col-6">
      <label for="">AMOUNT</label>
      <input type="text" name="amount" id="amount" value="0.00" class="form-control"  placeholder="AMOUNT" required>
    </div>
  
  </div>
  <button type="submit" class="btn btn-primary">save stock</button>
</form>
 			</div>
 		</div>
 	</div>
 </section>
