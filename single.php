<?php
/**
 * The template for displaying all single posts.
 *
 * @package veartix
 */

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
?>

<div class="article-page">
      <div class="container container--small">
        <main id="main" class="article-page__main">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'single' ); ?>

						<?php understrap_post_nav(); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>
        </main>
      </div>
    </div>

<?php get_footer(); ?>
