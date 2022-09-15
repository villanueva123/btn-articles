<?php
/**
 * Template part for displaying Single BTN LMS Archive Module
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE : Expects $html variable
 */
$html .= "<li class=\"{$prefix}-li\" data-module=\"{$id}\" data-status=\"{$status}\">";
    $html .= "<details class=\"{$prefix}-details\">";
        // Title
        $html .= "<summary class=\"{$prefix}-summary\">";
            $html .= "<legend>{$module['title']}</legend>";
        $html .= "</summary>";
        $html .= "<div class=\"{$prefix}-inner\">";
            // Display Header Image
            $html .= btn_lms()->functions()->module_header($id, $module);
            $html .= "<div class=\"{$prefix}-content\">";
            // Activities List
            $html .= btn_lms()->functions()->activities_list($id, $module, $user_data);
            // Checkup Points List
            $html .= btn_lms()->functions()->checkpoints_list($id, $module, $user_data);
            $html .= "</div>";
            // Module Link
            $el = $status === 'locked' ? 'span' : 'a';
            $href = $status === 'locked' ? "" : " href=\"{$link_href}\"";
            $link_string = '<%s class="%s"%s>%s<i aria-hidden="true"></i></%s>';
            $html .= sprintf($link_string, $el, "{$prefix}-link", $href, $link_text, $el);
        $html .= "</div>";
    $html .= "</details>";
$html .= "</li>";