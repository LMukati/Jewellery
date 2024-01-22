<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css')?>">
    <!--datatable open-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css')?>">
   <!--datatable close-->
   <!-- Select2 -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/select2/select2.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;1,300;1,900&display=swap" rel="stylesheet">

   <title>Maa Gayatri jewellers</title>
  </head>

  <body>
  <!--main-header start here-->
    <section class="main-header">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand logo" href="<?php echo base_url('dashboard')?>"><img src="<?php echo base_url('assets/image/logo2.png')?>" alt="logo" class="img-fluid"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav ">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url('stock/addstock')?>">Add Stock <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('stock')?>">stock Manage</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('billing/addbilling')?>">Billing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('billing')?>">Bill Manage</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" target="_blank" href="#">Expenses</a>
            </li>
			      <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('logout')?>">Logout</a>
            </li>
          </ul>
        </div>
      </nav>
</section>
<!--main-header end here-->