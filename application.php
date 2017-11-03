<?php
require_once SABIAN_APP_PATH."init.php";

require_once SABIAN_APP_PATH."widgets.php";

require_once SABIAN_APP_PATH."register_scripts.php";

require_once SABIAN_APP_PATH."segments.php";

require_once SABIAN_APP_PATH."content.php";

require_once SABIAN_APP_PATH."sabian_nav.php";

require_once SABIAN_APP_PATH."sabian_woocommerce.php";

require_once SABIAN_APP_PATH."posts/init.php";

require_once SABIAN_APP_PATH."easyparts/init.php";

require_once SABIAN_APP_PATH."vc_addons/init.php";

add_action("sabian_main_content","sabian_load_content");

/*register menus*/
function sabian_register_menus() {
	
	
  register_nav_menus(
    array(
      'header-menu' => __( 'Sabian Main Menu' ),
      'extra-menu' => __( 'Sabian Top And Footer Menu' ),
	  'sabian-header-menu-sub'=>__('Sabian Sub Main Menu'),
	  'sabian-header-menu-mobile' =>__('Sabian Mobile Menu')
    )
  );
  
  /*register sidebars*/
  register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sabian_sidebar',
		'before_widget' => '<div class="widget_side">',
		'after_widget' => '</div>',
		'before_title' => '<div class="category_title"><span>',
		'after_title' => '</span></div>',
	) );
	
	/*register sidebars*/
  register_sidebar( array(
		'name' => 'Content Sidebar',
		'id' => 'sabian_content_sidebar',
		'before_widget' => '<div class="widget_side">',
		'after_widget' => '</div>',
		'before_title' => '<div class="category_title"><span>',
		'after_title' => '</span></div>',
	) );
  
  register_sidebar( array(
		'name' => 'Footer Widget 1',
		'id' => 'sabian_fw1',
		'before_widget' => '<div class="col">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );	

register_sidebar( array(
		'name' => 'Footer Widget 2',
		'id' => 'sabian_fw2',
		'before_widget' => '<div class="col">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );	

register_sidebar( array(
		'name' => 'Footer Widget 3',
		'id' => 'sabian_fw3',
		'before_widget' => '<div class="col">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );

register_sidebar( array(
		'name' => 'Footer Widget 4',
		'id' => 'sabian_fw4',
		'before_widget' => '<div class="col">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );		

}

/*register search form*/
function sabian_search_form()
{
	
    $form='<form class="form-light form-horizontal" role="form" action="'.home_url( '/' ).'">
            <div class="input-group">
                <input class="form-control" value="'.get_search_query().'" placeholder="Search site..." type="text">
                <span class="input-group-btn">
                    <button class="btn btn-base" type="button">Go</button>
                </span>
            </div>
        </form>';
		
		return $form;
}

/*register sidebar*/
function sabian_init_sidebars()
{
	register_sidebar( array(
		'name' => 'Primary Sidebar',
		'id' => 'sabian_sidebar',
		'before_widget' => '<div class="widget_side">',
		'after_widget' => '</div>',
		'before_title' => '<div class="category_title"><span>',
		'after_title' => '</span></div>',
	) );
}

function sabian_filter_menus($items)
{
	$parents = array();
 
    // Collect menu items with parents.
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
            $parents[] = $item->menu_item_parent;
        }
    }
 
    // Add class.
    foreach ( $items as $item ) {
        if ( in_array( $item->ID, $parents ) ) {
            $item->classes[] = 'menu-parent-item';
        }
    }
    return $items;
}
function sabian_default_menu()
{
	$link_container='';
	
	$link_container.='<ul class="nav navbar-nav navbar-left">';
	
	$pages=sabian_get_pages();
	
	foreach($pages as $pag)
	{
		$class=array();
		//echo $pag->ID." : ".get_the_ID()."<br/>";
		
		if($pag->ID==get_the_ID()){
			$class[]="active";
		}
		
		$link_container.='<li class=""><a href="'.$pag->guid.'" class="'.implode(" ",$class).'" tabindex="-1"><span>'.$pag->post_title.'</span></a></li>';
	}
	
	$link_container.="</ul>";
	
	echo $link_container;
}
function sabian_default_extra_menu()
{
	$count=1;
	
	$link_container='';
	
	$link_container.='<ul class="list-inline">';
	
	$pages=sabian_get_pages();
	
	foreach($pages as $pag)
	{
		if($count>=6)
		break;
		
		$link_container.='<li><a href="'.$pag->guid.'">'.$pag->post_title.'</a></li>';
		
		$count++;
	}
	
	$link_container.="</ul>";
	
	echo $link_container;
}
function sabian_default_sub_menu()
{
	
	return;
	
	$count=1;
	
	$link_container='';
	
	$link_container.='<ul class="nav navbar-nav navbar-right">';
	
	$pages=sabian_get_pages();
	
	foreach($pages as $pag)
	{
		if($count>=4)
		break;
		
		$link_container.='<li><a href="'.$pag->guid.'">'.$pag->post_title.'</a></li>';
		
		$count++;
	}
	
	$link_container.="</ul>";
	
	echo $link_container;
}
?>