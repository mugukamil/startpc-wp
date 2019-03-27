<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<span class="woocommerce-checkout-review-order-table">
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<span>תשלומים (<?php wc_cart_totals_fee_html( $fee ); ?> עמלה)</span>
		<?php endforeach; ?>
		<!-- <span style="display: none"> -->
		<!-- </span> -->
		<span class="js-updated-price" style="display: none">
			<?php echo WC()->cart->total; ?>
		</span>
		<script>

			$(".cart-form__commission-select").on("change", function(e) {
			  var $monthlyPrice = $(".js-checkout-monthly-price").find(
			    ".woocommerce-Price-amount"
			  );
			  $monthlyPrice[0].lastChild.textContent =
			    Math.round($('.js-subtotal').val() /
			    $(this)
			      .find(":selected")
			      .text());
			});

			var $jsUpdatedPrice = $('.js-updated-price');
			var $jsCheckoutTotalPrice = $('.js-checkout-total-price');

			$jsCheckoutTotalPrice.text("₪" + $jsUpdatedPrice.text());
		</script>
</span>
