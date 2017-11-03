<?php
add_action('vc_before_init','sabian_register_model_select_addon');

add_action('vc_before_init','sabian_register_manuf_select_addon');

function sabian_register_model_select_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_model_search_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	 $sabian_opts[]=array(
	 'type' => 'dropdown',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Number of Columns' ),
	 'param_name' => 'sabian_model_search_columns',
	 'value' =>array(5,6,7,8),
	 'description' => __( 'Number of Columns' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_model_search";
	 
	 $shortcode["callback"]="sabian_model_search";
	 
	 $sabian_slider_addon=array(
            'name' => __( 'EAP Model Search' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_slider_addon,$shortcode);

}
function sabian_model_search($attr,$content)
{
	$title=$attr["sabian_model_search_title"];
	
	$items=$attr["sabian_model_search_columns"];
	
	if(!$items){ $items=7;  }
	
	$posts=sabian_get_posts(null,EAP_MODEL_POST_NAME);
	
	$cont='

<div class="container">

<div class="row">

<div class="col-md-12">';
	
    $cont.='<h3 class="feature_top_heading text-center heading-alt text_condesed">'.$title.'</h3>
	<div class="owl-carousel owl-theme owl-items" data-items="'.$items.'" id="featured_items_slider">';
	
	
		
		foreach($posts as $post){
			$img_id=get_post_thumbnail_id($post->ID);
			$img=wp_get_attachment_url($img_id);
			$link=get_permalink($post->ID);
			$cont.='<div class="feature_top_item"><a href="'.$link.'" alt="'.$post->post_title.'"><img src="'.$img.'"/></a></div>';	
		}
	
	
	$cont.='</div>';
 
 
$cont.='</div></div></div>'; 
 
	
	return $cont;
}



function sabian_register_manuf_select_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_manuf_search_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	 $sabian_opts[]=array(
	 'type' => 'dropdown',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Number of Columns' ),
	 'param_name' => 'sabian_manuf_columns',
	 'value' =>array(5,6,7,8),
	 'description' => __( 'Number of Columns' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_manuf_search";
	 
	 $shortcode["callback"]="sabian_manuf_search";
	 
	 $sabian_slider_addon=array(
            'name' => __( 'EAP Manufacturer Search' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_slider_addon,$shortcode);

}
function sabian_manuf_search($attr,$content)
{
	$title=$attr["sabian_manuf_search_title"];
	
	$cols=$attr["sabian_manuf_columns"];
	
	if(!$cols){ $cols=7; }
	
	$posts=sabian_get_posts(null,EAP_MANUF_POST_NAME);
	
	$cont='

<div class="container">

<div class="row">

<div class="col-md-12">';
	
    $cont.='<h3 class="feature_top_heading text-center heading-alt text_condesed">'.$title.'</h3>
	<div class="owl-carousel owl-theme owl-items" data-items="'.$cols.'" id="featured_items_slider" data-dots="true">';
	
	foreach($posts as $post){
			$img_id=get_post_thumbnail_id($post->ID);
			$img=wp_get_attachment_url($img_id);
			$link=get_permalink($post->ID);
			$cont.='<div class="feature_top_item"><a href="'.$link.'" alt="'.$post->post_title.'"><img src="'.$img.'"/></a></div>';	
		}
	
	
	$cont.='</div>';
 
 
$cont.='</div></div></div>'; 
 
	
	return $cont;
}
?>