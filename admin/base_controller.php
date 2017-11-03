<?php
class SB_WC_DashController{
	
	protected $view;
	
	protected $model;
	
	protected $action_options=array();
	
	protected $current_user;
	
	protected function get_user(){
		
		$this->current_user=wp_get_current_user();
		
		return $this->current_user;
			
	}
	
	/**
	* Adds a new menu option that will be used to display the view
	* @param array $opt The key-value pair array of menu args. They include
	*                   @string ID The unique ID of the menu
	                    @string action The controller action to execute
						@string icon The menu icon (Font Awesome without the 'fa fa-'
						@string title The menu title
						@int priority The menu position priority. FIFO. Default is 10
	*/
	protected function addActionOption($opt){
		
		if(isset($this->action_options[$opt['ID']])){
			unset($this->action_options['ID']);
		}
		
		$opt['ID']="sbc_view_menu_".$opt['ID'];
		
		if(!isset($opt['priority'])){
			$opt['priority']=10;	
		}
		if(!isset($opt['children'])){
			$opt['children']=array();
		}else{
			foreach($opt['children'] as $child){
				$this->addSubAction($opt['ID'],$child);
			}
		}
		
		$this->action_options[$opt['ID']]=$opt;
	}
	
	/**
	* Adds a new sub menu option that will be used to display the view
	* @param string ID The unique ID of the parent menu option
	* @param array $opt The key-value pair array of menu args. They include
	*                   @string ID The unique ID of the menu
	                    @string action The controller action to execute
						@string icon The menu icon (Font Awesome without the 'fa fa-'
						@string title The menu title
						@int priority The menu position priority. FIFO. Default is 10
	*/
	protected function addSubActionOption($id,$opt){
		
		$id="sbc_view_menu_".$id;
		
		if(!isset($this->action_options[$id])){
			return false;
		}
		
		$opt['ID']="sbc_view_sub_menu_".$opt['ID'];
		
		if(!isset($opt['priority'])){
			$opt['priority']=10;	
		}
		
		$this->action_options[$id]['children'][]=$opt;
	}
	
	public function getActionOptions(){
		
		usort($this->action_options,function($mn1,$mn2){
			
			return $mn2['priority']-$mn1['priority'];
		});
		
		array_walk($this->action_options,function($mn){
			
			usort($mn['children'],function($mnc1,$mnc2){
				
				return $mnc2['priority']-$mnc1['priority'];
				
			});
			
		});
		
		return $this->action_options;	
	}
	
	protected function setView($view){
		
		$this->view=$view;	
	}
	public function getView(){
		
		return $this->view;	
	}
	protected function setModel($model){
		
		$this->model=$model;
	}
	protected function getModel($model){
		
		return $this->model;	
	}
	public function index(){}
}
?>