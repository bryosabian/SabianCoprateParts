<?php
class SB_WC_DashView{
	
	protected $model;
	
	protected $view_file;
	
	/**
	Renders the view
	*/
	public function display(){
		
		require_once $this->view_file;
	}
	
	/**
	Sets the model
	*/
	public function setModel($model){
		
		$this->model=$model;	
	}
	
	public function setViewFile($file){
		
		$this->view_file=$file;	
	}
	public function getPage(){
		
		return $_GET['page'];
	}
		
}
?>