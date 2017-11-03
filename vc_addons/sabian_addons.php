<?php
add_action( 'vc_before_init', 'sabian_register_slider_addon');

add_action('vc_before_init','sabian_register_cta_addon');

add_action('vc_before_init','sabian_register_clients_addon');

add_action('vc_before_init','sabian_register_title_addon');

add_action('vc_before_init','sabian_register_overlay_addon');

add_action('vc_before_init','sabian_register_featured_categories_addon');

add_action('vc_before_init','sabian_register_featured_categories_list_addon');

add_action('vc_before_init','sabian_register_testimonial_slider_addon');

add_action('vc_before_init','sabian_register_product_slider_addon');

$GLOBALS["slider_carousel_ids"]=909;

function sabian_register_slider_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_slider_opts=array();
	
	$sabian_category_blocks=array();
	
	$categories=array();
	
	$slider=$GLOBALS["sabian_slider_post"];
	
	$args=array("taxonomy"=>$slider->cat_name,"orderby"=>"name");
	
	$categories=get_categories($args);
	
	foreach($categories as $cat){
					$sabian_category_blocks[$cat->name]="sabiancat::".$cat->term_id;
	}
	
	$sabian_slider_opts[]=array(
	  'type' => 'dropdown',
	  'holder' => '',
	  'class' => '',
	  'heading' => __( "Select Slider Category" ),
	  'param_name' => 'sabian_slider_category',
	  'value' => $sabian_category_blocks,
	  'description' => __( 'Select Category' ),
     );
	 
	 $shortcode=array();
	  
	  $shortcode["title"]="sabian_posts_slider";
	  
	  $shortcode["callback"]="sabian_slider";
	  
	  $sabian_slider_addon=array(
            'name' => __( 'Sabian Slider' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_slider_opts);
			
	  $sabian_vc_addons->add_option($sabian_slider_addon,$shortcode);

}
function sabian_slider($attr,$content)
{
	$cat_id=$attr["sabian_slider_category"];
	
	$total_posts=$attr["sabian_slider_posts"];
	
	$slider=$GLOBALS["sabian_slider_post"];
	
	$cat=explode("::",$cat_id);
	
	$posts=sabian_get_posts($cat[1],$slider->post_name,$slider->cat_name);
	
	$cont='';
	
	$categories=sabian_get_product_categories();
	
	$slide_images=array();
	
	$opts=$GLOBALS["eap_model_options"];
	
	$vopts=$GLOBALS["eap_model_variant_options"];
	
	$yopts=$GLOBALS["eap_model_year_options"];
	
	foreach($posts as $i=>$post)
	{
		$image_link="";
		
		if(has_post_thumbnail($post->ID)){
			
			$imID=get_post_thumbnail_id($post->ID);
			$image_link=wp_get_attachment_url($imID);
			$slide_images[]=$image_link;
		}
	}
	
	ob_start();
	
	?>
    <style>
	.section_banner.parts .banner_content .container{
		margin-top:-60px;
	}
	.section_banner.parts [class*=banner_caption] {
		/*margin-bottom: 0px;*/
	}
	.section_banner.parts .banner_caption_container {
		padding: 5px 0px !important;
	}
	
	.banner_slide_control{
		position: absolute;
		z-index: 1399;
		top: 40%;
		bottom: 0;
		margin-top: auto;
		margin-bottom: auto;
		left: 0;
		text-align: center;
		color: #fff;
		font-size: 25px;
	}
	.banner_slide_control.control-left {
		left: 0;
		margin-left:30px;
	}
	.banner_slide_control.control-right {
		right: 0;
		left:auto;
		margin-right:30px;
	}
	
	.banner_slide_control span{
		cursor:pointer;	
		display:block;
		text-align:center;
		background: rgba(0,0,0,0.3);
		border-radius: 3px;	
		padding:10px 15px;
	}
	
	</style>
    <!--Mobile Slider-->
    <section class="section_banner shop parts" id="section_banner" data-slide-images="<?php echo implode(",",$slide_images); ?>">

<div class="banner_mask"></div>

        <!--Search Form-->
        <!--Search Slide SideBar-->
        <div class="search-picker visible-lg">
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
<input type="hidden" name="post_type" value="product" />
<input type="hidden" name="s" />

            <div class="header"><span>Search Parts</span></div>

            <div class="body">
            
                <div class="container">

                    <div class="row">

                        <div class="col-md-6">

                            <select class="form-control" name="model">
                                <option selected="selected" value="">Select Car Model</option>
                                <?php foreach($opts as $i=>$opt){ ?>
                                <option value="<?php echo $i; ?>"><?php echo $opt; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-md-6">

                            <select class="form-control" name="year">
                                <option selected="selected" value="">Year of Manufacturer</option>
                                <?php foreach($yopts as $i=>$yop) { ?>
                                <option value="<?php echo $yop ;?>"><?php echo $yop; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <select class="form-control" name="variant">
                                <option selected="selected" value="">Select Variant</option>
                                <?php foreach($vopts as $i=>$vop) { ?>
                                <option value="<?php echo $i ;?>"><?php echo $vop; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-md-12">

                            <select class="form-control" name="sab_cat">
                                <option selected="selected" value="">Select Category</option>
                                <?php foreach ($categories as $cat) { ?>
                                    <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                    </div>



                </div>
                

            </div>

            <div class="footer">

                <button class="btn btn-lg btn-block btn-alt btn-icon btn-icon btn-sign-in" type="submit">
                    <span>Search</span>
                </button>

            </div>
            </form>

        </div>
        <!--End form-->

        <!--Start Carousel Slide-->
        <div id="banner_carousel" class="banner_carousel carousel" data-ride="carousel">

            <!--Carousel Controls-->
            <div class="banner_slide_control control-left hidden-xs" id="slider_prev"><span><i class="fa fa-chevron-left"></i></span></div>
            <div class="banner_slide_control control-right hidden-xs" id="slider_next"><span><i class="fa fa-chevron-right"></i></span></div>
            
        
            <ol class="banner-indicators carousel-indicators">
                <?php foreach($posts as $j=>$post) {
					
					$is_active=$j==0;
					
					 ?>
                <li data-target="#banner_carousel" data-slide-to="<?php echo $j; ?>" class="<?php echo ($is_active)?"active":""; ?>"></li>
                <?php } ?>
            </ol>   
            <!--End Controls-->


            <div class="banner_content content_centered">

                <div class="container">

                    <!--Start Carousel Inner-->
                    <div class="carousel-inner">

<?php foreach($posts as $k=>$post) {
					
					$is_active=$k==0;
					
					$page=get_post_meta( $post->ID, $slider->link_meta_key, true );
	 
	 $btnText=get_post_meta( $post->ID, $slider->button_text_meta_key, true );
	 
	 $page=WP_Post::get_instance($page);
	 
	 $link=$page->guid;
					
					 ?>
                        <!--First Carousel-->
                        <div class="item <?php echo ($is_active)?"active":""; ?>">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="banner_caption_1 animatedDown anim_step_1" style="margin-bottom:0px !important"><h1><?php echo $post->post_title; ?></h1></div>

                                    <div class="banner_caption_container animatedDown anim_step_2">

                                        <div class="banner_description text_white"><?php echo $post->post_excerpt; ?></div>

                                    </div>


                                    <div class="banner_caption_4 animatedDown anim_step_3">
                                        <a class="btn btn-primary btn-icon btn-eye" href="<?php echo $link; ?>"><?php echo $btnText; ?></a>
                                    </div>

                                </div>

                                <!--<div class="col-md-6">
                                <img class="img-responsive pull-right" src="images/responsive-imac.png" />
                                </div>-->

                            </div>

                        </div>
                        <!--End First Carousel-->
                        <?php } ?>



                    </div>
                    <!--End Carousel Inner-->

                </div>

            </div>

        </div>
        <!--End Slide Carousel-->

    </section>
    <?php
	
	$cont=ob_get_contents();
	
	ob_end_clean();
   
    return $cont;
    
}


function sabian_register_cta_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Call To Action Description' ),
	 'param_name' => 'sabian_cta_description',
	 'value' => __( '' ),
	 'description' => __( 'Call To Action Description' ),
     );
	 
	 $sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Button Text' ),
	 'param_name' => 'sabian_cta_btn_text',
	 'value' => __( '' ),
	 'description' => __( 'Button Text' ),
     );
	 
	 $pages=sabian_get_pages();
	 
	 foreach($pages as $pag){
		 $sabian_page_blocks[$pag->post_title]=$pag->guid;
	}
	
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	 'class' => '',
	 'heading' => __( 'Select Go To Page' ),
	 'param_name' => 'sabian_cta_link',
	 'value' => $sabian_page_blocks,
	 'description' => __( 'Select Go To Page' ),
                );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_cta";
	 
	 $shortcode["callback"]="sabian_call_to_action";
	 
	 $sabian_slider_addon=array(
            'name' => __( 'Sabian Call To Action' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_slider_addon,$shortcode);

}
function sabian_call_to_action($attr,$content)
{
	$desc=$attr["sabian_cta_description"];
	
	$btnText=$attr["sabian_cta_btn_text"];
	
	$url=$attr["sabian_cta_link"];
	
    $cont='<div class="call_to_action">

        <div class="container">

            <div class="row">

                <div class="col-md-8">

                    <h2 class="message">'.$desc.'</h2>

                </div>

                <div class="col-md-4">

                    <a class="btn btn-white btn-icon btn-check btn-sm pull-right" href="'.$url.'">'.$btnText.'</a>

                </div>

            </div>

        </div>

    </div>';
	
	return $cont;
}
function sabian_register_clients_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_clients_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	 $sabian_opts[]=array(
	 'type' => 'dropdown',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Number of Columns' ),
	 'param_name' => 'sabian_clients_columns',
	 'value' =>array(5,6,7,8),
	 'description' => __( 'Number of Columns' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_clients_slider";
	 
	 $shortcode["callback"]="sabian_clients_slider";
	 
	 $sabian_slider_addon=array(
            'name' => __( 'Sabian Clients Slider' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_slider_addon,$shortcode);

}
function sabian_clients_slider($attr,$content)
{
	$title=$attr["sabian_clients_title"];
	
	$cols=$attr["sabian_clients_columns"];
	
	if(!$cols){ $cols=7; }
	
	$clPost=$GLOBALS["sabian_client_post"];
	
	$posts=sabian_get_posts(null,$clPost->post_name);
	
	$cont='

<div class="container">

<div class="row">

<div class="col-md-12">';
	
    $cont.='<h3 class="feature_top_heading text-center heading-alt text_condesed" style="margin-bottom:15px !important">'.$title.'</h3>
	<div class="owl-carousel owl-theme owl-items" data-items="'.$cols.'" id="clients_slider">';
	
	
		
		foreach($posts as $post){
			$img_id=get_post_thumbnail_id($post->ID);
			$img=wp_get_attachment_url($img_id);
			$link=get_post_meta($post->ID,$clPost->link_meta_key,true);
			if(!$link){ $link="#"; }
			$target='target="_blank"';
			if($link=="#"){ $target='target="_self"'; }
			$cont.='<div class="client"><a href="'.$link.'" alt="'.$post->post_title.'" '.$target.'><img src="'.$img.'"/></a></div>';	
		}
	
	
	$cont.='</div>';
 
 
$cont.='</div></div></div>'; 
 
	
	return $cont;
}



function sabian_register_title_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_title";
	 
	 $shortcode["callback"]="sabian_title";
	 
	 $sabian_addon=array(
            'name' => __( 'Sabian Title' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_addon,$shortcode);

}
function sabian_title($attr,$content)
{
	$title=$attr["sabian_title"];
	
	$cont='<h2 class="text-center heading-alt text_condesed" style="font-size: 20px">Top Categories</h2>';
	
	return $cont;
}


function sabian_register_overlay_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
                    'type' => 'attach_image',
                    'holder' => '',
                    'class' => '',
                    'heading' => __( 'Select Background Image' ),
                    'param_name' => 'sabian_overlay_image',
                    'value' => __( '' ),
                    'description' => __( 'Select Background Image' ),
	);
	
	$sabian_opts[]=array(
	'type' => 'iconpicker',
	'heading' => __( 'Icon', 'js_composer' ),
	'param_name' => 'sabian_overlay_icon',
	'settings' =>array(
	             'emptyIcon' => false, // default true, display an "EMPTY" icon?
				 'type' => 'fontawesome',
				 'iconsPerPage' => 200, // default 100, how many icons per/page to display
				 ),
	'dependency' => array(
	                'element' => 'icon_type',
					'value' => 'fontawesome',
					),
	'description' => __( 'Select icon from library.', 'js_composer' ),
);
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_overlay_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	 
	 $sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Overlay Description' ),
	 'param_name' => 'sabian_overlay_description',
	 'value' => __( '' ),
	 'description' => __( 'Overlay Description' ),
     );
	 
	 
	 $sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Overlay Button Text' ),
	 'param_name' => 'sabian_overlay_button_text',
	 'value' => __( '' ),
	 'description' => __( 'Overlay Button Text' ),
     );
	 
	 $pages=sabian_get_pages();
	 
	 foreach($pages as $pag){
		 $sabian_page_blocks[$pag->post_title]=$pag->guid;
	}
	
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	 'class' => '',
	 'heading' => __( 'Select Button Link' ),
	 'param_name' => 'sabian_overlay_button_link',
	 'value' => $sabian_page_blocks,
	 'description' => __( 'Select Button Link' ),
     );
	 
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_overlay_container";
	 
	 $shortcode["callback"]="sabian_overlay_container";
	 
	 $sabian_addon=array(
            'name' => __( 'Sabian Overlay Container' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_addon,$shortcode);

}
function sabian_overlay_container($attr,$content){
	
	$image=$attr["sabian_overlay_image"];
	
	$icon=$attr["sabian_overlay_icon"];
	
	$type=$attr["sabian_overlay_type"]; //big or small
	
	$title=$attr["sabian_overlay_title"];
	
	$description=$attr["sabian_overlay_description"];
	
	$button_text=$attr["sabian_overlay_button_text"];
	
	$button_url=$attr["sabian_overlay_button_link"];
	
	$image=wp_get_attachment_url($image);
	
	$cont='<div class="overlay_container overlay_feature visible-lg" style="background-image: url('.$image.'); margin-top: 0px;">

                    <div class="overlay_body" style="padding-top: 90px; padding-bottom: 90px; padding-left : 10px; padding-right:10px">

                        <span class="overlay_icon">

                            <i class="'.$icon.'"></i>

                        </span>

                        <h4 class="overlay_title">'.$title.'</h4>

                        <p class="overlay_description text_block">'.$description.'</p>

                        <a class="btn" href="'.$button_url.'">'.$button_text.'</a>

                    </div>

                </div>';
				
				return $cont;
}

