<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

echo '<a href="' . esc_url( WC()->cart->get_checkout_url() ) . '" class="btn btn-lg btn-block btn-alt btn-icon btn-icon-right btn-icon-go pull-right"><span>' . __( 'Proceed to Checkout', 'woocommerce' ) . '</span></a>';
