<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<div class="site-elements__tabs product-page__tabs" role="tablist">
			<?php $i = 0; ?>
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<?php $i++; ?>
				<div class="<?php echo esc_attr( $key ); ?>_tab site-elements__tab <?php echo $i == 1 ? 'site-elements__tab--active' : '' ?> " id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>" class="js-tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="tabs-content">
		<?php $i = 0; ?>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<?php $i++; ?>
			<div class="product__tab-content <?php echo $i == 1 ? 'product__tab-content--visible' : '' ?>" id="tab-<?php echo $key; ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php if ($key == "additional_information") : ?> 
					<div class="product__cols">
						<div class="product__col">
							<div class="product__table">
								<?php 
									if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } 
								?>
							</div>
						</div>
					</div>
					
				<?php else: ?>
					<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>
