<?php
if(!defined("SB_DASH_PATH")){
	define("SB_DASH_PATH",SABIAN_APP_PATH."admin/");	
}
if(!defined("SB_DASH_PAGES_PATH")){
	define("SB_DASH_PAGES_PATH",SB_DASH_PATH."pages/");	
}

require_once SB_DASH_PATH."base_view.php";

require_once SB_DASH_PATH."base_controller.php";

$GLOBALS["sb_dash_controllers"]=$sb_dash_controllers=array();

//Auto load controller pages
$dirIterator=new DirectoryIterator(SB_DASH_PAGES_PATH);

foreach ($dirIterator as $fileinfo) {
	
	if ($fileinfo->isDir() && !$fileinfo->isDot()) {
		
		$app_path = $fileinfo->getPathname();
		
		$plug_in = $app_path . "/" . 'init.php';
		
		if (file_exists($plug_in)) {
			
			include_once($plug_in);
		}
     }
}

function sb_dash_add_controller($name,$controller,$priority=10){
	
	if(isset($GLOBALS["sb_dash_controllers"][$name])){
		return;	
	}
	
	$GLOBALS["sb_dash_controllers"][$name]=array("name"=>$name,"page"=>$controller,"priority"=>$priority);
}



add_action('sabian_wc_dash_content','sb_dash_load_view');

function sb_dash_load_view(){
	
	if(isset($_GET["page"])){
		
		$page=$_GET["page"];
		
		$controllers=$GLOBALS["sb_dash_controllers"];
		
		if(!isset($controllers[$page])){
			
			return;	
		}
		
		$cont=$controllers[$page]["page"];
		
		if(!isset($_GET["action"])){
			
			$cont->{ 'index' }();
			
		}else{
			
			$action=$_GET["action"];
			
			$cont->{ $action }();
		}
		
		$view=$cont->getView();
		
		$view->display();
		
		return;
	}
}

add_action('sabian_wc_dash_sidelinks','sb_dash_load_options');


function sb_dash_load_options(){
	
	global $wp;
	
	$current_url=home_url(add_query_arg(array(),$wp->request));
	
	$controllers=$GLOBALS["sb_dash_controllers"];
	
	usort($controllers,function($conta,$contb){
		
		return $conta['priority']-$contb['priority'];
		
	});
	
	$cont='';
	
	foreach($controllers as $i=>$contr){
		
		$crl=$contr['page'];
		
		$menus=$crl->getActionOptions();
		
		$link='page='.$contr['name'];
			
		foreach($menus as $menu){
			
		if(isset($menu['action'])){
			$link.='&action='.$menu['action'];	
		}
			
			$cont.='<li class="treeview">
              <a href="'.$current_url.'?'.$link.'" id="'.$menu['ID'].'">
                <i class="fa fa-'.$menu['icon'].'"></i>
                <span>'.$menu['title'].'</span>
              </a>';
			  
			  $children=$menu['children'];
			  
			  if(count($children)>0){
				  
				  usort($children,function($ch1,$ch2){
					 
					 return $ch1['priority']-$ch2['priority'];
					  
				  });
				  
				  $link='page='.$contr['name'];
				  
				  $cont.='<ul class="treeview-menu">';
				  
				  foreach($children as $child){
					  
					  if(isset($child['action']))
					  $link.='&action='.$child['action'];
					  
					  $cont.='<li class=""><a href="'.$current_url.'?'.$link.'"><i class="fa fa-'.$child['icon'].'"></i> '.$child['title'].'</a></li>';
				}
				
				$cont.='</ul>';
			  
			  }
            
			$cont.='</li>';
		}
	}
	
	echo $cont;
}


?>