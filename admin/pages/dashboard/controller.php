<?php
class SB_DashboardPage extends SB_WC_DashController{
	
	public function __construct(){
		
		$this->setView(new SB_DashView());
		
		$this->addActionOption(array(
		       'ID'=>'SB_Dashboard',
			   'icon'=>'dashboard',
			   'title'=>'Dashboard'
		));
		
	}
	public function index(){
		
		$this->view->setViewFile(dirname(__FILE__)."/dash.php");
	}
}
?>