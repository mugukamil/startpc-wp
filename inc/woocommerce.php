<?php
/**
 * Add WooCommerce support
 *
 * @package veartix
 */
add_action( 'after_setup_theme', 'understrap_woocommerce_support' );
if ( ! function_exists( 'understrap_woocommerce_support' ) ) {
    /**
     * Declares WooCommerce theme support.
     */
    function understrap_woocommerce_support() {
        add_theme_support( 'woocommerce' );
        
        // Add New Woocommerce 3.0.0 Product Gallery support
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-zoom' );

        // Gallery slider needs Flexslider - https://woocommerce.com/flexslider/
        //add_theme_support( 'wc-product-gallery-slider' );

        // hook in and customizer form fields.
        add_filter( 'woocommerce_form_field_args', 'understrap_wc_form_field_args', 10, 3 );
    }
}
/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
function understrap_wc_form_field_args( $args, $key, $value = null ) {
    // Start field type switch case.
    switch ( $args['type'] ) {
        /* Targets all select input type elements, except the country and state select input types */
        case 'select' :
            // Add a class to the field's html element wrapper - woocommerce
            // input types (fields) are often wrapped within a <p></p> tag.
            $args['class'][] = 'form-group';
            // Add a class to the form input itself.
            $args['input_class']       = array( 'form-control', 'input-lg' );
            $args['label_class']       = array( 'control-label' );
            $args['custom_attributes'] = array(
                'data-plugin'      => 'select2',
                'data-allow-clear' => 'true',
                'aria-hidden'      => 'true',
                // Add custom data attributes to the form input itself.
            );
            break;
        // By default WooCommerce will populate a select with the country names - $args
        // defined for this specific input type targets only the country select element.
        case 'country' :
            $args['class'][]     = 'form-group single-country';
            $args['label_class'] = array( 'control-label' );
            break;
        // By default WooCommerce will populate a select with state names - $args defined
        // for this specific input type targets only the country select element.
        case 'state' :
            // Add class to the field's html element wrapper.
            $args['class'][] = 'form-group';
            // add class to the form input itself.
            $args['input_class']       = array( '', 'input-lg' );
            $args['label_class']       = array( 'control-label' );
            $args['custom_attributes'] = array(
                'data-plugin'      => 'select2',
                'data-allow-clear' => 'true',
                'aria-hidden'      => 'true',
            );
            break;
        case 'password' :
        case 'text' :
        case 'email' :
        case 'tel' :
        case 'number' :
            $args['class'][]     = 'form-group';
            $args['input_class'] = array( 'form-control', 'input-lg' );
            $args['label_class'] = array( 'control-label' );
            break;
        case 'textarea' :
            $args['input_class'] = array( 'form-control', 'input-lg' );
            $args['label_class'] = array( 'control-label' );
            break;
        case 'checkbox' :
            $args['label_class'] = array( 'custom-control custom-checkbox' );
            $args['input_class'] = array( 'custom-control-input', 'input-lg' );
            break;
        case 'radio' :
            $args['label_class'] = array( 'custom-control custom-radio' );
            $args['input_class'] = array( 'custom-control-input', 'input-lg' );
            break;
        default :
            $args['class'][]     = 'form-group';
            $args['input_class'] = array( 'form-control', 'input-lg' );
            $args['label_class'] = array( 'control-label' );
            break;
    } // end switch ($args).
    return $args;
}

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );



add_action( 'wp_ajax_remove_from_cart', 'remove_from_cart' );
add_action( 'wp_ajax_nopriv_remove_from_cart', 'remove_from_cart' );

function remove_from_cart() {
    global $wpdb, $woocommerce;
    session_start();

    $cart = $woocommerce->cart;

    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        if ($cart_item['product_id'] == $_POST['product_id'] ){
            // Remove product in the cart using  cart_item_key.
            // echo $cart_item_key;
            $cart->remove_cart_item($cart_item_key);
            die('deleted');
        }
    }
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );


