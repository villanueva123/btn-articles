<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Shortcode Class
 *
 * @since      1.0.0
 * @package    btn-articles
 * @subpackage btn-articles/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_articles_shortcodes {

  	static function sponsored_article($atts, $content, $tag){
  		$args = shortcode_atts( [
  			'class_name'	=> '',
  			'template'		=> 'sponsored-content.php',
        'title'       => 'SPONSORED CONTENT HERE?',
        'read_more'   => 'READ MORE',
				'id'   				=> ''
  		], $atts );
					$html = '';
          $post_id = get_the_ID();
					$default_id = $args['id'];
					$css_class = $args['class_name'];
          $template = btn_articles()->template_part_path( $args['template'] );
					$recent_post_id =btn_articles()->articles()->get_latest_post_id($post_id);
					$sponsored_id = get_post_meta($post_id, btn_articles()->article_screen()::SPONSORED_CONTENT, true );
					$sponsored_content = ($sponsored_id > '')? $sponsored_id : $recent_post_id;
					$id = ($sponsored_content > 0)? $sponsored_content : $default_id;
          $post = get_post($id);
          $permalink = get_permalink($id);
          $excerpt = $post->post_excerpt;
          $sponsored_title = $post->post_title;
          $readmore =  $args['read_more'];
          $section_title = $args['title'];
          $img_url = get_the_post_thumbnail_url($id,'full');
          $img = ($img_url > '')? true : false;
          $full_width_class = (!$img)? 'btn-articles-sponsored-full-content':'';
          if($template > '' && $sponsored_content != '' || $default_id > 0){
              include $template;
          }
          btn_articles()->frontend()->set_json('btn-articles-shortcode', $args);
          return $html;
  	}


    static function related_article($atts, $content, $tag){
      $args = shortcode_atts( [
        'class_name'	=> '',
        'template'		=> 'related-article.php',
        'title'       => 'RELATED ARTICLE',
        'read_more'   => 'READ MORE'
      ], $atts );
				  $html = '';
          $post_id = get_the_ID();
          $template = btn_articles()->template_part_path( $args['template'] );
          $post =  btn_articles()->articles()->get_article_related_data();
          $id = $post->ID;
          $permalink = get_permalink($id);
          $excerpt = $post->post_excerpt;
          $related_title = $post->post_title;
          $readmore =  $args['read_more'];
          $section_title = $args['title'];
          $img_url = get_the_post_thumbnail_url($id,'full');
          $img = ($img_url > '')? true : false;
					$full_width_class = (!$img)? 'btn-articles-related-full-content':'';
          if($template > ''){
              include $template;
          }
          btn_articles()->frontend()->set_json('btn-articles-related', $args);
          return $html;
    }
    static function article_categories($atts, $content, $tag) {
		  $args = shortcode_atts( [
					'class_name' => '',
			  		'description'	=> false,
		 ], $atts );
		  $tax_args = [
				'orderby'    => 'ID',
  			'order'     => 'DESC',
				'hide_empty' => true,
		  ];
			$html = '';
		  $css_class = $args['class_name'];
		  $description = $args['description'];
	      $html .= '<ul class="'.$css_class.'">';
				if(is_tax()){
					$queried_object = get_queried_object();
					$taxonomy = $queried_object->taxonomy;
					$catlist = get_terms($taxonomy,$tax_args);
				}else{
					 $catlist = get_terms(btn_articles()->articles()->get_taxonomy_slug(),$tax_args);
				}

	      if ( ! empty( $catlist ) ) {
	        foreach ( $catlist as $key => $item ) {
	      	$link = get_category_link($item->term_taxonomy_id);
	          $html .= '<li> <a href="'.$link.'" class="category-'.$item->slug.'">'. $item->name . '</a><br />';
			  if($description){
				  $html .= '<em>'. $item->description . '</em> </li>';
			  }
	        }
	      }
	      $html .= '</ul>';
	      return $html;
    }

		static function all_articles($atts, $content, $tag) {
				$args = shortcode_atts( [
					'class_name'			=> '',
					'template'				=> 'all-article.php',
					'posts_per_page'  => '2',
					'offset'  				=> '1',
					'sponsored_id'  	=> '',
					'sponsored_row'  	=> '3',
					'sponsored_title' => 'SPONSORED ARTICLE',
					'max_num_pages'		=> '',
					'category_id'			=> '',
					'image'   				=> true,
					'image_link'  		=> true,
					'title_link'  		=> true,
					'title'   				=> true,
					'read_more'				=> true,
					'read_more_text'  => 'Read More'

				], $atts );
				$html = '';
				$image_check = $args['image'];
				$image_link_check = $args['image_link'];
				$title_link_check = $args['title_link'];
				$title_check = $args['title'];
				$read_more = $args['read_more'];
				$read_more_text =  $args['read_more_text'];
				$sponsored_id = $args['sponsored_id'];
				$posts_per_page = $args['posts_per_page'];
				$max_num_pages = $args['max_num_pages'];
				$sponsored_row = $args['sponsored_row'];
				$sponsored_title = $args['sponsored_title'];
				$readmore =  $args['read_more_text'];
				$template = btn_articles()->template_part_path( $args['template'] );
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$offset_start = $args['offset'];
				$offset = ( $paged - 1 ) * $posts_per_page + $offset_start;
				$post_type = btn_articles()->articles()->get_post_slug();
				$post_taxonomy = btn_articles()->articles()->get_taxonomy_slug();
				$category_id = $args['category_id'];
				$css_class = $args['class_name'];
				$args = [
					'post_type'				=> $post_type,
					'posts_per_page'	=> $posts_per_page,
					'paged' 					=> $paged,
					'offset'					=> $offset,
				];


				$queried_object = get_queried_object();
				$taxonomy = $queried_object->taxonomy;
				if(is_tax()){
					$term_id = $queried_object->term_id;
					$args['tax_query'] = [
					 [
						 'taxonomy'	=> $post_taxonomy,
						 'terms' 	=> $term_id,
						 'field'		=> 'term_id',
					 ]
				 ];
				}

				if($category_id > ''){
					$args['tax_query'] = [
					 [
						 'taxonomy'	=> $taxonomy,
						 'terms' 	=> $category_id,
						 'field'		=> 'term_id',
					 ]
				 ];
				}

				if($max_num_pages > ''){
					$args['max_num_pages'] = $max_num_pages;
				}
				$loop = new WP_Query( $args );

				if($template > ''){
						include $template;
				}
				return $html;
		}

		static function latest_article($atts, $content, $tag) {
				$args = shortcode_atts( [
					'class_name'			=> '',
					'template'				=> 'latest-article.php',
					'category_id'			=> '',
					'show_image'  		=> true,
					'show_title'  		=> true,
					'show_category'  	=> true,
					'link_image'  		=> true,
					'link_title'  		=> true,
					'link_category'  	=> true,
					'show_excerpt'		=> true,
				], $atts );
				$html = '';
				$image_check = $args['show_image'];
				$image_link_check = $args['link_image'];
				$title_check = $args['show_title'] ;
				$title_link_check =  $args['link_title'];
				$category_check = $args['show_category'];
				$category_link_check =  $args['link_category'];
				$excerpt_check = $args['show_excerpt'] ;

				$template = btn_articles()->template_part_path( $args['template'] );
				$post_type = btn_articles()->articles()->get_post_slug();
				$post_taxonomy = btn_articles()->articles()->get_taxonomy_slug();
				$args = [
					'post_type'				=> $post_type,
					'posts_per_page'	=> 1,
				];

				$queried_object = get_queried_object();
				$taxonomy = $queried_object->taxonomy;
				if(is_tax()){
					$term_id = $queried_object->term_id;
					$args['tax_query'] = [
					 [
						 'taxonomy'	=> $post_taxonomy,
						 'terms' 	=> $term_id,
						 'field'		=> 'term_id',
					 ]
				 ];
				}
				if($category_id > ''){
						$args['tax_query'] = [
						 [
							 'taxonomy'	=> $taxonomy,
							 'terms' 	=> $category_id,
							 'field'		=> 'term_id',
						 ]
					 ];
				}
				$loop = new WP_Query( $args );
				if($template > ''){
						include $template;
				}
				return $html;
		}
    function __construct(){}
}
