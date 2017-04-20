<?php 
class VideoAdmin extends ModelAdmin {
	private static $managed_models = array('Video'); // Can manage multiple models
	
	private static $url_segment = 'videos'; // Linked as /admin/products/
	
	private static $menu_title = 'Videos';
	
	private static $menu_icon = 'themes/liberal/images/icons/video.png';
	
	
}