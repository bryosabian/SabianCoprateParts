<?php
if(!defined("EAP_MODEL_OPTION_OUTBACK")){
	define("EAP_MODEL_OPTION_OUTBACK","outback");	
}
if(!defined("EAP_MODEL_OPTION_SUBARU")){
	define("EAP_MODEL_OPTION_SUBARU","subaru");	
}
if(!defined("EAP_MODEL_KEY")){
	define("EAP_MODEL_KEY","eap_model");	
}
if(!defined("EAP_MODEL_YEAR_KEY")){
	define("EAP_MODEL_YEAR_KEY","eap_model_year");	
}
if(!defined("EAP_MODEL_VARIANT_KEY")){
	define("EAP_MODEL_VARIANT_KEY","eap_model_variant");	
}
if(!defined("EAP_MODEL_MANUF_KEY")){
	define("EAP_MODEL_MANUF_KEY","eap_model_manufacturer");	
}
if(!defined("EAP_MODEL_PART_NO_KEY")){
	define("EAP_MODEL_PART_NO_KEY","eap_model_part_number");	
}

add_action("init",function(){
	
	$GLOBALS["eap_model_options"]=apply_filters("eap_model_options",array(EAP_MODEL_OPTION_OUTBACK=>"Outback",EAP_MODEL_OPTION_SUBARU=>"Subaru"));
	
	$GLOBALS["eap_model_year_options"]=apply_filters("eap_model_year_options",array(date("Y")));
	
	$GLOBALS["eap_model_variant_options"]=apply_filters("eap_model_variant_options",array("ll_bean_edition"=>"LL Bean Edition","subaru"=>"Subaru"));
	
	$GLOBALS["eap_model_manuf_options"]=apply_filters("eap_model_manuf_options",array("Isuzu","Subaru"));
	
},5);


add_filter("eap_model_options",function($options){
	
	$models=sabian_get_posts(null,EAP_MODEL_POST_NAME);
	
	$opts=array();
	
	foreach($models as $mod){
		
		$opts[$mod->ID]=$mod->post_title;
	}
	
	return $opts;
});


add_filter("eap_model_variant_options",function($options){
	
	$models=sabian_get_posts(null,EAP_VARIANT_POST_NAME);
	
	$opts=array();
	
	foreach($models as $mod){
		
		$opts[$mod->ID]=$mod->post_title;
	}
	
	return $opts;
});


add_filter("eap_model_manuf_options",function($options){
	
	$models=sabian_get_posts(null,EAP_MANUF_POST_NAME);
	
	$opts=array();
	
	foreach($models as $mod){
		
		$opts[$mod->ID]=$mod->post_title;
	}
	
	return $opts;
});

add_action( 'add_meta_boxes', function(){
	
	add_meta_box( 
	'sabian_part_model_box',
	'Car Model',
	'eap_model_box',
	'product',
	'side',
	'high'
	);	
});

add_action( 'save_post', 'eap_model_update');

/*Product Search*/
add_action("woocommerce_product_query",'eap_model_search',10000,2);

