<?php
/**
* The Template for displaying product archives, including the main shop page which is a post type archive
*
* This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
get_header( 'shop' );
/**
* Hook: woocommerce_before_main_content.
*
* @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
* @hooked woocommerce_breadcrumb - 20
* @hooked WC_Structured_Data::generate_website_data() - 30
*/
do_action( 'woocommerce_before_main_content' );
?>
<header class="woocommerce-products-header">
	<div class="catalog__header">
	<?php 
		do_action( 'veartix_categories' );

	 ?>
	</div>
</header>
<main class="catalog__main main">

<aside class="site-sidebar catalog-sidebar sidebar sticky">
	<?php dynamic_sidebar( 'right-sidebar' ); ?>
</aside>
<div class="calculator__content calc-content">
	<?php if ( have_posts() ) {?>
	<div class="calc-content__in">
		<div class="calc-content__header">
			<div class="calc-content__form-wrapper">
				<a role="button" title="show sidebar" class="js-show-sidebar"><i aria-controls="navigation" aria-expanded="false" role="img" class="fa fa-times"></i><span aria-controls="navigation" aria-expanded="true" role="img" class="hamlines"></span></a>
			<div class="calc-content__search">
				<div class="calc-content__search-container">
					<?php echo do_shortcode( '[aws_search_form]', false ); ?>
				</div>
			</div>
		</div>
		<div class="calc-content__filter">
			<p class="calc-content__filter-text">סינון לפי</p>
			<?php 
			
				/**
				* Hook: woocommerce_before_shop_loop.
				*
				* @hooked wc_print_notices - 10
				* @hooked woocommerce_result_count - 20
				* @hooked woocommerce_catalog_ordering - 30
				*/

				do_action( 'woocommerce_before_shop_loop' );

			 ?>
		</div>
	<div class="calc-content__shows"><button aria-label="grid view" class="calc-content__show active js-show-grid"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><path fill="#909090" d="M0 31V0h31v31z"></path><path fill="#fff" d="M13 18v-5h5v5zM13 26v-5h5v5zM13 10V5h5v5zM21 18v-5h5v5zM21 26v-5h5v5zM21 10V5h5v5zM5 18v-5h5v5zM5 26v-5h5v5zM5 10V5h5v5z"></path></svg></button>
<button aria-label="list view" class="calc-content__show js-show-list"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><path fill="#909090" d="M0 31V0h31v31z"></path><path fill="#fff" d="M5 10V5h21v5zM5 18v-5h21v5zM5 26v-5h21v5z"></path></svg></button>
</div>
</div> <!-- /.calc-content__header -->
<!-- WOOCOMMERCE LOOP -->
<?php
	woocommerce_product_loop_start();
	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();
			/**
			* Hook: woocommerce_shop_loop.
			*
			* @hooked WC_Structured_Data::generate_product_data() - 10
			*/
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		}
	}
	woocommerce_product_loop_end();
} else {
	/**
	* Hook: woocommerce_no_products_found.
	*
	* @hooked wc_no_products_found - 10
	*/
	do_action( 'woocommerce_no_products_found' );
}
?>
</div> <!-- /.calc-content__in -->
</div> <!-- /.calc-content -->
</main>
<?php
/**
* Hook: woocommerce_after_main_content.
*
* @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
*/
do_action( 'woocommerce_after_main_content' );
/**
* Hook: woocommerce_sidebar.
*
* @hooked woocommerce_get_sidebar - 10
*/
do_action( 'woocommerce_sidebar' );
get_footer( 'shop' );