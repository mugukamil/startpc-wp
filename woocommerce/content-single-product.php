<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div class="product single" id="product-<?php the_ID(); ?>" <?php post_class(); ?> class="product">
	<?php woocommerce_breadcrumb(array(
		'home' => false,
		'before' => '<li class="breadcrumbs__item">',
		'after' => '</li>',
		'wrap_before' => '<ul class="product-page__breadcrumbs breadcrumbs" itemprop="breadcrumb">',
		'wrap_after'  => '</ul>',
		'delimiter' => false
	)); ?>

<div class="product__cols">
	
	<div class="product__col">
		<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>
	<div class="product__col">
		<?php
			/**
			 * Hook: Woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
		<div class="product__table">
			<table>
				<tbody>
					<?php 
						$warranty = get_field('product_warranty');
						$delivery = get_field('delivery_time');
						$site = get_field('manufacturer_site');
					?>
					<?php if ($warranty): ?>
					<tr>
						<th><?php _e('אחריות:', 'understrap') ?></th>
						<td class="dir-rtl medium-pd"><?php echo $warranty ?></td>
					</tr>
					<?php endif; ?>
					<?php if ($delivery): ?>
					<tr>
						<th><?php _e('זמן משלוח:', 'understrap') ?></th>
						<td class="dir-rtl medium-pd"><?php echo $delivery ?></td>
					</tr>
					<?php endif; ?>
					<?php if ($site): ?>
					<tr>
						<th><?php _e('אתר היצרן:', 'understrap') ?></th>
						<td class="dir-rtl medium-pd"><a href="<?php echo $site ?>"><?php echo $site; ?></a></td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div> <!-- /.product__table -->
	</div>
</div>

<div class="product__info">
	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