function eap_model_search($q,$wcq){
	
	$meta_query=$q->get('meta_query');
	
	$tax_query=$q->get('tax_query');
	
	$model_set=false;
	
	$var_set=false;
	
	$year_set=false;
	
	$cat_set=false;
	
	if(isset($_REQUEST["model"]) && $_REQUEST["model"]!=""){
		
		$model_set=true;
		
		$model=$_REQUEST["model"];
		
		$meta_query[]=array(
		
		'key'=>EAP_MODEL_KEY,
		'value'=>$model,
		'compare'=>'='
		
		);
	}
	
	
	if(isset($_REQUEST["year"]) && $_REQUEST["year"]!=""){
		
		$year_set=true;
		
		$year=$_REQUEST["year"];
		
		$meta_query[]=array(
		
		'key'=>EAP_MODEL_YEAR_KEY,
		'value'=>$year,
		'compare'=>'='
		
		);
	}
	
	if(isset($_REQUEST["variant"]) && $_REQUEST["variant"]!=""){
		
		$var_set=true;
		
		$var=$_REQUEST["variant"];
		
		$meta_query[]=array(
		
		'key'=>EAP_MODEL_VARIANT_KEY,
		'value'=>$var,
		'compare'=>'='
		
		);
	}
	
	if(isset($_REQUEST["sab_cat"]) && $_REQUEST["sab_cat"]!=""){
		
		$cat_set=true;
		
		$cat=sabian_get_product_category_by_id($_REQUEST["sab_cat"]);
		
		if($cat!=null && !($cat instanceof WP_Error)){
		
		$tax_query=array(array(
		'taxonomy'=>'product_cat',
		'field'=>'term_id',
		'terms'=>array($cat->term_id),
		
		));
		
		$q->set('tax_query',$tax_query);
		
		}else{
			$cat_set=false;
		}
	}
	
	$q->set('meta_query',$meta_query);
	
	
}


/*Title search settings*/
add_filter("sabian_wc_page_title",function($title){
	
	global $product;
	
	$post=$product->post;
	
	$model_set=false;
	
	$var_set=false;
	
	$year_set=false;
	
	$cat_set=false;
	
	$year_options=$GLOBALS["eap_model_year_options"];
	
	$model_options=$GLOBALS["eap_model_options"];
	
	$variant_options=$GLOBALS["eap_model_variant_options"];
	
	if(isset($_REQUEST["model"]) && $_REQUEST["model"]!=""){
		
		$model_set=true;
		
		$model=$model_options[$_REQUEST["model"]];
	}
	
	
	if(isset($_REQUEST["year"]) && $_REQUEST["year"]!=""){
		
		$year_set=true;
	}
	
	if(isset($_REQUEST["variant"]) && $_REQUEST["variant"]!=""){
		
		$variant=$variant_options[$_REQUEST["variant"]];
		
		$var_set=true;
	}
	
	if(isset($_REQUEST["sab_cat"]) && $_REQUEST["sab_cat"]!=""){
		
		$cat=sabian_get_product_category_by_id($_REQUEST["sab_cat"]);
		
		if($cat!=null && !($cat instanceof WP_Error)){
			$cat_set=true;
		}
		
	}
		
		$ttle=array();
		
		if($model_set){
			$ttle[]="Model ".$model;	
		}
		
		if($var_set){
			$ttle[]="Variant ".$variant;			
		}
		
		if($year_set){
			$ttle[]="Year ".$_REQUEST["year"];			
		}
		if($cat_set){
		$ttle[]="Category ".$cat->name;	
		}
		
		if(count($ttle)<=0){
			return $title;
				
		}
		
		return implode(",",$ttle);
	});

