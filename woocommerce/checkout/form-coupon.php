<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' );
wc_print_notice( $info_message, 'notice' );
?>


<div class="panel panel-default panel-sidebar-1 cart-summary checkout_coupon" style="display:none">
                            <div class="panel-heading">
                                <h2>Enter Coupon</h2>
                            </div>
                            <div class="panel-body bb">
                                <form role="form" class="form-light" method="post">
                                    <label for="">Enter Coupon Code</label>
                                    <div class="input-group">
                                        <input type="text" name="coupon_code" placeholder="Coupon code" class="form-control left">
                                        
                                        <span class="input-group-btn">
                                            <input class="btn btn-base" type="submit" name="apply_coupon" value="Apply Code"/>
                                            </span>
                                        
                                    </div>
                                    
                                                                        
                                </form>
                            </div>
                                                        
                            
                        </div>