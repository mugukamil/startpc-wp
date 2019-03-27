<?php /* Template Name: Calculator Page Template */  

global $catalog_orderby_options;

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
  <div class="calculator__recommendations">
    <?php 
      $rec_text = get_field('recommendation_block_text');
      if ($rec_text): 
    ?>
      <p><?php echo $rec_text; ?></p>
    <?php endif; ?>
    <?php 
      $rec_link = get_field('recommendation_block_link');
      if ($rec_link): 
    ?>
      <a href="<?php echo $rec_link; ?>" target="_blank">המומלצים שלנו</a>
    <?php endif; ?>
  </div>
  <div class="calculator__header">
    <p class="calculator__title"><?php the_title(); ?></p>
    <p class="calculator__sub">
      <?php 
      $help_info = get_field('calc_help_info');
      if ($help_info) {
        echo $help_info;
      } ?>
    </p>
  </div>
</header>
<main class="calculator__main main">
  <aside class="site-sidebar calc-sidebar sidebar sticky">
    <?php do_action('veartix_calc_categories'); ?>
    <div class="calculator__cat calculator__cat--closed calculator__cat--checkbox">
      <input id="water-cooling" type="checkbox" name="calculator-water-cooling" class="custom-checkbox__input js-checkbox-diff-name">
      <label for="water-cooling" tabindex="0" class="custom-checkbox__label">
        <span tabindex="0" class="custom-checkbox__icon custom-checkbox__icon--small"></span><strong>קירור מים</strong><span> - תוספת המחיר תמסר בטלפון</span>
      </label>
    </div>
    <div class="calc-sidebar__required-text">
      <p>* רכיבים שחובה לבחור</p>
    </div>
    <div class="calc-sidebar__price">
      <p>סה”כ:&nbsp;<span>₪</span><span id="js-total-price">0</span></p>
    </div>
    <div class="calc-sidebar__cart"><a href="?add-to-cart=" class="js-add-to-cart">הוסף לסל הקניות שלך</a></div>
    <ul class="calc-sidebar__share">
      <li><a href="" class="calc-sidebar__share-link"><i aria-hidden="true" class="share-icon share-icon--html"></i><span>HTML</span></a></li>
      <li><a href="" class="calc-sidebar__share-link js-print"><i aria-hidden="true" class="share-icon share-icon--pdf"></i><span>PDF</span></a></li>
      <li><a href="" class="calc-sidebar__share-link"><i aria-hidden="true" class="share-icon share-icon--fb"></i><span>Facebook</span></a></li>
    </ul>
    <hr class="calc-sidebar__hr">
    <p class="calc-sidebar__delivery">זמן אספקה: עד 7 ימי עבודה.</p>

  </aside>
  <div class="calculator__content calc-content">
   <ul class="calc-content__tabs calc-content__tabs--inactive">
    <?php do_action('veartix_calc_subcategories'); ?>
   </ul>
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
          $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => __( 'Default sorting', 'woocommerce' ),
            'popularity' => __( 'Sort by popularity', 'woocommerce' ),
            'rating'     => __( 'Sort by average rating', 'woocommerce' ),
            'date'       => __( 'Sort by newness', 'woocommerce' ),
            'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
            'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
          ) );
          ?>
          <form class="woo-ordering" method="get">
              <select title="filter dropdown" class="calc-content__filter-dropdown orderby" name="orderby">
                  <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                  <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
                  <?php endforeach; ?>
              </select>
              <input type="hidden" name="paged" value="1" />
          </form>
      </div>
      <div class="calc-content__shows"><button aria-label="grid view" class="calc-content__show active js-show-grid"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><path fill="#909090" d="M0 31V0h31v31z"></path><path fill="#fff" d="M13 18v-5h5v5zM13 26v-5h5v5zM13 10V5h5v5zM21 18v-5h5v5zM21 26v-5h5v5zM21 10V5h5v5zM5 18v-5h5v5zM5 26v-5h5v5zM5 10V5h5v5z"></path></svg></button>
        <button aria-label="list view" class="calc-content__show js-show-list"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><path fill="#909090" d="M0 31V0h31v31z"></path><path fill="#fff" d="M5 10V5h21v5zM5 18v-5h21v5zM5 26v-5h21v5z"></path></svg></button>
      </div>
    </div> <!-- /.calc-content__header -->
    <?php 
    wp_reset_query();
    $orderby = '';

    if ( ! $orderby ) {
      $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( (string) wp_unslash( $_GET['orderby'] ) ) : ''; // WPCS: sanitization ok, input var ok.

      if ( ! $orderby_value ) {
        $orderby_value = apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
      }

      // Get order + orderby args from string.
      $orderby_value = explode( '-', $orderby_value );
      $orderby       = esc_attr( $orderby_value[0] );
      $order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
    }

    $orderby = strtolower( $orderby );
    $order   = strtoupper( $order );
    $args    = array(
      'post_type' => 'product',
      'posts_per_page' => -1,
      'orderby'  => $orderby,
      'order'    => ( 'DESC' === $order ) ? 'DESC' : 'ASC',
      'meta_key' => '', // @codingStandardsIgnoreLine
    );

    switch ( $orderby ) {
      case 'menu_order':
        $args['orderby']  = 'menu_order title';
        break;
      case 'title':
        $args['orderby'] = 'title';
        $args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
        break;
      case 'relevance':
        $args['orderby'] = 'relevance';
        $args['order']   = 'DESC';
        break;
      case 'rand':
        $args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
        break;
      case 'date':
        $args['orderby'] = 'date ID';
        $args['order']   = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
        break;
      case 'price':
          $args['orderby'] = 'meta_value_num';
          $args['meta_key'] = '_price'; // @codingStandardsIgnoreLine
          $args['order'] = 'asc'; // @codingStandardsIgnoreLine
        break;
      case 'price-desc':
          $args['orderby'] = 'meta_value_num';
          $args['meta_key'] = '_price'; // @codingStandardsIgnoreLine
          $args['order'] = 'desc'; // @codingStandardsIgnoreLine
          break;
      case 'popularity':
        $args['meta_key'] = 'total_sales'; // @codingStandardsIgnoreLine

        // Sorting handled later though a hook.
        add_filter( 'posts_clauses', array( new WC_Query, 'order_by_popularity_post_clauses' ) );
        break;
      case 'rating':
        $args['meta_key'] = '_wc_average_rating'; // @codingStandardsIgnoreLine
        $args['orderby']  = array(
          'meta_value_num' => 'DESC',
          'ID'             => 'ASC',
        );
        break;
    }

    $woo_products = new WP_Query( $args );

    woocommerce_product_loop_start();
    if ( $woo_products->have_posts()) {
      while ( $woo_products->have_posts() ) {
        $woo_products->the_post();
        do_action( 'woocommerce_shop_loop' );
        wc_get_template_part( 'content', 'product' );
      }
    }
    wp_reset_query();
    woocommerce_product_loop_end();
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
