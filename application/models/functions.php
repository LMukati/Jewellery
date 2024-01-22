<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */



//Code for support Woocommerce
function mytheme_add_woocommerce_support() {
add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
//Code for support Woocommerce


//Code for Dynamic Version of the CSS&JS
// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) ){
		$src = remove_query_arg( 'ver', $src );
		$src = $src.'?ver='.date('y.mdh.i.s').'';
	}
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
// remove wp version param from any enqueued scripts
//Code for Dynamic Version of the CSS&JS



/******** cart ***********/ 
 


function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');

add_action('woocommerce_after_shop_loop_item','replace_add_to_cart');
function replace_add_to_cart() {
	global $product;
	$link = $product->get_permalink();
	$id = $product->get_id();
	$name = $product->get_name();
	
	$cart = WC()->cart->get_cart();
	$cart_product_data = array();
	foreach($cart as $key=>$v_cart){ 
	 /* $cart_product_data[$v_cart['product_id']] = $v_cart['quantity']; */
	 
	 $quantity = '<div class="product-quantity">
		<div class="quantity">
			<input type="number" step="1" min="1"
			 name="cart['.$key.'][qty]"
			 value="'.$v_cart['quantity'].'" title="Qty" class="input-text qty text custom-qty qty__'.$v_cart['product_id'].' " size="4"  id="'.$v_cart['product_id'].'"   >
		</div>
	</div>';
	 $cart_product_data[$v_cart['product_id']]['quantity'] = $v_cart['quantity'];
	 $cart_product_data[$v_cart['product_id']]['html'] = $quantity;
	 
	}
	
	echo '<div class="quantity-content-'.$id.'">';
	if(isset($cart_product_data[$id]['quantity'])){
		 $quantity = $cart_product_data[$id]['quantity']; 
		 echo  '
		 <button  class="btn-primary cart-btn-minus" type="button" data-product_id="'.$id.'" ><i  class="fa fa-minus"></i></button>
		 
		'.$cart_product_data[$id]['html'].' 
		 
		 <button  class="btn-primary btn-sm cart-btn-plus" type="button" data-product_id="'.$id.'"><i  class="fa fa-plus"></i></button>
		 ';
		 
	
	}else{ 
		
		echo  '<a href="?add-to-cart='.$id.'" data-quantity="1" class="custom-add_to_cart_button button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="'.$id.'" data-product_sku="" aria-label="Add “'.$name.'” to your cart" rel="nofollow">Add to cart</a>';
		
	}
	echo '</div>';
	
}


function function_footer_woocommerce() {
    ?>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script> 
 
	$(document).on('click', '.cart-btn-plus', function (e)
    {
		 
		var product_id = $(this).attr("data-product_id"); 
		var qty = $(".qty__"+product_id+"").val();
			qty = parseInt(qty)+1;
			if(qty<1){ qty =1; }
			$(".qty__"+product_id+"").val(qty);
			$(".qty__"+product_id+"").trigger('change');
	});
	
	$(document).on('click', '.cart-btn-minus', function (e)
    {
		var product_id = $(this).attr("data-product_id"); 
		var qty = $(".qty__"+product_id+"").val();
			qty = parseInt(qty)-1;
			if(qty<1){ qty =1; }
			$(".qty__"+product_id+"").val(qty);
			$(".qty__"+product_id+"").trigger('change');
		
	});
	
	$(document).on('click', '.custom-add_to_cart_button', function (e)
    {
		var product_id = $(this).attr("data-product_id"); 
		 
		$(".quantity-content-"+product_id+"").html('<button  class="btn-primary cart-btn-minus" type="button" data-product_id="'+product_id+'" ><i  class="fa fa-minus"></i></button><div class="product-quantity"><div class="quantity"><input type="number" step="1" min="1"   value="1" title="Qty" class="input-text qty text custom-qty qty__'+product_id+' " size="4"  id="'+product_id+'"   ></div></div><button  class="btn-primary btn-sm cart-btn-plus" type="button" data-product_id="'+product_id+'"><i  class="fa fa-plus"></i></button>');
		
		
	});
	
	
	$(document).on('change', 'input.custom-qty', function (e)
    {
		 e.preventDefault();
		 var qty = $(this).val();
		 var cart_item_key = $(this).attr("id"); 

	   $.ajax({
			type: 'POST',
			dataType: 'json',
			url: "/wp-admin/admin-ajax.php",
			data: {action : 'update_item_from_cart', 'cart_item_key' : cart_item_key, 'qty' : qty,  },
			success: function (data) {
				 
				/*refresh mini cart*/
				 refresh_cart_fragment();
				/*refresh mini cart*/
			  
		}

		});

	 });
	
	 function refresh_cart_fragment(){
		 
		 var $fragment_refresh = {
		url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
		type: 'POST',
		data: {
			time: new Date().getTime()
		},
		timeout: wc_cart_fragments_params.request_timeout,
		success: function( data ) {
			if ( data && data.fragments ) {

				$.each( data.fragments, function( key, value ) {
					$( key ).replaceWith( value );
				});

				if ( $supports_html5_storage ) {
					sessionStorage.setItem( wc_cart_fragments_params.fragment_name, JSON.stringify( data.fragments ) );
					set_cart_hash( data.cart_hash );

					if ( data.cart_hash ) {
						set_cart_creation_timestamp();
					}
				}

				$( document.body ).trigger( 'wc_fragments_refreshed' );
			}
		},
		error: function() {
			$( document.body ).trigger( 'wc_fragments_ajax_error' );
		}
	};
	
		 $.ajax( $fragment_refresh );
		 
	 }
	
	  
	</script>
	
	<?php
}
add_action( 'wp_footer', 'function_footer_woocommerce' );



