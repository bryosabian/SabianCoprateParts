<?php
$GLOBALS["sabian_show_sidebar"]=$show_sidebar=apply_filters("sabian_show_sidebar",false);

add_filter("sabian_page_header","sabian_get_breadcrumbs");

add_filter("sabian_main_content_dimension","sabian_no_sidebar");

add_action("sabian_after_all_posts","sabian_posts_pagination");

add_action("sabian_after_single_post","sabian_single_comment");

function sabian_posts_pagination()
{
	$pagination="";
	
	ob_start();
	
	global $wp_query;
	
    $total_pages = $wp_query->max_num_pages;
 
    if ($total_pages > 1){
		
        $current_page = max(1, get_query_var('paged'));
 
        $pagins=paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
			'prev_next' => false,
            'type'  => 'array',
            'prev_next'   => TRUE,
			'prev_text'    => __('«'),
			'next_text'    => __('»'),
        ));
		
		 if( is_array( $pagins ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			
            echo '<ul class="pagination pagination pull-left">';
			
            foreach ( $pagins as $i=>$page ) {
				$class=array();
				
				if ( strpos( $page, 'current' ) !== false)
				{
					$class[]="active";
				}
				$open_ahref=( strpos( $page, 'current' ) !== false)?'<a href="#">':"";
				$close_ahref=( strpos( $page, 'current' ) !== false)?'</a>':"";
				echo '<li class="'.implode(" ",$class).'">'.$open_ahref.strip_tags($page,"<a>").$close_ahref.'</li>';
            }
           echo '</ul>';
        }
    }
	
	$pagination=ob_get_contents();
	
	ob_end_clean();
	
	echo apply_filters("sabian_posts_pagination",$pagination);
}
function sabian_list_comments()
{
	$comments="";
	
	ob_start();
	?>
    <div class="comment-list clearfix" id="comments">
		                        <h2>Comment Section</h2>
                                <ol>
                                <?php 
								wp_list_comments(array('walker'=>new SabianCommentWalker()));

								//wp_list_comments( /*'type=comment&callback=sabian_comment_callback'*/ );  ?>
                                </ol>
                                </div>
    <?php
	$comments=ob_get_contents();
	
	ob_end_clean();
	
	echo apply_filters("sabian_comment_template",$comments);
}
function sabian_comment_callback($comment, $args, $depth)
{
	?>
    <li class="comment">
		                                <div class="comment-body bb">
		                                    <div class="comment-avatar">
		                                        <div class="avatar"><img src="images/temp/avatar1.png" alt=""></div>
		                                    </div>
		                                    <div class="comment-text">
		                                        <div class="comment-author clearfix">
		                                            <a href="#" class="link-author" hidefocus="true" style="outline: none;">Brad Pit</a>
		                                            <span class="comment-meta"><span class="comment-date">June 26, 2013</span> | <a href="#addcomments" class="link-reply anchor" hidefocus="true" style="outline: none;">Reply</a></span>
		                                        </div>
		                                        <div class="comment-entry">
		                                            William Bradley "Brad" Pitt is an American actor and film producer. Pitt has received four Academy Award nominations and five Golden Globe.
		                                        </div>
		                                    </div>
		                                </div>
		                            </li>
    <?php
}
function sabian_single_comment()
{
	sabian_list_comments();
	
	sabian_get_comment_form();
}
function sabian_no_sidebar()
{
	if(!$GLOBALS["sabian_show_sidebar"])
	return "col-md-12";
	
	return "col-md-9";
}