add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );          // Remove the description tab

    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

function woo_rename_tabs( $tabs ) {

    $tabs['additional_information']['title'] = __( 'Details', 'woocommerce' );    // Rename the additional information tab

    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

    $tabs['additional_information']['priority'] = 1;   // Additional information third

    return $tabs;
}

/*
 * Remove related products from product page
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
/*
 * Register custom tab
 */
function woo_custom_product_tab( $tabs ) {

    $custom_tab = array( 
        'custom_tab' =>  array( 
            'title' => __('Upgrade options', 'woocommerce'), 
            'priority' => 2, 
            'callback' => 'woo_custom_product_tab_content' 
        )
    );
    return array_merge( $custom_tab, $tabs );
}
/*
 * Place content in custom tab (related products in this sample)
 */
function woo_custom_product_tab_content() {
    // woocommerce_cross_sell_display();
    $args = array(
        'posts_per_page' => 4,
        'columns'        => 4,
        'orderby'        => 'rand', // @codingStandardsIgnoreLine.
    );

    woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}
add_filter( 'woocommerce_product_tabs', 'woo_custom_product_tab' );




// //* Used when the widget is displayed as a dropdown
// add_filter( 'woocommerce_product_categories_widget_dropdown_args', 'rv_exclude_wc_widget_categories' );
// //* Used when the widget is displayed as a list
// add_filter( 'woocommerce_product_categories_widget_args', 'rv_exclude_wc_widget_categories' );
// function rv_exclude_wc_widget_categories( $cat_args ) {
//     $cat_args['exclude'] = array('25'); // Insert the product category IDs you wish to exclude
//     return $cat_args;
// }



add_filter( 'woocommerce_product_tabs', 'veartix_video_product_tab' );
function veartix_video_product_tab( $tabs ) {
    
    // Adds the new tab
    
    $tabs['video_tab'] = array(
        'title'     => __( 'Video', 'woocommerce' ),
        'priority'  => 50,
        'callback'  => 'veartix_video_product_tab_content'
    );

    return $tabs;

}
function veartix_video_product_tab_content($args) {
    if (get_field('youtube_embed_link')) {
        $youtube_link = get_field('youtube_embed_link');
        $youtube_link = substr($youtube_link, strpos($youtube_link, 'v=') + 2);

        echo "<div class='product__video embed-responsive embed-responsive-16by9'><iframe width='100%' height='603' src='https://www.youtube.com/embed/$youtube_link' allowfullscreen title='video' style='border: 0' class='embed-responsive-item'></iframe></div>";
    }
}

// hide coupon field on cart page
function hide_coupon_field_on_cart( $enabled ) {
    if ( is_cart() ) {
        $enabled = false;
    }
    return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );






// Add to Cart For Calc Page
function woocommerce_maybe_add_multiple_products_to_cart( $url = false ) {
    // Make sure WC is installed, and add-to-cart qauery arg exists, and contains at least one comma.
    if ( ! class_exists( 'WC_Form_Handler' ) || empty( $_REQUEST['add-to-cart'] ) || false === strpos( $_REQUEST['add-to-cart'], ',' ) ) {
        return;
    }

    // Remove WooCommerce's hook, as it's useless (doesn't handle multiple products).
    remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );

    $product_ids = explode( ',', $_REQUEST['add-to-cart'] );
    $count       = count( $product_ids );
    $number      = 0;

    foreach ( $product_ids as $id_and_quantity ) {
        // Check for quantities defined in curie notation (<product_id>:<product_quantity>)
        // https://dsgnwrks.pro/snippets/woocommerce-allow-adding-multiple-products-to-the-cart-via-the-add-to-cart-query-string/#comment-12236
        $id_and_quantity = explode( ':', $id_and_quantity );
        $product_id = $id_and_quantity[0];

        $_REQUEST['quantity'] = ! empty( $id_and_quantity[1] ) ? absint( $id_and_quantity[1] ) : 1;

        if ( ++$number === $count ) {
            // Ok, final item, let's send it back to woocommerce's add_to_cart_action method for handling.
            $_REQUEST['add-to-cart'] = $product_id;

            return WC_Form_Handler::add_to_cart_action( $url );
        }

        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $product_id ) );
        $was_added_to_cart = false;
        $adding_to_cart    = wc_get_product( $product_id );

        if ( ! $adding_to_cart ) {
            continue;
        }

        $add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );


        WC()->cart->add_to_cart($product_id, $_REQUEST['quantity']);
    }
}

