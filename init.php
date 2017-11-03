<?php
add_action( 'after_switch_theme', 'sabian_theme_setup' );

function sabian_theme_setup($theme)
{
	do_action("sabian_activated");
}

add_action('switch_theme','sabian_theme_deactivate');

function sabian_theme_deactivate($theme){
	
	do_action("sabian_deactivated");
}

new SabianSettings();

class SabianSettings{
	
	const DASHBOARD_PAGE_KEY="sabian_dashboard_page_key";
	
	const TEMPLATES_DIR='page-templates/';
	
	const VENDOR_ROLE_KEY='sabian_wc_vendor';
	
	public function __construct(){
		
		add_action('sabian_activated',array($this,'register'));
		
		add_action('sabian_deactivated',array($this,'remove'));
		
		add_filter('woocommerce_prevent_admin_access',array($this,'filterAdmin'));
		
		add_action('pre_get_posts',array($this,'filterByVendor'));
		
		add_action('load-edit.php',array($this,'disablePostLock'));
		
		add_action('load-post.php',array($this,'disablePostLock'));
		
		add_action('transition_post_status',array($this,'lockPostToReview'),30000,3);
		
		/*Remove the custom fields option for products*/
		add_action('admin_menu',function(){
			
			if(!current_user_can(self::VENDOR_ROLE_KEY))
			return;
			
			remove_meta_box('postcustom','product','normal');
		},1000000);
	}
	public function lockPostToReview($new_status,$old_status,$post){
		
		if(is_super_admin()){
			return;	
		}
		
		if(current_user_can(self::VENDOR_ROLE_KEY)){
			
			if($post->post_type=='product' && $new_status=='publish'){
				$post->post_status='pending';
				wp_update_post($post);	
			}
		}
		
	}
	public function disablePostLock(){
		
		if('product'===get_current_screen()->post_type){
			
				add_filter('wp_check_post_lock_window',function(){
				return false;	
				});	
				
				add_filter('show_post_locked_dialog',function(){
				return false;	
				});
				
				wp_deregister_script('heartbeat');	
			}
	}
	public function filterByVendor($q){
		
		if(!is_admin()){
			return;	
		}
		
		if(!is_user_logged_in()){
			return;	
		}
		if(is_super_admin()){
			return;	
		}
		
		if(!current_user_can(self::VENDOR_ROLE_KEY)){
			return;
		}
		
		$current_user=wp_get_current_user();
		
		$global_post_types=array(EAP_MODEL_POST_NAME,EAP_VARIANT_POST_NAME,'shop_order',EAP_MANUF_POST_NAME);
		
		if(!in_array($q->get('post_type'),$global_post_types)){
			$q->set('author',$current_user->ID);
		}
	}
	public function filterAdmin($return){
		
		if(current_user_can(self::VENDOR_ROLE_KEY)){
			return false;	
		}
		
		return $return;
	}
	public function register(){
		
		$this->registerDashPage();	
		
		$this->registerVendorRole();
	}
	public function remove(){
		
		$this->registerDashPage(true);
		
		$this->registerVendorRole(true);
	}
	private function registerVendorRole($is_remove=false){
		
		if($is_remove){
			
			remove_role(self::VENDOR_ROLE_KEY);
			
			return;
		}
		
		$roleCreated=add_role(self::VENDOR_ROLE_KEY,__('Shop Vendor'),array(
		'read'=>true,
		'edit_posts'=>false,
		'delete_posts'=>false
		));
		
		$role=get_role(self::VENDOR_ROLE_KEY);
		
		$default_caps=array('upload_files');
		
		$product_caps=array(
		'edit_product',
		'read_product',
		'delete_product',
		'edit_products',
		'publish_products',
		'read_private_products',
		'delete_products',
		'delete_private_products',
		'delete_published_products',
		'edit_private_products',
		'edit_published_products',
		'edit_products'
		
		);
		
		$product_term_caps=array(/*
		'manage_product_terms',*/
		'edit_product_terms',
		'delete_product_terms',
		'assign_product_terms',
		);
		
		$product_order_caps=array(
		'edit_shop_order',
		'read_shop_order',
		'delete_shop_order',
		'edit_shop_orders',
		'publish_shop_orders',
		'read_private_shop_orders',
		'delete_shop_orders',
		'delete_private_shop_orders',
		'delete_published_shop_orders',
		'edit_private_shop_orders',
		'edit_published_shop_orders',
		
		'manage_shop_order_terms',
		'edit_shop_order_terms',
		'delete_shop_order_terms',
		'assign_shop_order_terms'
		);
		
		$product_coupon_caps=array(
		'edit_shop_coupon',
		'read_shop_coupon',
		'delete_shop_coupon',
		'edit_shop_coupons',
		'publish_shop_coupons',
		'read_private_shop_coupons',
		'delete_shop_coupons',
		'delete_private_shop_coupons',
		'delete_published_shop_coupons',
		'edit_private_shop_coupons',
		'edit_published_shop_coupons',
		
		'manage_shop_coupon_terms',
		'edit_shop_coupon_terms',
		'delete_shop_coupon_terms',
		'assign_shop_coupon_terms'
		);
		
		$caps=array_merge($default_caps,$product_caps,$product_term_caps,$product_coupon_caps);
		
		foreach($caps as $cap){
			$role->add_cap($cap);
		}
		
		
		
		return $roleCreated;
	}
	private function registerDashPage($is_remove=false){
		
		if($is_remove){
			
			$pageID=get_option(self::DASHBOARD_PAGE_KEY);
			
			if($pageID!==FALSE){
				
				$deleted=wp_delete_post($pageID, true);
				
				if($deleted!==FALSE){
					
					delete_option(self::DASHBOARD_PAGE_KEY);	
				}
			}
			
			return;	
		}
		
		$ex=get_option(self::DASHBOARD_PAGE_KEY);
		
		if($ex!==FALSE)
		return;
		
		$args=array(
		     'post_type'=>'page',
			 'post_title'=>"Dashboard",
			 'post_status'=>'publish'
		);
		
		$pageID=wp_insert_post($args,true);
		
		if($pageID instanceof WP_Error)
			return false;
		
		if(!$pageID || $pageID==0)
		return false;
		
		//Assign to the dashboard template
		update_post_meta($pageID,'_wp_page_template',self::TEMPLATES_DIR.'dashboard.php');
		
		add_option(self::DASHBOARD_PAGE_KEY,$pageID);
	}
	
	public function loadLoginCss(){
		
		$url=get_stylesheet_directory_uri()."/css/wp_login.css";
		
		echo '<link rel="stylesheet" type="text/css" href="'.$url.'" />';	
	}
}
?>