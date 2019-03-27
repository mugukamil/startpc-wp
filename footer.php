<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package veartix
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_sidebar( 'footerfull' ); ?>

<footer class="site-footer"><a href="#0" class="cd-top cd-is-visible">Scroll to top<i aria-hidden="true" class="fa fa-chevron-up"></i></a>
  <div class="container">
    <!-- The WordPress Menu STARTS here -->
    <?php 
    wp_nav_menu(
      array(
        'theme_location'  => 'footer',
        'container_class' => 'site-footer__menu footer-menu',
        'container_id'    => '',
        'menu_class'      => 'footer-menu__list',
        'fallback_cb'     => '',
        'menu_id'         => '',
      ) );

    ?>
    <!-- The WordPress Menu ENDS here -->

    <div class="site-footer__copyright"><a href=""><span class="site-footer__copyright-text">UI & Graphics by</span><img src="<?php echo get_template_directory_uri() ?>/img/veartix.png" alt="veartix" class="site-footer__copyright-img"></a></div>
  </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
<script>
  WebFont.load(
  {
    google:
    {
      families: ['Arimo:400,700:latin,hebrew', 'Heebo:hebrew', 'Roboto']
    }
  });

</script>

<?php wp_footer(); ?>

</body>
</html>

