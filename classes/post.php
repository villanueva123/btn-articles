<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * CPT Class
 *
 * @since      1.0.0
 * @package    btn-articles
 * @subpackage btn-articles/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_articles_post {

		function register() {
		//Taxonomy Categories
	    $taxonomy_args = [
	        'labels'            	=>  [
	            'name'          =>  __( 'Categories', 'btn-articles' ),
	            'singular_name' =>  __( 'Category', 'btn-articles' ),
							'add_new' 				=> _x( 'Add New', 'Category articles', 'btn-articles' ),
		    			'add_new_item' 			=> __( 'Add New Category articles', 'btn-articles' ),
		    			'edit_item' 			=> __( 'Edit Category articles', 'btn-articles' ),
		    			'new_item' 				=> __( 'New Category articles', 'btn-articles' ),
		    			'view_item' 			=> __( 'View Category articles', 'btn-articles' ),
		    			'search_items' 			=> __( 'Search Category articles', 'btn-articles' ),
		    			'not_found' 			=> __( 'Nothing found', 'btn-articles' ),
		    			'not_found_in_trash'	=> __( 'Nothing found in Trash', 'btn-articles' ),
	        ],
					'hierarchical' => true,
			    'show_ui' => true,
			    'show_admin_column' => true,
			    'query_var' => true,
			    'rewrite' => [
						'slug' => self::TAX_SLUG,
					],
	    ];
		  register_taxonomy( self::TAX_SLUG, self::POST_SLUG, $taxonomy_args );


			//Taxonomy Type
			$taxonomy_type_args = [
						'labels'            	=>  [
								'name'          =>  __( 'Type', 'btn-articles' ),
								'singular_name' =>  __( 'Type', 'btn-articles' ),
								'add_new' 				=> _x( 'Add New', 'Type articles', 'btn-articles' ),
								'add_new_item' 			=> __( 'Add New Type articles', 'btn-articles' ),
								'edit_item' 			=> __( 'Edit Type articles', 'btn-articles' ),
								'new_item' 				=> __( 'New Type articles', 'btn-articles' ),
								'view_item' 			=> __( 'View Type articles', 'btn-articles' ),
								'search_items' 			=> __( 'Search Type articles', 'btn-articles' ),
								'not_found' 			=> __( 'Nothing found', 'btn-articles' ),
								'not_found_in_trash'	=> __( 'Nothing found in Trash', 'btn-articles' ),
						],
						'hierarchical' => true,
						'show_ui' => true,
						'show_admin_column' => true,
						'query_var' => true,
						'rewrite' => [
							'slug' => self::TAX_TYPE_SLUG,
						],
				];
				register_taxonomy( self::TAX_TYPE_SLUG, self::POST_SLUG, $taxonomy_type_args );

			//Taxonomy Edition
			$taxonomy_edition_args = [
						'labels'            	=>  [
								'name'          =>  __( 'Editions', 'btn-articles' ),
								'singular_name' =>  __( 'Edition', 'btn-articles' ),
								'add_new' 				=> _x( 'Add New', 'Edition articles', 'btn-articles' ),
								'add_new_item' 			=> __( 'Add New Edition articles', 'btn-articles' ),
								'edit_item' 			=> __( 'Edit Edition articles', 'btn-articles' ),
								'new_item' 				=> __( 'New Edition articles', 'btn-articles' ),
								'view_item' 			=> __( 'View Edition articles', 'btn-articles' ),
								'search_items' 			=> __( 'Search Edition articles', 'btn-articles' ),
								'not_found' 			=> __( 'Nothing found', 'btn-articles' ),
								'not_found_in_trash'	=> __( 'Nothing found in Trash', 'btn-articles' ),
						],
						'hierarchical' => true,
						'show_ui' => true,
						'show_admin_column' => true,
						'query_var' => true,
						'rewrite' => [
							'slug' => self::TAX_EDITION_SLUG,
						],
				];
				register_taxonomy( self::TAX_EDITION_SLUG, self::POST_SLUG, $taxonomy_edition_args );
		    // articles Post Type
		  $articles_args = [
				'labels' 				=> [
						'name'								=> _x( 'Articles','post type general name', 'btn-articles' ),
						'singular_name' 			=> _x( 'Articles', 'post type singular name', 'btn-articles' ),
						'add_new' 						=> _x( 'Add New', 'Articles', 'btn-articles' ),
						'add_new_item' 				=> __( 'Add New Articles', 'btn-articles' ),
						'edit_item' 					=> __( 'Edit Articles', 'btn-articles' ),
						'new_item' 						=> __( 'New Articles', 'btn-articles' ),
						'view_item' 					=> __( 'View Articles', 'btn-articles' ),
						'search_items' 				=> __( 'Search Articles', 'btn-articles' ),
						'not_found' 					=> __( 'Nothing found', 'btn-articles' ),
						'not_found_in_trash'	=> __( 'Nothing found in Trash', 'btn-articles' ),
					],
				'hierarchical'        => false,
         'public'              => true,
         'show_ui'             => true,
         'show_in_menu'        => true,
         'show_in_nav_menus'   => true,
         'show_in_admin_bar'   => true,
         'menu_position'       => 5,
         'can_export'          => true,
         'has_archive'         => true,
         'exclude_from_search' => false,
         'publicly_queryable'  => true,
         'capability_type'     => 'post',
				'menu_icon'					=> 'dashicons-admin-post',
				'supports'          => ['title', 'excerpt', 'author', 'thumbnail', 'editor','comments', 'revisions' ],
			];
			register_post_type( self::POST_SLUG, $articles_args );

		}


	function get_article_post_data(){
		$post_data = [];
		$posts = get_posts([
			 'post_type' => self::POST_SLUG,
			 'posts_per_page' => -1,
		 ]);
			if( $posts ){
				foreach( $posts as $post ){
					$post_data[] = [
						'value' => $post->ID,
						'title' => $post->post_title
					];
				}
			}
			return $post_data;
	}

	function get_article_related_data($posts_per_page = 1){
		$related_data = [];
		$id = get_the_ID();
		$recent_post_id = $this->get_latest_post_id($id);
		$ids = [];
		$ids[] = $id;
		$ids[] = $recent_post_id;
		$posts = get_posts([
			 'post_type' => self::POST_SLUG,
			 'posts_per_page' => $posts_per_page,
			 'exclude' => $ids,
			 'orderby'   => [
					'date' =>'DESC',
					'menu_order'=>'ASC',
				],
		 ]);
			if( $posts ){
				foreach( $posts as $post ){
					if($posts_per_page === 1){
						$related_data = $post;
					}else{
						$related_data[] = $post;
					}

				}
			}
			return $related_data;
	}

	function get_latest_post_id($post_id){
		$post_recent_id = '';
		$post_type = $this->get_post_slug();
		$posts = get_posts([
			'post_type' => $post_type,
			'numberposts' => 1,
			'exclude' => [$post_id],
			'orderby'   => [
				'date' =>'DESC',
				'menu_order'=>'ASC',
			]
		 ]);
		foreach($posts as $post){
			$post_recent_id = $post->ID;
		}
		return $post_recent_id;
	}
  function get_post_slug(){
      return self::POST_SLUG;
  }
	function get_taxonomy_slug(){
			return self::TAX_SLUG;
	}
	function get_taxonomy_type_slug(){
			return self::TAX_TYPE_SLUG;
	}
	function get_taxonomy_edition_slug(){
			return self::TAX_EDITION_SLUG;
	}

	// Check for custom single page template in theme or load default
	static function single_module_template( $template, $type, $templates ){
		$slug = self::POST_SLUG;
		if( is_singular( $slug ) ) {
			$file = "single-{$slug}.php";
			// Theme does not have Single Post Template
			if( basename($template) != $file ){
				$module_template = btn_articles()->template_part_path($file);
				if( $module_template ){
					if( basename($module_template) === $file ){
						$template = $module_template;
					}
				}
			}
		}
	return $template;
}


	function __construct(){}

    const POST_SLUG = 'articles';
    const TAX_SLUG = 'articles-categories';
		const TAX_EDITION_SLUG = 'articles-editions';
		const TAX_TYPE_SLUG = 'articles-types';



}
