<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php echo apply_filters("sabian_meta",'
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index, follow">');
?>

<title>
<?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?> | <?php bloginfo( 'description' ); ?>
</title>
<?php wp_head(); ?>
</head>

    <header>

        <!--Top Bar-->
        <div class="navbar-top parts">

            <div class="container">

                <ul class="navbar-top-contacts hidden-xs">

                    <li>
                        <i class="fa fa-bullhorn"></i> Free shipping on all orders
                    </li>

                    <li>
                        <i class="fa fa-android"></i> <a href="#">Download The App</a>
                    </li>
                </ul>

                <ul class="navbar-top-contacts pull-right">
                
                <?php if(is_user_logged_in()){
					
					$cart_url=WC_Cart::get_cart_url(); 
					
					$logout_url=wp_logout_url();
					
					?>
                    <li>
                        <i class="fa fa-shopping-cart"></i> <a href="<?php echo $cart_url; ?>">View Cart</a>
                    </li>
                    
                    <li>
                    <i class="fa fa-lock"></i><a href="<?php echo wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ); ?>">Log Out</a>
                    </li>
                    <?php
					
				}else{
					
					$login=get_permalink(get_option('woocommerce_myaccount_page_id')); 
					
					$signup=wp_registration_url();
					
					?>
					
					
                    
                    <li>
                        <i class="fa fa-lock"></i> <a href="<?php echo $login; ?>">Log In</a>
                    </li>
                    
                    
                    
                     
                    <?php
					
				}
				?>
<li>
                        <i class="fa fa-envelope"></i> <a href="">info@easyparts.co.ke</a>
                    </li>

                    <li>
                        <i class="fa fa-phone"></i> <a href="#">+25412345678</a>
                    </li>
                   
                </ul>

            </div>

        </div>



        <!--Nav bar-->

        <nav class="navbar parts navbar-default hidden-xs sabian_nav" role="navigation" id="sabian_nav">


            <div class="container">

                <div class="navbar-header" style="display:none">
                    <a href="#" class="navbar-brand"><?php bloginfo('name'); ?></a>
                </div>

                <?php 
			wp_nav_menu(array(
		'theme_location' => apply_filters("sabian_header_menu",'header-menu'), // menu slug from step 1
		'container' => '', // 'div' container will not be added
		'menu_class' => 'nav navbar-nav navbar-left',
		"fallback_cb"=>"sabian_default_menu",
		'walker' => apply_filters("sabian_header_menu_walker",new SabianNavWalker())
		 // <ul class="nav"> 
		 
	));
	?>

                <?php 
			wp_nav_menu(array(
		'theme_location' => 'sabian-header-menu-sub', // menu slug from step 1
		'container' => '', // 'div' container will not be added
		'menu_class' => 'nav navbar-nav navbar-right',
		"fallback_cb"=>"sabian_default_sub_menu",
		'walker' => new SabianNavWalker()
		 // <ul class="nav"> 
		 
	));
	?>



            </div>

            <div class="search-bar-container search-bar">
                <div class="container">

<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">

<input type="hidden" name="post_type" value="product" />

                    <div class="form-inline">

                        <div class="form-group">

                            <input class="form-control search-bar-text" type="search" name="s" value="<?php echo get_search_query();?>" placeholder="Search For Parts..." /> 

                        </div>

                        <button class="btn btn-primary bnt-sm btn-icon btn-search btn-search-bar-btn" type="submit">Search</button>

                    </div>
                    
                    </form>

                </div>

            </div>
        </nav>


        <nav class="navbar navbar-default visible-xs" role="navigation" id="sabian_nav_collapse">

            <div class="navbar-header">

                <div class="navbar-toggle" data-toggle="collapse" data-target="#sabian_nav_collapse_cont">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>

                <a class="navbar-brand"><?php echo get_bloginfo('name'); ?></a>
            </div>

            <div class="collapse navbar-collapse" id="sabian_nav_collapse_cont">
                  <?php 
			wp_nav_menu(array(
		'theme_location' => 'sabian-header-menu-mobile', // menu slug from step 1
		'container' => '', // 'div' container will not be added
		'menu_class' => 'nav navbar-nav navbar-left',
		"fallback_cb"=>"sabian_default_menu",
		'walker' => new SabianNavWalker()
		 // <ul class="nav"> 
		 
	));
	?>
            </div>


        </nav>



    </header>