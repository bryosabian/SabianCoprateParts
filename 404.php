<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Sabian Theme
 */

$heading=apply_filters("sabian_page_not_found_heading","Page not found");

$title=apply_filters("sabian_page_not_found_title","Page not found");

$sub_title=apply_filters("sabian_page_not_found_sub_title","The request page could not be found");

$description=apply_filters("sabian_page_not_found_description","It seems the page you are looking for does not exist. Sorry about that");

$meta_description=apply_filters("sabian_page_not_found_meta_description","It seems the page you are looking for does not exist. Sorry about that");

$container='
    <!--Banner-->
<section class="section_404" data-bg-images="'.$slideImgs.'" id="section_banner">

<div class="banner_content">

<div class="container">

<div class="row">

<div class="col-md-12">

<div class="banner_body">

<h2 class="text-center" style="font-size:56px">4<i class="fa fa-times-circle-o"></i>4</h2>

<h3 class="banner_title text-center h0" style="margin-top:-10px">'.$title.'</h3>

<p class="banner_subtitle text-center">'.$description.'</p>


</div>

</div>

</div>

</div>

</div>

</section>
<!--Banner-->
    
  ';

get_header(); ?>

<div class="pg-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>Page Not Found</h2>
            </div>
            
        </div>
    </div>
</div>


	<?php 
	
	echo apply_filters("sabian_page_not_found_container",$container);
	
	
get_footer();
?>