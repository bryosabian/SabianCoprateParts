<?php
/*register menus*/

if(!defined("SABIAN_THEME_NAME")){
	define("SABIAN_THEME_NAME","Sabian Corporate");	
}

if(!defined("SABIAN_APP_PATH"))
define("SABIAN_APP_PATH",dirname(__FILE__)."/");

if(!defined("SABIAN_URL"))
define("SABIAN_URL",get_template_directory_uri()."/");

require_once(SABIAN_APP_PATH."application.php");

/*allow thumbnails*/
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'sabian_preview', 300, 300 ); //300 pixels wide (and unlimited height)
add_image_size( 'sabian_sidebar', 370, 500 ); 
add_image_size( 'sabian_blog', 470, 500 );
add_image_size( 'sabian_small', 50, 100 ); 
add_image_size('sabian_gallery',250,500);
set_post_thumbnail_size( 150, 150, true ); 
/*allow thumbnails*/

/*menus*/
add_action( 'init', 'sabian_register_menus' );
/*menus*/

/*register theme scripts*/
add_action( 'wp_enqueue_scripts', 'sabian_register_styles' );

add_action( 'wp_enqueue_scripts', 'sabian_register_scripts' );

add_action( 'admin_enqueue_scripts', 'sabian_register_admin_scripts');

add_filter("sabian_site_logo","sabian_site_logo");

function sabian_site_logo($img)
{
	$logo="";
	
	$logo=get_bloginfo("name");
	
	return apply_filters("sabian_img_logo",$logo);
}

function sabian_theme_active()
{
	return true;
}




?>