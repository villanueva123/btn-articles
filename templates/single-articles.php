<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
<main id="main" class="site-main">

    <?php if ( have_posts() ) :
      $post_id = get_the_ID();
      $has_access = btn_articles()->memberium()->has_post_access($post_id);
      if($has_access){
          do_action( 'astra_template_parts_content_top' );
          while ( have_posts() ) :
            the_post();
              if ( true == $is_page ) {
                do_action( 'astra_page_template_parts_content' );
              } else {
                do_action( 'astra_template_parts_content' );
              }
           endwhile;
        }else{
          //Content Protection
          while ( have_posts() ) :
            the_post();
		  if ( is_active_sidebar('sidebar-content-protection' ) ) {
			  dynamic_sidebar('sidebar-content-protection');
		  }
           endwhile;
        }

      endif; ?>

  </main><!-- #main -->


<?php get_footer(); ?>
