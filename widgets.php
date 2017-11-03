<?php
register_widget('SB_LatestProductSlider');

register_widget('SB_FeaturedCategories');

$sabian_widgets=array("SB_MailingListWidget","SB_SocialLinksWidget","SB_BriefWidget");

foreach($sabian_widgets as $wds)
{
	register_widget($wds);
}

class SB_WidgetBridge 
{
	public static $mailing_description_post="sabian_mailing_description";
	
	public static $social_facebook_post="sabian_social_facebook";
	
	public static $social_twitter_post="sabian_social_twitter";
	
	public static $social_google_post="sabian_social_google";
	
	public static $social_linkedin_post="sabian_social_linkedin";
	
	public static $brief_description_text_post="sabian_brief_description";
	
	public static $brief_button_text_post="sabian_brief_button_text";
	
	public static $brief_button_url_post="sabian_brief_button_url";
	
	public static function displayMailingForm($args, $instance){
		
		if ( ! empty( $instance[self::$mailing_description_post] ) ){
			
			$description=$instance[self::$mailing_description_post];
			
		}else{
			$description='';	
		}
		
		?>
        
        <p><?php echo $description; ?></p>
                        <form class="form-horizontal form-light">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your email address...">
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-primary" type="button">Go!</button>
                                </span>
                            </div>
                        </form>
                   
        
        <?php
			
	}
	
	public static function displaySocialLinks($args, $instance){
		
		if ( ! empty( $instance[self::$mailing_description_post] ) ){
			
			$description=$instance[self::$mailing_description_post];
			
		}else{
			$description='';	
		}
		
		$ok_links=array();
		
		$links[]=array("title"=>"Facebook Link","id"=>self::$social_facebook_post,"icon"=>"facebook");
				
		$links[]=array("title"=>"Twitter Link","id"=>self::$social_twitter_post,"icon"=>"twitter");
				
		$links[]=array("title"=>"Google Plus Link","id"=>self::$social_google_post,"icon"=>"google-plus");
				
		$links[]=array("title"=>"Linkedin Link","id"=>self::$social_linkedin_post,"icon"=>"linkedin");
		
		foreach($links as $link){
			
			if ( ! empty( $instance[$link["id"]] ) ){
				
				$ok_links[]=$link;
			}	
		}
		
		?>
        
       <div class="social-icons">
       <?php foreach($ok_links as $link) { ?>
                        <a href="<?php echo $instance[$link["id"]]; ?>"><i class="fa fa-<?php echo $link["icon"]; ?>"></i></a>
                        <?php } ?>
                    </div>
                   
        
        <?php
			
	}
	public static function displayBriefDescription($args,$instance){
		
		if ( ! empty( $instance[self::$brief_description_text_post] ) ){
			
			$description=$instance[self::$brief_description_text_post];
			
		}else{
			$description='';	
		}
		
		if ( ! empty( $instance[self::$brief_button_url_post] ) ){
			
			$url=$instance[self::$brief_button_url_post];
			
		}else{
			$url='';	
		}
		
		if ( ! empty( $instance[self::$brief_button_text_post] ) ){
			
			$btnText=$instance[self::$brief_button_text_post];
			
		}else{
			$btnText='';	
		}
		
		?>
                        <p class="no-margin">
                       <?php echo $description; ?>
                        <br><br>
                        <a href="<?php echo $url; ?>" class="btn btn-primary btn-icon btn-check" style="width:100%; padding:5px 20px; border-radius:4px"><span><?php echo $btnText; ?></span></a>
                        </p>
                    
        <?php
		
			
	}
}

class SB_LatestProductSlider extends WP_Widget{
	
	public function __construct() {
		parent::__construct( 'widget_sb_latestproductslider', 'Latest Product Slider', array(
			'classname'   => 'widget_SB_LatestProductSlider',
			'description' => 'Widget item for displaying latest product on an owl carousel',
		) );
	}
	
