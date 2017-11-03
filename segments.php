<?php
function sabian_categories()
{
	$categories=array();
	
	 $bcats = get_categories();
	 
                    foreach($bcats as $category) :
					$catid=$category->cat_ID;
					$catname=$category->name;
					$categories[]=$category;
					endforeach; 
					
					return $categories;
}
function sabian_get_posts($cat_id=null, $post_name=null, $cat_name=null, $no_posts=100)
{
	$posts=array();
	
	$args=array(
	
	'posts_per_page'=>-1,
	'post_type'=>$post_name,
	
	);
	
	if($cat_id!=null){
		$args['tax_query']=array(array(
	             'taxonomy'=>$cat_name,
				 'field'=>'term_id',
				 'terms'=>$cat_id
	));	
	}
	
	$posts=get_posts($args);
	
	return $posts;
}
function sabian_get_pages($args=null)
{
	$arg;
	
	if(!is_null($args))
	$arg=$args;
	
	$arg=array(
	'post_type'=>'page',
	'post_status'=>'publish'
	);
	
	return get_pages($arg);
	
}
function sabian_get_ellipsis($string,$length)
	{
		if(strlen($string)<=$length)
		{
			return $string;
		}
		else
		{
			return substr($string,0,$length).".....";
		}
	}
	
function sabian_update_meta_values($post_id,$meta_key,$value){
	
	$old_value=wp_specialchars(get_post_meta( $post_id, $meta_key, true ));
	
	if($value && '' == $old_value){
		
		update_post_meta( $post_id, $meta_key, $value );
		
		return;
	}
	
	if( $value!=$old_value){
		
		update_post_meta( $post_id, $meta_key, $value );
		
		return;	
	}
	if ( '' == $value && $old_value )
	{
		delete_post_meta( $post_id, $meta_key, $meta_value );
		
		return;
	}
	
}
?>