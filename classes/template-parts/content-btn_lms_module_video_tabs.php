<?php
/**
 * Template part for displaying Single BTN LMS Video Tabs and default content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 */

$current_tab = false;
$child_tab = '';
$active_class = 'btn-lms-active';
if( isset($tabs) && is_array($tabs) && ! empty($tabs) ){ ?>

    <nav class="btn-lms-video-tabs">
        <ul>
        <?php foreach ($tabs as $tab) {
            $current_tab = ( ! $current_tab ) ? $tab : $current_tab;
            $current_class = ( $current_tab === $tab ) ? $active_class : '';
            $children = !empty($tab['children']) ? $tab['children'] : false;
            $bg = ( $tab['settings']['tab_color'] > '' ) ? " style=\"background-color:{$tab['settings']['tab_color']};\"" : "";?>
                <li<?php echo $bg; ?> class="<?php echo $current_class; ?>">
                    <button value="<?php echo $tab['slug']; ?>" data-parent-tab-id="<?php echo $tab['id']; ?>"><?php echo $tab['name']; ?></button>
                    <?php if( $children ){
                            $child_tab .='<ul '.$bg.' class="btn-lms-sub-menu '.$current_class.'"  data-child-tab-container="'.$tab['id'].'">';
                            foreach ($children as $child) {
                                $id = $child['id'];
                                $sub_class = ( $current_tab && (substr($id, -5) === 'dummy') ) ? " class=\"{$active_class}-sub\"" : "";
                                $child_tab .='<li'.$sub_class.'>';
                                    $child_tab .='<button value="'.$child['slug'].'" data-child-tab-id="'.$id.'">'.$child['name'].'</button>';
                                $child_tab .='</li>';
                             }
                             $child_tab .='</ul>';
                    ?>
                    <?php } ?>
                </li>
        <?php } ?>
        </ul>
        <?php echo $child_tab;?>
    </nav>

    <?php if($current_tab) {
        $settings = $current_tab['settings'];
        $video_url = $functions->get_video_url($settings['embed_id'], 'embed');
        $links = $settings['video_links'];
        $copy = btn_lms()->settings()->get_option_title('title_text_copy');
        $materials = $settings['video_materials'];
        $materials_title = btn_lms()->settings()->get_option_title('title_text_materials');
        $materials_aria = ( $materials ) ? '' : ' aria-hidden="true"';
        $upsells = $settings['video_upsell'];
        $section_class = $settings['section_class'];
    ?>
    <section class="<?php echo $section_class;?>">

        <div class="btn-lms-embed-container">
            <?php echo $settings['video_toggle']; ?>
            <iframe class="vimeo-player" src="<?php echo $video_url; ?>" frameborder="0" width="100%" height="100%" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
        </div>

        <div class="btn-lms-video-materials"<?php echo $materials_aria; ?>>
            <?php if( $materials_title > '' ){ ?>
                <h3><?php echo $materials_title; ?></h3>
            <?php } ?>
            <ul>
                <?php echo $materials; ?>
            </ul>
        </div>
        <div class="btn-lms-module-links">
            <ul>
                <?php echo $settings['video_links']; ?>
            </ul>
        </div>
        <?php if( $copy > '' ){ ?>
            <div class="btn-lms-copy">
                <p><?php echo $copy; ?></p>
            </div>
        <?php } ?>
        <?php echo $upsells; ?>
    </section>
    <?php } ?>

<?php } ?>