function sabian_get_breadcrumbs()
{
	$bd="";
	
	if(!is_front_page())
	{
		$bd='<div class="pg-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>'.get_title().'</h2>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li class="active">'.get_title().'</li>
                </ol>
            </div>
        </div>
    </div>
</div>';
	}
	
	return $bd;
}
function sabian_load_home_content()
{
	if ( have_posts() )
	{
		while ( have_posts() ) {
			
			the_post(); 
			
			the_content(); 
		}
	}
}
function sabian_load_sub_content()
{
	while ( have_posts() ) 
	{
		the_post(); 
		
		the_content(); 
	}
	
}
function sabian_load_content()
{
	switch( is_front_page()) 
	{
		case true:
		sabian_load_home_content();
		break;
		
		case false:
		if(sabian_is_post()){
			
			sabian_display_posts();
		}
		else{
			sabian_load_sub_content();
		}
		
		break;
	}
}
function sabian_display_posts()
{
	$displayPost=apply_filters("sabian_display_posts",true);
	
	if(!$displayPost)
	return;
	
	echo '<section class="section_content">';
	
	$cont_sd=apply_filters("sabian_post_content_dimension",'col-md-9');
	
	$sb_sd=apply_filters("sabian_post_content_dimension",'col-md-3');
	
	?>
    <div class="container">
    <div class="row">
    <div class="col-md-9">
    <?php
	if(!is_single())
	echo apply_filters("sabian_open_post_items",'<ul class="list-listings blog-list">'); 
	
	while ( have_posts() ) 
	{
		the_post();
		
		if(is_single())
		{
			sabian_load_single_post();
		}
		else
		{
			sabian_load_posts();
		}
	}
	
	if(!is_single())
	{
		echo apply_filters("sabian_close_post_items",'</ul>'); 
		
		do_action("sabian_after_all_posts");
	}
	
	
	
	?>
    </div>
    
    
     <div class="<?php echo $sb_sd; ?> sidebar">
    <?php get_sidebar('sabian_sidebar'); ?>
    </div>
	<?php
	
	?>
    </div>
    </div>
    <?php
	
	echo '</section>';
	
}
function sabian_load_posts()
{
	$post=get_post();
	
	if(has_post_thumbnail())
	{
		$image_link=wp_get_attachment_url( get_post_thumbnail_id() );
		
		$img='<div class="sabian_product" style="height:150px; background-image: url('.$image_link.')"></div>';
		
		$width="200px";
	}
	else
	{
		$img="";
		
		$width="";
	}
	
	$cont="";
	
	$cont.='<li class="">
	
	'.do_action("sabian_before_post").'
	
                                <div class="listing-image" style="width:'.$width.'">'.$img.'</div>
								
                                <div class="listing-body">
                                    <h3><a href="'.$post->guid.'">'.$post->post_title.'</a></h3>
                                    <span class="list-item-info">
                                        Posted by <a href="#">'.get_the_author().'</a> on '.date('j M Y',strtotime($post->post_date_gmt)).'
                                    </span>
                                    <p>
                                    '.sabian_get_ellipsis(strip_tags($post->post_content),180).'
                                    </p>
                                    <p>
                                        <a href="'.$post->guid.'" class="btn btn-sm btn-base pull-right">Read more</a>
                                    </p>
                                </div>
                            </li>';
							
							echo apply_filters("sabian_post_item",$cont);
							
							do_action("sabian_after_post");
}
function sabian_get_comment_form()
{
	if ( comments_open() )
	{
		$args = array(
	'comment_field' => ' <label class="">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" class="form-control input-lg" cols="45" rows="8" aria-required="true"></textarea>',
	
  'fields' => apply_filters( 'comment_form_default_fields', array(

    'author' =>
      '<label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
      ( $req ? '<span class="required">*</span>' : '' ) .
      '<input id="author" name="author" type="text" class="form-control input-lg" value="' . esc_attr( $commenter['comment_author'] ) .
      '" size="30"' . $aria_req . ' />',

    'email' =>
      '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
      ( $req ? '<span class="required">*</span>' : '' ) .
      '<input id="email" name="email" class="form-control input-lg" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" size="30"' . $aria_req . ' /></p>',

    'url' =>
      '<p class="comment-form-url"><label for="url">' .
      __( 'Website', 'domainreference' ) . '</label>' .
      '<input id="url" name="url" class="form-control input-lg" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" size="30" /></p>'
    )
	));
		comment_form( $args ); 
	}
	else
	{
		_e(apply_filters("sabian_comments_not_allowed_message",'<h2>Comments are closed</h2>'));
	}
}
function sabian_load_single_post()
{
	$post=get_post();
	
	if(has_post_thumbnail())
	{
		
		$image_link=wp_get_attachment_url( get_post_thumbnail_id() );
		
		$img='<div class="sabian_product" style="height:300px; background-image: url('.$image_link.')"></div>';
		
		
		$img_container='<div class="post-image">
	                            	<a href="'.$image_link.'" class="theater" title="Shoreline">
	                            		'.$img.'
	                            	</a>
	                            </div>';
	}
	else
	{
		$img="";
		
		$img_container="";
	}
	$cont="";
	
	do_action("sabian_before_single_post");
	
	$cont.='<div class="post-item">
	                        <div class="post-meta-top">'.$img_container.'</div>';
							
							$cont.='<div class="post-content">
	                            <h2 class="post-title"><a href="'.$post->guid.'" hidefocus="true" style="outline: none;">'.$post->post_title.'</a></h2>
	                            <span class="post-author">WRITTEN BY <a href="#" hidefocus="true" style="outline: none;">'.get_the_author().'</a></span>
	                            <div class="post-tags">Posted on <a href="#" hidefocus="true" style="outline: none;">'.date('j M Y',strtotime($post->post_date_gmt)).'</a></div>
	                            <div class="clearfix"></div>
	                            <div class="post-desc">
	                            	<p>'.$post->post_content.'</p>
	                            </div>
	                        </div>
                            
	                        <!--<hr>-->
							
							</div>';
						
						
						echo apply_filters("sabian_single_post_item",$cont);
						
						do_action("sabian_after_single_post",$post);
						
						
}
function sabian_is_post()
{
	if(is_page()) {
		return false;
		}
		
return true;

}
?>