<?php
/**
 * Template part for displaying Video Upsells
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE : Expects $html variable
 */

$html .= "<div class=\"btn-lms-upsell\">";



if( $title ){
    $html .="<span>";
    $html .= "{$title}";
    if( $link ){
        $html .= "<a target=\"_blank\" class=\"btn-lms-button\" href=\"{$link}\">";
    }
    if( $text ){
        $html .= "<i>{$text}</i>";
    }
    if( $link ){
        $html .= "</a>";
    }
    $html .="</span>";
}
if( $image ){
    $alt = $title ? $title : '';
    $html .= "<img src=\"{$image}\" alt=\"{$alt}\">";
}
$html .= "</div>";
