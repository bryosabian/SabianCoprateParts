<?php
if(!defined("EAP_MANUF_POST_KEY")){
	define("EAP_MANUF_POST_KEY","eap_manuf_post_key");	
}
if(!defined("EAP_MANUF_POST_NAME")){
	define("EAP_MANUF_POST_NAME","eap_manuf_post");	
}

add_action( 'init', 'eap_manuf_register_post');

function eap_manuf_register_post() {
		
		$labels = array(
		'name'               => _x( 'Car Part Manufacturer', 'post type general name' ),
		'singular_name'      => _x( 'Car Manufacturer', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'manufacturer' ),
		'add_new_item'       => __( 'Add New Manufacturer' ),
		'edit_item'          => __( 'Edit Manufacturer' ),
		'new_item'           => __( 'New Manufacturer' ),
		'all_items'          => __( 'All Manufacturers' ),
		'view_item'          => __( 'View Manufacturer' ),
		'not_found'          => __( 'No manufacturer found' ),
		'not_found_in_trash' => __( 'No manufacturers found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Car Part Manufacturers'
		);
		
		$args = array(
		'labels'        => $labels,
		'description'   => 'Collection of various car manufacturers',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title','content', 'thumbnail'),
		'has_archive'   => true,
		);
		
		register_post_type(EAP_MANUF_POST_NAME, $args ); 
	}		

/*Custom permalinks*/
add_action('wp_loaded','eap_manuf_permastructure');
	
function eap_manuf_permastructure(){
	
	global $wp_rewrite;
	
	add_permastruct(EAP_MANUF_POST_NAME,'manufacturers/%'.EAP_MANUF_POST_NAME.'%',false);
		
}

?>