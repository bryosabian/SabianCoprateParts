<?php
$clpost=new SabianClientPost();

$GLOBALS["sabian_client_post"]=$clpost;

class SabianClientPost{
	
	public $post_name="client";
	
	public $cat_name="client_category";
	
	private $link_nonce="sabian_client_link_nonce";
	
	public $link_meta_key="sabian_client_link_post";
	
	public function __construct(){
		
		add_action( 'init', array($this,'register_post'));
		
		add_filter( 'post_updated_messages', array($this,'get_slider_messages'));
		
		add_action( 'add_meta_boxes', array($this,'register_boxes') );
		
		add_action( 'save_post', array($this, 'client_box_update'));
		
		add_action("manage_".$this->post_name."_posts_columns",array($this,"clients_table_head"));
		
		add_action("manage_".$this->post_name."_posts_custom_column",array($this,"clients_table_rows"),1000,2);
			
	}
	public function register_post() {
		
		$labels = array(
		'name'               => _x( 'Clients', 'post type general name' ),
		'singular_name'      => _x( 'Client', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'client' ),
		'add_new_item'       => __( 'Add New Client' ),
		'edit_item'          => __( 'Edit Client' ),
		'new_item'           => __( 'New Client' ),
		'all_items'          => __( 'All Clients' ),
		'view_item'          => __( 'View Client' ),
		'not_found'          => __( 'No client found' ),
		'not_found_in_trash' => __( 'No clients found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Clients'
		);
		
		$args = array(
		'labels'        => $labels,
		'description'   => 'Collection of various clients',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'thumbnail'),
		'has_archive'   => true,
		);
		
		register_post_type($this->post_name, $args ); 
	}
	public function get_slider_messages( $messages ) {
		
		global $post, $post_ID;
		
		$messages[$this->post_name] = array(
		0 => '', 
		1 => sprintf( __('Client updated. <a href="%s">View slide</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Client field updated.'),
		3 => __('Client field deleted.'),
		4 => __('Client updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Client restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Client published. <a href="%s">View slide</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Client saved.'),
		8 => sprintf( __('Client submitted. <a target="_blank" href="%s">Preview property</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Client scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview client</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Client draft updated. <a target="_blank" href="%s">Preview client</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		
		return $messages;
	}
	public function register_boxes(){
		
		add_meta_box( 
        'sabian_client_link_photo_box',
		'Client Settings',
        array($this,'client_box_settings'),
        $this->post_name,
        'normal',
        'high'
		);
		
	}
	public function client_box_settings($post){
		
		wp_nonce_field( plugin_basename( __FILE__ ), $this->link_nonce);
		
		$sel_images=array();
		
		$link=get_post_meta( $post->ID, $this->link_meta_key, true );
		
		?>
        
        
        
        <div class="sky-form form-group">
		
		<label for="sabian-header-title">Select Url To Direct To</label>
		
        <label class="input">
		<input name="sabian_client_link" placeholder="Enter Link" value="<?php echo ($link)?$link:""; ?>">
         </label>
		
		</div>
        
        
        
        <?php
	}
	public function client_box_update($post_id){
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
		
		if ( !wp_verify_nonce( $_POST[$this->link_nonce], plugin_basename( __FILE__ ) ) )
		return;
		
		if($this->post_name!==$_POST['post_type'])
		return;
		
		//if ( !current_user_can( 'edit_page', $post_id ) )
		//return; 
		
		$btnLink=$_POST['sabian_client_link'];
		
		sabian_update_meta_values($post_id,$this->link_meta_key,$btnLink);
		
	}
	public function clients_table_head($column){
		
		unset($column['date']);
		
		$column["link"]="Link";
		
		$column['date']="Date Created";
		
		return $column;
	}
	
	public function clients_table_rows($column,$post_id){
		
		$sPost=WP_Post::get_instance($post_id);
		
		if($column=="link"){
			
			$page=get_post_meta($post_id,$this->link_meta_key,true);
			
			echo $page;	
		}
	}
}

?>