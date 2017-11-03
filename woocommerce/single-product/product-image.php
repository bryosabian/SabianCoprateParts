<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>
<div class="product-gallery">
                                    

	<?php
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );
				
				?>
                <div class="primary-image">
                                        <a href="<?php echo $image_link; ?>" class="theater" rel="group">
                                           <!-- <img src="<?php echo $image_link; ?>" class="img-responsive" style="width:100%" alt="">-->
                                           <div class="sabian_product" style="background-image:url(<?php echo $image_link; ?>); height:270px"></div>
                                        </a>
                                    </div>
                <?php

		}
	?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
