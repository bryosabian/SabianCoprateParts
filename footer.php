
<footer class="footer">
    <div class="container">
        
        <div class="row">
                <div class="col-md-3">
				
				<?php dynamic_sidebar( 'sabian_fw1' ); ?>
           
            </div>
                
                <div class="col-md-3">
                    <?php dynamic_sidebar( 'sabian_fw2' ); ?>
                </div>
                
                <div class="col-md-3">
                    <?php dynamic_sidebar( 'sabian_fw3' ); ?>
                </div>

                 <div class="col-md-3">
                    <?php dynamic_sidebar( 'sabian_fw4' ); ?>
                </div>
            </div>

        <hr>

        <div class="row">
            <div class="col-lg-9 copyright">
                <?php echo apply_filters("sabian_copyright",'2017 © Designed By <a href="http://cloudsync.co.ke" target="_blank">Cloud Sync LTD</a>'); ?>
                <a href="#">Terms and conditions</a>
            </div>

        </div>
    </div>
</footer>


<?php  
wp_footer();
?>

<script type="text/javascript">
    $(document).ready(function (e) {

        jQuery('#banner_rs_slider').revolution(
                {
                    delay: 9000,
                    startwidth: 1170,
                    startheight: 450,
                    hideThumbs: 10,
                    fullWidth: "on",
                });
    });
	
	/*Wordpress settings*/
	$(".widget_side").each(function(index, element) {
        
		var _this=$(this);
		
		_this.find('ul').addClass("categories highlight");
		
    });

</script>

</html>