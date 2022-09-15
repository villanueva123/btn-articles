<?php
/**
 * Template part for displaying Video Links
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package btn-lms/template-parts
 * @NOTE : Expects $html variable
 */

if( !empty($links) && is_array($links) ){
    foreach ($links as $key => $link) {
        $html .= "<li data-link-type=\"{$key}\">";

        $text_link = $options["link_text_{$key}"];
        $text_button = '';
        $prop_string = 'target="_blank"';
        $prop_string .= ( $key === 'faq' ) ? '' : '';

        if( $key === 'cheat_sheet' || $key === 'faq' ){
            $text_button = $options["button_text_{$key}"];
        }

        if($text_link > ''){
            $props = "{$prop_string} class=\"btn-lms-link\"";
            $html .= $functions->maybe_protect_amazon_link($link, $text_link, $props);
        }
        if($text_button > ''){
            $props = "{$prop_string} class=\"btn-lms-button\"";
            $html .= $functions->maybe_protect_amazon_link($link, $text_button, $props);
        }

        $html .= "</li>";
    }
}
