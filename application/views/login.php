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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;1,300;1,900&display=swap" rel="stylesheet">
    <title><?php echo $title ?></title>
  </head>
  <body>
  
<!--banner start here-->
<section class="banner" id="home">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="baner-contnt">
      <img src="<?php echo base_url('assets/image/logo.png')?>" alt="logo">
        <p>"Purity is our moto"</p>
              <?php
				$errormessage = $this->session->flashdata('errormessage');
				    if (isset($errormessage)) {
				        echo '<div class="alert alert-info">' . $errormessage . '</div>';
				        $this->session->unset_userdata('errormessage');
				}
				?>
				
				<?php
				$logincheck = $this->session->flashdata('logincheck');
				    if (isset($logincheck)) {
				        echo '<div class="alert alert-info">' . $logincheck . '</div>';
				        $this->session->unset_userdata('logincheck');
				}
				?>
	<form name="login" method="post" action="<?php echo base_url('home/checkjewellerylogin')?>">
            <div class="row">
              <div class="col-md-6 offset-md-3">
              	<div class="row">
              		<div class="col-md-7">
                <input type="password" class="form-control" name="jewl_password" value="" placeholder="Enter 6 Digit Password..."></div>
                <div class="col-md-5"><button type="submit" class="btn-view"><span>Enter</span></button></div>
              </div>
              </div>
        
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!--banner end here-->
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
      <script src="<?php echo base_url('assets/js/custom.js')?>"></script>
     <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
  </body>
</html>
