<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Main Plugin Class
 *
 * @since      1.0.0
 * @package    btn-articles
 * @subpackage btn-articles/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_articles {

	function init(){
			// Text Domain / Localization
			$this->load_text_domain();
			// Init Hooks
			add_action('init',[$this,'init_hooks']);
			//Widget Register
			add_action('widgets_init', [$this,'articles_register_sidebar']);
    }

    // Init
    function init_hooks(){

			$this->articles()->register();

			add_action('pre_get_posts', [$this,'add_custom_post_types']);
			if( is_plugin_active('elementor/elementor.php') || is_plugin_active('elementor-pro/elementor-pro.php') ){
					$this->elementor()->add_wp_hooks();
			}
			if (is_admin()) {
				$this->article_screen()->add_wp_hooks();
			}else{
				$this->frontend()->add_wp_hooks();
			}

}

	// Get Edition Class
	function elementor(){
	static $elementor = null;
			if( is_null($elementor) ){
					$elementor = new btn_articles_elementor;
			}
			return $elementor;
	}


	// Get Edition Class
    function articles(){
		static $articles = null;
        if( is_null($articles) ){
            $articles = new btn_articles_post;
        }
        return $articles;
    }


		// Get Admin Class
		function frontend(){
		static $frontend = null;
				if( is_null($frontend) ){
						$frontend = new btn_articles_frontend;
				}
				return $frontend;
		}
		// Get Instance of Admin
		function article_screen(){
			static $article_screen = null;
			if( is_null($article_screen) ){
				$article_screen = new btn_articles_article_screen;
			}
			return $article_screen;
		}

	function add_custom_post_types($query) {
			if ( is_home() && $query->is_main_query() ) {
				  $post_slug = $this->articles()->get_post_slug();
					$query->set( 'post_type', [$post_slug] );
			}
			if (is_author() && !is_admin() && in_array ( $query->get('post_type'),[$this->articles()->get_post_slug()])){
				$author = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
				$author_id = $author->ID;
				$query->set( 'author', $author_id);
			}
			return $query;
	}


	// Get Memberium Class
	function memberium(){
	static $memberium = null;
			if( is_null($memberium) ){
					$memberium = new btn_articles_memberium;
			}
			return $memberium;
	}


	/**
	 * Return templates path checks child theme first
	 *
	 * @param string $filename
	 * @return string template path admin error or false
	*/
	function template_part_path( $filename, $directory_name = '' ){

		$not_found = [];
		$directory_name = $directory_name > '' ? trailingslashit($directory_name) : '';
		$theme_template = "{$directory_name}{$filename}";

		// Locate Template in Themes
		$template = locate_template($theme_template, false);
		// Get Plugin Defaults
		if( ! is_file($template) ){
			$not_found['theme'] = $theme_template;
			$template = BTN_ARTICLES_DIR . 'templates/' . $filename;
			if( ! is_file($template) ){
				$not_found['extension'] = $template;
				$template = false;
			}
		}

		$template = apply_filters('btn/articles/template/path', $template, $filename, $directory_name);
		if ( ! is_file($template) )	{
			if ( is_admin() ) {
				$notice = __('File not found in any of the following locations :', 'btn-articles');
				$notice .= '<ul>';
				foreach ($not_found as $path) {
					$notice .= "<li>{$path}</li>";
				}
				$notice .= '</ul>';
				return $this->admin_error_msg($notice);
			}
			else{
				return false;
			}
		}
		else{
			return $template;
		}
	}

	// Text Domain
	function load_text_domain(){
		load_plugin_textdomain('btn-articles', false, BTN_ARTICLES_DIR . '/languages' );
	}

  // Write Log
  function write_log( $log, $print = false ){
      $error_log = ( is_array( $log ) || is_object( $log ) ) ? print_r( $log, true ) : $log;
      if($print){
          return '<pre>'.$error_log.'</pre>';
      }
      else{
          error_log($error_log);
      }
  }

	/**
	 * Add New widget for additional content on the single event page
	*/
	function articles_register_sidebar() {
		register_sidebar([
				'id'            => 'article_sidebar_content',
				'name'          => __( ' Article Sidebar Content' ),
				'description'   => __( 'This sidebar will be display on the sidebar of the Article post' ),
		]);
		register_sidebar([
				 'name'          => __( 'Content Protection Template', 'btn-articles' ),
				 'id'            => 'sidebar-content-protection',
				 'description'   => __( 'Add the Content to be display on the Content Protection', 'btn-articles' ),
				 'before_widget' => '<div id="%1$s" class="widget %2$s">',
				 'after_widget'  => '</div>',
				 'before_title'  => '<h2 class="widgettitle">',
				 'after_title'   => '</h2>',
		 ]);
	}





    // Singleton Instance
  private function __construct(){}
	public static function get_instance() {
        static $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new self;
        }
        return $instance;
    }

}
