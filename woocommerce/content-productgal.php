<?php
/**
* The template for displaying product content within loops
*
* This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @author  WooThemes
* @package WooCommerce/Templates
* @version 3.0.0
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $product;
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<div class="calc-product calc-product--gallery">
    <p class="calc-product__text">
        <span class="calc-product__checkbox"><svg xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" height="14" viewBox="0 0 24 24" width="15"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg></span>
        <?php the_title() ?>
        </p>
    <div class="calc-product__logo-out">
        <!-- <img src="//localhost:3000/wp-content/themes/understrap/img/amd.jpg" alt="product brand" class="calc-product__logo"> -->
        <?php 
        $product_brand = get_field('product_brand');
        $product_brand_text = get_field('product_brand_text');

        if (!$product_brand && $product_brand_text) : ?>
            <p class="calc-product__brand-text"><?php echo get_field('product_brand_text'); ?></p>
        <?php endif; ?>
        <?php if ($product_brand) : ?>
            <img src="<?php echo $product_brand['url']; ?>" alt="product brand" class="calc-product__logo" />
        <?php endif; ?>
    </div>
    <div class="calc-product__img-out"><?php echo woocommerce_get_product_thumbnail() ?></div>
    <?php 
    // get product_tags of the current product
    $current_tags = get_the_terms( get_the_ID(), 'product_tag' );

    //only start if we have some tags
    if ( $current_tags && ! is_wp_error( $current_tags ) ) { 

        //create a list to hold our tags
        echo '<ul class="calc-product__tags product-tags">';

        //for each tag we create a list item
        foreach ($current_tags as $tag) {

            $tag_title = $tag->name; // tag name
            $tag_link = get_term_link( $tag );// tag archive link

            echo '<li class="product-tags__tag">'.$tag_title.'</li>';
        }

        echo '</ul>';
        if (get_field('product_warranty')) {
            echo "<p class='calc-product__warranty'>". get_field('product_warranty') ."</p>";
        }
    }

     ?>
    <p class="calc-product__price">
        <?php
        /* @hooked woocommerce_template_loop_price - 10 */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
    </p>
</div> <!-- /.calc-product -->