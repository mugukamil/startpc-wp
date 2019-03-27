<?php
/**
 * Check and setup theme's default settings
 *
 * @package veartix
 *
 */

if ( ! function_exists( 'understrap_setup_theme_default_settings' ) ) :
	function understrap_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$understrap_posts_index_style = get_theme_mod( 'understrap_posts_index_style' );
		if ( '' == $understrap_posts_index_style ) {
			set_theme_mod( 'understrap_posts_index_style', 'default' );
		}

		// Sidebar position.
		$understrap_sidebar_position = get_theme_mod( 'understrap_sidebar_position' );
		if ( '' == $understrap_sidebar_position ) {
			set_theme_mod( 'understrap_sidebar_position', 'right' );
		}

		// Container width.
		$understrap_container_type = get_theme_mod( 'understrap_container_type' );
		if ( '' == $understrap_container_type ) {
			set_theme_mod( 'understrap_container_type', 'container' );
		}
	}
endif;

function veartix_get_subcats($term_id) {
  $subcategories = get_term_children( $term_id, 'product_cat' );
  $sub_names = "";
  $last_subcat = end($subcategories);
  foreach ($subcategories as $subcategory) {
    $subcat = get_term( $subcategory, 'product_cat' );
    $sub_names .= $subcat->name;
    if ($last_subcat !== $subcategory) {
      $sub_names .= ',';
    }
  }

  return $sub_names;
}

function veartix_calculator_categories( $args = array() ) {
  $terms = get_terms( 'product_cat', array() );

  if ( $terms ):
    foreach ( $terms as $term ):
      $term_id = $term->term_id;
      if (get_field('show_in_calculator_sidebar', $term->taxonomy.'_'.$term_id)) :
        $sub_names = veartix_get_subcats($term_id);
        $isReq = get_field('required_for_calculator', $term->taxonomy.'_'.$term_id);
      ?>

    <div data-cid="<?php echo $term_id; ?>" data-subcategories="<?php echo $sub_names; ?>" data-compulsory="<?php echo $isReq; ?>" class="calculator__cat calculator__cat--closed">
      <table class="calc-sidebar__table">
        <caption><?php echo $term->name; ?> <?php echo ($isReq ? '<span>*</span>' : '' ) ?></caption>
        <tr class="calc-sidebar__t-header">
          <th>דגם</th>
          <th>כמות</th>
          <th>מחיר</th>
        </tr>
      </table>
    </div>

  <?php endif; endforeach; endif;
  }

add_action( 'veartix_calc_categories', 'veartix_calculator_categories');


if (!function_exists('veartix_product_subcategories')) {
  function veartix_product_subcategories($args = array()) {
    $args = array(
      'parent' => 0,
    );

    $terms = get_terms('product_cat', $args);

    if ($terms) {

      echo '<div class="catalog__tabs">';

      foreach ($terms as $term) {
        echo '<a href="' . esc_url(get_term_link($term)) . '" class="catalog__tab ' . $term->slug . '" data-catslug="'.$term->slug.'"><div class="catalog__tab-flex">';
        woocommerce_subcategory_thumbnail($term);

        echo '<h2>';
        echo $term->name;
        echo '</h2>';

        echo '</div></a>';

      }

      echo '</div>';
    }
  }

  add_action('veartix_categories', 'veartix_product_subcategories');
}

function veartix_mega_menu_shortcode($atts) {
  ob_start();
  ?>
  <?php

  $terms = get_terms( 'product_cat' );

  if ($terms):
    foreach ($terms as $term):
      if (get_field('show_in_header_mega_menu', $term->taxonomy.'_'.$term->term_id)):
        $cat_thumb_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
        $cat_thumb_url = wp_get_attachment_thumb_url( $cat_thumb_id );
        $term_link = get_term_link( $term );
        ?>
        <li class="mega-menu__column">
            <a href="<?php echo $term_link; ?>" class="mega-menu__header"><p class="mega-menu__title"><?php echo $term->name; ?></p><img src="<?php echo $cat_thumb_url; ?>" alt="מחשבי גיימינג" class="mega-menu__img"></a>
            <ul class="mega-menu__links">
              <?php
              $subcats = get_categories(
                array('child_of' => $term->term_id, 'taxonomy' => 'product_cat')
              );
              foreach ($subcats as $subcat): ?>
              <li class="mega-menu__link">
                <a href="<?php echo get_category_link($subcat->term_id) ?>">
                  <?php echo $subcat->name; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
      </li>
    <?php endif; endforeach; endif;

                      // Reset the `$post` data to the current post in main query.
    wp_reset_postdata(); 
    return ob_get_clean();
  }

add_shortcode( 'veartix_mega_menu', 'veartix_mega_menu_shortcode' );

function veartix_calculator_subcategories( $args = array() ) {
  $terms = get_terms( 'product_cat', array() );
  if ( $terms && ! is_wp_error( $terms) ) {
    echo '<li><button data-tab="all" class="calc-content__tabs__btn calc-content__tabs__btn--active">הצג הכל</button></li>';

    foreach ($terms as $term) {
      if (get_field('show_in_calculator_sidebar', $term->taxonomy.'_'.$term->term_id)) {
        $subcategories = get_term_children( $term->term_id, 'product_cat' );
        foreach ($subcategories as $subcategory) {
          $subcat = get_term( $subcategory, 'product_cat' );
          $subcat_name = strtolower($subcat->name);
          echo '<li>';
          echo "<button data-tab='$subcat_name' class='calc-content__tabs__btn'>";
          echo $subcat->name;
          echo '</button>';
          echo '</li>';
        }
      }
    }

  }
}

add_action( 'veartix_calc_subcategories', 'veartix_calculator_subcategories');


function contact_send_message() {
    $contact_errors = false;

    // get the posted data
    $contact_fullname = $_POST["contact_fullname"];
    $contact_email = $_POST["contact_email"];
    $contact_phone = $_POST["contact_phone"];
    $contact_message = $_POST["contact_message"];
    
    $contact_address = $_POST['contact_address'];
    $contact_repair = $_POST['contact_repair'];
    
    // write the email content
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/html; charset=utf-8\n";
    $header .= "From:" . $contact_email;


    $message = "Name: $contact_fullname <br>";
    $message .= "Email Address: $contact_email <br>";
    $message .= "Phone: $contact_phone <br>";
    $message .= "Address: $contact_address <br>";
    $message .= "Repair: $contact_repair <br>";
    $message .= "Message: $contact_message <br>";
    if (isset($_POST['repair_delivery'])) {
      $repair_delivery = $_POST['repair_delivery'];
      $message .= "Repair Delivery: $repair_delivery <br>";
    }
    if (isset($_POST['repair_apply'])) {
      $repair_apply = $_POST['repair_apply'];
      $message .= "Repair Apply: $repair_apply <br>";
    }
    if (isset($_POST['contact_os'])) {
      $contact_os = $_POST['contact_os'];
      $message .= "Operating System: $contact_os <br>";
    }
    if (isset($_POST['contact_problem'])) {
      $contact_problem = $_POST['contact_problem'];
      $message .= "Problem: $contact_problem <br>";
    }
    if (isset($_POST['contact_problem'])) {
      $contact_problem = $_POST['contact_problem'];
      $message .= "Problem: $contact_problem <br>";
    }

    $subject = "Contact Page Form";

    $to = get_option('admin_email');

    // send the email using wp_mail()
    if ( !wp_mail($to, $subject, $message, $header) ) {
        $contact_errors = true;
    }

}
add_action('contact_send_message', 'contact_send_message');

function remove_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');