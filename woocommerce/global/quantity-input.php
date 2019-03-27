<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	?>
	<div class="input-plus-minus quantity">
		<button type="button" data-type="plus" aria-label="increase quantity by 1" class="btn-number"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px"><path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M15.000,7.994 L7.994,7.994 L7.994,15.000 L7.006,15.000 L7.006,7.994 L-0.000,7.994 L-0.000,7.006 L7.006,7.006 L7.006,-0.000 L7.994,-0.000 L7.994,7.006 L15.000,7.006 L15.000,7.994 Z"></path></svg></button>
		<input type="text" value="<?php echo esc_attr( $input_value ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( 0 < $max_value ? $max_value : 100 ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-number" name="<?php echo esc_attr( $input_name ); ?>" aria-labelledby="<?php echo ! empty( $args['product_name'] ) ? sprintf( esc_attr__( '%s quantity', 'woocommerce' ), $args['product_name'] ) : ''; ?>">
		<button type="button" data-type="minus" aria-label="decrease quantity by 1" class="btn-number"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="1px"><path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M0.000,0.994 L0.000,0.006 L15.000,0.006 L15.000,0.994 L0.000,0.994 Z"></path></svg></button>
	</div>
 <?php
	}
