<?php
/**
 * Edit address form
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $current_user;

$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'woocommerce' ) : __( 'Shipping Address', 'woocommerce' );

get_currentuserinfo();

?>
<style>
.account input , .account select{
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
                <h2><?php echo $page_title; ?></h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>
                    <li><a href="#"><?php echo $page_title; ?></a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section_account">
<div class="container">
<div class="row">


<?php wc_print_notices(); ?>


<?php if ( ! $load_address ) : ?>

	<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php else : ?>

<div class="wp-block default user-form"> 
<div class="form-header">

<h2><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h2>

</div>

<div class="form-body">

	<form method="post" class="account">

		<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

		<?php foreach ( $address as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

		<?php endforeach; ?>

		<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

		<p>
			<button type="submit" class="btn btn-base" name="save_address" value="<?php esc_attr_e( 'Save Address', 'woocommerce' ); ?>"><?php esc_attr_e( 'Save Address', 'woocommerce' ); ?></button>
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>
    </div>
    </div>

<?php endif; ?>
</div>
</div>
</section>
