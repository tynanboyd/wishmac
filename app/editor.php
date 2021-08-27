<?php

/**
 * Modify the WordPress editor
 *
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Load editor stylesheet
// ---------------------------

function pd_theme_add_editor_styles() {
    add_editor_style('public/css/wp-editor.css');
    $editor_font = 'https://fonts.googleapis.com/css?family=Montserrat:400';
    add_editor_style($editor_font);
}
// add_action('admin_init', 'pd_theme_add_editor_styles');


// -------------------------------------------------------------
//  Customize available block & style formats (headings, etc)
// -------------------------------------------------------------

function add_style_select_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'add_style_select_buttons');

function pd_mce_before_init_block_formats($settings) {
    $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;';

    $style_formats = [
        [
            'title' => 'Hero Text',
            'block' => 'p',
            'classes' => 'hero-text',
            'wrapper' => false,
        ],
    ];
    $settings['style_formats'] = json_encode($style_formats);

    return $settings;
}
add_filter('tiny_mce_before_init', 'pd_mce_before_init_block_formats');
