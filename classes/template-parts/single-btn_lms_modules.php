<?php
/**
 * The template for displaying single BTN LMS Module
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package btn-lms/template-parts
 */

get_header();

do_action( 'btn/lms/module/after/header' );

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        if ( have_posts() ) :

            do_action( 'btn/lms/module/template/parts/content/top' );

            while ( have_posts() ) :

                the_post();

                do_action( 'btn/lms/module/template/parts/content' );

            endwhile; // End of the loop.

            do_action( 'btn/lms/module/template/parts/content/bottom' );

        endif;
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action( 'btn/lms/module/before/footer' );

get_footer();
