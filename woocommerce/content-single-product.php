<?php
global $product;

$rating_count=$product->get_rating_count();

$review_count = $product->get_review_count();

$average_rating=$product->get_average_rating();

$price_html=$product->get_price_html();

$attributes = $product->get_attributes();

$image_link=wp_get_attachment_url($product->get_image_id());

$isdiscount=false;

$sale_price=$product->get_sale_price();
								
$reg_price=$product->get_regular_price();

if($sale_price<$reg_price && $sale_price!=$reg_price && $sale_price>0){
									
									$isdiscount=true;
									
									$discount=$reg_price-$sale_price;
									
									$discount=($discount/$reg_price)*100;
									
									$discount=ceil($discount);	
								}else{
								    
								    $sale_price=$reg_price;
								}
								

$image_ids=$product->get_gallery_attachment_ids();

$image_gallery=array();

foreach($image_ids as $imd){
	$image_gallery[]=wp_get_attachment_url($imd);
}

$currency="KES";

$related_ids=$product->get_related(8);

$attrs=$product->get_attributes();

$tag_lists=$product->get_tags();

$cat_lists=$product->get_categories();


remove_action("woocommerce_after_single_product_summary","woocommerce_output_related_products",20);

do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 
/*Change product tabs*/
add_filter("woocommerce_product_tabs","sb_custom_product_tabs",99);

