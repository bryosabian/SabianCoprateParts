<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<li class="comment">
                                                            <div class="comment-body bb">
                                                                <div class="comment-avatar">
                                                                    <div class="avatar"><?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); ?></div>
                                                                </div>
                                                                <div class="comment-text">
                                                                    <div class="comment-author clearfix">
                                                                        <a href="#" class="link-author" hidefocus="true"><?php comment_author(); ?></a>
                                                                        <span class="comment-meta"><span class="comment-date"><?php echo get_comment_date( wc_date_format() ); ?></span></span>
                                                                    </div>
                                                                    <div class="comment-entry">
                                                                        <?php comment_text(); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
