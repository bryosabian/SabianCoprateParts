<?php
class SB_ProductsModel{
	
	public $products=array();
	
	public $product;
	
	public $wp_query;
	
	public function getProducts($args=null){
		
		global $current_user;
		
		$products=array();
		
		if(is_null($args))
		$args=array(
		"post_type"=>'product',
		"posts_per_page"=>-1,
		"orderby"=>'ID',
		'order'=>'DESC'
		/*"author"=>$current_user->ID*/
		);
		
		$loop=new WP_Query($args);
		
		while($loop->have_posts())
		{
			$loop->the_post();
			
			$product=new WC_Product(get_the_ID());
			
			$products[]=$product;
		}
		
		$this->wp_query=$loop;
		
		$this->products=$products;	
	}
	public function getQueryArgs(){
		
		$params=array(
		'paged'=>$paged,
		"post_type"=>'product',
		"posts_per_page"=>10,
		"orderby"=>'ID',
		'order'=>'DESC',
		/*"author"=>$current_user->ID*/
		);
		
		return $params;	
	}
}
?>