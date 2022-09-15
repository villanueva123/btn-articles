<?php
/**
 * Template part for displaying Video Toggles
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE : Expects $html variable
 */
$html = "<div class=\"btn-lms-video-toggle\">";
    $html .= "<input data-toggle-tab-id=\"{$id}\" id=\"{$css_id}\" type=\"checkbox\" checked=\"checked\">";
    $html .= "<label for=\"{$css_id}\">{$label_on}</label>";
$html .= "</div>";