function update_item_from_cart() {
     $cart_item_key = $_REQUEST['cart_item_key'];   
     $quantity = $_REQUEST['qty'];     
    ob_start();
	

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
    {
        if( $cart_item['product_id'] == $_REQUEST['cart_item_key'] )
        { 
            WC()->cart->set_quantity( $cart_item_key, $quantity, $refresh_totals = true );
        }
    }
    WC()->cart->calculate_totals();
    WC()->cart->maybe_set_cart_cookies();
    return true;
}

add_action('wp_ajax_update_item_from_cart', 'update_item_from_cart');
add_action('wp_ajax_nopriv_update_item_from_cart', 'update_item_from_cart');


/******* cart ***********/





/*woocommerce_register_form*/

add_shortcode( 'woocommerce_register_form', 'woocommerce_separate_registration_form' );
    
function woocommerce_separate_registration_form() {
 ob_start();
  if ( is_user_logged_in() ){ 
    wp_redirect( '/my-account/' );
  }
  do_action( 'woocommerce_before_customer_login_form' );
 
   ?>
      <?php
	  if (isset($_GET['register'])): 
    echo '<div class="successmessage"><p>' . __('Your Success message.') . '</p></div>';
endif;
	  ?>

    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
      
      <?php do_action( 'woocommerce_register_form_start' ); ?>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
          <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
          <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
        </p>

      <?php endif; ?>

      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required/><?php // @codingStandardsIgnoreLine ?>
      </p>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
          <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
          <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required="" />
        </p>

      <?php else : ?>

        <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

      <?php endif; ?>

      <?php do_action( 'woocommerce_register_form' ); ?>

      <p class="woocommerce-FormRow form-row">
        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
        <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Signup', 'woocommerce' ); ?></button>
      </p>

      <?php do_action( 'woocommerce_register_form_end' ); ?>

    </form>

 
   <?php 
   return ob_get_clean();
 
}
/*woocommerce_register_form*/


add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

    ?>
     <script>
	   alert('form has been submitted');
</script>	 
<?php
}

//Code For Add custom Register Field's
    function wooc_extra_register_fields() {?>
          
           <p class="form-row form-row-first">
           <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
           <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" required/>
           </p>
           <p class="form-row form-row-last">
           <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
           <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" required/>
           </p>
            <p class="form-row form-row-wide">
           <label for="reg_billing_phone"><?php _e( 'Mobile Number', 'woocommerce' ); ?></label>
           <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" maxlength="10" minlength="10" placeholder="Enter 10 Digit Mobile Number" />
           </p>
           <div class="clear"></div>
           <?php
     }
     add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
//Code For Add custom Register Field's





