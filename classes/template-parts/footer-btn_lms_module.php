<?php
/**
 * Template part for displaying Single BTN LMS Footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 */

//echo '<pre>' . print_r([$buttons], true) . '</pre>';
if( !empty($buttons) && is_array($buttons) ){
    foreach ($buttons as $slug => $button) {
        $label = $button['label'];
        $url = $button['url'] > '' ? $button['url'] : false;
        $attrs = ( !empty($button['attrs']) ) ? " {$button['attrs']}" : "";
        if( $url ){
            echo "<a href=\"{$url}\" class=\"{$slug}\"{$attrs}>{$label}</a>";
        }
        else{
            echo "<span class=\"{$slug}\"{$attrs}>{$label}</span>";
        }
    }
}