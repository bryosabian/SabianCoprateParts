<?php
/**
 * The General template for displaying all easyparts models in php.
 *
 * 
 *
 * @author 		Brian Sabana
 * @package 	sabiancorporate/
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$meta_key=$eap_meta_key;

$meta_key_title=$eap_meta_title;

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


add_filter("sabian_wc_page_title",function($title){
	
	global $post,$meta_key_title;
	
	return $meta_key_title." ".$post->post_title;
	
});

/**
	 * WP Core doens't let us change the sort direction for invidual orderby params - http://core.trac.wordpress.org/ticket/17065
	 *
	 * This lets us sort by meta value desc, and have a second orderby param.
	 *
	 * @access public
	 * @param array $args
	 * @return array
	 */
	function eap_gpt_order_by_popularity_post_clauses( $args ) {
		global $wpdb;

		$args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";

		return $args;
	}

	/**
	 * order_by_rating_post_clauses function.
	 *
	 * @access public
	 * @param array $args
	 * @return array
	 */
	function eap_gpt_order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";

		$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";

		$args['join'] .= "
			LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

		$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}
	
function eap_gpt_ordering_opts($orderby = '', $order = ''){
		
		global $wpdb;

		// Get ordering from query string unless defined
		if ( ! $orderby ) {
			$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

			// Get order + orderby args from string
			$orderby_value = explode( '-', $orderby_value );
			$orderby       = esc_attr( $orderby_value[0] );
			$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
			
			//echo $order;
		}

		$orderby = strtolower( $orderby );
		$order   = strtoupper( $order );
		
		/*echo $order;*/
		$args    = array();

		// default - menu_order
		$args['orderby']  = 'menu_order title';
		$args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
		$args['meta_key'] = '';

		switch ( $orderby ) {
			case 'rand' :
				$args['orderby']  = 'rand';
			break;
			case 'date' :
				$args['orderby']  = 'date';
				$args['order']    = $order == 'ASC' ? 'ASC' : 'DESC';
			break;
			case 'price' :
				$args['orderby']  = "meta_value_num {$wpdb->posts}.ID";
				$args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
				$args['meta_key'] = '_price';
			break;
			case 'popularity' :
				$args['meta_key'] = 'total_sales';

				// Sorting handled later though a hook
				add_filter( 'posts_clauses', 'eap_gpt_order_by_popularity_post_clauses'  );
			break;
			case 'rating' :
				// Sorting handled later though a hook
				add_filter( 'posts_clauses', 'eap_gpt_order_by_rating_post_clauses' );
			break;
			case 'title' :
				$args['orderby']  = 'title';
				$args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
			break;
		}

		return apply_filters( 'woocommerce_get_catalog_ordering_args', $args );
}

$has_posts=have_posts();

get_header();

if(!$has_posts){
	
	require_once SABIAN_APP_PATH."404.php";
	
	get_footer();
	
	return;
}

while ( have_posts() ){
		
		the_post();
		
		$post=get_post();
		
}


$paged=(get_query_var('paged'))?get_query_var('paged'):1;



$params=array(
'post_type'=>'product',
'paged'=>$paged,

);

$params['meta_query']=array(array(
              'key'=>$eap_meta_key,
			  'value'=>$post->ID
			  ));

// Ordering
if(isset($_GET['orderby'])){
	
	$ordering   = eap_gpt_ordering_opts();
	
	$params['orderby']=$ordering['orderby'];
	
	$params['order']=$ordering['order'];
}

if(isset($_GET["order_items"])){
	
	$params['posts_per_page']=	$_GET["order_items"];
}

$wp_query=new WP_Query($params);

$page_title=apply_filters("sabian_wc_page_title","Models");
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
    
	
	
	if($wp_query->have_posts()):
	
	do_action('woocommerce_before_shop_loop'); 
	
	woocommerce_product_loop_start();
	
	woocommerce_product_subcategories();
	
	//$arr=array();
	
	while($wp_query->have_posts()){
		
		$wp_query->the_post();
		
		//$arr[]=get_post()->post_title;
		
		wc_get_template_part( 'content', 'product' ); 
		
}

wp_reset_postdata();

woocommerce_product_loop_end();

do_action('woocommerce_after_shop_loop');
 
else:
				
				?>
                <div class="row">
<div class="col-md-12">

                            <div class="category_title">
                                <span>0 Results Found For <?php echo $page_title; ?></span>
                            </div>

                        </div>
                <?php
					
				endif;
	?>
    </div>
    
     
    
    
    <?php
?>
 </div>
        </div>
            </section>


<?php

get_footer();