	public function widget( $args, $instance ){
		
		echo '<div class="widget_side">';
		
		if(!empty($instance['count'])){
			$count=$instance['count'];	
		}else{
			$count=10;	
		}
		
		$products=sabian_get_products();
		?>

                        <div class="category_title">

                            <span><a href="#"><?php echo $instance['title']; ?><i class="fa fa-chevron-circle-right"></i></a> </span>

                        </div>

                        <!--Slider-->
                        <div class="owl-carousel owl-theme owl-items" data-items="1" id="latest_product_slider_<?php echo $this->id; ?>">

                            <?php foreach($products as $i=>$product) {
								
								if($i>=$count){
									break;	
								}
								
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
								
								$rating=$product->get_rating_count(5);
								
								$average_rating=absint(($rating/5)*5);
								
								$currency="KES";
								 ?>
                            <div class="box-product-outer bordered product_slide">

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
                            <?php } ?>


                            

                        </div>

                        <!--Nav-->
                        <div class="owl-nav">
                            <div class="owl-prev owl_carousel_nav" data-target="#latest_product_slider_<?php echo $this->id; ?>" data-slide-to="prev"><i class="fa fa-angle-left"></i></div>
                            <div class="owl-next owl_carousel_nav" data-target="#latest_product_slider_<?php echo $this->id; ?>" data-slide-to="next"><i class="fa fa-angle-right"></i></div>
                        </div>
        
        <?php
		
		echo '</div>';
		
	}
	public function form( $instance ) {
	
	echo '<div class="widget">';
	
	$title=(!empty($instance["title"]))?$instance["title"]:"Latest Product Slider";
	
	$count=(!empty($instance["count"]))?$instance["count"]:10;
	
	?>
    <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'Title'); ?></label> 
		<input class="form-control" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        </div>
        
        
        <div class="form-group">
        <p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>">Total Product Count</label> 
		<input class="form-control" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
        </div>
    <?php
	
	echo '</div>';
	}
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		
		return $instance;
	}	
}

class SB_FeaturedCategories extends WP_Widget{
	
	public function __construct() {
		parent::__construct( 'widget_sb_featured_categories', 'Product Categories', array(
			'classname'   => 'widget_SB_FeaturedCategories',
			'description' => 'Widget item for displaying list of categories',
		) );
	}
	
	public function widget( $args, $instance ){
		
		$selected=!empty($instance["categories"])?$instance["categories"]:null;
		
		if(is_null($selected)){
			return;	
		}
		
		echo '<div class="widget_side">';
		
		if ( ! empty( $instance['title'] ) ) :
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		else:
		echo ''; endif;
		
		if(!empty($instance['count'])){
			$count=$instance['count'];	
		}else{
			$count=10;	
		}
		
		$categories=array();
		
		foreach($selected as $sel){
			
			$categories[]=sabian_get_product_category_by_id($sel);	
		}
		?>
        <ul class="categories highlight">
        <?php foreach($categories as $cat) {
			
			$link=get_term_link((int)$cat->term_id,"product_cat");
			
			if($link instanceof WP_Error){
				$link="#";	
			}
			 ?>
        <li><a href="<?php echo $link; ?>"><?php echo $cat->name; ?> (<?php echo $cat->count; ?>)</a></li>
        <?php } ?>
        </ul>
        <?php
		
		echo '</div>';
		
	}
	public function form( $instance ) {
	
	echo '<div class="widget">';
	
	$title=(!empty($instance["title"]))?$instance["title"]:"Product Categories";
	
	$count=(!empty($instance["count"]))?$instance["count"]:10;
	
	$selected=(!empty($instance["categories"]))?$instance["categories"]:null;
	
	$all_cats=sabian_get_product_categories();
	
	?>
    <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'Title'); ?></label> 
		<input class="form-control" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        </div>
        
        
        <div class="form-group">
        <p>
		<label for="<?php echo $this->get_field_id( 'categories' ); ?>">Featured Categories</label> 
		<?php
		echo '<select name="'.$this->get_field_name("categories").'[]" multiple="multiple" class="form-control" style="height:200px">';
	
	foreach($all_cats as $cat){
		
		if($cat->count<=0)
		continue;
		
		$iselected=in_array($cat->term_id,$selected)?"selected=selected":"";
		
		echo '<option value="'.$cat->term_id.'" '.$iselected.'>'.$cat->name.'</option>';
	}
	
	echo '</select>';
		?>
		</p>
        </div>
    <?php
	
	echo '</div>';
	}
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		//$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		
		$instance["categories"]=!empty($new_instance["categories"])?$new_instance["categories"]:'';
		
		return $instance;
	}	
}



