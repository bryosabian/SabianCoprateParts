<?php
if(!defined("EAP_VARIANT_POST_KEY")){
	define("EAP_VARIANT_POST_KEY","eap_model_post_key");	
}
if(!defined("EAP_VARIANT_MODEL_KEY")){
	define("EAP_VARIANT_MODEL_KEY","eap_variant_model_key");	
}
if(!defined("EAP_VARIANT_POST_NAME")){
	define("EAP_VARIANT_POST_NAME","eap_variant_post");	
}

add_action( 'init', 'eap_variant_register_post');

add_action( 'add_meta_boxes', function(){
	
	add_meta_box( 
	'sabian_variant_model_box',
	'Car Model',
	'eap_variant_model_box',
	EAP_VARIANT_POST_NAME,
	'normal',
	'high'
	);	
});

add_action( 'save_post', 'eap_variant_model_update');

function eap_variant_register_post() {
		
		$labels = array(
		'name'               => _x( 'Car Variant', 'post type general name' ),
		'singular_name'      => _x( 'Car Variant', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'property' ),
		'add_new_item'       => __( 'Add New Variant' ),
		'edit_item'          => __( 'Edit Variant' ),
		'new_item'           => __( 'New Variant' ),
		'all_items'          => __( 'All Variants' ),
		'view_item'          => __( 'View Variant' ),
		'not_found'          => __( 'No variant found' ),
		'not_found_in_trash' => __( 'No variants found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Car Variants'
		);
		
		$args = array(
		'labels'        => $labels,
		'description'   => 'Collection of various car variants',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title','content', 'thumbnail'),
		'has_archive'   => true,
		);
		
		register_post_type(EAP_VARIANT_POST_NAME, $args ); 
	}

function eap_variant_model_box($post){
	
	wp_nonce_field( plugin_basename( __FILE__ ), "eap_variant_model_nonce");
	
	$model=get_post_meta( $post->ID, EAP_VARIANT_MODEL_KEY, true);
	
	$model_options=$GLOBALS["eap_model_options"];
	
	$modelChosen=false;
	
	$variantChosen=false;
	
	if($model && isset($model_options[$model])){
		
		$modelChosen=true;
		
		$selKey=$model;
		
		$selValue=$model_options[$model];
	}
		
	$keys=array_keys($model_options);
	
	$values=array_values($model_options);
		?>
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Car Model</label>
		
        <label class="select">
		<select name="eap_model">
		
        <?php if($modelChosen) { ?> <option selected value="<?php echo $selKey; ?>"><?php echo $selValue; ?></option> <?php } ?>
        
                <?php foreach($keys as $key) { ?>
        		<option value="<?php echo $key; ?>"><?php echo $model_options[$key]; ?></option>
                <?php } ?>
        		
		 </select>
         
         <i></i>
         
         </label>
		
		</div>
        
         <?php
}

function eap_variant_model_update($post_id){
	
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;
	
	if ( !wp_verify_nonce( $_POST["eap_variant_model_nonce"], plugin_basename( __FILE__ ) ) )
	return;
	
	if(EAP_VARIANT_POST_NAME!==$_POST['post_type'])
	return;
	
	$model=$_POST['eap_model'];
	
	sabian_update_meta_values($post_id,EAP_VARIANT_MODEL_KEY,$model);
		
}		

/*Custom permalinks*/
add_action('wp_loaded','eap_variant_permastructure');
	
function eap_variant_permastructure(){
	
	global $wp_rewrite;
	
	add_permastruct(EAP_VARIANT_POST_NAME,'variants/%'.EAP_VARIANT_POST_NAME.'%',false);
		
}

?>