// Fire before the WC_Form_Handler::add_to_cart_action callback.
add_action( 'wp_loaded', 'woocommerce_maybe_add_multiple_products_to_cart', 15 );




add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
    $fees = range(1, 36);
    $feeArr = array();

    foreach ($fees as $fee => $val) {
      $feeArr[$fee + 1] = get_field($val . "_month_fee");
      $fee_val = get_field($val . "_month_fee");
    }

    $fields['billing']['billing_name_on_invoice'] = array(
        'type' => 'text',
        'label'     => __('Name On Invoice', 'woocommerce'),
        'required' => false,
        'clear'     => true
    );

    $fields['billing']['billing_store_pickup'] = array(
        'type' => 'select',
        'label'     => __('Pickup Place', 'woocommerce'),
        'clear'     => false,
        'options' => array(
          'אודים' => 'אודים',
          'אשדוד' => 'אשדוד',
          'תל אביב' => 'תל אביב',
          'חיפה' => 'חיפה'
      )
    );

    $fields['billing']['billing_per_month'] = array(
        'type' => 'select',
        'label'     => __('Pickup Place', 'woocommerce'),
        'clear'     => false,
        'options' => $feeArr
    );

    return $fields;
}

add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_country', 10, 1 );
function wc_npr_filter_country( $address_fields ) {
    $address_fields['billing_country']['required'] = false;
    return $address_fields;
}


/**
 * Update the order meta with store location pickup value
 **/
add_action( 'woocommerce_checkout_update_order_meta', 'store_pickup_field_update_order_meta' );
function store_pickup_field_update_order_meta( $order_id ) {
    if ( $_POST[ 'billing_store_pickup' ] )
        update_post_meta( $order_id, 'Store PickUp Location', esc_attr( $_POST[ 'billing_store_pickup' ] ) );
}

/**
 * Display field value on the order edit page
 */
 
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p class="form-field"><strong>'.__('Pickup Place', 'woocommerce').':</strong> ' . get_post_meta( $order->get_id(), '_billing_store_pickup', true ) . '</p>';
    echo '<p class="form-field"><strong>'.__('Billing Name on Invoice', 'woocommerce').':</strong> ' . get_post_meta( $order->get_id(), '_billing_name_on_invoice', true ) . '</p>';
    // echo '<p><strong>'.__('Self Collection', 'woocommerce').':</strong> ' . get_post_meta( $order->get_id(), '_billing_self_collection', true ) . '</p>';
    // echo '<p><strong>'.__('Delivery to home', 'woocommerce').':</strong> ' . get_post_meta( $order->get_id(), '_billing_delivery_to_home', true ) . '</p>';
}



function woo_add_cart_fee() {
    if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST; // fallback for final checkout (non-ajax)
    }

    if (isset($post_data['billing_per_month'])) {
        $subtotal = WC()->cart->subtotal;
        $bill_per_month = $post_data['billing_per_month'];
        $fee = ceil($subtotal / 100 * $bill_per_month);

        // echo $post_data['billing_per_month']; // not sure why you used intval($_POST['state']) ?
        WC()->cart->add_fee( __('Pay Per Month Fee:', 'woocommerce'), $fee);
    }
}
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );

