<?php
/**
* Register Mega Menu-Menu that will be used for the mega menus
*/
function eap_register_mega_menu(){
	
	register_nav_menus(
	array(
      'eap-mega-menu' => __( 'Easy Parts Mega Menu' )
    )
  );
  
  add_filter("sabian_header_menu",function(){ return 'eap-mega-menu'; });	
}

add_action( 'init', 'eap_register_mega_menu' );

/**
* Register the mega menu sidebars that will be used for the mega menu containers in form of widgets
*/
function eap_init_mega_menu_areas(){
	
	$css_class="eap-mega-menu";
	
	$location_menu='eap-mega-menu';
	
	$locations = get_nav_menu_locations();
	
    if ( isset( $locations[ $location_menu ] ) ) {
        $menu = get_term( $locations[ $location_menu ], 'nav_menu' );
        if ( $items = wp_get_nav_menu_items( $menu->name ) ) {
            foreach ( $items as $item ) {
                if ( in_array( $css_class, $item->classes ) ) {
                    register_sidebar( array(
                        'id'   => 'eap-mega-menu-widget-area-' . $item->ID,
                        'name' => $item->title . ' - Mega Menu',
                    ) );
                }
            }
        }
    }	
		
}
add_action( 'widgets_init', 'eap_init_mega_menu_areas' );



class EAP_MegaMenuWalker extends Walker {
	
	var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
	
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='dropdown-menu'>\n";
	}
	
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	
		global $wp_query;
		
		$is_mega_menu=is_active_sidebar( 'eap-mega-menu-widget-area-' . $item->ID );
		
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		
		$class_names = $value = '';
		
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		
		/* Check for children */
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		
		if (!empty($children)) {
			
			if($depth>=1)
			{
				$classes[] = 'dropdown-submenu depth_'.$depth;
			}
			else
			{
				$classes[]="dropdown depth_".$depth;
			}
		}
		
		
		//echo 'eap-mega-menu-widget-area-' . $item->ID.'<br/>';
		
		if ( $is_mega_menu) {
			
			$classes[]="mega-menu";	
		}
		
		
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		
		$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
		
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		
		$attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
		
		$attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
		
		$attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
		
		$a_class=array();
		
		$a_attrs=array();
		
		if (in_array('current-menu-item', $classes)) {
			//$classes[] = 'active';
			$a_class[]="active";
			
			unset($classes['current-menu-item']);
		}
		
		if(!empty($children))
		{
			$a_class[]="dropdown-toggle";
			
			$a_attrs[]="data-toggle=dropdown";
		}
		
		if($is_mega_menu){
			
			$a_class[]="dropdown-toggle";	
		}
		
		$attributes.=' class="'.implode(" ",$a_class).'"';
		
		$attributes.=implode(" ",$a_attrs);
		
		$attributes.=' tabindex="-1"';
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		if($is_mega_menu){
			
			$item_output.= '<ul class="dropdown-menu mega-menu">';
			
			$item_output.='<div class="container-fluid" style="height: 100%"><div class="row">';
			
			$w_area='';
			
			ob_start();
			
			dynamic_sidebar( 'eap-mega-menu-widget-area-' . $item->ID );
			
			$w_area=ob_get_contents();
			
			ob_end_clean();
			
			$item_output.=$w_area;
								
			$item_output.='</div></div>';					
			
			$item_output.='</ul>';	
		}
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= "</li>\n";
	}
}

add_filter("sabian_header_menu_walker",function(){ return new EAP_MegaMenuWalker(); });


/**
* The Category Search Widget Menu
*/
class EAP_CategorySearchMenu extends WP_Widget{
	
	public function __construct() {
		parent::__construct( 'widget_eap_catsearch', 'Category Search Mega Menu', array(
			'classname'   => 'widget_EAP_CategorySearchMenu',
			'description' => 'Mega Menu Item for searching categories',
		) );
	}
	
	public function widget( $args, $instance ){
		
		$this->mega_menu($instance);
		
	}
	public function form( $instance ) {
	
	echo '<div class="widget">';
	
	$selected=(!empty($instance["eap_categories"]))?$instance["eap_categories"]:null;
	
	$all_cats=sabian_get_product_category_parents();
	
	echo '<div class="eap_categories_widget_menu">';
	
	echo '<select name="'.$this->get_field_name("eap_categories").'[]" multiple="multiple" class="form-control eap_categories_widget_menu_select" style="height:200px">';
	
	foreach($all_cats as $cat){
		
		$iselected=in_array($cat->term_id,$selected)?"selected=selected":"";
		
		echo '<option value="'.$cat->term_id.'" '.$iselected.'>'.$cat->name.'</option>';
	}
	
	echo '</select>';
	
	//print_r(sabian_get_product_categories());
	
	echo '</div>';
	
	echo '</div>';
	}
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title'] = ! empty( $new_instance['title'] )  ? strip_tags( $new_instance['title'] ) : '';
		
		$instance["eap_categories"]=!empty($new_instance["eap_categories"])?$new_instance["eap_categories"]:'';
		
