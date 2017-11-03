<?php
$model=$this->model;

$page=$this->getPage();

$products=$model->products;

$wp_query=$model->wp_query;
?>
<style>
.btn-sm{
	padding:6px 6px;
	display:inline-block;
	font-size:13px;	
}
</style>
<div class="row">

            <div class="col-md-12">
            
            <div class="row">
            <div class="col-md-4 pull-right">
           <form class="form-horizontal" method="get">
           
          <input type="hidden" name="page" value="<?php echo $page; ?>" />
          <input type="hidden" name="action" value="productSearch" />
           
                            <div class="input-group">
                                <input type="text" class="form-control" name="p_search" placeholder="Search Parts....">
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-primary" type="submit">Go!</button>
                                </span>
                            </div>
                        </form>
                        </div>
                        </div>
            
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Part List
                  
                   <?php if(!$wp_query->have_posts()){ ?>
                
                (0 Results found)
                
                <?php } ?>
                  
                  </h3>
                  <div class="box-tools" style="top:-8px">
                  
                  <?php sabian_pagination($wp_query,'pagination pagination-sm no-margin pull-right'); ?>
                  
                  
                    
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                
               
                
                  <table class="table">
                    <tbody>
                    
                    <tr>
                      <th style="width: 8%">#</th>
                      <th style="width:20%">Name</th>
                      <th style="width:10%">Price</th>
                      <th style="width:50%">Categories</th>
                      <th style="width: 20%"></th>
                    </tr>
                    
                    <?php foreach($products as $product) {
						
						$post=$product->post;
						
						$rating_count=$product->get_rating_count();
						
						$review_count = $product->get_review_count();
						
						$average_rating=$product->get_average_rating();
						
						$price_html=$product->get_price_html();
						
						$attributes = $product->get_attributes();
						
						$cats=$product->get_categories();
						
						$image_link=wp_get_attachment_url($product->get_image_id());
						
						$isdiscount=false;
						
						$sale_price=$product->get_sale_price();
						
						$reg_price=$product->get_regular_price();
						
						$currency="KES";
						
						 ?>
                    
                    <tr>
                    <td><img class="img-responsive" style="height:50px" src="<?php echo $image_link; ?>" /></td>
                    <td><?php echo $post->post_title; ?></td>
                    <td><?php echo $currency." ".$sale_price; ?></td>
                    <td><?php echo $cats; ?></td>
                    <td><a href="" class="btn btn-sm btn-primary" style="display:inline-block">Edit</a> <a href="#" class="btn btn-sm btn-danger">Delete</a></td>
                    </tr>
                    
                    <?php } ?>
                    
                    
                  </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- /.box -->
            </div><!-- /.col -->
          </div>