<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once dirname(__FILE__)."/model.php";

require_once dirname(__FILE__)."/view.php";

require_once dirname(__FILE__)."/controller.php";

$sPage=new SB_ProductsPage();

sb_dash_add_controller('Products',$sPage,20);
?>