		return $instance;
	}
	
	protected function mega_menu($instance){
		
		$selected=!empty($instance["eap_categories"])?$instance["eap_categories"]:null;
		
		if(is_null($selected)){
			return;	
		}
		
		$categories=array();
		
		foreach($selected as $sel){
			
			$categories[]=sabian_get_product_category_by_id($sel);	
		}
		
		?>
        
        <div class="container-fluid" style="height: 100%">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="post_type" value="product" />
        <input type="hidden" name="s" />
                                <div class="row">

                                    <div class="col-md-3 mega-nav-section-wr">
                                        <h3 class="mega-nav-section-title">Select Car Model</h3>

                                        <div class="form-group">
                                            <select class="form-control" name="model">
                                            <option selected="selected" value="">Select Model</option>
                                            <?php foreach($GLOBALS["eap_model_options"] as $k=>$opt) { ?>
                                                <option value="<?php echo $k; ?>"><?php echo $opt; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <img class="img-responsive" src="<?php echo SABIAN_URL; ?>/images/bgs/ad.jpg"> 

                                    </div>

                                    <div class="col-md-9">

<?php if(count($categories)==1) {
	
	$cat=$categories[0];
	
	$children=sabian_get_product_child_categories($cat->term_id);
	
	$g_children=array_chunk($children,6);
	
	 ?>
                                        <div class="col-md-12">
                                            <div class="mega-nav-section">
                                         
                                            <h3 class="mega-nav-section-title"><?php echo $cat->name; ?></h3>
                                            <?php foreach($g_children as $g_child) { ?>
                                                <div class="col-md-4">
                                                    
                                                    <ul class="mega-nav-ul">
                                                    <?php foreach($g_child as $child) {
														$link=get_term_link($child->term_id,"product_cat");
														 ?>
                                                        <li><!--<a href="<?php echo $link; ?>"><?php echo $child->name; ?></a>-->
                                                        <button class="menu_button" value="<?php echo $child->term_id; ?>" name="sab_cat" type="submit"><?php echo $child->name; ?></button>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <?php } ?>
                                                
                                                </div>
                                        </div>
                                        <?php } else {
											
											$count_cats=count($categories);
											
											if($count_cats<=3){
											$col="4";	
											}else{
											$col="3";	
											}
	
	 ?>
                                        <div class="col-md-12">
                                            <div class="mega-nav-section">
                                            <?php foreach($categories as $g_child) {
												
												$children=sabian_get_product_child_categories($g_child->term_id);
												
												 ?>
                                                <div class="col-md-<?php echo $col; ?>">
                                                <h3 class="mega-nav-section-title"><?php echo $g_child->name; ?></h3>
                                                    <ul class="mega-nav-ul">
                                                    <?php foreach($children as $child) {
														$link=get_term_link($child->term_id,"product_cat");
														 ?>
                                                        <li>
                                                        <!--<a href="<?php echo $link; ?>"><?php echo $child->name; ?></a>-->
                                                        <button class="menu_button" value="<?php echo $child->term_id; ?>" name="sab_cat" type="submit"><?php echo $child->name; ?></button>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <?php } ?>
                                                
                                                </div>
                                        </div>
                                        <?php } ?>

                                    </div>

                                </div>
                                </form>
                            </div>
        
        <?php
		
	}
	
	
	
}

register_widget('EAP_CategorySearchMenu');



function eap_dummy_data() {	
$parts = array();
$parts[] = new part("Built Chassis", 12000, 56, array("chassis", "engines"));
$parts[] = new part("Window Shield", 5000, 55, array("chassis"));
$parts[] = new part("Firestone Tyres", 300, 54, array("engines"));
$parts[] = new part("Gear Box", 1500, 53, array("engines"));
$parts[] = new part("Steering Wheels", 5200, 52, array("chassis"));
$parts[] = new part("Radio Stereo", 1500, 51, array("chassis"));
$parts[] = new part("Side Mirrors", 2500, 50, array("chassis"));
$parts[] = new part("Fuel Machine", 4500, 49, array("engines"));
$parts[] = new part("Exhaust Pipes", 13500, 48, array("engines"));
	
foreach($parts as $product){
	
	$post = array(
    'post_author' => 1,
    'post_content' => "Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.
	Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next",
    'post_status' => "publish",
    'post_title' => $product->name,
    'post_parent' => '',
    'post_type' => "product",
);

//Create post
$post_id = wp_insert_post( $post, $wp_error );
if($post_id){
    $attach_id = $product->image;
    //add_post_meta($post_id, '_thumbnail_id', $attach_id);
	set_post_thumbnail($post_id,$attach_id);
}

//wp_set_object_terms( $post_id, 'Races', 'product_cat' );
//wp_set_object_terms($post_id, 'simple', 'product_type');

update_post_meta( $post_id, '_visibility', 'visible' );
update_post_meta( $post_id, '_regular_price', $product->old_price );
update_post_meta( $post_id, '_sale_price', $product->price );
update_post_meta( $post_id, '_price', $product->price );

update_post_meta($post_id,EAP_MODEL_KEY,'subaru');
}
}

//add_action("init","eap_dummy_data");
?>