<?php
$product=$sabian_product;

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
								
								$image_link=wp_get_attachment_url($product->get_image_id());
								
								$average_rating=$product->get_average_rating();
								
								$currency="KES";
?>
<div class="box-product-outer bordered">

                                            <div class="box-product">
                                    <div class="img-wrapper" style="height: 200px">
                                        <a href="<?php echo $product->get_permalink(); ?>" style="height: 100%">
                                            
                                            <div class="product-image" style="background-image: url(<?php echo $image_link; ?>)"></div>
                                            
                                        </a>
                                        <?php if($product->is_featured()){ ?>
                                        <div class="tags">
                                            <span class="label-tags"><span class="label label-default arrowed">Featured</span></span>
                                        </div>
                                        <?php } ?>
                                        
                                        <?php if($product->is_on_sale()) { ?>
                                        <div class="tags tags-left">
                                            <span class="label-tags"><span class="label label-danger arrowed-right">Sale</span></span>
                                        </div>
                                        <?php } ?>
                                        
                                        <div class="option">
                                            <a href="<?php echo $product->add_to_cart_url(); ?>" data-toggle="tooltip" title="" data-original-title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                            <a href="#" data-toggle="tooltip" title="" data-original-title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                            <a href="#" data-toggle="tooltip" title="" class="wishlist" data-original-title="Add to Wishlist"><i class="fa fa-heart"></i></a>
                                        </div>
                                    </div>
                                    <h6><a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_title(); ?></a></h6>
                                    <div class="price">
                                    
                                        <div><?php echo $currency; ?> <?php echo $sale_price; ?> <?php if($isdiscount) { ?><span class="label-tags"><span class="label label-default">-<?php echo $discount; ?>%</span></span><?php } ?></div>
                                        <?php if($isdiscount) { ?><span class="price-old"><?php echo $currency; ?> <?php echo $reg_price; ?></span><?php } ?>
                                    </div>
                                    <div class="rating">
                                        <?php for($i=0;$i<$average_rating;$i++) { ?>
                                        <i class="fa fa-star"></i>
                                        <?php } ?>
                                        <a href="#">(<?php echo $product->get_review_count(); ?> reviews)</a>
                                    </div>
                                </div>
                                
                                        </div>
                                    
