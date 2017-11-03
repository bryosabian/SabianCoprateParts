<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

$tpages=$wp_query->get( 'posts_per_page' );

if(isset($_GET["order_items"])){
	$tpages=	$_GET["order_items"];
}
?>

 
                        <div class="filter sort-filter">
                            <div class="form-inline form-light">
                                <label>Sort by</label>
                                <a href="">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
                                <form class="woocommerce-ordering sb-wc-items" method="get" id="ss jnd" style="display:inline-block">
 
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
                                <select class="orderby form-control" name="orderby">
                                    <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
        
                                </select>                           

                                <label>Items</label>
                                <select class="form-control" name="order_items" id="order_items">
                                <option selected="selected"><?php echo $tpages; ?></option>
                                <option><?php echo $wp_query->get( 'posts_per_page' ); ?></option>
                                <option>10</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                                </form>
                            </div>
                        </div>

                                           

