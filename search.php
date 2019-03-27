<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header( 'shop' );
?>
<div class="search-page woocommerce woocommerce-page">
	<div class="container">
		<div class="search-page__header">
			<p class="search-page__result"><?php printf(
				/* translators:*/
				esc_html__( 'Search Results for: %s', 'understrap' ),
				'<span>' . get_search_query() . '</span>' ); ?>
			</p>
		</div>
		<main class="search-page__main main">
			<aside class="site-sidebar search-sidebar sidebar sticky">
				<?php dynamic_sidebar( 'right-sidebar' ); ?>
			</aside>
			<div class="calculator__content calc-content search-page__content calc-content">
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
						<!-- <div class="calc-content__filter">
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
							</div> -->
							<div class="calc-content__shows">
								<button aria-label="grid view" class="calc-content__show active js-show-grid">
									<svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><path fill="#909090" d="M0 31V0h31v31z"></path><path fill="#fff" d="M13 18v-5h5v5zM13 26v-5h5v5zM13 10V5h5v5zM21 18v-5h5v5zM21 26v-5h5v5zM21 10V5h5v5zM5 18v-5h5v5zM5 26v-5h5v5zM5 10V5h5v5z"></path></svg>
								</button>
								<button aria-label="list view" class="calc-content__show js-show-list">
									<svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><path fill="#909090" d="M0 31V0h31v31z"></path><path fill="#fff" d="M5 10V5h21v5zM5 18v-5h21v5zM5 26v-5h21v5z"></path></svg>
								</button>
							</div> <!-- /.calc-content__shows -->
						</div> <!-- /.calc-content__header -->
						<div class="calc-content__products calc-products">
						<?php if ( have_posts() ) : ?>

							<?php while ( have_posts() ) : the_post(); ?>

								<?php
								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'loop-templates/content', 'search' );
								?>

							<?php endwhile; ?>

						<?php else : ?>

							<?php get_template_part( 'loop-templates/content', 'none' ); ?>

						<?php endif; ?>
						</div>
					</div> <!-- /.calc-content__in -->
				</div> <!-- /.calc-content -->
			</main>
	</div> <!-- /.container -->
</div> <!-- /.search -->

<?php
/**
* Hook: woocommerce_after_main_content.
*
* @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
*/
do_action( 'woocommerce_after_main_content' );
get_footer('shop');

