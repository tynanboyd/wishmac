<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Add ACF init callback
// ---------------------------

function my_acf_init() {
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    register_custom_acf_blocks();
}

add_action('acf/init', 'my_acf_init');

// ---------------------------
//  Add ACF block fields
// ---------------------------

/**
 * Render Options:
 * .php - to render a .php file, use 'render_template' property and provide path to file - do not use render_callback
 * .twig - if ACF block just needs twig file, use 'render_callback' => 'acf_block_render_callback'
 *      refer to /app/timber.php for details on file naming specifics
 */
function register_custom_acf_blocks() {

    acf_register_block_type([
        'name' => 'projects',
        'title' => __('Projects'),
        'description' => __('A block for adding artists and bios.'),
        'render_callback' => 'acf_block_render_callback',
        'category' => 'common',
        'icon' => 'images-alt',
        'keywords' => ['projects',],
        'mode' => 'auto',
        'post_types' => ['page'],
    ]);

    acf_register_block_type([
        'name' => 'festival',
        'title' => __('Festival'),
        'description' => __('A block for adding a festival with a gallery.'),
        'render_callback' => 'acf_block_render_callback',
        'category' => 'common',
        'icon' => 'calendar-alt',
        'keywords' => ['festival',],
        'mode' => 'auto',
        'post_types' => ['page'],
    ]);

    acf_register_block_type([
        'name' => 'press',
        'title' => __('Press'),
        'description' => __('A block for adding a press item.'),
        'render_callback' => 'acf_block_render_callback',
        'category' => 'common',
        'icon' => 'megaphone',
        'keywords' => ['press', 'news', 'media'],
        'mode' => 'auto',
        'post_types' => ['page'],
    ]);

    acf_register_block_type([
        'name' => 'initiative',
        'title' => __('Initiative'),
        'description' => __('A block for adding an initiative.'),
        'render_callback' => 'acf_block_render_callback',
        'category' => 'common',
        'icon' => 'megaphone',
        'keywords' => ['initiative'],
        'mode' => 'auto',
        'post_types' => ['page'],
    ]);
}