class SB_MailingListWidget extends WP_Widget {
	
	 public function __construct() {
		parent::__construct( 'widget_SB_MailingListWidget', 'Sabian Mailing List Form', array(
			'classname'   => 'widget_SB_MailingListWidget',
			'description' => 'Allows one to register for mailing lists. To be used preferebly at the footer',
		) );
	}
	
	function widget( $args, $instance ) {
		
		if ( ! empty( $instance['title'] ) ) :
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		else:
		echo ''; endif;
		
		SB_WidgetBridge::displayMailingForm($args, $instance);
	}
	public function form( $instance ) {
		
     	        $title = ! empty( $instance['title'] ) ? $instance['title'] : 'Mailing List Form';
				
				$description=!empty($instance[SB_WidgetBridge::$mailing_description_post])?$instance[SB_WidgetBridge::$mailing_description_post]:'Register For Our Mailing List';
		?>
        <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'Title'); ?></label> 
		<input class="form-control" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        </div>
        
         <div class="form-group">
        <p>
        <label for="<?php echo $this->get_field_id( SB_WidgetBridge::$mailing_description_post ); ?>">Enter Brief Description</label>
        <textarea id="<?php echo $this->get_field_id( SB_WidgetBridge::$mailing_description_post ); ?>" name="<?php echo $this->get_field_name( SB_WidgetBridge::$mailing_description_post ); ?>" value="<?php echo $description; ?>" style="width:100%"><?php echo $description; ?></textarea>
        </p>
        
        </div>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		$instance[SB_WidgetBridge::$mailing_description_post]=(!empty($new_instance[SB_WidgetBridge::$mailing_description_post]))?strip_tags($new_instance[SB_WidgetBridge::$mailing_description_post]):'';
		
		return $instance;
	}
}


class SB_SocialLinksWidget extends WP_Widget {
	
	public function __construct() {
		parent::__construct( 'widget_SB_SocialLinksWidget', 'Sabian Social Media Links', array(
			'classname'   => 'widget_SB_SocialLinksWidget',
			'description' => 'Display list of social media links. To be used preferebly at the footer',
		) );
	}
	
	function widget( $args, $instance ) {
		
		if ( ! empty( $instance['title'] ) ) :
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		else:
		echo ''; endif;
		
		SB_WidgetBridge::displaySocialLinks($args, $instance);
	}
	public function form( $instance ) {
		
     	        $title = ! empty( $instance['title'] ) ? $instance['title'] : 'Social Links';
				
				$facebook=!empty($instance[SB_WidgetBridge::$social_facebook_post])?$instance[SB_WidgetBridge::$social_facebook_post]:'';
				
				$twitter=!empty($instance[SB_WidgetBridge::$social_twitter_post])?$instance[SB_WidgetBridge::$social_twitter_post]:'';
				
				$linkedin=!empty($instance[SB_WidgetBridge::$social_linkedin_post])?$instance[SB_WidgetBridge::$social_linkedin_post]:'';
				
				$google=!empty($instance[SB_WidgetBridge::$social_google_post])?$instance[SB_WidgetBridge::$social_google_post]:'';
				
				$links=array();
				
				$links[]=array("title"=>"Facebook Link","id"=>SB_WidgetBridge::$social_facebook_post,"value"=>$facebook);
				
				$links[]=array("title"=>"Twitter Link","id"=>SB_WidgetBridge::$social_twitter_post ,"value"=>$twitter);
				
				$links[]=array("title"=>"Google Plus Link","id"=>SB_WidgetBridge::$social_google_post,"value"=>$google);
				
				$links[]=array("title"=>"Linkedin Link","id"=>SB_WidgetBridge::$social_linkedin_post,"value"=>$linkedin);
				
				
		?>
        <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'Social Links'); ?></label> 
		<input class="form-control" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        </div>
        
        <?php foreach($links as $link) { ?>
         <div class="form-group">
        <p>
        <label for="<?php echo $this->get_field_id( $link["id"]); ?>"><?php echo $link["title"]; ?></label>
        <input id="<?php echo $this->get_field_id( $link["id"]); ?>" class="form-control" name="<?php echo $this->get_field_name($link["id"]); ?>" value="<?php echo esc_attr($link["value"]); ?>" />
        </p>
        
        </div>
        
        <?php } ?>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
				
