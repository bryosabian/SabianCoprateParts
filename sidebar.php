<?php do_action( 'before_sidebar' ); ?>
<?php if ( ! dynamic_sidebar( 'sabian_sidebar' ) )
{
	?>
    <div class="widget_side">
	   <div class="category_title"><span>Search</span>
       </div>
       
                <?php echo sabian_search_form(); ?>
                
            </div>
            
            
            <div class="widget_side">
	    <div class="category_title"><span>Search</span>
       </div>
        <ul class="categories highlight">
            <li><a href="#">Web design (23)</a></li>
            <li><a href="#">Online business (100)</a></li>
            <li><a href="#">Marketing strategy (7)</a></li>
            <li><a href="#">Technology (33)</a></li>
            <li><a href="#">About finance (123)</a></li>
        </ul>
    </div>
    <?php
}
?>

