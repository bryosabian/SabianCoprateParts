<?php
$GLOBALS["sabian_vc_addons"]=new sabian_visual_composer();

class sabian_visual_composer
{
	private $elements=array();
	
	private $options=array();
	
	public $sabian_options="Sabian Options";
	
	public $vc_plug="js_composer/js_composer.php";
	
	public function __construct()
	{
		register_activation_hook(__FILE__,array($this,"check_visual_composer"));
	}
	public function check_visual_composer()
	{
		if(!is_plugin_active($this->vc_plug))
		wp_die("This plugin requires visual composer to run.");
		
		wp_die("Hello");
	}
	private function add_element($elem)
	{
		$this->elements[]=$elem;
	}
	public function add_option($option,$shortcode=null)
	{
		if(!is_null($shortcode))
		{
			$shortcode=(array)$shortcode;
			
			add_shortcode($shortcode["title"],$shortcode["callback"]);
		}
		
		$this->options[]=$option;
		
		vc_map($option);
		
	}
}

?>