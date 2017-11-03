<?php
if(!defined("EAP_PATH"))
define("EAP_PATH",SABIAN_APP_PATH."easyparts/");

if(!defined("EAP_POSTS_PATH"))
define("EAP_POSTS_PATH",EAP_PATH."posts/");

if(!defined("EAP_TEMPLATES_PATH"))
define("EAP_TEMPLATES_PATH",EAP_PATH."templates/");

require_once EAP_PATH."model.php";

require_once EAP_PATH."parts_categories.php";

require_once EAP_PATH."vc_addons.php";

require_once EAP_POSTS_PATH."model_post.php";

require_once EAP_POSTS_PATH."variant_post.php";

require_once EAP_POSTS_PATH."manufacturer_post.php";


/*Register posts template files*/
add_filter('single_template','eap_post_templates_dir');

function eap_post_templates_dir($template){
	
	global $post;
	
	if($post->post_type==EAP_MODEL_POST_NAME){
		
		$template=EAP_TEMPLATES_PATH.'single-'.EAP_MODEL_POST_NAME.'.php';
	}
	
	if($post->post_type==EAP_VARIANT_POST_NAME){
		
		$template=EAP_TEMPLATES_PATH.'single-'.EAP_VARIANT_POST_NAME.'.php';
	}
	
	if($post->post_type==EAP_MANUF_POST_NAME){
		
		$template=EAP_TEMPLATES_PATH.'single-'.EAP_MANUF_POST_NAME.'.php';
	}
	
	return $template;
			
}

/*Custom permalinks redirects. Fix for singular post types like models and variants*/
add_filter('redirect_canonical','eap_fix_custom_pagination_redirect');

function eap_fix_custom_pagination_redirect($redirect_url){
	
	if(is_paged() && is_singular())$redirect_url=false;
	
	return $redirect_url;	
}


/*Product Items*/
add_action("woocommerce_product_query",'eap_items_filter',10000,2);

function eap_items_filter($q,$wcq){
	
	if(isset($_REQUEST["order_items"]) && $_REQUEST["order_items"]!=""){
		
		$q->set( 'posts_per_page',$_REQUEST["order_items"]);
	}	
}

?>