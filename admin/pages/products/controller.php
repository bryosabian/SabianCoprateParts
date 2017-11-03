<?php
class SB_ProductsPage extends SB_WC_DashController{
	
	public function __construct(){
		
		$this->setView(new SB_ProductsView());
		
		$this->setModel(new SB_ProductsModel());
		
		$this->addActionOption(array(
		       'ID'=>'SB_Products',
			   'icon'=>'edit',
			   'title'=>'Products'
		));
		
		$this->addSubActionOption('SB_Products',array(
		       'ID'=>'SB_View_Products',
			   'icon'=>'edit',
			   'title'=>'View Products',
			   'priority'=>10
		));
		
		$this->addSubActionOption('SB_Products',array(
		       'ID'=>'SB_New_Product',
			   'icon'=>'plus',
			   'title'=>'New Product',
			   'action'=>'newProduct',
			   'priority'=>11
			   
		));
		
	}
	/**
	* Action
	*/
	public function index(){
		
		$this->retrieveProducts();
		
		$this->view->setViewFile(dirname(__FILE__)."/products.php");
	}
	/**
	* Action
	*/
	public function productSearch(){
		
		$current_user=$this->get_user();
		
		$paged=(get_query_var('paged'))?get_query_var('paged'):1;
		
		$params=array(
		'paged'=>$paged,
		"post_type"=>'product',
		"posts_per_page"=>10,
		"orderby"=>'ID',
		'order'=>'DESC',
		"author"=>$current_user->ID
		);
		
		if(isset($_GET['p_search'])){
			
			$params['s']=$_GET['p_search'];	
		}
		
		$this->model->getProducts($params);
		
		$this->view->setModel($this->model);
		
		$this->view->setViewFile(dirname(__FILE__)."/products.php");
	}
	/**
	* newProduct
	*/
	public function newProduct(){
		
		$this->view->setViewFile(dirname(__FILE__)."/new_product.php");		
	}
	private function retrieveProducts(){
		
		$current_user=$this->get_user();
		
		$paged=(get_query_var('paged'))?get_query_var('paged'):1;
		
		$params=array(
		'paged'=>$paged,
		"post_type"=>'product',
		"posts_per_page"=>10,
		"orderby"=>'ID',
		'order'=>'DESC',
		"author"=>$current_user->ID
		);
		
		$this->model->getProducts($params);
		
		$this->view->setModel($this->model);
	}
	
}
?>