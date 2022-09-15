<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Frontend Class
 *
 * @since      1.0.0
 * @package    btn-articles
 * @subpackage btn-articles/classes
 * @author    Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_articles_frontend {

    // Wordpress Hooks ( Actions & Filters )
    function add_wp_hooks() {

		    add_action('wp_enqueue_scripts',[$this,'enqueue']);
        add_action('wp_footer', [$this,'frontend_print_scripts']);
				add_filter('single_template', ['btn_articles_post', 'single_module_template'], 10, 3);
    		// Shortcodes
    		$this->register_shortcodes();

    }


	// Register Shortcodes
	function register_shortcodes(){

		$prefix = "btn_articles_";
		$this->shortcode_map = [
			"{$prefix}sponsored_article"	=> "{$prefix}shortcodes",
      "{$prefix}related_article"		=> "{$prefix}shortcodes",
      "{$prefix}article_categories"	=> "{$prefix}shortcodes",
			"{$prefix}all_articles" 			=>"{$prefix}shortcodes",
			"{$prefix}latest_article" 		=>"{$prefix}shortcodes",

		];
		foreach ($this->shortcode_map as $tag => $class) {
			add_shortcode($tag, [$this, "shortcode_mapping"]);
		}
	}

	// Shortcode Mapping Function
	// Only includes suporting classes as needed
	function shortcode_mapping( $atts, $content, $tag ){
		$html = '';
		if( isset($this->shortcode_map[$tag]) ){
			$class = $this->shortcode_map[$tag];
			if( class_exists($class) ){
				$prefix = "btn_articles_";
				$func = str_replace($prefix, '', $tag);
				if( method_exists($class, $func) ){
					$html = call_user_func([$class, $func], $atts, $content, $tag);
				}
				else {
					error_log("Function {$class} does not exist");
				}
			}
			else {
				error_log("Class {$class} does not exist");
			}
		}
		return $html;
	}

	// Enqueue Scripts
 function enqueue(){
			$url = BTN_ARTICLES_ASSESTS_URL;
			$v = BTN_ARTICLES_VERSION;

    //wp_register_style('btn-articles-frontend-css', "{$url}css/frontend.css", [], $v, 'all');


	}

  // Footer Scripts
	function frontend_print_scripts(){
	  $to_json = $this->get_json();
	    // Nothing Doing
	  if ( empty($to_json) ){
	        return;
	  }else {
	    wp_enqueue_style('btn-articles-frontend-css');
	  }
	}

	// Set JSON Data
    function set_json($key, $value = false) {
		if ($value) {
			$this->to_json[$key] = $value;
		}
		else {
			unset($this->to_json[$key]);
		}
	}

    // Get JSON Data
	function get_json($key = false) {
		if ($key) {
			return (isset($this->to_json[$key])) ? $this->to_json[$key] : null;
		}
		else {
			return $this->to_json;
		}
	}






	function __construct(){}

	// JSON Data for JS
	private $to_json = [];
	private $enqueue_css = false;
	// Shortcode Mapping
	private $shortcode_map;
	// Current User Data
	private $user = null;
}
