<?php
/**
 * Template part for displaying All BTN LMS Shortcode
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE : Expects $html variable
 */
$html .= "<li class=\"{$prefix}-li {$progress_status}\" data-module=\"{$id}\" data-status=\"{$status}\"{$style_css}";
        // Title
        $html .= "<summary class=\"{$prefix}-summary\">";
        // Module Link
        $el = $status === 'locked' ? 'span' : 'a';
        $href = $status === 'locked' ? "" : " href=\"{$link_href}\"";
        $link_string = '<%s class="%s"%s>%s</%s>';
        $link_html = "<legend>{$module['title']}</legend>";
        if($has_access){
            foreach($module['activities'] as $activity){
                $link_html .=  "<h4>".$activity['activity_title']."</h4>";
            }
        }
        $link_html .= "<div class=\"btn-lms-icon-container\">";
           $link_html .= "<span class=\"btn-lms-checked-icon\"></span>";
           $link_html .= "<span class=\"btn-lms-checked-play\"></span>";
        $link_html .= "</div>";
        $html .= sprintf($link_string, $el, "{$prefix}-link", $href, $link_html, $el);
        $html .= "</summary>";
$html .= "</li>";
