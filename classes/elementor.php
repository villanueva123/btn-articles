<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Elementor Class
 *
 * @since      1.0.0
 * @package    btn-articles
 * @subpackage btn-articles/classes
 * @author    Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_articles_elementor {

    // Wordpress Hooks ( Actions & Filters )
    function add_wp_hooks() {
      if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
        add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version' ]);
        return;
      }
      // Check for required PHP version
      if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
        add_action('admin_notices', [$this, 'admin_notice_minimum_php_version' ]);
        return;
      }
      add_action('elementor/elements/categories_registered', [$this, 'add_categories' ]);
      add_action('elementor/widgets/widgets_registered', [$this, 'load_widgets' ]);
    }

  	function is_editor(){
  		return ((isset($_REQUEST['action']) && isset($_REQUEST['post']) && $_REQUEST['action'] == 'elementor' && absint($_REQUEST['post']) > 0) || isset($_GET['elementor-preview']));
  	}

  	function add_categories( $elements_manager ) {

  		$elements_manager->add_category(
  			'btn-articles',
  			[
  				'title' => __( 'BTN Articles', 'btn-articles' ),
  				'icon' => 'fa fas fa-utensils',
  			]
  		);
  	}

  	function load_widgets(){
  		$widgets = BTN_ARTICLES_DIR . 'widgets';

  		$fileSystemIterator = new FilesystemIterator($widgets);
  		foreach ($fileSystemIterator as $widget_file){
  			// Find all widgets
  			$filename = $widget_file->getFilename();

  			if(preg_match('~btn-article-(.*?)-widget~i', $filename)){

  				// Generate widget file path
  				$file = "{$widgets}/{$filename}";

  				if(file_exists($file)){
  					// Load widget
  					include_once $file;
  					// Translate class name
  					$class_name = str_replace('.php', '', $filename);
  					$class_name = explode('-', $class_name);
  					$class_name = array_map('trim', $class_name);
  					$class_name = array_map('ucfirst', $class_name);
  					$class_name[0] = strtoupper($class_name[0]);
  					$class_name = join('_', $class_name);

  					// Include class
  					if(class_exists($class_name)){
  						// Let Elementor know about our widget
  						\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
  					}
  				}
  			}
  		}
  	}


  	public function admin_notice_minimum_elementor_version() {

  		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

  		$message = sprintf(
  			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
  			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'btn-articles' ),
  			'<strong>' . esc_html__( 'BTN Recipe', 'btn-articles' ) . '</strong>',
  			'<strong>' . esc_html__( 'Elementor', 'btn-articles' ) . '</strong>',
  			 self::MINIMUM_ELEMENTOR_VERSION
  		);

  		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

  	}

  	public function admin_notice_minimum_php_version() {

  		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

  		$message = sprintf(
  			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
  			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'btn-articles' ),
  			'<strong>' . esc_html__( 'BTN Recipe', 'btn-articles' ) . '</strong>',
  			'<strong>' . esc_html__( 'PHP', 'btn-articles' ) . '</strong>',
  			 self::MINIMUM_PHP_VERSION
  		);

  		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  	}

		function get_article_option(){
			$option = [];
			$post_type = btn_articles()->articles()->get_post_slug();
			$args = [
				'post_type'				=> $post_type,
				'posts_per_page'	=> -1,
			];
			$loop = new WP_Query( $args );
			foreach($loop->posts as $article){
				$option[$article->ID] = __( $article->post_title, 'btn-articles' );
			}
			return $option;
		}

	function __construct(){}

	// JSON Data for JS
	private $to_json = [];
	private $enqueue_css = false;
	// Shortcode Mapping
	private $shortcode_map;
	// Current User Data
	private $user = null;

  const MINIMUM_ELEMENTOR_VERSION = '3.0';
  const MINIMUM_PHP_VERSION = '7.0';
}
