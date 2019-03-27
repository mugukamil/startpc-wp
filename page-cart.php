<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package veartix
 */

get_header('shop');

$container   = get_theme_mod( 'understrap_container_type' );

?>

<div id="main" class="simple-page cart-page">
	<div class="container">
		<div class="simple-page__header">
			<?php the_title( '<h1 class="simple-page__title"><span>', '</span></h1>' ); ?>
        </div>

		<main class="cart-page__main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'loop-templates/content', 'cart' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->

	</div><!-- Container end -->
</div>


<?php get_footer('shop'); ?>