/**
* Code for save extra register form fields in the database.
*/
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
          }
      if ( isset( $_POST['billing_first_name'] ) ) {
             //First name field which is by default
             update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
             // First name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
      }
      if ( isset( $_POST['billing_last_name'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
      }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
/*Code for save extra register form fields in the database.*/



/*Code for do field's read only on the Edit Address form*/
add_filter('woocommerce_address_to_edit', 'cb_woocommerce_address_to_edit');
function cb_woocommerce_address_to_edit($address){
        array_key_exists('billing_email', $address)?$address['billing_email']['custom_attributes'] = array('readonly'=>'readonly'):'';
        array_key_exists('billing_email-2', $address)?$address['billing_email-2']['custom_attributes'] = array('readonly'=>'readonly'):'';
        return $address;
}
/*Code for do field's read only on the Edit Address form*/



/*Code for do field's read only on the Checkout billing form*/
add_filter('woocommerce_billing_fields', 'my_woocommerce_billing_fields');
function my_woocommerce_billing_fields($fields)
{
   $fields['billing_email']['custom_attributes'] = array('readonly'=>'readonly');
 
    
   return $fields;
}
/*Code for do field's read only on the Checkout billing form*/





//Code for redirect after Login
function iconic_login_redirect() {
wp_redirect(home_url('/checkout'));
}
add_filter( 'woocommerce_login_redirect', 'iconic_login_redirect' );
//Code for redirect Login





//Code for redirect after Logout 
add_action('wp_logout','ps_redirect_after_logout');
function ps_redirect_after_logout(){
         wp_redirect(home_url('/login'));
         exit();
}
//Code for redirect after Logout



//Code for Custom "Tanzanian Currency"
add_filter( 'woocommerce_currencies', 'add_tsh_currency' );
function add_tsh_currency( $tsh_currency ) {
     $tsh_currency['Tanzanian'] = __( 'Tanzanian Shilling', 'woocommerce' );
     return $tsh_currency;
}
add_filter('woocommerce_currency_symbol', 'add_tsh_currency_symbol', 10, 2);
function add_tsh_currency_symbol( $custom_currency_symbol, $custom_currency ) {
     switch( $custom_currency ) {
         case 'Tanzanian': $custom_currency_symbol = 'TSh'; break;
     }
     return $custom_currency_symbol;
}
//Code for Custom "Tanzanian Currency"





//Code for search in mobile
if ( ! function_exists( 'storefront_handheld_footer_bar' ) ) {
	/**
	 * Display a menu intended for use on handheld devices
	 *
	 * @since 2.0.0
	 */
	function storefront_handheld_footer_bar() {
		$links = array(
			'my-account' => array(
				'priority' => 10,
				'callback' => 'storefront_handheld_footer_bar_account_link',
			),
			'search'     => array(
				'priority' => 20,
				'callback' => 'storefront_handheld_footer_bar_search',
			),
			'cart'       => array(
				'priority' => 30,
				'callback' => 'storefront_handheld_footer_bar_cart_link',
			),
		);

		if ( wc_get_page_id( 'myaccount' ) === -1 ) {
			unset( $links['my-account'] );
		}

		if ( wc_get_page_id( 'cart' ) === -1 ) {
			unset( $links['cart'] );
		}

		$links = apply_filters( 'storefront_handheld_footer_bar_links', $links );
		?>
		<div class="storefront-handheld-footer-bar">
			<ul class="columns-<?php echo count( $links ); ?>">
				<?php foreach ( $links as $key => $link ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>">
						<?php
						if ( $link['callback'] ) {
							call_user_func( $link['callback'], $key, $link );
						}
						
						if($key=='search'){
						?> 
					<div class="site-search">
						<div class="widget woocommerce widget_product_search"><form role="search" method="get" class="woocommerce-product-search" action="/">
						<label class="screen-reader-text" for="woocommerce-product-search-field-1">Search for:</label>
						<input type="search" id="woocommerce-product-search-field-1" class="search-field" placeholder="Search products…" value="" name="s">
						<button type="submit" value="Search">Search</button>
						<input type="hidden" name="post_type" value="product">
						</form>
						</div>
					</div>
						<?php } ?>
					
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}
//Code for search in mobile


//Code for remove description heading from product details page
// Remove the product description Title
//add_filter( 'woocommerce_product_description_heading', '__return_null' );
//Code for remove description heading from product details page



//Code for remove category product counting
add_filter( 'woocommerce_subcategory_count_html', '__return_false' );
//Code for remove category product counting


//Code for + and - button on single product page
// Add this to your theme's functions.php
function kia_add_script_to_footer(){
    if( ! is_admin() ) { ?>
    <script>
		jQuery(document).ready(function ($) {
			$('body').on('click', '.minus', function (e) {
			var $inputQty = $(this).parent().find('input.qty');
			var val = parseInt($inputQty.val());
			var step = $inputQty.attr('step');
			step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
			if (val > 0) {
				$inputQty.val(val - step).change();
			}
		});
		$('body').on('click', '.plus', function (e) {
			var $inputQty = $(this).parent().find('input.qty');
			var val = parseInt($inputQty.val());
			var step = $inputQty.attr('step');
			step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
			$inputQty.val(val + step).change();
		});
	});
</script>
<?php }
}
add_action( 'wp_footer', 'kia_add_script_to_footer' );
//Code for + and - button on single product page


//Code for product added to cart message
add_filter( 'wc_add_to_cart_message_html', '__return_false' );
//Code for product added to cart message


//Code for Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
//Code for Remove the additional information tab


//Code for Remove titles from pages
add_filter('woocommerce_show_page_title', '__return_false');
//Code for Remove titles from pages



/* Code for Hide shipping rates when free shipping is available.
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();

	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}

	return ! empty( $free ) ? $free : $rates;
}

add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );
/* Code for Hide shipping rates when free shipping is available.
 */
 
 
 // add this to functions.php, a custom plugin, or a snippets plugin to remove the description tab in woocommerce
// by Robin Scott of Silicon Dales - full info at https://silicondales.com/tutorials/woocommerce-tutorials/remove-description-tab-woocommerce/
/*add_filter( 'woocommerce_product_tabs', 'sd_remove_product_tabs', 98 );
function sd_remove_product_tabs( $tabs ) {
 unset( $tabs['description'] );
 return $tabs;
}*/




//Code for show L,W and H on product details page
add_action( 'woocommerce_single_product_summary', 'display_hon_product_dimensions', 25 );
function display_hon_product_dimensions(){
global $product;
 
$dimensions = wc_format_dimensions($product->get_dimensions(false));
 
if ( $product->has_dimensions() ) {
 
echo '<div class="pdt-dimensions"><ul><li><strong>Length:</strong><span>' . $product->get_length() . get_option( 'woocommerce_dimension_unit' ).'</span></li>';
echo '<li><strong>Width:</strong><span>' . $product->get_width() . get_option( 'woocommerce_dimension_unit' ).'</span></li>';
echo '<li><strong>Height:</strong><span>' . $product->get_height() . get_option( 'woocommerce_dimension_unit' ).'</span></li>';

echo '</ul></div>';
}
}
//Code for show L,W and H on product details page



//Code for change Tabs name on product details page
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Capacity' );		// Rename the description tab
	//$tabs['reviews']['title'] = __( 'Ratings' );				// Rename the reviews tab
	//$tabs['additional_information']['title'] = __( 'Product Data' );	// Rename the additional information tab

	return $tabs;

}
//Code for change Tabs name on product details page


//Code for Add placeholder on checkout fields
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
 {
 unset($fields['billing']['billing_address_2']);
 //$fields['billing']['billing_company']['placeholder'] = 'Business Names';
 //$fields['billing']['billing_company']['label'] = 'Business Name';
 $fields['billing']['billing_first_name']['placeholder'] = 'First Name'; 
 $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
 $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';
 $fields['shipping']['shipping_company']['placeholder'] = 'Company Name'; 
 $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
 $fields['billing']['billing_email']['placeholder'] = 'Email Address ';
 $fields['billing']['billing_phone']['placeholder'] = 'Phone Number: Please add Country calling code: 254 with your phone number.';
 return $fields;
 }
//Code for Add placeholder on checkout fields




//Code for remove label from checkout fields
// WooCommerce Checkout Fields Hook
add_filter('woocommerce_checkout_fields','custom_wc_checkout_fields_no_label');

// Our hooked in function - $fields is passed via the filter!
// Action: remove label from $fields
function custom_wc_checkout_fields_no_label($fields) {
    // loop by category
    foreach ($fields as $category => $value) {
        // loop by fields
        foreach ($fields[$category] as $field => $property) {
            // remove label property
            unset($fields[$category][$field]['label']);
        }
    }
     return $fields;
}
//Code for remove label from checkout fields





//Code for change order of checkout field
 add_filter( 'woocommerce_default_address_fields', 'bbloomer_reorder_checkout_fields' );
 
function bbloomer_reorder_checkout_fields( $fields ) {
 
   // default priorities:
   // 'first_name' - 10
   // 'last_name' - 20
   // 'company' - 30
   // 'country' - 40
   // 'address_1' - 50
   // 'address_2' - 60
   // 'city' - 70
   // 'state' - 80
   // 'postcode' - 90
 
  // e.g. move 'company' above 'first_name':
  // just assign priority less than 10
  $fields['country']['priority'] = 95;
 
  return $fields;
}
//Code for change order of checkout field



//Code for Change the 'Billing details' checkout label to 'Shipping details'
function wc_billing_field_strings( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'Billing details' :
$translated_text = __( 'Shipping Details', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );
//Code for Change the 'Billing details' checkout label to 'Shipping details'



// Change number of related products output
function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 2 columns
	return $args;
}
// Change number of related products output





//Code for remove description tab
function tutsplus_remove_product_long_desc( $tabs ) {
 
    unset( $tabs['description'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'tutsplus_remove_product_long_desc', 98 );
//Code for remove description tab




//Code for show Description on after price
/*function tutsplus_remove_short_desc_product() {
     
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    add_action( 'woocommerce_single_product_summary', 'the_content', 20 );
     
}
add_action( 'init', 'tutsplus_remove_short_desc_product' );*/
//Code for show Description on after price


//Code for hide fields from shipping or click and collect
/*add_filter( 'woocommerce_checkout_fields' , 'quadlayers_remove_checkout_fields' ); 

function quadlayers_remove_checkout_fields( $fields ) { 

  //unset($fields['shipping_country']);
  unset($fields['shipping']['shipping_company']);
  unset($fields['shipping']['shipping_address_1']);
  unset($fields['shipping']['shipping_address_2']);
  unset($fields['shipping']['shipping_state']);
  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_email']);
  unset($fields['shipping']['shipping_city']);
  unset($fields['shipping']['shipping_country']);

return $fields; 

}*/
//Code for hide fields from shipping or click and collect



//code for phone and email field
/* Add additional shipping fields (email, phone) in FRONT END (i.e. My Account and Order Checkout) */
/* Note:  $fields keys (i.e. field names) must be in format: "shipping_" */
add_filter( 'woocommerce_shipping_fields' , 'my_additional_shipping_fields' );
function my_additional_shipping_fields( $fields ) {
    $fields['shipping_email'] = array(
        'label'         => __( 'Ship Email', 'woocommerce' ),
		 'placeholder'   => _x('Email', 'placeholder', 'woocommerce'),
        'required'      => false,
        'class'         => array( 'form-row-first' ),
        'validate'      => array( 'email' ),
    );
    $fields['shipping_phone'] = array(
        //'label'         => __( 'Ship Phone', 'woocommerce' ),
		'placeholder'   => _x('Phone', 'placeholder', 'woocommerce'),
        'required'      => true,
        'class'         => array( 'form-row-last' ),
        'clear'         => true,
        'validate'      => array( 'phone' ),
    );
    return $fields;
}
/* Display additional shipping fields (email, phone) in ADMIN area (i.e. Order display ) */
/* Note:  $fields keys (i.e. field names) must be in format:  WITHOUT the "shipping_" prefix (it's added by the code) */
add_filter( 'woocommerce_admin_shipping_fields' , 'my_additional_admin_shipping_fields' );
function my_additional_admin_shipping_fields( $fields ) {
        $fields['email'] = array(
            'label' => __( 'Order Ship Email', 'woocommerce' ),
        );
        $fields['phone'] = array(
            'label' => __( 'Order Ship Phone', 'woocommerce' ),
        );
        return $fields;
}
/* Display additional shipping fields (email, phone) in USER area (i.e. Admin User/Customer display ) */
/* Note:  $fields keys (i.e. field names) must be in format: shipping_ */
add_filter( 'woocommerce_customer_meta_fields' , 'my_additional_customer_meta_fields' );
function my_additional_customer_meta_fields( $fields ) {
        $fields['shipping']['fields']['shipping_phone'] = array(
            'label' => __( 'Telephone', 'woocommerce' ),
            'description' => '',
        );
        $fields['shipping']['fields']['shipping_email'] = array(
            'label' => __( 'Email', 'woocommerce' ),
            'description' => '',
        );
        return $fields;
}
/* Add CSS for ADMIN area so that the additional shipping fields (email, phone) display on left and right side of edit shipping details */
add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css() {
  echo '<style>
    #order_data .order_data_column ._shipping_email_field {
        clear: left;
        float: left;
    }
    #order_data .order_data_column ._shipping_phone_field {
        float: right;
    }
  </style>';
}

add_action( 'woocommerce_email_after_order_table', 'ts_email_phone_after_order_table', 10, 4 );
function ts_email_phone_after_order_table( $order, $sent_to_admin, $plain_text, $email ) {
        //echo '<h2>Additional information</h2>';
        //echo '<p><strong>'.__('Text').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_text', true ) . '</p>';
	//echo '<p><strong>'.__('Text Area').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_textarea', true ) . '</p>';
	//echo '<p><strong>'.__('Date').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_date', true ) . '</p>';
	echo '<p><strong>'.__('Email').':</strong> <br/>' . get_post_meta( $order->get_id(), '_shipping_email', true ) . '</p>';
	echo '<p><strong>'.__('Phone').':</strong> <br/>' . get_post_meta( $order->get_id(), '_shipping_phone', true ) . '</p>';
}
//code for phone and email field 







//Code for choose store
// Can be added to billing, shipping or order area. For the account page use the word account.
add_filter( 'woocommerce_checkout_fields', 'custom_fields_checkout' );
function custom_fields_checkout( $fields ) {
	
  
	

	// Added below the order notes area.
    $fields['shipping']['shipping_dropdown'] = array(
      'label' => 'Choose a store',
      'required' => true,
      'class' => array( 'form-row-wide' ),
      'priority' => 1,
      'type'  => 'select',
      'options'  	=> array( // options for <select> or <input type="radio" />
	      ''    		=> 'Please select a Store', // empty values means that field is not selected 
                      // 'value'=>'Name'
		            	'CBD'	=> 'CBD', 
			            'Garden City'	=> 'Garden City',
			            'Westgate'	=> 'Westgate',
						'Sarit Centre'	=> 'Sarit Centre',
						'Village Market'	=> 'Village Market'
					
		)
      
   );
   return $fields;	
	
}

 
// Save the custom checkout fields in the order meta, when checkbox has been checked
// https://stackoverflow.com/questions/12958193/show-custom-field-on-order-in-woocommerce
// NB! Use this instead: https://stackoverflow.com/questions/45905237/add-a-custom-checkbox-in-woocommerce-checkout-which-value-shows-in-admin-edit-or
// Custom fields that were added to the Order area will here be shown in the Billing area inside the WP backend WooCommerce -> Order and "Order Details" page.

add_action('woocommerce_checkout_update_order_meta','my_custom_checkout_field_update_order_meta');
function my_custom_checkout_field_update_order_meta($order_id) {
  	if ( ! empty( $_POST['shipping_dropdown'] ) )
        update_post_meta( $order_id, 'shipping_dropdown', $_POST['shipping_dropdown'] );
	
 }

	      
// Display the custom field result on the order edit page (backend) when checkbox has been checked
// https://stackoverflow.com/questions/45905237/add-a-custom-checkbox-in-woocommerce-checkout-which-value-shows-in-admin-edit-or

/* add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_custom_field_on_order_edit_pages', 10, 1 );
function display_custom_field_on_order_edit_pages( $order ){
    $shipping_dropdown = get_post_meta( $order->get_id(), 'shipping_dropdown', true );
    if( $shipping_dropdown == 1 )
        echo '<p><strong>Checkbox: </strong> <span style="color:red;">On</span></p>';
	
	$billing_checkbox2 = get_post_meta( $order->get_id(), 'billing_checkbox2', true );
    if( $billing_checkbox2 == 1 )
        echo '<p><strong>Checkbox 2: </strong> <span style="color:red;">Yes</span></p>';
}	  */     

 
// Display fields in the backend Order details screen.       
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'customfields_shipping_checkbox_checkout_display' );
function customfields_shipping_checkbox_checkout_display( $order ){
	//echo '<p><b>Text:</b> '      . get_post_meta( $order->get_id(), '_billing_text', true ) . '</p>';
	//echo '<p><b>Text Area:</b> '  . get_post_meta( $order->get_id(), '_billing_textarea', true ) . '</p>';
	//echo '<p><b>Date:</b> '      . get_post_meta( $order->get_id(), '_billing_date', true ) . '</p>';
	echo '<p><b>Store :</b> ' . get_post_meta( $order->get_id(), '_shipping_dropdown', true ) . '</p>';
}
	      
// Display fields in the admin and customer e-mails.  
// https://www.tychesoftwares.com/how-to-customize-woocommerce-order-emails/    	      
add_action( 'woocommerce_email_after_order_table', 'ts_email_after_order_table', 10, 4 );
function ts_email_after_order_table( $order, $sent_to_admin, $plain_text, $email ) {
        //echo '<h2>Additional information</h2>';
        //echo '<p><strong>'.__('Text').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_text', true ) . '</p>';
	//echo '<p><strong>'.__('Text Area').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_textarea', true ) . '</p>';
	//echo '<p><strong>'.__('Date').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_date', true ) . '</p>';
	echo '<p><strong>'.__('Store').':</strong> <br/>' . get_post_meta( $order->get_id(), '_shipping_dropdown', true ) . '</p>';
}
//Code for choose store

function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

add_action( 'woocommerce_after_checkout_form', 'bbloomer_disable_shipping_local_pickup' );
  
function bbloomer_disable_shipping_local_pickup( $available_gateways ) {
    
   // Part 1: Hide shipping based on the static choice @ Cart
   // Note: "#customer_details .col-2" strictly depends on your theme
 
   $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
   $chosen_shipping = $chosen_methods[0];
   
   if ( 0 === strpos( $chosen_shipping, 'local_pickup' ) ) {
   ?>
     
   <?php  
   } 
  ?>
    <script type="text/javascript">
	
	jQuery('.woocommerce-shipping-methods').hide();
          jQuery('#shipping_method_0_flat_rate1').hide();
					 jQuery('#shipping_method_0_local_pickup4').hide();
					 jQuery('#shipping_method').hide();
      </script>
      <script type="text/javascript">
         jQuery('form.checkout').on('change','input[name^="shipping_method[0]"]',function() {
            var val = jQuery( this ).val();
			//alert(val);
            if (val.match("^local_pickup")) {
				 alert('in local pickup');
                     jQuery('#div_shipping_address').fadeIn();
					 jQuery('#div_billing_address').fadeOut();
					 jQuery('#shipping_method_0_flat_rate1').hide();
					 jQuery('#shipping_method_0_local_pickup4').show();
					 jQuery('#show_before').hide();
					 //jQuery('#show_before_flat').hide();
					 //jQuery('#show_before_local').show();
				} 
			   
			if (val.match("^flat_rate")) {
					 alert('in flat rate');
                    jQuery('#div_billing_address').fadeIn();
			        jQuery('#div_shipping_address').fadeOut();
					jQuery('#shipping_method_0_local_pickup4').hide();
					jQuery('#shipping_method_0_flat_rate1').show();
					jQuery('#show_before').hide();
					//jQuery('#show_before_local').hide();
					//jQuery('#show_before_flat').show();
			}
			   //else {
               //jQuery('#div_billing_address').fadeIn();
			    //jQuery('#div_shipping_address').fadeOut();
				//$('#shipping_method_0_flat_rate_1').attr("checked", "checked");
				//if($('#shipping_method_0_flat_rate_1').is(':checked')) { 
					              //alert("it's checked"); 
								  //$('#shipping_method_0_flat_rate1').attr("checked", "checked");
								  //}
				
				
            //}
         });
		 
		
      </script>
   <?php
   }
   
   // define the woocommerce_review_order_before_submit callback 
function custom_woocommerce_review_order_before_submit(){ 

$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
   $chosen_shipping = $chosen_methods[0];
   
   if ( 0 === strpos( $chosen_shipping, 'local_pickup' ) ) {
   ?>
    <script>
     jQuery('#show_before').hide();
	jQuery('#show_before_local').show();
					jQuery('#show_before_flat').hide();</script>
   <?php  
   }

   elseif(0 === strpos( $chosen_shipping, 'flat_rate' ) ){ ?>
	    <script>
       jQuery('#show_before').hide();
	jQuery('#show_before_local').hide();
					jQuery('#show_before_flat').show();</script>
	<?php				
   }	   
   else {
  
 
								if(WC()->cart->get_displayed_subtotal() <= 5000.00){
				                       echo "Flat rate: KSh 500.00";
			                        }
			                   else {
				                      echo "Click and Collect";
			                        }
   }						
} 

//add the action 
add_action('woocommerce_review_order_after_submit', 'custom_woocommerce_review_order_before_submit');
   //add_filter( 'woocommerce_shipping_chosen_method', '__return_false', 99));
   
   
   
   
   
 //Code for password lenght 
 /*  function change_pie_password_strength(){
	return 'minSize[6]';
}
add_filter( 'pie_password_strength_length', 'change_pie_password_strength' ); */



add_action('woocommerce_process_registration_errors', 'validatePasswordReg', 10, 2 );
 
function validatePasswordReg( $errors, $user ) {
    // change value here to set minimum required password chars
    if(strlen($_POST['password']) < 7  ) {
        $errors->add( 'woocommerce_password_error', __( 'Password must be at least 8 characters long.' ) );
    }
    // adding ability to set maximum allowed password chars — uncomment the following two (2) lines to enable that
    //elseif (strlen($_POST['password']) > 16 )
        //$errors->add( 'woocommerce_password_error', __( 'Password must be shorter than 16 characters.' ) );
    return $errors;
    }
 
add_action('woocommerce_save_account_details_errors', 'validateProfileUpdate', 10, 2 );
 
function validateProfileUpdate( $errors, $user ) {
    // change value here to set minimum required password chars
    if(strlen($_POST['password_2']) < 7  ) {
        $errors->add( 'woocommerce_password_error', __( 'Password must be at least 8 characters long.' ) );
    }
    // adding ability to set maximum allowed password chars — uncomment the following two (2) lines to enable that
    //elseif (strlen($_POST['password_2']) > 16 )
        //$errors->add( 'woocommerce_password_error', __( 'Password must be shorter than 16 characters.' ) );
    return $errors;
    }
 
add_action('woocommerce_password_reset', 'validatePasswordReset', 10, 2 );
 
function validatePasswordReset( $errors, $user ) {
    // change value here to set minimum required password chars — uncomment the following two (2) lines to enable that
    if(strlen($_POST['password_3']) < 7  ) {
        $errors->add( 'woocommerce_password_error', __( 'Password must be at least 8 characters long.' ) );
    }
    // adding ability to set maximum allowed password chars — uncomment the following two (2) lines to enable that
    //elseif (strlen($_POST['password_3']) > 16 )
        //$errors->add( 'woocommerce_password_error', __( 'Password must be shorter than 16 characters.' ) );
    return $errors;
    }
 
 
add_action( 'woocommerce_after_checkout_validation', 'minPassCharsCheckout', 10, 2 );
function minPassCharsCheckout( $user ) {
    // change value here to set minimum required password chars on checkout page account registration
    if ( strlen( $_POST['account_password'] ) < 7  ) {
        wc_add_notice( __( 'Password must be at least 8 characters long.', 'woocommerce' ), 'error' );
    }
}
   
   
   
   
 // Second, change the wording of the password hint.
add_filter( 'password_hint', 'smarter_password_hint' );
function smarter_password_hint ( $hint ) {
    $hint = 'Hint: The password should be at least eight characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).';
    return $hint;
}

  
   
//Code for Day part dropdown on checkout
//* Add select field to the checkout page
/*add_action('woocommerce_before_order_notes', 'wps_add_select_checkout_field');
function wps_add_select_checkout_field( $checkout ) {

	echo '<h2>'.__('Next Day Delivery').'</h2>';

	woocommerce_form_field( 'daypart', array(
	    'type'          => 'select',
	    'class'         => array( 'wps-drop' ),
	    'label'         => __( 'Delivery options' ),
	    'options'       => array(
	    	'blank'		=> __( 'Select a day part', 'wps' ),
	        'morning'	=> __( 'In the morning', 'wps' ),
	        'afternoon'	=> __( 'In the afternoon', 'wps' ),
	        'evening' 	=> __( 'In the evening', 'wps' )
	    )
 ),

	$checkout->get_value( 'daypart' ));

}





//* Do NOT include the opening php tag shown above. Copy the code shown below.

//* Process the checkout
 add_action('woocommerce_checkout_process', 'wps_select_checkout_field_process');
 function wps_select_checkout_field_process() {
    global $woocommerce;

    // Check if set, if its not set add an error.
    if ($_POST['daypart'] == "blank")
     wc_add_notice( '<strong>Please select a day part under Delivery options</strong>', 'error' );

 }





//* Update the order meta with field value
 add_action('woocommerce_checkout_update_order_meta', 'wps_select_checkout_field_update_order_meta');
 function wps_select_checkout_field_update_order_meta( $order_id ) {

   if ($_POST['daypart']) update_post_meta( $order_id, 'daypart', esc_attr($_POST['daypart']));

 } 
 
 
 
 
 //* Display field value on the order edition page
add_action( 'woocommerce_admin_order_data_after_billing_address', 'wps_select_checkout_field_display_admin_order_meta', 10, 1 );
function wps_select_checkout_field_display_admin_order_meta($order){

	echo '<p><strong>'.__('Delivery option').':</strong> ' . get_post_meta( $order->id, 'daypart', true ) . '</p>';

}

//* Add selection field value to emails
add_filter('woocommerce_email_order_meta_keys', 'wps_select_order_meta_keys');
function wps_select_order_meta_keys( $keys ) {

	$keys['Daypart:'] = 'daypart';
	return $keys;
	
}
