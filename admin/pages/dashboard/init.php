<?php
require_once dirname(__FILE__)."/view.php";

require_once dirname(__FILE__)."/controller.php";

$dPage=new SB_DashboardPage();

sb_dash_add_controller('Dashboard',$dPage)
?>