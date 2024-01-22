


<!--about start here-->
 <section class="dashbord stock_manage">
    <div class="container-fluid">
 	<div class="dashbord_main">


<!--table start here-->
<table id="example" class="table table-responsive ">
  <thead>
    <tr>
      <th scope="col">sn</th>
      <th scope="col">Item Name</th>
      <th scope="col">G.Wt</th>
      <th scope="col">Bags Qty</th>
      <th scope="col">Bags Wt</th>
      <th scope="col">Total Bags Wt</th>
      <th scope="col">Net Wt</th>
      <th scope="col">Melting</th>
	  <th scope="col">Tunch</th>
      <th scope="col">Fine</th>
      <th scope="col">LBR/PCS</th>
      <th scope="col">LBR/GM</th>
      <th scope="col">LBR Amount</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
  <?php
    if(count($stock_info) > 0){
    foreach ($stock_info as $v_stock_info) { 
  ?>
    <tr class="rocolor1">
      <th scope="row"><?php echo $v_stock_info['id'] ?></th>
      <td style="width: 153px;"><?php echo $v_stock_info['item_name'] ?></td>
      <td><?php echo $v_stock_info['g_weight'] ?></td>
      <td><?php echo $v_stock_info['bags_qty'] ?></td>
      <td><?php echo $v_stock_info['bags_weight'] ?></td>
      <td><?php echo $v_stock_info['total_bags_weight'] ?></td>
      <td><?php echo $v_stock_info['net_weight'] ?></td>
      <td><?php echo $v_stock_info['melting'] ?></td>
	  <td><?php echo $v_stock_info['tunch'] ?></td>
      <td><?php echo $v_stock_info['fine'] ?></td>
      <td><?php echo $v_stock_info['labour_pcs'] ?></td>
      <td><?php echo $v_stock_info['labour_gm'] ?></td>
      <td><?php echo $v_stock_info['amount'] ?></td>
	  <td>
	   <!-- <button type="submit" class="btn btn-primary acontview"><a href="#viewModal<?php echo $v_stock_info['id']?>" class="trigger-btn" data-toggle="modal">View</a></button> -->
	   <button type="submit" class="btn btn-primary acontview"><a href="<?php echo base_url('stock/stock_manage_l/'.$v_stock_info['id'])?>" class="trigger-btn">View</a></button>

     <button type="submit" class="btn btn-primary acontview"><a href="<?php echo base_url('stock/addstock/'.$v_stock_info['id'])?>">Add Stock</a></button>
     <!-- <button type="submit" class="btn btn-primary acontview"><a href="<?php echo base_url('stock/edit_stock/'.$v_stock_info['id'])?>">Edit</a></button> -->
       <button type="submit" class="btn btn-primary"><a href="#delModal<?php echo $v_stock_info['id']?>" class="trigger-btn" data-toggle="modal">Delete</a></button>
	 </td>
    </tr>
	<!--Delete Model Box--->
	<div id="delModal<?php echo $v_stock_info['id']?>" class="modal fade" aria-hidden="true" style="display: none;">
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
				<p>Do you really want to delete these Stock?.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger"><a href="<?php echo base_url('stock/remove_stock/'.$v_stock_info['id'])?>">Delete</a></button>
			</div>
		</div>
	</div>
</div>
<!--Delete Model Box--->


<!-- Modal Box  For View -->
<div id="viewModal<?php echo $v_stock_info['id']?>" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
	 <p><span style="font-weight:500;">Merchant Name</span>:-  <?php echo $v_stock_info['merchant_name']; ?></p>
     <p><span style="font-weight:500;">Merchant Mobile No</span>:-  <?php echo $v_stock_info['merchant_mobile_no']; ?></p>
     <p><span style="font-weight:500;">Merchant Address</span>:-  <?php echo $v_stock_info['merchant_address']; ?></p>
     <p><span style="font-weight:500;">Date</span>:-  <?php echo $v_stock_info['stock_date']; ?></p>	 
	 </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Box  For View -->
 <?php  } 
	  }
	else {
	   echo "<tr><td colspan=13 style=text-align:center;>Record Not Found!</td></tr>";	
	}
  ?>
  </tbody>
</table>
<!--table end here-->

 		</div>
 	</div>
 </section>
