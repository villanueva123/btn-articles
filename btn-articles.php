<?php
/*
Plugin Name: BTN Articles
Plugin URI: https://businesstechninjas.com/
Description: Articles Custom Post Type
Version: 1.0.0
Author: Business Tech Ninjas
Author URI: https://businesstechninjas.com/
License: Copyright (c) Business Tech Ninjas
Text Domain: btn-articles
*/

// If this file is called directly, abort.
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

define('BTN_ARTICLES_VERSION', '1.0.1');
define('BTN_ARTICLES_PLUGIN', __FILE__);
define('BTN_ARTICLES_DIR', __DIR__ . '/');
define('BTN_ARTICLES_CLASS_DIR', BTN_ARTICLES_DIR . 'classes/');
define('BTN_ARTICLES_TMPL_DIR', BTN_ARTICLES_DIR . 'templates/');
$btn_articles_url = plugins_url('', __FILE__);
define('BTN_ARTICLES_URL', $btn_articles_url . '/');
define('BTN_ARTICLES_ASSESTS_URL', BTN_ARTICLES_URL . 'assets/');

// Include Autoloader
include_once BTN_ARTICLES_CLASS_DIR . 'autoloader.php';

// Init Plugin
add_action('plugins_loaded',function(){
	btn_articles()->init();
}, 1 );

// Gets the instance of the `btn_articles` class
function btn_articles(){
    return btn_articles::get_instance();
}
