<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 */
			do_action( 'storefront_footer' );
			?>

			<!--<div class="our-store w-100 float-left">
				<div class="our-store-head w-100 float-left">
					<h2>Our store</h2>
				</div>

				<div class="our-store-main">
							<div class="bxes-strs">
								<div class="bx-hd-title w-100 float-left">
									<h4><i class="fa fa-map-marker"></i> CBD</h4>
								</div>

								<div class="bx-dtl float-left">
									<p>Kenyatta Avenue, 680 Hotel
                                <br>Nairobi
                            </p>
								</div>
							</div>
							<div class="bxes-strs">
								<div class="bx-hd-title w-100 float-left">
									<h4><i class="fa fa-map-marker"></i> Garden City</h4>
								</div>

								<div class="bx-dtl">
									<p>Ground Floor, Garden City Mall
                                <br>Nairobi
                            </p>
								</div>
							</div>
							<div class="bxes-strs">
								<div class="bx-hd-title">
									<h4><i class="fa fa-map-marker"></i> Westgate</h4>
								</div>

								<div class="bx-dtl">
									<p>Ground Floor, New Wing
                                <br>Nairobi
                            </p>
								</div>
							</div>
							<div class="bxes-strs">
								<div class="bx-hd-title">
									<h4><i class="fa fa-map-marker"></i> Sarit Centre</h4>
								</div>

								<div class="bx-dtl">
									<p>Lower Ground Fl, Sarit Centre
                                <br>Nairobi
                            </p>
								</div>
							</div>
							<div class="bxes-strs">
								<div class="bx-hd-title">
									<h4><i class="fa fa-map-marker"></i> Village Market</h4>
								</div>

								<div class="bx-dtl">
									<p>1st Floor, New Wing
                                <br>Nairobi
                            </p>
								</div>
							</div>
							<div class="bxes-strs">
								<div class="bx-hd-title">
									<h4><i class="fa fa-map-marker"></i> Mombasa Likoni</h4>
								</div>

								<div class="bx-dtl">
									<p>Nova Complex
                                <br>Mombasa
                            </p>
								</div>
							</div>
							<div class="bxes-strs">
								<div class="bx-hd-title w-100 float-left">
									<h4><i class="fa fa-map-marker"></i> Nyali Centre</h4>
								</div>

								<div class="bx-dtl">
									<p>Ground Floor
                                <br>Mombasa
                            </p>
								</div>
							</div>
				</div>
			</div>-->
			
			
			
		<div class="site-info">
			<div class="copyright-info">
		    	<?php echo bi_get_data('copyright_1') ;?>
		    </div>

		    <!--<div class="powered-by">
			 <p>Powered By:</p>
                    <a href="<?php echo bi_get_data('footer_logo_link'); ?>"><img src="<?php echo bi_get_data('footer_logo') ;?>" alt="logo"></a>
            </div>-->

		</div><!-- .site-info -->
			

		</div><!-- .col-full -->
	</div>
	
	
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6091406cb1d5182476b57890/1f4rm7avm';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<script type="text/javascript">
          jQuery('#shipping_method_0_flat_rate1').hide();
					 jQuery('#shipping_method_0_local_pickup4').hide();
      </script>
<!--End of Tawk.to Script-->
	
	
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
