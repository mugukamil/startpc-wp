<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$attachment_ids = $product->get_gallery_image_ids();

?>
<div class="product__gallery">
	<div class="product__slider">
		<?php

if ( $attachment_ids && has_post_thumbnail() ) {
	$html  = '<div><a href="' . esc_url( $full_size_image[0] ) . '" data-lightbox="product-slide">';
	$html .= '<img class="product__img" src="' .esc_url( $full_size_image[0] ) . '" alt="'. get_post_field( 'post_title', $post_thumbnail_id ) .'">';
	$html .= '</a></div>';
	foreach ( $attachment_ids as $attachment_id ) {
		$attributes = array(
			'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
			'class'                   => 'product__img'
		);
		if ( has_post_thumbnail() ) {
            $attach = wp_get_attachment_image_src( $attachment_id, 'full' );
			$html  .= '<div><a href="' . esc_url( $attach[0] ) . '" data-lightbox="product-slide">';
			$html .= wp_get_attachment_image( $attachment_id, 'woocommerce_single', false, $attributes );
			$html .= '</a></div>';
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="product__img" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
	}
} elseif (has_post_thumbnail()) {  ?>
    <div><a href="<?php echo $full_size_image[0] ?>" data-lightbox="product-slide">
    <img class="product__img" src="<?php echo  $full_size_image[0] ?>" alt="<?php echo get_post_field( 'post_title', $post_thumbnail_id ) ?>"></a></div>
    <?php } ?>
	</div>
	<?php
		do_action( 'woocommerce_product_thumbnails' );
	 ?>
</div>

