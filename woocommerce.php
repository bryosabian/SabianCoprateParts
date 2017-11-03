<?php
add_filter("sabian_page_header","sabian_woocomerce_header",10000);

remove_action("woocommerce_before_shop_loop","woocommerce_catalog_ordering",30);

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_action('woocommerce_before_shop_loop',function(){
	
	?>
    <div class="product-sorting-bar product-list-filters light-gray" style="margin-bottom:10px">

                       <ul class="product-options">
                            <li><?php woocommerce_result_count(); ?> </li>
                        </ul>



 <?php woocommerce_catalog_ordering(); ?>
 
                        <?php sabian_pagination(); ?>
                    </div>
    <?php
},30);

function sabian_woocomerce_header()
{
	return "";
	
}
get_header(); 
?>
<style>
.page-title{
	display:none !important;	
}
</style>

<?php
$page_title="All Parts";

if(is_product_category()){
	$page_title=single_term_title('',false);
}

if(is_product_tag()){
	$page_title="Tag :: ".single_tag_title('',false);
}

if(is_search()){
	$page_title="Search :: " . get_search_query();	
}

if(is_product()){
	$page_title=get_the_title();
}

$page_title=apply_filters("sabian_wc_page_title",$page_title);

?>
<div class="pg-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2><?php echo $page_title; ?></h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>
                    <li><a href="#"><?php echo $page_title; ?></a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
 <!-- MAIN CONTENT -->
        <section class="section_products">
            <div class="container">
                <div class="row">
                
<?php
$cont_sd=apply_filters("sabian_wc_main_content_dimension",'col-md-9');
	
	$sb_sd=apply_filters("sabian_wc_sub_content_dimension",'col-md-3');
	?>
    
    
    <div class="<?php echo $sb_sd; ?> sidebar">
    <?php get_sidebar('sabian_sidebar'); ?>
    </div>
    
    <div class="<?php echo $cont_sd; ?>">
    <?php
	if( have_posts() ){
					woocommerce_content();
				}else{
				
				?>
                <div class="row">
<div class="col-md-12">

                            <div class="category_title">
                                <span>0 Results Found For <?php echo $page_title; ?></span>
                            </div>

                        </div>
                <?php
					
				}
	?>
    </div>
    
     
    
    
    <?php
?>
 </div>
        </div>
            </section>
               
<?php
get_footer();
?>