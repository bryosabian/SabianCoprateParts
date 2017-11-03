<?php
if(!defined("EAP_MODEL_POST_KEY")){
	define("EAP_MODEL_POST_KEY","eap_model_post_key");	
}
if(!defined("EAP_MODEL_POST_NAME")){
	define("EAP_MODEL_POST_NAME","eap_model_post");	
}

add_action( 'init', 'eap_model_register_post');

function eap_model_register_post() {
		
		$labels = array(
		'name'               => _x( 'Car Model', 'post type general name' ),
		'singular_name'      => _x( 'Car Model', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'property' ),
		'add_new_item'       => __( 'Add New Model' ),
		'edit_item'          => __( 'Edit Model' ),
		'new_item'           => __( 'New Model' ),
		'all_items'          => __( 'All Models' ),
		'view_item'          => __( 'View Model' ),
		'not_found'          => __( 'No model found' ),
		'not_found_in_trash' => __( 'No models found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Car Models'
		);
		
		$args = array(
		'labels'        => $labels,
		'description'   => 'Collection of various car models',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title','content', 'thumbnail'),
		'has_archive'   => true,/*
		'rewrite'   => array('slug'=>'easyparts/'.EAP_MODEL_POST_NAME),*/
		);
		
		register_post_type(EAP_MODEL_POST_NAME, $args ); 
	}
	
	/*Custom permalinks*/
	add_action('wp_loaded','eap_model_permastructure');
	
	function eap_model_permastructure(){
		
		global $wp_rewrite;
		
		add_permastruct(EAP_MODEL_POST_NAME,'models/%'.EAP_MODEL_POST_NAME.'%',false);
		
	}
	
	
		

?>