<?php
/**
 * XXXXX- Template Name: User Dashboard Template
 * To be used for the display of the user's dashboard
 * @package WordPress
 * @subpackage Sabian Corporate
 * @since 1.2.5
 */
 
 

$cart_url=wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) );
	
if(!is_user_logged_in()){
	wp_redirect($cart_url);
	exit();
}

$current_user=wp_get_current_user();

$is_elligible=current_user_can(SabianSettings::VENDOR_ROLE_KEY);

if(!$is_elligible){
	wp_die('You are not elligible to access this page. Click here to return <a href="'.get_bloginfo('url').'">Home</a>');	
}

require_once SABIAN_APP_PATH."admin/init.php";

$img_url=get_avatar_url($current_user->ID);

?>
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


<body class="admin-body">

<header class="admin-header">

<a href="<?php echo get_bloginfo('url'); ?>" class="logo">

<?php echo get_bloginfo('name'); ?>
        </a>
       
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar admin-nav navbar-static-top hidden-xs" role="navigation">
        
        <!--<div class="navbar-header">
<a href="#" class="navbar-brand"><?php echo get_bloginfo('name'); ?></a>
</div>-->
        
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav pull-right">
            
            
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo $img_url; ?>" class="user-image" alt="">
                  <span class="hidden-xs"><?php echo $current_user->display_name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo $img_url; ?>" class="img-circle" alt="">
                    <p>
                      <?php echo $current_user->user_firstname . " ".$current_user->user_lastname; ?> - <?php echo $current_user->user_login; ?>
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  
                  <!-- Menu Footer-->
                  <li class="user-footer clearfix">
                    <div class="pull-right">
                      <a href="<?php echo wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
             
            </ul>
          </div>
        </nav>
         
        
        <nav class="navbar navbar-default visible-xs" role="navigation" id="sabian_nav_collapse">

<div class="navbar-header">

<div class="navbar-toggle" data-toggle="collapse" data-target="#sabian_nav_collapse_cont">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</div>

<a class="navbar-brand">Sabian Corporate</a>
</div>

<div class="collapse navbar-collapse" id="sabian_nav_collapse_cont">
<ul class="nav navbar-nav">
<li><a href="index.html" class="dropdown-toggle" data-toggle="dropdown">Home</a>

<ul class="dropdown-menu">
<li><a href="index.html">Home (Carousel Slider)</a>
</li><li><a href="home-rev-slider.html">Home (Revolution Slider)</a>
</li></ul>

</li>

<li><a href="#">About Us</a></li>
<li><a href="#">Portfolio</a></li>

<li><a class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>

<ul class="dropdown-menu">
<li class="not-active"><a href="#">Menu 1</a></li>
<li><a href="#">Menu 2</a></li>
<li><a href="#">Menu 3</a></li>

<li class="dropdown-submenu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown Level 2</a>
<ul class="dropdown-menu">
<li class="not-active"><a href="#">Menu 1</a></li>
<li><a href="#">Menu 2</a></li>
<li><a href="#">Menu 3</a></li>

<li class="dropdown-submenu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown Level 3</a>
<ul class="dropdown-menu">
<li class="not-active"><a href="#">Menu 1</a></li>
<li><a href="#">Menu 2</a></li>
<li><a href="#">Menu 3</a></li>
</ul>
</li>

</ul>
</li>
</ul>

</li>


<li><a href="#">Skills</a></li>
<li><a href="#">Team</a></li>
<li><a href="#">Pricing</a></li>
<li><a href="#">Contact Us</a></li>
</ul>
</div>
</nav>
      </header>
      
      <aside class="admin-sidebar">
      
      <section class="sidebar" style="height: auto;">
      
      <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $img_url; ?>" class="img-circle" alt="">
            </div>
            <div class="pull-left info">
              <p><?php echo $current_user->user_login; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Log Out</a>
            </div>
          </div>
          
          
          <ul class="admin-sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            
            <?php do_action("sabian_wc_dash_sidelinks"); ?>
            
             </ul>
      
      </section>
      
      </aside>
      
      
      <div class="content-wrapper" style="min-height: 921px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo apply_filters("sabian_wc_dash_title","Dashboard"); ?>
            <small><?php echo apply_filters("sabian_wc_dash_sub_title","Control Panel"); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo apply_filters("sabian_wc_dash_title","Dashboard"); ?></li>
          </ol>
        </section>
        
        
        <section class="content">
        
        <?php do_action("sabian_wc_dash_content"); ?>
        
        </section>
        
        
        </div>
      

</body>

<?php  
wp_footer();
?>

<script type="text/javascript">
    $(document).ready(function (e) {

        jQuery('#banner_rs_slider').revolution(
                {
                    delay: 9000,
                    startwidth: 1170,
                    startheight: 450,
                    hideThumbs: 10,
                    fullWidth: "on",
                });
    });
	
	/*Wordpress settings*/
	$(".widget_side").each(function(index, element) {
        
		var _this=$(this);
		
		_this.find('ul').addClass("categories highlight");
		
    });

</script>

</html>

