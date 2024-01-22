

// This  Code for the Get The  Total Bags wight  and  Net Weight
$(document).ready(function(){
	$("#bags_weight").blur(function(){
		var g_weight = $('#g_weight').val();
		var bags_qty = $('#bags_qty').val();
		var bags_weight = $('#bags_weight').val();
	    var newbagswt = bags_qty * bags_weight;
        $('#total_bags_weight').val(newbagswt.toFixed(2));
		var net_weight=g_weight-newbagswt;
		$('#net_weight').val(net_weight.toFixed(2));
	});
 
 
 //This is the Tunch an  Get the Total amount
  
   $("#tunch").blur(function(){
	var tunch = $('#tunch').val();
	var net_weight=$('#net_weight').val();
	var newfine1= parseFloat(tunch*net_weight); // Multiplication net  weight and  addtion of  tunch and WSTG
	var newfine= parseFloat(newfine1/100);
	$('#fine').val(newfine.toFixed(2));
   });

 //This is to get the Amount for  labour_pcs
    $("#labour_pcs").blur(function(){
	   if($("#labour_pcs").val().length != ''){
			 var bags_qty=$('#bags_qty').val();
			 var labour_pcs=$('#labour_pcs').val();
			 var labour_pcs_net_amount=bags_qty*labour_pcs;
			 $('#amount').val(labour_pcs_net_amount.toFixed(2));
		 }
	 });

 //This is to get the Amount for  labour_gm
     $("#labour_gm").blur(function(){
		 if($("#labour_gm").val().length != ''){
			 var net_weight=$('#net_weight').val();
			 var labour_gm=$('#labour_gm').val();
			 var labour_gm_net_amount=net_weight*labour_gm;
			 $('#amount').val(labour_gm_net_amount.toFixed(2));
		 }
     });
  });