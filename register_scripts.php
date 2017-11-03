<?php
function sabian_register_styles() {
    
    wp_enqueue_style('sabian_bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('sabian_font', get_template_directory_uri() . '/css/font/font-awesome-4.0.3/css/font-awesome.css');
    wp_enqueue_style('sabian_animate', get_template_directory_uri() . '/css/animate.css');
	wp_enqueue_style('sabian_css', get_template_directory_uri() . '/css/sabian.css');

    //Owl carousel
    wp_enqueue_style('sabian_owl_carousel', get_template_directory_uri() . '/js/plugins/owl-carousel/assets/owl.carousel.css');
    wp_enqueue_style('sabian_owl_theme', get_template_directory_uri() . '/js/plugins/owl-carousel/assets/owl.theme.green.css');

    //Revslider
    wp_enqueue_style('sabian_rev_slider_settings', get_template_directory_uri() . '/js/plugins/revslider/css/settings.css');

    //Bootstrap Select
    wp_enqueue_style('sabian_bootstrap_css', get_template_directory_uri() . '/plugins/bselect/css/bootstrap-select.css');

    //Sky Forms
    wp_enqueue_style('sabian_skyforms_css', get_template_directory_uri() . '/plugins/sky-forms/css/sky-forms.css');

    //Easy Parts
    wp_enqueue_style('sabian_easyparts_css', get_template_directory_uri() . '/css/easyparts.css');
	
	//Popup
	wp_enqueue_style('sabian_mg_popup', get_template_directory_uri() . '/plugins/magnific-popup/magnific-popup.css');
	
	
	//Popup
	wp_enqueue_style('sabian_admin', get_template_directory_uri() . '/admin/css/admin.css');
}

function sabian_register_scripts() {
	
    if (is_singular() && comments_open() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');


    /* JS Packages */
    wp_enqueue_script('jquery-masonry');
    wp_enqueue_script('sabian_main_jquery', get_template_directory_uri() . '/js/jquery.js', array('jquery'), false, true);
    wp_enqueue_script('sabian_bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_backstretch', get_template_directory_uri() . '/js/plugins/backstretch/jquery.backstretch.min.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_waypoints', get_template_directory_uri() . '/js/plugins/waypoints/jquery.waypoints.min.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_mixitup', get_template_directory_uri() . '/js/plugins/mixitup/mixitup.js', array('jquery'), false, true);
	
	
	//Owl carousel
	wp_enqueue_script('sabian_owl_carousel', get_template_directory_uri() . '/js/plugins/owl-carousel/assets/owl.carousel.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_touchswipe', get_template_directory_uri() . '/js/plugins/touch-swipe/jquery.touchSwipe.js', array('jquery'), false, true);
	
	//Bootstrap select
	wp_enqueue_script('sabian_bootstrap_selected', get_template_directory_uri() . '/plugins/bselect/js/bootstrap-select.js', array('jquery'), false, true);
	
	//Sky forms
	wp_enqueue_script('sabian_sky_forms', get_template_directory_uri() . '/plugins/sky-forms/js/jquery.form.min.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_sky_forms_validate', get_template_directory_uri() . '/plugins/sky-forms/js/jquery.validate.min.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_sky_forms_masked_input', get_template_directory_uri() . '/plugins/sky-forms/js/jquery.maskedinput.min.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_sky_forms_modal', get_template_directory_uri() . '/plugins/sky-forms/js/jquery.modal.js', array('jquery'), false, true);
	
	//Rev slider
	wp_enqueue_script('sabian_revslider_themepunch', get_template_directory_uri() . '/js/plugins/revslider/js/jquery.themepunch.plugins.min.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_revslider_revolution', get_template_directory_uri() . '/js/plugins/revslider/js/jquery.themepunch.revolution.js', array('jquery'), false, true);
	
	//Popup
	wp_enqueue_script('sabian_mg_popup', get_template_directory_uri() . '/plugins/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), false, true);
	
	//Sabian
	wp_enqueue_script('sabian_theme', get_template_directory_uri() . '/js/sabian.js', array('jquery'), false, true);
	wp_enqueue_script('sabian_theme_shop', get_template_directory_uri() . '/js/shop.js', array('jquery'), false, true);
	
}
function sabian_register_admin_scripts($hook)
{
	wp_enqueue_style('sabian_admin',get_template_directory_uri() . '/css/admin.css');	
	
	wp_enqueue_style("sabian_dropdown_css",get_template_directory_uri().'/plugins/multi-select/jquery.dropdown.css');
	
	wp_enqueue_script("sabian_dropdown_js",get_template_directory_uri().'/plugins/multi-select/jquery.dropdown.js',array('jquery'), false, true);
	
	wp_enqueue_script("sabian_category_select",get_template_directory_uri().'/js/admin/category_select.js',array('jquery'), false, true);
}

?>