function eap_model_box($post){
	
	wp_nonce_field( plugin_basename( __FILE__ ), "eap_model_nonce");
	
	$model=get_post_meta( $post->ID, EAP_MODEL_KEY, true);
	
	$year=get_post_meta( $post->ID, EAP_MODEL_YEAR_KEY, true);
	
	$variant=get_post_meta( $post->ID, EAP_MODEL_VARIANT_KEY, true);
	
	$manuf=get_post_meta( $post->ID, EAP_MODEL_MANUF_KEY, true);
	
	$pNumber=get_post_meta($post->ID,EAP_MODEL_PART_NO_KEY,true);
	
	$year_options=$GLOBALS["eap_model_year_options"];
	
	$model_options=$GLOBALS["eap_model_options"];
	
	$variant_options=$GLOBALS["eap_model_variant_options"];
	
	$manuf_options=$GLOBALS["eap_model_manuf_options"];
	
	$modelChosen=false;
	
	$variantChosen=false;
	
	$manufChosen=false;
	
	if($model && isset($model_options[$model])){
		
		$modelChosen=true;
		
		$selKey=$model;
		
		$selValue=$model_options[$model];
	}
	
	if($variant && isset($variant_options[$variant])){
		
		$variantChosen=true;
		
		$selVar=$variant;
		
		$selVarValue=$variant_options[$variant];
	}
	if($manuf && isset($manuf_options[$manuf])){
		
		$manufChosen=true;
		
		$selMan=$manuf;
		
		$selManValue=$manuf_options[$selMan];	
	}
		
	$keys=array_keys($model_options);
	
	$values=array_values($model_options);
		?>
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Car Model</label>
		
        <label class="select">
		<select name="eap_model">
        <option>Select Car Model</option>
		
        <?php if($modelChosen) { ?> <option selected value="<?php echo $selKey; ?>"><?php echo $selValue; ?></option> <?php } ?>
        
                <?php foreach($keys as $key) { ?>
        		<option value="<?php echo $key; ?>"><?php echo $model_options[$key]; ?></option>
                <?php } ?>
        		
		 </select>
         
         <i></i>
         
         </label>
		
		</div>
        
        
        
        
        
        
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Variant</label>
		
        <label class="select">
		<select name="eap_model_variant">
		<option>Select Car Variant</option>
        <?php if($variantChosen) { ?> <option selected value="<?php echo $selVar; ?>"><?php echo $selVarValue; ?></option> <?php } ?>
        
                <?php foreach($variant_options as $i=>$var) { ?>
        		<option value="<?php echo $i; ?>"><?php echo $var; ?></option>
                <?php } ?>
        		
		 </select>
         
         <i></i>
         
         </label>
		
		</div>
        
        
        
        
        
        
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Manufacturer</label>
		
        <label class="select">
		<select name="eap_manuf">
        <option>Select Manufacturer</option>
		
        <?php if($manufChosen) { ?> <option selected value="<?php echo $selMan; ?>"><?php echo $selManValue; ?></option> <?php } ?>
        
                <?php foreach($manuf_options as $i=>$var) { ?>
        		<option value="<?php echo $i; ?>"><?php echo $var; ?></option>
                <?php } ?>
        		
		 </select>
         
         <i></i>
         
         </label>
		
		</div>
        
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Year of Manufacturer</label>
		
        <label class="select">
		<select name="eap_model_year">
		<option>Select Year</option>
        <?php if($year) { ?> <option selected value="<?php echo $year; ?>"><?php echo $year; ?></option> <?php } ?>
        
                <?php foreach($year_options as $yopt) { ?>
        		<option value="<?php echo $yopt; ?>"><?php echo $yopt; ?></option>
                <?php } ?>
        		
		 </select>
         
         <i></i>
         
         </label>
		
		</div>
        
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Enter Part Number</label>
		
        <label class="input">
		<input name="eap_part_no" placeholder="Enter Part Number" type="text" value="<?php echo $pNumber; ?>" />
         
         </label>
		
		</div>
        
        <?php
}

function eap_model_update($post_id){
	
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;
	
	if ( !wp_verify_nonce( $_POST["eap_model_nonce"], plugin_basename( __FILE__ ) ) )
	return;
	
	if('product'!==$_POST['post_type'])
	return;
	
	$model=$_POST['eap_model'];
	
	$variant=$_POST["eap_model_variant"];
	
	$year=$_POST["eap_model_year"];
	
	$manuf=$_POST["eap_manuf"];
	
	$p_no=$_POST["eap_part_no"];
	
	sabian_update_meta_values($post_id,EAP_MODEL_KEY,$model);
	
	sabian_update_meta_values($post_id,EAP_MODEL_VARIANT_KEY,$variant);
	
	sabian_update_meta_values($post_id,EAP_MODEL_YEAR_KEY,$year);
	
	sabian_update_meta_values($post_id,EAP_MODEL_MANUF_KEY,$manuf);
	
	sabian_update_meta_values($post_id,EAP_MODEL_PART_NO_KEY,$p_no);
		
}
		
