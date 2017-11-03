<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) )
{
	$keys=array_keys($tabs);
	
	$vals=array_values($tabs);
	
	$theaders=0;
	
	$tvaues=0;
	
	?>
    <div class="tabs-framed mt-20">
                                    <ul class="tabs clearfix">
                                        <?php foreach($tabs as $key=>$tab) : 
										$is_first=$theaders==0;
										?>
				<li class="<?php echo esc_attr( $key ) ?>_tab <?php echo ($is_first)?"active":""; ?> ">
					<a href="#tab-<?php echo esc_attr( $key ) ?>" data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>

			<?php $theaders++; endforeach; ?>
                                    </ul>

                                    <div class="tab-content">

                                        <!-- Tab 1 -->
                                        <?php foreach ( $tabs as $key => $tab ) : 
										$isvfirst=$tvaues==0;
										?>

                                        <div class="tab-pane fade <?php echo ($isvfirst)?"active in": ""; ?>" id="tab-<?php echo esc_attr( $key ) ?>">
                                            <div class="tab-body">
											<?php call_user_func( $tab['callback'], $key, $tab ) ?>
                                            </div>
                                        </div>
                                        
                                        <?php $tvaues++; endforeach; ?>
                                        
                                    </div>
                                </div>
    <?php
}
?>
