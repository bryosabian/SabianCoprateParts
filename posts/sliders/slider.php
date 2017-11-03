<?php
$sppost=new SabianSliderPost();

$GLOBALS["sabian_slider_post"]=$sppost;

class SabianSliderPost{
	
	public $post_name="slider";
	
	public $cat_name="slider_category";
	
	private $link_nonce="sabian_slider_link_nonce";
	
	public $link_meta_key="sabian_slider_link_post";
	
	public $button_text_meta_key="sabian_slider_button_text_post";
	
	public function __construct(){
		
		add_action( 'init', array($this,'register_post'));
		
		add_action( 'init', array($this,'register_slider_category'), 0 );
		
		add_filter( 'post_updated_messages', array($this,'get_slider_messages'));
		
		add_action( 'add_meta_boxes', array($this,'register_boxes') );
		
		add_action( 'save_post', array($this, 'slider_box_update'));
		
		add_action("manage_".$this->post_name."_posts_columns",array($this,"sliders_table_head"));
		
		add_action("manage_".$this->post_name."_posts_custom_column",array($this,"sliders_table_rows"),1000,2);
			
	}
	public function register_post() {
		
		$labels = array(
		'name'               => _x( 'Sliders', 'post type general name' ),
		'singular_name'      => _x( 'Slide', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'property' ),
		'add_new_item'       => __( 'Add New Slide' ),
		'edit_item'          => __( 'Edit Slide' ),
		'new_item'           => __( 'New Slide' ),
		'all_items'          => __( 'All Slides' ),
		'view_item'          => __( 'View Slide' ),
		'not_found'          => __( 'No slide found' ),
		'not_found_in_trash' => __( 'No slides found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Slides'
		);
		
		$args = array(
		'labels'        => $labels,
		'description'   => 'Collection of various slides',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'excerpt', 'thumbnail'),
		'has_archive'   => true,
		);
		
		register_post_type($this->post_name, $args ); 
	}
	public function get_slider_messages( $messages ) {
		
		global $post, $post_ID;
		
		$messages[$this->post_name] = array(
		0 => '', 
		1 => sprintf( __('Slide updated. <a href="%s">View slide</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Slide field updated.'),
		3 => __('Slide field deleted.'),
		4 => __('Slide updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Slide restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Slide published. <a href="%s">View slide</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Slide saved.'),
		8 => sprintf( __('Slide submitted. <a target="_blank" href="%s">Preview property</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview property</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Slide draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		
		return $messages;
	}
	public function register_slider_category() {
		
		$labels = array(
		'name'              => _x( 'Slide Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Slide Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Slide Categories' ),
		'all_items'         => __( 'All Slide Categories' ),
		'parent_item'       => __( 'Parent Slide Category' ),
		'parent_item_colon' => __( 'Parent Slide Category:' ),
		'edit_item'         => __( 'Edit Slide Category' ), 
		'update_item'       => __( 'Update Slide Category' ),
		'add_new_item'      => __( 'Add New Slide Category' ),
		'new_item_name'     => __( 'New Slide Category' ),
		'menu_name'         => __( 'Slide Categories' ),
		);
		
		$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		);
		
		register_taxonomy( $this->cat_name,$this->post_name, $args);
	}
	public function register_boxes(){
		
		add_meta_box( 
        'sabian_slide_link_photo_box',
		'Slide Settings',
        array($this,'slide_box_settings'),
        $this->post_name,
        'side',
        'high'
		);
		
	}
	public function slide_box_settings($post){
		
		wp_nonce_field( plugin_basename( __FILE__ ), $this->link_nonce);
		
		$sel_images=array();
		
		$link=get_post_meta( $post->ID, $this->link_meta_key, true );
		
		$btnText=get_post_meta( $post->ID, $this->button_text_meta_key, true );
		
		$pages=sabian_get_pages();
		
		if($link)
		$sP=WP_Post::get_instance($link);
		
		?>
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Button Text</label>
		
        <label class="input">
		<input name="sabian_button_text" placeholder="Enter Button Text" value="<?php echo ($btnText)?$btnText:"View More"; ?>">
         </label>
		
		</div>
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Page To Direct To</label>
		
        <label class="select">
		<select name="sabian_button_link">
		
        <?php if($link) { ?> <option selected value="<?php echo $sP->ID; ?>"><?php echo $sP->post_title; ?></option> <?php } ?>
        
                <?php foreach($pages as $page) { ?>
        		<option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                <?php } ?>
        		
		 </select>
         
         <i></i>
         
         </label>
		
		</div>
        
        
        
        <?php
	}
	public function slider_box_update($post_id){
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
		
		if ( !wp_verify_nonce( $_POST[$this->link_nonce], plugin_basename( __FILE__ ) ) )
		return;
		
		if($this->post_name!==$_POST['post_type'])
		return;
		
		//if ( !current_user_can( 'edit_page', $post_id ) )
		//return; 
		
		$btnLink=$_POST['sabian_button_link'];
		
		$btnText=$_POST['sabian_button_text'];
		
		sabian_update_meta_values($post_id,$this->link_meta_key,$btnLink);
		
		sabian_update_meta_values($post_id,$this->button_text_meta_key,$btnText);
		
	}
	public function sliders_table_head($column){
		
		unset($column['date']);
		
		$column["excerpt"]="Description";
		
		$column["page"]="Link";
		
		$column['date']="Date Created";
		
		return $column;
	}
	
	public function sliders_table_rows($column,$post_id){
		
		$sPost=WP_Post::get_instance($post_id);
		
		if($column=="excerpt"){
			echo sabian_get_ellipsis($sPost->post_excerpt,70);
		}
		
		if($column=="page"){
			
			$page=get_post_meta($post_id,$this->link_meta_key,true);
			
			$page=WP_Post::get_instance($page);
			
			echo $page->guid;	
		}
	}
}

?>