/*Single product meta info*/		
add_action("sabian_product_meta_before",function(){
	
	global $product;
	
	$post=$product->post;
	
	$model=get_post_meta($post->ID, EAP_MODEL_KEY, true);
	
	$year=get_post_meta($post->ID, EAP_MODEL_YEAR_KEY, true);
	
	$variant=get_post_meta($post->ID, EAP_MODEL_VARIANT_KEY, true);
	
	$pNumber=get_post_meta($post->ID,EAP_MODEL_PART_NO_KEY,true);
	
	$mf=get_post_meta($post->ID, EAP_MODEL_MANUF_KEY, true);
	
	$year_options=$GLOBALS["eap_model_year_options"];
	
	$model_options=$GLOBALS["eap_model_options"];
	
	$variant_options=$GLOBALS["eap_model_variant_options"];
	
	$model_is_set=false;
	
	$year_is_set=false;
	
	$variant_is_set=false;
	
	$p_no_is_set=$pNumber!==FALSE;
	
	$manuf_is_set=(!$mf)!=true;
	
	if(isset($model_options[$model])){
		$mPost=WP_Post::get_instance($model);
		$model=$model_options[$model];
		$model_is_set=true;
	}
	if($year){
		$year_is_set=true;	
	}
	if(isset($variant_options[$variant])){
		$vPost=WP_Post::get_instance($variant);
		$variant=$variant_options[$variant];
		$variant_is_set=true;
	}
	
	if($manuf_is_set){
	    
	    $mfPost=WP_Post::get_instance($mf);
	    
	    $mfLink=get_permalink($mfPost->ID);
	}
	
	?>
	
	 <?php if($manuf_is_set) { ?>
                                    <p><i class="fa fa-dashboard"></i><strong>Manufacturer</strong>: <a href="<?php echo $mfLink; ?>"><?php echo $mfPost->post_title; ?></a></p>
                                    <?php } ?>
    
    <?php if($p_no_is_set) { ?>
                                    <p><i class="fa fa-user"></i><strong>Part Number</strong>: <?php echo $pNumber; ?></p>
                                    <?php } ?>
	
	<?php if($model_is_set) { ?>
                                    <p><i class="fa fa-dashboard"></i><strong>Model</strong>: <a href="<?php echo get_permalink($mPost->ID); ?>"><?php echo $model; ?></a></p>
                                    <?php } ?>
                                    
                                    <?php if($variant_is_set) { ?>
                                    <p><i class="fa fa-dashboard"></i><strong>Variant</strong>: <a href="<?php echo get_permalink($vPost->ID); ?>"><?php echo $variant; ?></a></p>
                                    <?php } ?>
                                    
                                    <?php if($year_is_set) { ?>
                                    <p><i class="fa fa-calendar"></i><strong>Year</strong>: <?php echo $year; ?></p>
                                    <?php } ?>
                                    
                                    <hr />
<?php });


/*Single product manufacturer info*/		
add_action("sabian_after_brief_product_description",function(){
	
	global $product;
	
	$post=$product->post;
	
	$mf=get_post_meta($post->ID, EAP_MODEL_MANUF_KEY, true);
	
	if(!$mf){
		return;	
	}
	
	$mfPost=WP_Post::get_instance($mf);
	
	if(!$mfPost){
		return;	
	}
	
	$img_id=get_post_thumbnail_id($mfPost->ID);
	
	$img=wp_get_attachment_url($img_id);
	
	$link=get_permalink($mfPost->ID);
	
	?>
    
    <p style="margin:0">
    <a href="<?php echo $link; ?>">
    <img src="<?php echo $img; ?>" class="img_manufacturer" style="width:auto; height:auto; max-height:83px" />
    <span style="display:inline-block; vertical-align:middle; font-weight:bold; font-size:18px" class="text_condesed"><?php echo $mfPost->post_title; ?></span>
    </p>
    </a>
    
    <hr>
    
    <?php
		
		
});

?>