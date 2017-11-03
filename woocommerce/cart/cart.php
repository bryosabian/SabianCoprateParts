<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="pg-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>Your Cart</h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>
                    <li><a href="#">Cart</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section_product">
<div class="container">
<div class="row">

<div class="col-md-8">

<?php
wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="table table-cart table-responsive">
                            <tbody>
                            
                            <tr>
                            <th>&nbsp;</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                            </tr>
                            
                            <?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) 
		{
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			
			$image_link=wp_get_attachment_url( $_product->get_image_id() );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
                                <tr>
                                    <td><img src="<?php echo $image_link; ?>" class="img-center" style="height:50px" alt=""></td>
                                    <td><a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>"><?php echo $_product->get_title(); ?></a></td>
                                    <td><?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?></td>
                                    <td>
                                    <?php
									$pq=$_product->backorders_allowed() ? '' : $_product->get_stock_quantity();
									
							if ( $_product->is_sold_individually() ) {
								$product_quantity = '1 <input type="hidden" name="cart['.$cart_item_key.'][qty]" value="1" />';
							} else {
								$product_quantity='<input type="number" name="cart['.$cart_item_key.'][qty]" value="'.$cart_item['quantity'].'" style="width:60px; text-align:center; margin-right:5px; height:34px;" max="'.$pq.'" min="0">';
								
							} 
							echo $product_quantity;
							?>
                                        
                                    </td>
                                    
                                    <td><?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?></td>
                                    <td class="remove-cell">
                                    <?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="cart-remove" title="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-times-circle fa-2x"></i></a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
                                   </td>
                                </tr>
                                <?php } } ?>
                                
                                <tr>
                                <td colspan="6"><input type="submit" class="btn btn-base btn-icon btn-refresh" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" /></td>
                                </tr>
                                
                                
                                
                                
                               
                            </tbody>
                        </table>
                        
                
                <?php do_action( 'woocommerce_cart_contents' ); ?>
                
                <?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
                
                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                
                
                
                            
                
                
                        
                        

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>



<?php do_action( 'woocommerce_after_cart' ); ?>
</div>


<div class="col-md-4">

<div class="panel panel-default panel-sidebar-1 cart-summary">
                            <div class="panel-heading">
                                <h2>Cart summary</h2>
                            </div>
                            <?php if ( WC()->cart->coupons_enabled() ) { ?>
                            <div class="panel-body bb">
                                <form role="form" class="form-light" method="post">
                                    <label for="">Do you have a promo code?</label>
                                    <div class="input-group">
                                        <input type="text" name="coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" class="form-control left">
                                         <span class="input-group-btn">
                                            <input class="btn btn-base" type="submit" name="apply_coupon" value="Apply Code"/>
                                            </span>
                                    </div>
                                    
                                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                    
                                </form>
                            </div>
                            <?php } ?>
                            <div class="panel-body bb">
                            
                            <?php do_action( 'woocommerce_before_cart_totals' ); ?>
                            
                                <table class="table table-cart-subtotal">
                                    <tbody>
                                        <tr>
                                            <th><?php _e( 'Cart Sub Total', 'woocommerce' ); ?></th>
                                            <td class="text-right"><span class="amount"><?php wc_cart_totals_subtotal_html(); ?></span></td>
                                        </tr>
                                        
                                        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>
        
                                        
                                        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() ) : ?>

			<tr class="shipping">
				<th><?php _e( 'Shipping', 'woocommerce' ); ?></th>
				<td><?php woocommerce_shipping_calculator(); ?></td>
			</tr>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && WC()->cart->tax_display_cart == 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
                                        <tr>
                                            <th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
                                        </tr>
                                        
                                        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo esc_url( WC()->cart->get_checkout_url() ); ?>" class="btn btn-primary btn-lg btn-block btn-icon btn-download pull-right">
                                    <span>Proceed to checkout</span>
                                </a>
                            </div>
                        </div>


</div>

</div>



</div>
</section>