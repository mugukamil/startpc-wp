<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package veartix
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<main id="main">
      <?php putRevSlider("hp_slider", "homepage") ?>
      <div class="categories">
        <?php 

        $categories = get_terms('product_cat');
        if ($categories) {
          foreach ($categories as $category) {
            $display_on_home_page = get_field('display_on_home_page', $category->taxonomy.'_'.$category->term_id);
             if ($display_on_home_page) {
              if (count($display_on_home_page) > 1) {
                $cat_thumb_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
                $cat_thumb_url = wp_get_attachment_thumb_url( $cat_thumb_id );
                $category_link = get_term_link( $category );

         ?>
           <a href="<?php echo $category_link ?>" tabindex="0" class="category category--big">
             <figure><img src="<?php echo $cat_thumb_url ?>" alt="<?php echo $category->name ?>" class="category--big__img">
               <figcaption class="category--big__txt">
                 <p><?php echo $category->name ?></p>
               </figcaption>
             </figure>
           </a>
          <?php } } } } ?>
         

        <div class="categories__flex-wrapper">
          <div class="categories__flex-container">
          <?php
            if ($categories) {
              foreach ($categories as $category) {
                $display_on_home_page = get_field('display_on_home_page', $category->taxonomy.'_'.$category->term_id);
                if ($display_on_home_page) {
                  if (count($display_on_home_page) == 1) {
                    $cat_thumb_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
                    $cat_thumb_url = wp_get_attachment_thumb_url( $cat_thumb_id );
                    $category_link = get_term_link( $category );
              ?>
              <a href="<?php echo $category_link ?>" tabindex="0" class="category category--small">
                <figure><img src="<?php echo $cat_thumb_url ?>" alt="<?php echo $category->name ?>" class="category--small__img">
                  <figcaption class="category--small__txt">
                    <p><?php echo $category->name ?></p>
                  </figcaption>
                </figure>
              </a>
              <?php } } } } ?>
          </div>
        </div>
      </div>
    </main>

<?php get_footer(); ?>