function sb_custom_product_tabs($tabs){
	
	$tabs['description']['callback']='sb_custom_product_desc_tab_content';
	
	$tabs['description']['title']='<i class="fa fa-eye"></i>&nbsp;Description';
	
	$tabs['reviews']['title']='<i class="fa fa-globe"></i>&nbsp;Reviews';
	
	if(isset($tabs['additional_information'])){
		
		$tabs['additional_information']['title']='<i class="fa fa-user-md"></i>&nbsp;Part Specifications';
		
		$tabs['additional_information']['callback']='sb_custom_product_attr_tab_content';
	}
	
	return $tabs;
}
function sb_custom_product_desc_tab_content(){
    ?>
	
<p> <?php the_content(); ?></p>
	
	<?php
}
function sb_custom_product_attr_tab_content(){
	
	global $product;
	
	$attrs=$product->get_attributes();
	
	if(count($attrs)<=0){
		echo 'None found';
	}
	
	$gattrs=array_chunk($attrs,3);
	?>
    <table class="table table-bordered table-striped table-hover table-responsive">
                                            <tbody>
                                            <?php foreach($gattrs as $gattr) { ?>
                                                <tr>
                                                <?php foreach($gattr as $attr) {
													
													if(!$attr["is_visible"])
													continue;
													
													 ?>
                                                    <td><strong><?php echo $attr["name"]; ?>:</strong> <?php echo $attr["value"]; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php } ?>
                                                
                                                
                                                
                                            </tbody>
                                        </table>
    <?php	
}


?>
 <!--Product-->
 
 <style>
 .product-info hr {
    margin-bottom: 5px;
	margin-top:5px;
 }
 </style>

                    <div class="row">
                    
                        <!--Images-->
                        <div class="col-md-7 product-info">
                            <div class="product-gallery">

                                <div class="primary-image">
                                    <a href="<?php echo $image_link; ?>" class="gallery" rel="group">
                                        <div class="product-image-container" style="background-image:url(<?php echo $image_link; ?>);"></div>
                                    </a>
                                </div>

                                <div class="owl-carousel owl-theme owl-items thumbnail-images gallery_images" data-items="4" data-dots="true" id="image_slider">
								<?php foreach($image_gallery as $gal) { ?>
                                    <a href="<?php echo $gal; ?>" class="gallery" rel="group">
                                        <div class="thumb" style="background-image:url(<?php echo $gal; ?>)"></div>
                                    </a>
                                    <?php } ?>
                                    
                                    </div>

                            </div>
                        </div>

                        <!--Info-->
                        <div class="col-md-5">

                            <div class="product-info">
                                <h3 class="product-title"><?php echo get_the_title(); ?></h3>
                                <div class="rating pull-left">
                                    <?php
                                    $tot_r = 5;

                                    $rem_t = $tot_r -$average_rating;

                                    for ($i = 0; $i < $average_rating; $i++) {
                                        ?>
                                        <span class="star voted" rel="<?php echo $i + 1; ?>"></span>
                                    <?php } ?>

                                    <?php for ($i = 0; $i < $rem_t; $i++) { ?>

                                        <span class="star"></span>

                                    <?php } ?>

                                </div>
                                <span class="review-rating pull-left" style="margin-left:15px;">
                                    <a href="">Read all <?php echo $review_count; ?> reviews</a> or 
                                    <a href="">Share you opinion</a>

                                </span>
                                <span class="clearfix"></span> 
                                
                                 <?php do_action("sabian_before_brief_product_description"); ?>
                                 
                                <p>
                                    <?php echo sabian_get_ellipsis(get_the_content(),apply_filters("sabian_product_excerpt_length",100)); ?>
                                </p>
                                <hr>
                                
                                <?php do_action("sabian_after_brief_product_description"); ?>
                                
                                <div class="product-price">
                                <?php if($isdiscount) { ?>
                                    <span class="price discount"><?php echo $currency; ?> <?php echo $reg_price; ?></span>
                                    <?php } ?>
                                    <span class="price"><?php echo $currency; ?> <?php echo $sale_price; ?></span>
                                </div>

<?php if($product->is_in_stock())
									{ ?>
                                    
                                    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
                                    
                                <form class="cart" method="post" enctype='multipart/form-data'>
                                    <input type="number" name="cant" value="<?php echo ( isset( $_POST['quantity'] )  )? wc_stock_amount( $_POST['quantity'] ) : 1; ?>" style="width:60px; text-align:center; margin-right:5px; margin-bottom:15px; height:34px;">
                                    
                                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
                                    
                                    <button type="submit" name="submit" class="btn btn-base btn-icon btn-cart" style="width:60%">
                                        <span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span>
                                    </button>
                                    
                                    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                                    
                                    <!--<button type="submit" class="btn btn-light btn-icon fa-heart">
                                        <span>Whishlist</span>
                                    </button>-->
                                </form>
                                
                                <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
                                
                                <?php } ?>

                                <hr>
                                <div class="product-short-info">
                                
                                <?php do_action("sabian_product_meta_before"); ?>
                                
                                <?php if($cat_lists!="") { ?>
                                    <p><i class="fa fa-inbox"></i><strong>Categories</strong>: <?php echo $cat_lists; ?></p>
                                    <?php } ?>
                                    
                                    <p><i class="fa fa-check"></i><strong>Availability</strong>: <?php if($product->is_in_stock()) { echo 'In Stock'; } else { echo 'Out Of Stock'; } ?></p>
                                    
                                    <?php if($tag_lists!="") { ?>
                                    <p><i class="fa fa-tag"></i><strong>Tags</strong>: <?php echo $tag_lists; ?></p>
                                    <?php } ?>
                                    
								<?php do_action("sabian_product_meta_after"); ?>	
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--Product details-->
                    <div class="col-md-12">
                    
                    <style>
					h2 {
    font-size: 20px;
}
					</style>

<div class="text_condesed" style="font-size:15px">
                        <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
</div>

<?php if(count($related_ids)>0) { ?>
                        <div class="row" style="margin-top: 30px">

                            <div class="col-md-12">

                                <div class="category_title">

                                    <span><a href="#">Related Parts</a> </span>

                                </div>

                                <div class="owl-carousel owl-theme owl-items" data-items="3" id="related_product_slider">

                                    <?php foreach ($related_ids as $rid) {
										
										$prd=new WC_Product($rid);
										
										sabian_get_product_template($prd);
										
								 } ?>

                                </div>

                                <div class="owl-nav">
                                    <div class="owl-prev owl_carousel_nav" data-target="#related_product_slider" data-slide-to="0"><i class="fa fa-angle-left"></i></div>
                                    <div class="owl-next owl_carousel_nav" data-target="#related_product_slider" data-slide-to="1"><i class="fa fa-angle-right"></i></div>
                                </div>

                            </div>

                        </div>
                        
                        <?php } ?>

                    </div>
                    
                    <?php do_action( 'woocommerce_after_single_product' ); ?>

            

