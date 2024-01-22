    
  <script>
   // $("#viewLedger").animate({ scrollTop: $("#viewLedger").height() }, "slow");
    function print_bill(){
      window.print();
       
    }
    function valueChanged()
    {
        
        if($('.open_div').is(":checked")){   
            $(".Labour").show();
            $("#rate_for_fine").keyup(function (){
            var labour_amount_for_fine = $('#labour_amount_for_fine').val();
            var rate_for_fine = $('#rate_for_fine').val();
            var newbagswt =  labour_amount_for_fine/rate_for_fine;
            $('#labour_to_fine').val(newbagswt.toFixed(2));
            
            })
            $('#labour_to_fine').blur(function (){
                if( $('#labour_to_fine').val() != ''){
                    var s_rec=$('#table_total_fine1').val();
                    var ltf=$('#labour_to_fine').val();
                    //var ltfnew=round(ltf, 2);
                var s_rec_new="";
                   s_rec_new= parseFloat(s_rec) + parseFloat(ltf);
                    $('#silver_receive').val(s_rec_new.toFixed(2));
                }
            })
        }else{
            if( $('#labour_to_fine').val() != ''){
                    var s_rec1=$('#silver_receive').val();
                    var ltf1=$('#labour_to_fine').val();
                var s_rec_new="";
                   s_rec_new1= parseFloat(s_rec1) - parseFloat(ltf1);
                    $('#silver_receive').val(s_rec_new1.toFixed(2));
                }
            $(".Labour").hide();
        }
    }

    function Get_opration(rowIdx){
  // This  Code for the Get The  Total Bags wight  and  Net Weight
  $("#bags_weight"+rowIdx).blur(function(){
		var g_weight = $('#g_weight'+rowIdx).val();
		var bags_qty = $('#bags_qty'+rowIdx).val();
		var bags_weight = $('#bags_weight'+rowIdx).val();
	    var newbagswt = bags_qty * bags_weight;
        $('#total_bags_weight'+rowIdx).val(newbagswt.toFixed(2));
		var net_weight=g_weight-newbagswt;
		$('#net_weight'+rowIdx).val(net_weight.toFixed(2));
   // gs_weight();
    //bsg_qty();
    total_bgs_weight1();
    total_net_weight();
	});

 
 
 //This is the Tunch an  Get the Total amount
  
   $("#tunch"+rowIdx).blur(function(){
	var tunch = $('#tunch'+rowIdx).val();
	var net_weight=$('#net_weight'+rowIdx).val();
	var newfine1= parseFloat(tunch*net_weight); // Multiplication net  weight and  addtion of  tunch and WSTG
	var newfine= parseFloat(newfine1/100);
	$('#fine'+rowIdx).val(newfine.toFixed(2));
  total_fine();
   });

 //This is to get the Amount for  labour_pcs
    $("#labour_pcs"+rowIdx).blur(function(){
	   if($("#labour_pcs"+rowIdx).val().length != ''){
			 var bags_qty=$('#bags_qty'+rowIdx).val();
			 var labour_pcs=$('#labour_pcs'+rowIdx).val();
			 var labour_pcs_net_amount=bags_qty*labour_pcs;
			 $('#amount'+rowIdx).val(labour_pcs_net_amount.toFixed(2));
       lbr_psc();
       //lbr_gm(rowIdx);
      lbr_amount();
		 }
	 });

 //This is to get the Amount for  labour_gm
     $("#labour_gm"+rowIdx).blur(function(){
		 if($("#labour_gm"+rowIdx).val().length != ''){
			 var net_weight=$('#net_weight'+rowIdx).val();
			 var labour_gm=$('#labour_gm'+rowIdx).val();
			 var labour_gm_net_amount=net_weight*labour_gm;
			 $('#amount'+rowIdx).val(labour_gm_net_amount.toFixed(2));
       //lbr_psc(rowIdx);
       lbr_gm();
       lbr_amount();
		 }
     });
// This code use for subtotal......
     $(".g_weight").change(function (){
            var sum=0;
            $('#table_total_g_weight1').val("");
            $(".g_weight").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum += parseFloat(this.value);
                    }

            })
            $('#table_total_g_weight1').val(sum);
        });
        $(".bags_qty").change(function (){
            var sum1=0;
            $(".bags_qty").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum1 += parseFloat(this.value);
                    }

            })
            $('#table_total_bags_qty1').val(sum1);
        });
        function total_bgs_weight1(){
            var sum2=0;
            $(".total_bags_weight").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum2 += parseFloat(this.value);
                    }

            })
            $('#table_total_bags_weight1').val(sum2);
        }
        function total_net_weight(){
            var sum3=0;
            $(".net_weight").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum3 += parseFloat(this.value);
                    }

            })
            $('#table_total_net_weight1').val(sum3);
        }
        function total_fine (){
            var sum4=0;
            $(".fine").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum4 += parseFloat(this.value);
                    }

            })
            $('#table_total_fine1').val(sum4);
            $('#silver_receive').val(sum4);
        }
       function lbr_psc(){
            var sum5=0;
            $(".labour_pcs").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum5 += parseFloat(this.value);
                    }

            })
            $('#table_total_labour_pcs1').val(sum5);
        }
       function lbr_gm(){
            var sum6=0;
            $(".labour_gm").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum6 += parseFloat(this.value);
                    }

            })
            $('#table_total_labour_gm1').val(sum6);
        }
        function lbr_amount(){
            var sum7=0;
            $(".amount").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum7 += parseFloat(this.value);
                    }

            })
           // $('#table_total_g_weight1').val(sum7);
            $("#table_total_amount1").val(sum7);
            $(".lbr_total_amount12").val(sum7);
        }
  }
  function getvalues(id){
    Get_opration(id);
    //alert(id);
  }
  
  </script>
 <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
      <script src="<?php echo base_url('assets/js/custom.js')?>"></script>
	  <script src="<?php echo base_url('assets/js/common.js')?>"></script>
     <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
     <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
     <script src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js')?>"></script>
     <!-- Select2 -->
     <script src="<?php echo base_url(); ?>assets/backend/plugins/select2/select2.full.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
     <script src="<?php echo base_url('assets/js/html2canvas.js')?>"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

    
     <!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script> -->
