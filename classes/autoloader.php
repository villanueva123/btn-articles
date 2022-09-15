<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

spl_autoload_register(['btn_articles_autoloader', 'load']);

final class btn_articles_autoloader {

	private static $classes = false;
	private static $paths   = false;

	private static function init() {
		self::$classes = [
            'btn_articles' 	=> BTN_ARTICLES_CLASS_DIR . 'btn-articles',
						// utilities
						'wp_admin_templater'				=> BTN_ARTICLES_DIR . 'vendor/wp-admin-templater/wp-admin-templater',
						'wp_admin_templater_data'		=> BTN_ARTICLES_DIR . 'vendor/wp-admin-templater/wp-admin-data',
						'wp_admin_templater_ajax'		=> BTN_ARTICLES_DIR . 'vendor/wp-admin-templater/wp-admin-ajax',
						'btn_articles_article_screen'	=> BTN_ARTICLES_DIR . 'screens/article_screen',
        ];
		self::$paths = [
			BTN_ARTICLES_CLASS_DIR,
			BTN_ARTICLES_DIR . 'screens/',
		];
	}

	public static function load( $class ) {
		if ( ! self::$classes ) {
			self::init();
		}

		$class = trim( $class );
		if ( array_key_exists( $class, self::$classes ) && file_exists( self::$classes[$class] . '.php' ) ) {
			include_once self::$classes[$class] . '.php';
		}
		else {
			foreach(self::$paths as $path) {

				$file = $path . substr($class,13) . '.php';
				if (file_exists($file)) {
					include_once $file;
				}
			}
		}

		if (substr($class, 0, 12) <> 'btn_articles') {
			return;
		}
	}

}
