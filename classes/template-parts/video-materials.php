<?php
/**
 * Template part for displaying Video Materials
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE : Expects $html variable
 */

if( !empty($materials) && is_array($materials) ){
    foreach ($materials as $item) {
        $className = sanitize_title($item);
        $html .= "<li class=\"{$className}\">{$item}</li>";
    }
}