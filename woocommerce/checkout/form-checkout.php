<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<style>
.checkout input{
	outline: none;
    box-shadow: none !important;
    -webkit-box-shadow: none !important;
    background: #f9f9f9;
    border: 1px solid #ccc;
    color: #70808b;
    font-size: 13px !important;
	padding: 10px 10px;
	position: relative;
    z-index: 2;
    float: left;
    width: 100%;
    margin-bottom: 0;
}

</style>
<div class="pg-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>Check Out</h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>
                    <li><a href="#">Check Out Here</a></li>
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

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>




<form name="checkout" method="post" class="checkout woocommerce-checkout sky-form" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
<div class="wp-block default user-form"> 
<div class="form-header">
                                    
	<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h2><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h2>

	<?php else : ?>

		<h2><?php _e( 'Billing Details', 'woocommerce' ); ?></h2>

	<?php endif; ?>
                                </div>
                                
                                <div class="form-body">
                                
		<div id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
        
        </div>
        
        </div>
        
        
        
                                    
	
        <div class="wp-block default user-form"> 
<div class="form-header">

		<h2><?php _e( 'Shipping Details', 'woocommerce' ); ?></h2>

	
                                </div>
                                
                                <div class="form-body">
                                
		<div id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>

			
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
        
        </div>
        
        </div>

		

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

<div class="wp-block default user-form"> 
<div class="form-header">
                                    <h2>Your Order</h2>
                                </div>
                                
                                <div class="form-body">
	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    </div>
    
    </div>

</form>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

</div>

<div class="col-md-4">

<div class="panel panel-default panel-sidebar-1 cart-summary">
                            <div class="panel-heading">
                                <h2>Cart summary</h2>
                            </div>
                            <?php if ( WC()->cart->coupons_enabled() ) { ?>
                            
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

</div>

</div>

</div>

</section>
