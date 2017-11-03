<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>

<?php
global $page_title;

if(!$page_title || $page_title==""){
	$page_title="Latest Parts";	
}
?>

<div class="row">
<div class="col-md-12">

                            <div class="category_title">
                                <span><?php echo $page_title; ?></span>
                            </div>

                        </div>