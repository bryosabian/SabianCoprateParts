<?php
$tpost=new SabianTestimonialPost();

$GLOBALS["sabian_testimonial_post"]=$tpost;

class SabianTestimonialPost{
	
	public $post_name="testimonial";
	
	public $cat_name="testimonial_category";
	
	private $user_nonce="sabian_testimonial_uname_nonce";
	
	public $user_name_meta_key="sabian_testimonial_uname_post";
	
	public $user_position_meta_key="sabian_testimonial_uposition_post";
	
	public $user_company_meta_key="sabian_testimonial_ucompany_post";
	
	public function __construct(){
		
		add_action( 'init', array($this,'register_post'));
		
		add_action( 'init', array($this,'register_category'), 0 );
		
		add_filter( 'post_updated_messages', array($this,'get_post_messages'));
		
		add_action( 'add_meta_boxes', array($this,'register_boxes') );
		
		add_action( 'save_post', array($this, 'testimonial_box_update'));
		
		add_action("manage_".$this->post_name."_posts_columns",array($this,"testimonial_table_head"));
		
		add_action("manage_".$this->post_name."_posts_custom_column",array($this,"testimonial_table_rows"),1000,2);
			
	}
	public function register_post() {
		
		$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name' ),
		'add_new'            => _x( 'Add Testimonial', 'property' ),
		'add_new_item'       => __( 'Add New Testimonial' ),
		'edit_item'          => __( 'Edit Testimonial' ),
		'new_item'           => __( 'New Testimonial' ),
		'all_items'          => __( 'All Testimonials' ),
		'view_item'          => __( 'View Testimonial' ),
		'not_found'          => __( 'No testimonials found' ),
		'not_found_in_trash' => __( 'No testimonials found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Testimonials'
		);
		
		$args = array(
		'labels'        => $labels,
		'description'   => 'Collection of various testimonials',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'excerpt', 'thumbnail'),
		'has_archive'   => true,
		);
		
		register_post_type($this->post_name, $args ); 
	}
	public function get_post_messages( $messages ) {
		
		global $post, $post_ID;
		
		$messages[$this->post_name] = array(
		0 => '', 
		1 => sprintf( __('Testimonial updated. <a href="%s">View testimonial</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Testimonial field updated.'),
		3 => __('Testimonial field deleted.'),
		4 => __('Testimonial updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Testimonial published. <a href="%s">View testimonial</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Testimonial saved.'),
		8 => sprintf( __('Testimonial submitted. <a target="_blank" href="%s">Preview property</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview property</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Testimonial draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		
		return $messages;
	}
	public function register_category() {
		
		$labels = array(
		'name'              => _x( 'Testimonial Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Testimonial Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Testimonial Categories' ),
		'all_items'         => __( 'All Testimonial Categories' ),
		'parent_item'       => __( 'Parent Testimonial Category' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:' ),
		'edit_item'         => __( 'Edit Testimonial Category' ), 
		'update_item'       => __( 'Update Testimonial Category' ),
		'add_new_item'      => __( 'Add New Testimonial Category' ),
		'new_item_name'     => __( 'New Testimonial Category' ),
		'menu_name'         => __( 'Testimonial Categories' ),
		);
		
		$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		);
		
		register_taxonomy( $this->cat_name,$this->post_name, $args);
	}
	public function register_boxes(){
		
		add_meta_box( 
        'sabian_testimonial_user_box',
		'User Details',
        array($this,'testimonial_box_settings'),
        $this->post_name,
        'side',
        'high'
		);
		
	}
	public function testimonial_box_settings($post){
		
		wp_nonce_field( plugin_basename( __FILE__ ), $this->user_nonce);
		
		$unames=get_post_meta( $post->ID, $this->user_name_meta_key, true );
		
		$uposition=get_post_meta( $post->ID, $this->user_position_meta_key, true );
		
		$ucompany=get_post_meta( $post->ID, $this->user_company_meta_key, true );
		
		?>
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">User Names</label>
		<input type="text" class="form-control" value="<?php echo $unames; ?>" name="user_testimonial_names" placeholder="Enter user's full names" />
		
		</div>
        
         <div class="sky-form form-group">
		
		<label for="sabian-header-title">User Position</label>
		<input type="text" class="form-control" value="<?php echo $uposition; ?>" name="user_testimonial_position" placeholder="Enter company position e.g CEO" />
		
		</div>
        
         <div class="sky-form form-group">
		
		<label for="sabian-header-title">User Company</label>
		<input type="text" class="form-control" value="<?php echo $ucompany; ?>" name="user_testimonial_company" placeholder="Enter user's company" />
		
		</div>
        
        
        
        <?php
	}
	public function testimonial_box_update($post_id){
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
		
		if ( !wp_verify_nonce( $_POST[$this->user_nonce], plugin_basename( __FILE__ ) ) )
		return;
		
		if($this->post_name!==$_POST['post_type'])
		return;
		
		//if ( !current_user_can( 'edit_page', $post_id ) )
		//return; 
		
		$uname=$_POST["user_testimonial_names"];
		
		$uposition=$_POST["user_testimonial_position"];
		
		$ucompany=$_POST["user_testimonial_company"];
		
		sabian_update_meta_values($post_id,$this->user_name_meta_key,$uname);
		
		sabian_update_meta_values($post_id,$this->user_company_meta_key,$ucompany);
		
		sabian_update_meta_values($post_id,$this->user_position_meta_key,$uposition);
		
	}
	public function testimonial_table_head($column){
		
		unset($column['date']);
		
		$column["title"]="Title";
		
		$column["names"]="Names";
		
		$column["company"]="Company";
		
		$column['date']="Date Created";
		
		return $column;
	}
	
	public function testimonial_table_rows($column,$post_id){
		
		$sPost=WP_Post::get_instance($post_id);
		
		if($column=="title"){
			echo $sPost->post_title;
		}
		
		if($column=="names"){
			
			$uname=get_post_meta($post_id,$this->user_name_meta_key,true);
			
			echo $uname;
		}
		if($column=="company"){
			
			$ucompany=get_post_meta($post_id,$this->user_company_meta_key,true);
			
			echo $ucompany;
		}
	}
}

?>