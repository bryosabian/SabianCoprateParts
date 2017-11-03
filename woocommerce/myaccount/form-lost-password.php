<?php
/**
 * Lost password form
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="pg-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>Account</h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>
                    <li><a href="#">Account</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="section_product">
<div class="container">
<div class="row">

<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="wp-block default user-form"> 
                            <div class="form-header">
                                <h2><?php _e( 'Login', 'woocommerce' ); ?></h2>
                            </div>
                            <div class="form-body">
                            
                            <?php wc_print_notices(); ?>
                            
                            
                            
                                <form id="frmLogin" class="sky-form" method="post"> 

<?php if( 'lost_password' == $args['form'] ) : ?>

		<p><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p>

<section>
                                            <div class="form-group">
                                                <label class="label"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="user_login" id="user_login" />
                                                </label>
                                            </div>     
                                        </section>
	<?php else : ?>
                                
                              <p><?php echo apply_filters( 'woocommerce_reset_password_message', __( 'Enter a new password below.', 'woocommerce') ); ?></p>
                                                                   
                                    <fieldset>                  
                                        <section>
                                            <div class="form-group">
                                                <label class="label"><?php _e( 'New Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    <input type="text" type="password" name="password_1" id="password_1" />
                                                </label>
                                            </div>     
                                        </section>
                                        
                                        <section>
                                            <div class="form-group">
                                                <label class="label"><?php _e( 'Re-enter Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    <input type="text" type="password" name="password_2" id="password_2" />
                                                </label>
                                            </div>     
                                        </section> 
                                        
                                        
                                    </fieldset>
                                    
                                   <input type="hidden" name="reset_key" value="<?php echo isset( $args['key'] ) ? $args['key'] : ''; ?>" />
		<input type="hidden" name="reset_login" value="<?php echo isset( $args['login'] ) ? $args['login'] : ''; ?>" />
                                    
                                
                                <?php endif; ?>
                                
                                <?php do_action( 'woocommerce_lostpassword_form' ); ?>

                                        <section>
                                        
                                        <input type="hidden" name="wc_reset_password" value="true" />
        
                                           <input type="submit" class="btn btn-base btn-sm btn-block" value="<?php echo 'lost_password' == $args['form'] ? __( 'Reset Password', 'woocommerce' ) : __( 'Save', 'woocommerce' ); ?>" />
                                        </section>
                                        
                                 <?php do_action( 'woocommerce_login_form_end' ); ?>
                                      
                                      <?php wp_nonce_field( $args['form'] ); ?>
                                      
                                </form>
                            </div>
                            
                        </div>
                    </div>

</div>
</div>
</section>