function sabian_register_featured_categories_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_fc_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	 'class' => '',
	 'heading' => __( 'Select Number of Categories' ),
	 'param_name' => 'sabian_fc_limit',
	 'value' => array(3,6,9,12),
	 'description' => __( 'Select Number of Categories' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_featured_categories";
	 
	 $shortcode["callback"]="sabian_featured_categories";
	 
	 $sabian_addon=array(
            'name' => __( 'Sabian Featured Product Categories' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_addon,$shortcode);

}

function sabian_featured_categories($attrs,$content){
		
		$limit=$attrs["sabian_fc_limit"];
		
		$cont='';
		
		$categories=sabian_get_product_categories();
		
		$fcats=array();
		
		foreach($categories as $i=>$cat){
			
			$thumbID=sabian_get_category_image_id($cat->term_id);
			
			if($thumbID==null | !$thumbID)
			continue;
			
			$fcats[]=$cat;
		}
		
		$cont.='<div class="row">';
		
		//$cont.=print_r($fcats,true);
		
        foreach($fcats as $j=>$ncat) {
			
			if($j>=$limit){
				break;	
			}
			$link=get_term_link((int)$ncat->term_id,"product_cat");
			
			if($link instanceof WP_Error){
				
				$link="#";	
			}
			
			$thumbID=sabian_get_category_image_id($ncat->term_id);
			
			$image=wp_get_attachment_url($thumbID);
			
			$cont.='<div class="col-md-4 featured-category-cont">

                            <div class="thumbnail featured-category">

                                <div class="img" style="background-image: url('.$image.')"></div>

                                <div class="caption">
                                    <h3>'.sabian_get_ellipsis($ncat->name,35).'</h3>

                                    <a class="btn btn-primary" href="'.$link.'">View More</a>
                                </div>
                            </div>

                        </div>';
}
                        

                        
                        
                        $cont.='</div>';
						
						return $cont;
        
}


function sabian_register_featured_categories_list_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts[]=array(
	 'type' => 'textfield',
	 'holder' => '',
	 'class' => '',
	 'heading' => __( 'Title' ),
	 'param_name' => 'sabian_fc_title',
	 'value' => __( '' ),
	 'description' => __( 'Title' ),
     );
	 
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	 'class' => '',
	 'heading' => __( 'Select Number of Categories' ),
	 'param_name' => 'sabian_fc_limit',
	 'value' => array(2,3,4,5,6,7,8,9,10,11,12,13,14,15),
	 'description' => __( 'Select Number of Categories' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_featured_categories_list";
	 
	 $shortcode["callback"]="sabian_featured_categories_list";
	 
	 $sabian_addon=array(
            'name' => __( 'Sabian Featured Product Categories List' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_addon,$shortcode);

}


function sabian_featured_categories_list($attrs,$content){
		
		$limit=$attrs["sabian_fc_limit"];
		
		$title=$attrs["sabian_fc_title"];
		
		$cont='<div class="category_title">

                            <span>'.$title.'</span>

                        </div>';
		
		$categories=sabian_get_product_categories();
		
		$fcats=array();
		
		foreach($categories as $i=>$cat){
			
			if($cat->count<=0){
				continue;	
			}
			
			$fcats[]=$cat;
		}
		
		$cont.='<ul class="categories highlight">';
		
		//$cont.=print_r($fcats,true);
		
        foreach($fcats as $j=>$ncat) {
			
			if($j>=$limit){
				break;	
			}
			$link=get_term_link((int)$ncat->term_id,"product_cat");
			
			if($link instanceof WP_Error){
				
				$link="#";	
			}
			
			$cont.='<li><a href="'.$link.'">'.$ncat->name.' ('.$ncat->count.')</a></li>';
}

$cont.='</ul>';
						
						return $cont;
        
}

function sabian_register_testimonial_slider_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_slider_opts=array();
	
	$sabian_category_blocks=array();
	
	$categories=array();
	
	$slider=$GLOBALS["sabian_testimonial_post"];
	
	$args=array("taxonomy"=>$slider->cat_name,"orderby"=>"name");
	
	$categories=get_categories($args);
	
	foreach($categories as $cat){
					$sabian_category_blocks[$cat->name]="sabiancat::".$cat->term_id;
	}
	
	$sabian_slider_opts[]=array(
                    'type' => 'attach_image',
                    'holder' => '',
                    'class' => '',
                    'heading' => __( 'Select Background Image' ),
                    'param_name' => 'sabian_testimonial_bg_image',
                    'value' => __( '' ),
                    'description' => __( 'Select Background Image' ),
	);
	
	$sabian_slider_opts[]=array(
	  'type' => 'dropdown',
	  'holder' => '',
	  'class' => '',
	  'heading' => __( "Select Category" ),
	  'param_name' => 'sabian_testimonial_category',
	  'value' => $sabian_category_blocks,
	  'description' => __( 'Select Category' ),
     );
	 
	 $shortcode=array();
	  
	  $shortcode["title"]="sabian_testimonials_slider";
	  
	  $shortcode["callback"]="sabian_testimonials_slider";
	  
	  $sabian_slider_addon=array(
            'name' => __( 'Sabian Testimonials Slider' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_slider_opts);
			
	  $sabian_vc_addons->add_option($sabian_slider_addon,$shortcode);

}

function sabian_testimonials_slider($attrs,$content){
	
	$cat=$attrs["sabian_testimonial_category"];
	
	$image=$attrs["sabian_testimonial_bg_image"];
	
	$image=wp_get_attachment_url($image);
	
	$cat=explode("::",$cat);
	
	$cat=$cat[1];
	
	$cont='';
	
	$tpost=$GLOBALS["sabian_testimonial_post"];
	
	$test_posts=sabian_get_posts($cat, $tpost->post_name, $tpost->cat_name);
	
    $cont='<section class="section_testimonial overlay_container overlay_feature overlay_bg_fixed" style="background-image:url('.$image.')">
	
	<div class="container">

        <div class="row">

            <div class="col-md-12 testimonial">

                <!--<div class="owl-carousel owl-theme owl-items" data-items="3">-->

                <div class="carousel-testimonials slide" id="carouselTestimonial">

                    <div class="owl-carousel owl-theme owl-single" id="carouselOwlTestimonial">';

foreach($test_posts as $test) {
	
	$unames=get_post_meta( $test->ID, $tpost->user_name_meta_key, true );
	
	$uposition=get_post_meta( $test->ID, $tpost->user_position_meta_key, true );
	
	$ucompany=get_post_meta( $test->ID, $tpost->user_company_meta_key, true );
	
	$name=$test->post_title;
	
	$desc=$test->post_excerpt;
	
	$image_link="";
	 
	 if(has_post_thumbnail($test->ID)){
		 
		 $imID=get_post_thumbnail_id($test->ID);
		 
		 $image_link=wp_get_attachment_url($imID);
		 
	 }
	 
	 $cont.='<div class="item">

                            <div class="testimonial_image" style="background-image:url('.$image_link.'); background-position:-5px center"></div>

                            <h2 class="testimonial_heading">'.$name.'</h2>

                            <p class="testimonial_description">'.$desc.'</p>

                            <p class="testimonial_by"> By '.$unames.' <span>-'.$uposition.'  '. $ucompany. '</span></p>

                        </div>';
                        
                        }

                    $cont.='</div>

                </div>

            </div>

        </div>

    </div>
	
	<ol class="carousel-indicators testimonial_indicators">
        <li data-target="#carouselOwlTestimonial" data-slide-to="0" class="active owl_carousel_nav"></li>
        <li data-target="#carouselOwlTestimonial" data-slide-to="1" class="owl_carousel_nav"></li>

    </ol>
	
	</section>
	';
	
	return $cont;	
}

function sabian_register_product_slider_addon()
{
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$cats=sabian_get_product_categories();
	
	$cats=array_filter($cats,function($cat){
		
		return $cat->count>0;
		
	});
	
	$scats=array();
	
	foreach($cats as $cat){
		
		$scats[$cat->name]=$cat->term_id;	
	}
	 
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	'class' => '',
	'heading' => __( 'Select Category' ),
	'param_name' => 'sabian_products_slider_cat',
	'value' => $scats,
	'description' => __( 'Select Category' ),);
	
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	'class' => '',
	'heading' => __( 'Product Limit' ),
	'param_name' => 'sabian_products_slider_limit',
	'value' => array(2,3,4,5,6,7,8,9,10),
	'description' => __( 'Product Limit' ),);
	
	$sabian_opts[]=array(
	'type' => 'dropdown',
	'holder' => '',
	'class' => '',
	'heading' => __( 'Product Column' ),
	'param_name' => 'sabian_products_slider_columns',
	'value' => array(2,4,6,8),
	'description' => __( 'Product Column' ),);
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_products_slider_category";
	 
	 $shortcode["callback"]="sabian_products_slider_category";
	 
	 $sabian_addon=array(
            'name' => __( 'Sabian Products Slider Category' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	$sabian_vc_addons->add_option($sabian_addon,$shortcode);

}

function sabian_products_slider_category($attrs,$content){
	
	$cat_id=$attrs["sabian_products_slider_cat"];
	
	$column=$attrs["sabian_products_slider_columns"];
	
	$limit=$attrs["sabian_products_slider_limit"];
	
	$cont='';
	
	$products=sabian_get_products_by_category($cat_id);
	
	$cat=sabian_get_product_category_by_id($cat_id);
	
	if(count($products)>0){
		
		$products=array_chunk($products,$limit);
		
		$products=$products[0];	
	}
	
	ob_start();
	
	$sliderID=++$GLOBALS["slider_carousel_ids"];
	
	$sliderID="sabian_product_cat_".$sliderID;
	
	$link=get_term_link((int)$cat->term_id,"product_cat");
	
	if($link instanceof WP_Error){
		$link="#";	
	}
	
	?>

    <div class="container">

        <div class="row">

                    <div class="col-md-12">

                        <div class="category_title">

                            <span><a href="<?php echo $link; ?>"><?php echo $cat->name; ?></a> </span>

                        </div>

                        <div class="owl-carousel owl-theme owl-items" data-items="<?php echo $column; ?>" data-dots="true" id="<?php echo $sliderID; ?>">

                            <?php foreach ($products as $i=>$product) {
								
								if($i>=$limit)
								break;
								
								 ?>
                                
                                <?php sabian_get_product_template($product,apply_filters("sabian_main_wc_product_template","1")); ?>

                            <?php } ?>

                        </div>

                        <div class="owl-nav">
                            <div class="owl-prev owl_carousel_nav" data-target="#<?php echo $sliderID; ?>" data-slide-to="prev"><i class="fa fa-angle-left"></i></div>
                            <div class="owl-next owl_carousel_nav" data-target="#<?php echo $sliderID; ?>" data-slide-to="next"><i class="fa fa-angle-right"></i></div>
                        </div>

                    </div>

                

        </div>

    </div>
    <?php	
	
	$cont=ob_get_contents();
	
	ob_end_clean();
	
	return $cont;
}
?>