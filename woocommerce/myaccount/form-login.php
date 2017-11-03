<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
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

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
                            
                                <form id="frmLogin" class="sky-form" method="post"> 
                                
                                <?php do_action( 'woocommerce_login_form_start' ); ?>
                                
                                <?php wp_nonce_field( 'woocommerce-login' ); ?>
                                                                   
                                    <fieldset>                  
                                        <section>
                                            <div class="form-group">
                                                <label class="label"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                                                </label>
                                            </div>     
                                        </section>
                                        
                                        <section>
                                            <div class="form-group">
                                                <label class="label"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-lock"></i>
                                                    <input type="password" name="password" id="password" />
                                                </label>
                                            </div>     
                                        </section> 
                                        <section>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="checkbox"><input type="checkbox" name="rememberme" value="forever" checked=""><i></i>Keep me logged in</label>
                                                </div>
                                            </div>
                                        </section>

                                        <section>
                                        
                                           <input type="submit" class="btn btn-base btn-sm btn-block" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
                                        </section>
                                    </fieldset>
                                    
                                    <?php do_action( 'woocommerce_login_form_end' ); ?>
                                      
                                </form>    
                            </div>
                            <div class="form-footer">
                                <p>Lost your password? <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Click here to recover.</a></p>
                            </div>
                        </div>
                    </div>


<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="col-md-8 col-md-offset-2 col-sm-6 col-sm-offset-3">                   
                        <div class="wp-block default user-form no-margin">
                            <div class="form-header">
                                <h2><?php _e( 'Register', 'woocommerce' ); ?></h2>
                            </div>
                            <div class="form-body">
                                <form action="" id="frmRegister" class="sky-form" method="post"> 
                                
                                <?php do_action( 'woocommerce_register_form_start' ); ?>
                                                                   
                                    <fieldset class="no-padding">           
                                        <section>
                                            <div class="row">
                                            
                                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label class="label">Username <span class="required">*</span></label>
                                                        <label class="input">
                                                            <i class="icon-append fa fa-user"></i>
                                                            <input type="text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b>
                                                        </label>
                                                    </div>               
                                                </div>
                                                <?php endif; ?>
                                                
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="label">E-mail</label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-envelope-o"></i>
                                                                <input type="email" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
                                                                <b class="tooltip tooltip-bottom-right">Needed to verify your account</b>
                                                            </label>
                                                        </div>  
                                                    </div>               
                                                </div>
                                            </div>   
                                            
                                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label">Password</label>
                                                        <label class="input">
                                                            <i class="icon-append fa fa-lock"></i>
                                                            <input type="password" name="password" id="reg_password">
                                                            <b class="tooltip tooltip-bottom-right">Needed to enter the website</b>
                                                        </label>
                                                    </div>               
                                                </div>
                                                
                                            </div> 
                                            
                                            <?php endif; ?>  
                                        </section>
                                        
                                        <!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>
            
            <p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
			</p>
                                       
                                       </fieldset> 
                                       
                                       <?php do_action( 'woocommerce_register_form_end' ); ?>
                                       
                                </form>  
                                
                                <?php do_action( 'woocommerce_after_customer_login_form' ); ?>
                                  
                            </div>
                            <div class="form-footer">
                                <p>Already have an account? <a href="sign-in-1.html">Click here to sign in.</a></p>
                            </div>
                        </div>
                    </div>

<?php endif; ?>

</div>
</div>
</section>