				$links[]=array("title"=>"Facebook Link","id"=>SB_WidgetBridge::$social_facebook_post );
				
				$links[]=array("title"=>"Twitter Link","id"=>SB_WidgetBridge::$social_twitter_post );
				
				$links[]=array("title"=>"Google Plus Link","id"=>SB_WidgetBridge::$social_google_post );
				
				$links[]=array("title"=>"Linkedin Link","id"=>SB_WidgetBridge::$social_linkedin_post );
		
		foreach($links as $link)
		$instance[$link["id"]]=(!empty($new_instance[$link["id"]]))?strip_tags($new_instance[$link["id"]]):'';
		
		return $instance;
	}
}

class SB_BriefWidget extends WP_Widget {
	
	 public function __construct() {
		parent::__construct( 'widget_SB_BriefWidget', 'Sabian Footer Brief Description', array(
			'classname'   => 'widget_SB_BriefWidget',
			'description' => 'Display brief description of your website. To be used preferebly at the footer',
		) );
	}
	
	function widget( $args, $instance ) {
		
		if ( ! empty( $instance['title'] ) ) :
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		else:
		echo ''; endif;
		
		SB_WidgetBridge::displayBriefDescription($args, $instance);
	}
	public function form( $instance ) {
		
     	        $title = ! empty( $instance['title'] ) ? $instance['title'] : 'About Your Company';
				
				$description=!empty($instance[SB_WidgetBridge::$brief_description_text_post])?$instance[SB_WidgetBridge::$brief_description_text_post]:'';
				
				$url=!empty($instance[SB_WidgetBridge::$brief_button_url_post])?$instance[SB_WidgetBridge::$brief_button_url_post]:'';
				
				$btnText=!empty($instance[SB_WidgetBridge::$brief_button_text_post])?$instance[SB_WidgetBridge::$brief_button_text_post]:'';
				
				
		?>
        <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'Title'); ?></label> 
		<input class="form-control" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        </div>
        
         <div class="form-group">
        <p>
        <label for="<?php echo $this->get_field_id( SB_WidgetBridge::$brief_description_text_post ); ?>">Enter Brief Description</label>
        <textarea id="<?php echo $this->get_field_id( SB_WidgetBridge::$brief_description_text_post ); ?>" name="<?php echo $this->get_field_name( SB_WidgetBridge::$brief_description_text_post ); ?>" value="<?php echo $description; ?>" style="width:100%"><?php echo $description; ?></textarea>
        </p>
        
        </div>
        
        
        <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( SB_WidgetBridge::$brief_button_url_post ); ?>">Enter Button Url</label> 
		<input class="form-control" id="<?php echo $this->get_field_id( SB_WidgetBridge::$brief_button_url_post ); ?>" name="<?php echo $this->get_field_name( SB_WidgetBridge::$brief_button_url_post ); ?>" type="text" value="<?php echo esc_attr( $url); ?>">
		</p>
        </div>
        
        
        
        <div class="form-group">
        
        <p>
		<label for="<?php echo $this->get_field_id( SB_WidgetBridge::$brief_button_text_post ); ?>">Enter Button Text</label> 
		<input class="form-control" id="<?php echo $this->get_field_id( SB_WidgetBridge::$brief_button_text_post ); ?>" name="<?php echo $this->get_field_name( SB_WidgetBridge::$brief_button_text_post ); ?>" type="text" value="<?php echo $btnText; ?>">
		</p>
        </div>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		$instance[SB_WidgetBridge::$brief_description_text_post]=(!empty($new_instance[SB_WidgetBridge::$brief_description_text_post]))?strip_tags($new_instance[SB_WidgetBridge::$brief_description_text_post]):'';
		
		$instance[SB_WidgetBridge::$brief_button_url_post]=(!empty($new_instance[SB_WidgetBridge::$brief_button_url_post]))?strip_tags($new_instance[SB_WidgetBridge::$brief_button_url_post]):'';
		
		$instance[SB_WidgetBridge::$brief_button_text_post]=(!empty($new_instance[SB_WidgetBridge::$brief_button_text_post]))?strip_tags($new_instance[SB_WidgetBridge::$brief_button_text_post]):'';
		
		return $instance;
	}
}
?>