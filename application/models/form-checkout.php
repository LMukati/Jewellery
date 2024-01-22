<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<div class="where-hdng">
<h2>Where should we deliver to?</h2>
</div>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php //do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
			   <?php //do_action( 'woocommerce_checkout_billing' ); ?>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				
				
				
				
				
<!--Code for Deliver to my address-->
  <div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
		<div id="testing">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<!--<input id="ship-to-different-address-1" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" onclick="show_billing_address();" <?php //checked( 1, get_option( 'ship_to_different_address' ), false ); //checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'billing' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="radio" name="ship_to_different_address_1" value="1" />--> 
			<input type="radio" name="shipping_method[0]" data-index="0" id="shipping_method_0_flat_rate_1" value="flat_rate:1" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"><span><?php esc_html_e( 'Deliver to my address', 'woocommerce' ); ?></span>
			
			
			</label>

		</h3>

		<div id="div_billing_address" style="display:none">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'billing' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
 </div>
<!--Code for Deliver to my address-->
				
				
				
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
	
	     <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<!--Script for hide and show click and collect-->
<!--<script>
function show_billing_address(){
	document.getElementById("div_billing_address").style.display = 'none';
	document.getElementById("div_shipping_address").style.display = 'none';
	if(document.getElementById("ship-to-different-address-1").checked){
		document.getElementById("div_billing_address").style.display = 'block';	
	}
	if(document.getElementById("ship-to-different-address-checkbox").checked){
		document.getElementById("div_shipping_address").style.display = 'block';
		document.getElementById("div_billing_address").style.display = 'none';
	}
	
}
</script>-->
<!--Script for hide and show click and collect-->