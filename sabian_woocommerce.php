<?php
add_action("init","sabian_woocomerce_setup");

/*Product Search*/
add_action("woocommerce_product_query",'sb_items_filter',10000,2);

function sb_items_filter($q,$wcq){
	
	if(isset($_REQUEST["order_items"]) && $_REQUEST["order_items"]!=""){
		
		$q->set( 'posts_per_page',$_REQUEST["order_items"]);
	}	
}

function sabian_woocomerce_setup()
{
	add_theme_support("woocommerce");
}
function sabian_filter_woocomerce_title()
{
	return false;
}
function sabian_get_product_template($product=null,$style='1')
{
	$sabian_product=$product;
	
	include( locate_template('sabian_product_template/product-'.$style.'.php'));
}
function sabian_result_count()
{
	global $wp_query;
	
	$paged    = max( 1, $wp_query->get( 'paged' ) );
	$per_page = $wp_query->get( 'posts_per_page' );
	$total    = $wp_query->found_posts;
	$first    = ( $per_page * $paged ) - $per_page + 1;
	$last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

	if ( 1 == $total ) {
		_e( 'Showing the single result', 'woocommerce' );
	} elseif ( $total <= $per_page || -1 == $per_page ) {
		printf( __( 'Showing %d results', 'woocommerce' ), $total );
	} else {
		printf( _x( 'Showing %1$d&ndash;%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
	}
}
function sabian_order_by()
{
	global $catalog_orderby_options,$orderby;
	
	?>
    <form class="woocommerce-ordering" method="get" id="ss jnd">
    <div class="filter sort-filter">
                            <div class="form-inline form-light">
                                <label>Order by</label>
                                <a href="">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
                                <select class="orderby form-control" name="orderby">
                                   <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
                                </select>

                                
                            </div>
                        </div>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' === $key || 'submit' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>
    <?php
}
function sabian_pagination($twp_query=null,$ul_class=null)
{

if($twp_query){
	$wp_query=$twp_query;	
}else{
	global $wp_query;
}
	
		$pagins= paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'       => '',
			'add_args'     => '',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'prev_text'    => '«',
			'next_text'    => '»',
			'type'         => 'array',
			'end_size'     => 3,
			'mid_size'     => 3
		) ) );
		
		 if( is_array( $pagins ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			
			$ul_class=($ul_class)?$ul_class:'pagination pagination pull-right';
			
            echo '<ul class="'.$ul_class.'">';
			
            foreach ( $pagins as $i=>$page ) {
				
				$class=array();
				
				if ( strpos( $page, 'current' ) !== false)
				{
					$class[]="active";
				}
				$open_ahref=( strpos( $page, 'current' ) !== false)?'<a href="#">':"";
				$close_ahref=( strpos( $page, 'current' ) !== false)?'</a>':"";
				echo '<li class="'.implode(" ",$class).'">'.$open_ahref.strip_tags($page,"<a>").$close_ahref.'</li>';
            }
           echo '</ul>';
        }
	
}
function sabian_woocomerce_options()
{
	?>
    <div class="product-sorting-bar product-list-filters light-gray">

                        <ul class="product-options">
                            <li><a href=""><i class="fa fa-th"></i></a></li>
                            <li><a href=""><i class="fa fa-bars"></i></a></li>
                        </ul>



                        <div class="filter sort-filter">
                            <div class="form-inline form-light">
                                <label>Sort by</label>
                                <a href="">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
                                <select class="form-control">
                                    <option>Price</option>
                                    <option>Most bought</option>
                                    <option>Most reviewed</option>
                                </select>

                                <label>Items</label>
                                <select class="form-control">
                                    <option>10</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </div>

                       <?php sabian_pagination(); ?>
                    </div>
    <?php
}
function sabian_get_product_categories($orderby=null)
{
	$categories=array();
	
	$args=array(
	"taxonomy"=>"product_cat",
	"orderby"=>(!$orderby)?"term_id":$orderby,
	"order"=>"DESC",
	"show_count"=>false,
	"hide_empty"=>false
	);
	
	$all_cats=get_categories($args);
	
	foreach($all_cats as $cat)
	{
		$categories[]=$cat;
	}
	
	return $categories;
}
function sabian_get_product_category_by_id($id)
{
	$the_cat=get_term($id,"product_cat");
	
	return $the_cat;
}
function sabian_get_products_by_category($category=null)
{
	$products=array();
	
	$args=array(
	"post_type"=>'product',
	"posts_per_page"=>5000000000,
	"tax_query"=>array(array('taxonomy'=>'product_cat',"field"=>"term_id","terms"=>$category))
	);
	
	$loop=new WP_Query($args);
	
	while($loop->have_posts())
	{
		$loop->the_post();
		
		$product=new WC_Product(get_the_ID());
		
		$products[]=$product;
	}
	
	return $products;
}
function sabian_get_products($args=null)
{
	$products=array();
	
	if(is_null($args))
	$args=array(
	"post_type"=>'product',
	"posts_per_page"=>5000000000
	);
	
	$loop=new WP_Query($args);
	
	while($loop->have_posts())
	{
		$loop->the_post();
		
		$product=new WC_Product(get_the_ID());
		
		$products[]=$product;
	}
	
	return $products;
}
function sabian_get_product_category_parents(){
	
	$all_cats=sabian_get_product_categories();
	
	$parent_ids=array();
	
	foreach($all_cats as $cat){
		
		if($cat->parent!=null){
			
			if(!in_array($cat->parent,$parent_ids))
			$parent_ids[]=$cat->parent;
		}
	}
	
	$cat_parents=array();
	
	foreach($parent_ids as $id){
		
		$cat=sabian_get_product_category_by_id($id);
		
		if($cat==null){
			continue;
		}
		
		if($cat instanceof WP_Error){
			continue;
		}
		
		$cat_parents[]=$cat;	
	}
	
	return $cat_parents;
}
function sabian_get_product_child_categories($id){
	
	$term_id=$id;
	
	$tax_name="product_cat";
	
	$term_children=get_term_children($term_id,$tax_name);
	
	$children=array();
	
	foreach($term_children as $tid){
		
		$term=get_term_by('id',$tid,$tax_name);
		
		if($term==null){
			continue;	
		}
		
		if($term instanceof WP_Error){
			continue;	
		}
		
		$children[]=$term;
	}
	
	return $children;
}
function sabian_get_category_image_id($catID){
	return get_woocommerce_term_meta($catID,'thumbnail_id',true);	
}
/*latest products*/
?>