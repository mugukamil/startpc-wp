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

$product_cats = get_the_terms( get_the_ID(), 'product_cat' );

foreach ($product_cats as $prod_cat) {
    $subcat[] = $prod_cat;
}

$last_subcat_arr = array_slice($subcat, -1);
$last_subcat = $last_subcat_arr[0];

?>

<div <?php post_class("calc-product"); ?> data-cid="<?php echo $last_subcat->parent ?>" data-subcat="<?php echo strtolower($last_subcat->name); ?>">
    <p class="calc-product__text"><?php the_title() ?></p>
    <div class="calc-product__logo-out">
        <!-- <img src="//localhost:3000/wp-content/themes/understrap/img/amd.jpg" alt="product brand" class="calc-product__logo"> -->
        <?php
        $product_brand = get_field('product_brand');
        $product_brand_text = get_field('product_brand_text');
        if (!$product_brand && $product_brand_text) : ?>
            <p class="calc-product__brand-text"><?php echo $product_brand_text; ?></p>
        <?php endif; ?>
        <?php if ($product_brand) : ?>
            <img src="<?php echo $product_brand['url']; ?>" alt="product brand" class="calc-product__logo" />
        <?php endif; ?>
    </div>
    <div class="calc-product__img-out"><?php echo woocommerce_get_product_thumbnail() ?></div>
    <div class="calc-product__align-end">
    <?php
    // get product_tags of the current product
    $current_tags = get_the_terms( get_the_ID(), 'product_tag' );
    $current_cat = get_the_terms( get_the_ID(), 'product_cat' );


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
    </div>
    <div class="calc-product__hover">
        <a href="<?php the_permalink() ?>" target="_blank" class="calc-product__more">פרטים נוספים
            <span aria-hidden="true" class="calc-product__icon"></span>
        </a>
        <?php if (is_shop() || is_product_category()): ?>
            <a href="<?php echo get_site_url() ?>/?add-to-cart=<?php echo get_the_ID() ?>" data-product_id="<?php echo get_the_ID() ?>" data-product_sku="<?php echo $product->get_sku() ?>" data-quantity="1" class="calc-product__add-to-cart add_to_cart_button ajax_add_to_cart" rel="nofollow" aria-label='Add "<?php echo the_title() ?>" to your cart'>הוסף לסל
                <span aria-hidden="true" class="calc-product__icon"></span>
            </a>
            <a href="" data-pid='<?php echo $product->get_id() ?>' data-product_id="<?php echo get_the_ID() ?>" class="calc-product__remove-from-cart">להסיר מסל
                <span aria-hidden="true" class="calc-product__icon"></span>
            </a>
        <?php else: ?>
        <a href="" data-qty="1" data-pid='<?php echo $product->get_id() ?>' data-cid="<?php echo $last_subcat->parent ?>" class="calc-product__add-to-cart" rel="nofollow" aria-label='Add "<?php echo the_title() ?>" הוסף למפרט'>הוסף למפרט
                <span aria-hidden="true" class="calc-product__icon"></span>
            </a>
            <a href="" data-pid='<?php echo $product->get_id() ?>' class="calc-product__remove-from-cart">הסר מהמפרט
                <span aria-hidden="true" class="calc-product__icon"></span>
            </a>
        <?php endif; ?>

    </div>
</div> <!-- /.calc-product -->
