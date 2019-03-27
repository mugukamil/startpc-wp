<?php
/**
 * Search results partial template.
 *
 * @package veartix
 */

global $product;
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}


?>
<div class="calc-product">
    <p class="calc-product__text"><?php the_title() ?></p>
    <div class="calc-product__logo-out">
        <?php if (!get_field('product_brand') && get_field('product_brand_text')) : ?>
            <p class="calc-product__brand-text"><?php echo get_field('product_brand_text'); ?></p>
        <?php endif; ?>
        <?php if (get_field('product_brand')) : ?>
        	<?php $img = get_field('product_brand') ?>
            <img src="<?php echo $img['url']; ?>" alt="product brand" class="calc-product__logo" />
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
    <div class="calc-product__hover">
        <a href="<?php the_permalink() ?>" target="_blank" class="calc-product__more">פרטים נוספים
            <span aria-hidden="true" class="calc-product__icon"></span>
        </a>
        <a href="./?add-to-cart=<?php echo get_the_ID() ?>" data-pid='9' data-cid="cpu" data-product_id="<?php echo get_the_ID() ?>" data-product_sku="<?php echo $product->get_sku() ?>" data-quantity="1" class="calc-product__add-to-cart add_to_cart_button ajax_add_to_cart" rel="nofollow" aria-label='Add "<?php echo the_title() ?>" to your cart'>הוסף לסל
            <span aria-hidden="true" class="calc-product__icon"></span>
        </a>
        <a href="" data-pid='9' data-product_id="<?php echo get_the_ID() ?>" class="calc-product__remove-from-cart">להסיר מסל
            <span aria-hidden="true" class="calc-product__icon"></span>
        </a>
    </div>
</div>