<!--Delete Model Box--->
<div id="del" modal="hide" class="modal fade" aria-hidden="true" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="icon-remove">WARNING FOR STOCK</i> 
				</div>						
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<p id="stock_MSG"></p>
        <a style="background-color: black;" id="url_edit" href="" >CLICK HERE</a>
			</div>
			<!-- <div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger"><a href="">Delete</a></button>
			</div> -->
		</div>
	</div>
</div>
<!--Delete Model Box--->
   <script>  
   $(document).ready(function() {



    $('#example').DataTable();
    $('#example thead th').off('click');
    $(".select2").select2();
    $('#viewLedger').on('shown.bs.modal', function () {
    $(this).find('.modal-dialog').css({width:'auto',
                               height:'auto', 
                              'max-height':'100%'});
});
$(function () {
        $("#ddlPassport").change(function () {
            if ($(this).val() == "Gst") {
                $("#dvPassport").show();
                $("#dvPassport1").hide();
            } if ($(this).val() == "Plain") {
                $("#dvPassport1").show();
                $("#dvPassport").hide();

            }
        });
    });
    var furl_get= document.URL; // Get current url
                      var url_array = furl_get.split('/') // Split the string into an array with / as separator
                      var last_segment = url_array[url_array.length-2];  // Get the last part of the array (-1)
                      if(typeof(last_segment) && last_segment !="printbill" ){
    $.ajax({
                    method: 'GET',
                    url:'<?php echo base_url('billing/get_ajax_stock');?>',
                    success:function(response){
                        var data = jQuery.parseJSON(response);
                      if(data !=null){
						          $("#del").modal('show');
                      var url_edit= "<?php echo base_url('stock/stock_manage_l/'); ?>"+data.stock_id;
                      $('#url_edit').attr('href', url_edit);
                       
                      $('#stock_MSG').html(data.stock_MSG+' on this '+data.stock_id);
                      var furl_get= document.URL; // Get current url
                      var url_array = furl_get.split('/') // Split the string into an array with / as separator
                      var last_segment = url_array[url_array.length-1];  // Get the last part of the array (-1)
                      if(typeof(last_segment) && last_segment !=="" ){
                        $('#del').modal('toggle');
                        $("#del").modal('hide');
                      }
					
					}
        }
                });
                      }
       
  
  var rowIdx = <?php echo count($bill_trans_info+1);?>
       <?php
        // if(isset($_GET['id']) && $_GET['id'] !=''){
        //        if(count($bill_trans_info1) != 0){ 
        //         echo count($bill_trans_info1);
                       
        //         }}else{
        //           echo count($bill_trans_info1+1);
        //             }
         ?>;
  //alert(rowIdx);
  var sum=0.00;
  //$(this).change(function (){
  data_opration(rowIdx);
  //});


  
  //Start data opretion
  function data_opration(rowIdx){
  // This  Code for the Get The  Total Bags wight  and  Net Weight
  $("#bags_weight"+rowIdx).blur(function(){
		var g_weight = $('#g_weight'+rowIdx).val();
		var bags_qty = $('#bags_qty'+rowIdx).val();
		var bags_weight = $('#bags_weight'+rowIdx).val();
	    var newbagswt = bags_qty * bags_weight;
        $('#total_bags_weight'+rowIdx).val(newbagswt.toFixed(2));
		var net_weight=g_weight-newbagswt;
		$('#net_weight'+rowIdx).val(net_weight.toFixed(2));
   // gs_weight();
    //bsg_qty();
    total_bgs_weight1();
    total_net_weight();
	});

 
 
 //This is the Tunch an  Get the Total amount
  
   $("#tunch"+rowIdx).blur(function(){
	var tunch = $('#tunch'+rowIdx).val();
	var net_weight=$('#net_weight'+rowIdx).val();
	var newfine1= parseFloat(tunch*net_weight); // Multiplication net  weight and  addtion of  tunch and WSTG
	var newfine= parseFloat(newfine1/100);
	$('#fine'+rowIdx).val(newfine.toFixed(2));
  total_fine();
   });

 //This is to get the Amount for  labour_pcs
    $("#labour_pcs"+rowIdx).blur(function(){
	   if($("#labour_pcs"+rowIdx).val().length != ''){
			 var bags_qty=$('#bags_qty'+rowIdx).val();
			 var labour_pcs=$('#labour_pcs'+rowIdx).val();
			 var labour_pcs_net_amount=bags_qty*labour_pcs;
			 $('#amount'+rowIdx).val(labour_pcs_net_amount.toFixed(2));
       lbr_psc();
       //lbr_gm(rowIdx);
      lbr_amount();
		 }
	 });

 //This is to get the Amount for  labour_gm
     $("#labour_gm"+rowIdx).blur(function(){
		 if($("#labour_gm"+rowIdx).val().length != ''){
			 var net_weight=$('#net_weight'+rowIdx).val();
			 var labour_gm=$('#labour_gm'+rowIdx).val();
			 var labour_gm_net_amount=net_weight*labour_gm;
			 $('#amount'+rowIdx).val(labour_gm_net_amount.toFixed(2));
       //lbr_psc(rowIdx);
       lbr_gm();
       lbr_amount();
		 }
     });
// This code use for subtotal......
     $(".g_weight").change(function (){
            var sum=0;
            $('#table_total_g_weight1').val("");
            $(".g_weight").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum += parseFloat(this.value);
                    }

            })
            $('#table_total_g_weight1').val(sum);
        });
        $(".bags_qty").change(function (){
            var sum1=0;
            $(".bags_qty").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum1 += parseFloat(this.value);
                    }

            })
            $('#table_total_bags_qty1').val(sum1);
        });
        function total_bgs_weight1(){
            var sum2=0;
            $(".total_bags_weight").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum2 += parseFloat(this.value);
                    }

            })
            $('#table_total_bags_weight1').val(sum2);
        }
        function total_net_weight(){
            var sum3=0;
            $(".net_weight").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum3 += parseFloat(this.value);
                    }

            })
            $('#table_total_net_weight1').val(sum3);
        }
        function total_fine (){
            var sum4=0;
            $(".fine").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum4 += parseFloat(this.value);
                    }

            })
            $('#table_total_fine1').val(sum4);
            $('#silver_receive').val(sum4);
        }
       function lbr_psc(){
            var sum5=0;
            $(".labour_pcs").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum5 += parseFloat(this.value);
                    }

            })
            $('#table_total_labour_pcs1').val(sum5);
        }
       function lbr_gm(){
            var sum6=0;
            $(".labour_gm").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum6 += parseFloat(this.value);
                    }

            })
            $('#table_total_labour_gm1').val(sum6);
        }
        function lbr_amount(){
            var sum7=0;
            $(".amount").each(function(i, obj){
              

            if($.isNumeric(this.value)) {
                        sum7 += parseFloat(this.value);
                    }

            })
           // $('#table_total_g_weight1').val(sum7);
            $("#table_total_amount1").val(sum7);
            $(".lbr_total_amount12").val(sum7);
        }
  }
  
  //End data opration....
   $(".add").click(function(){
      var html = `<tr>
                     <td scope="row">${++rowIdx}</td>
					 <td>
					 <input type="hidden" name="stock_id[]" id="stock_id${rowIdx}" value="">
					  <select name="item_name[]" id="item_name${rowIdx}" class="form-control select2 required" id="size" placeholder="">
		                <option value="">Select Item</option>
						<?php 
						foreach($stock_info as $stock_info_v){
						?>
						 <option value="<?php echo $stock_info_v['id']?>"><?php echo $stock_info_v['item_name']?></option>
						<?php
						}
						?>
		              </select>
					  </td>
                     
      <td><input type="text" name="g_weight[]" id="g_weight${rowIdx}" class="form-control g_weight"  placeholder="G.WEIGHT" required></td>
      <td><input type="text" name="bags_qty[]" id="bags_qty${rowIdx}" class="form-control bags_qty"  placeholder="BAGS QTY" required></td>
      <td><input type="text" name="bags_weight[]" id="bags_weight${rowIdx}" class="form-control bags_weight"  placeholder="WT/BAG" required></td>
      <td><input type="text" name="total_bags_weight[]" id="total_bags_weight${rowIdx}" class="form-control total_bags_weight" value="0.00"  placeholder="TOTAL BAGS WT" required></td>
      <td><input type="text" name="net_weight[]" id="net_weight${rowIdx}" value="0.00" class="form-control net_weight"  placeholder="NET WEIGHT" required></td>
      <td><input type="text" name="melting[]" id="melting${rowIdx}"  class="form-control melting"  placeholder="Melting" required></td>
      <td> <input type="text" name="tunch[]" id="tunch${rowIdx}" value="0.00"  class="form-control tunch" placeholder="Tunch" required></td>
      <td><input type="text" name="fine[]" id="fine${rowIdx}" value="0.00" class="form-control fine"  placeholder="FINE" required></td>
     <td><input type="text" name="labour_pcs[]" id="labour_pcs${rowIdx}" class="form-control labour_pcs"  placeholder="LABOUR/pcs"></td>
      <td><input type="text" name="labour_gm[]" id="labour_gm${rowIdx}" class="form-control labour_gm"  placeholder="LABOUR/gm"></td>
      <td><input type="text" name="amount[]" id="amount${rowIdx}" value="0.00" class="form-control amount"  placeholder="AMOUNT" required></td>
                     <td><a href="javascript:void(0);" class="btn btn-danger del">-</a>
                    <!--  <a href="javascript:void(0);" class="btn btn-primary add">-</a>--></td>
                  </tr>`;
      $("#tbody_id").append(html);  
      data_opration(rowIdx); 
	   $(function () {
                //Initialize Select2 Elements
                $(".select2").select2();
               });
	 });

  
    
  } );
   // This  Code for the Get The  Remain fine
   $('#fine_receive').change(function() {
    $('#fine_remain').val("0.00");
    if($("#table_total_fine1").val() != "0.00" && $('#fine_receive').val() !=="0.00"){
     //alert();
     var table_total_fine1 = $('#silver_receive').val();
     var fine_receive = $('#fine_receive').val();
     //var bags_weight = $('#bags_weight').val();
       var newfine = table_total_fine1 - fine_receive;
         $('#fine_remain').val(newfine.toFixed(2));
   
   }
  });
   // This  Code for the Get The RATE CUT Amount
   $('#current_rate').change(function() {
    $('#jewellery_rate').val("0.00");
    if($("#fine_remain").val() != "0.00" && $('#current_rate').val() !=="0.00"){
     //alert();
     var table_total_fine1 = $('#fine_remain').val();
     var fine_receive = $('#current_rate').val();
     //var bags_weight = $('#bags_weight').val();
       var newfine = table_total_fine1 * fine_receive;
         $('#jewellery_rate').val(newfine.toFixed(2));
   
   }else{
    var table_total_fine1 = 0;
     var fine_receive = $('#current_rate').val();
     //var bags_weight = $('#bags_weight').val();
       var newfine = table_total_fine1 * fine_receive;
         $('#jewellery_rate').val(newfine.toFixed(2));
   }

   //$('[name="3"]').val(parseInt($("#1").val())+(parseInt($("#2").val())));
});
   if($("#silver_receive").val() != "0.00" && $('#fine_receive').val() !==""){
     //alert();
     var table_total_fine1 = $('#silver_receive').val();
     var fine_receive = $('#fine_receive').val();
     //var bags_weight = $('#bags_weight').val();
       var newfine = table_total_fine1 - fine_receive;
         $('#fine_remain').val(newfine.toFixed(2));
   
   }
   $( "#cgst").blur(function() {
		var MPGSTper=parseFloat($("#cgst").val());
		//alert(MPGSTper);
		var sub_total=parseFloat ($("#jewellery_rate").val());
		//alert(sub_total);
		var getMPGSTper=(sub_total*MPGSTper)/100;
		//alert(getMPGSTper);
		//var totalsub=getMPGSTper + sub_total;
		$("#MPGSTvalue").val(getMPGSTper.toFixed(2));
		
		var gsttotal=parseFloat($("#MPGSTvalue").val()) + parseFloat($("#MPSGSTvalue").val());
	
	
	
	var allgrandtotal=parseFloat($("#jewellery_rate").val()) + parseFloat(gsttotal);
	
	$("#grand_total").val(allgrandtotal.toFixed(2));
    });


$("#sgst").blur(function() {
		var MPSGSTper=parseFloat($("#sgst").val());
		//alert(MPSGSTper);
		var sub_total=parseFloat($("#jewellery_rate").val());
		//alert(sub_total);
		var getMPSGSTper=(sub_total*MPSGSTper)/100;
		//alert(getMPSGSTper);
		$("#MPSGSTvalue").val(getMPSGSTper.toFixed(2));
		
		
		var gsttotal=parseFloat($("#MPGSTvalue").val()) + parseFloat($("#MPSGSTvalue").val());
	
	
	
	var allgrandtotal=parseFloat($("#jewellery_rate").val()) + parseFloat(gsttotal);
	
	$("#grand_total").val(allgrandtotal.toFixed(2));
		
    });
  $(document).on("click",".del",function(){
       $(this).parent().parent().remove();
       //data_opration(rowIdx);
  });
   // function PrintDiv(){
    //   window.print();
    // }
  
</script>


  </body>
</html>