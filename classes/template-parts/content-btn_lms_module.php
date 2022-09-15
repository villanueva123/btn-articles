<?php
/**
 * Template part for displaying Single BTN LMS content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 */
$module_id = get_the_ID();
$functions = btn_lms()->functions();
$module = $functions->get_single_module_data($module_id);
$user_data = $functions->user_data($module_id);
$title = $module['title'];
$completed = $module['completed'];
?>
<article id="btn-lms-module-<?php echo $module_id; ?>" <?php post_class(); ?>>

    <header class="btn-lms-header entry-header">
        <?php // Module Title & Banner
        $page_title = $functions->get_module_title('welcome', $title, 'h1', 'entry-title');
        $banner = $functions->module_header($module_id, $module, $page_title);
        echo $banner ? $banner : $page_title; ?>
        <div class="btn-lms-mobile-header">
            <div class="btn-lms-mobile-column">
                <?php echo $title;?>
            </div>
            <div class="btn-lms-mobile-column">
                <?php
                $completed_class = $completed ? 'complete' : 'notcomplete';
                $completed_txt = $completed ? __('Completed', 'btn-lms') : __('Not Completed', 'btn-lms');?>
                <span class="btn-lms-module-<?php echo $completed_class ?>">
                    <?php echo $completed_txt ?>
                </span>
            </div>
        </div>
    </header><!-- .entry-header -->

    <div class="btn-lms-content entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->
    <div class="btn-lms-module-wrapper">
        <?php //.btn-lms-videos required for JS ?>
        <section class="btn-lms-videos">
            <?php // Video tabs
            echo $functions->module_video_tabs($module_id, $module, $user_data); ?>
        </section>
        <?php //.btn-lms-module-progress required for JS ?>
        <aside class="btn-lms-module-progress btn-lms-module-toggle">
                <?php // Sidebar Title
                echo $functions->get_module_title('sidebar', $title, 'h2', 'aside-title');?>
                 <div class="btn-lms-module-panel">
                    <?php
                    // Activities List
                    echo $functions->activities_list($module_id, $module, $user_data);
                    // Checkup Points List
                    echo $functions->checkpoints_list($module_id, $module, $user_data);
                    // Module Notes
                    echo $functions->get_module_title('notes', $title, 'h2', 'notes-title');
                    echo $functions->module_notes($module_id, $module, $user_data);?>
                </div>
        </aside><!-- .btn-lms-module-progress -->
    </div>
    <footer class="btn-lms-footer entry-footer">
        <?php // Footer Content
        echo $functions->module_footer($module_id, $module, $user_data); ?>
    </footer><!-- .entry-footer -->

</article>
