<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Enqueue Scripts & Styles
// ---------------------------

add_action('wp_enqueue_scripts', 'theme_scripts_and_styles', 10);

function theme_scripts_and_styles() {
    if (!is_admin()) {
        //  Styles
        // ----------------------------

        // wp_register_style($handle, $src, $deps, $ver, $media)

        $style_path = get_stylesheet_directory_uri() . '/public/css/theme.css';
        $style_modified_time = file_exists($style_path) ? filemtime($style_path) : '';

        wp_register_style('theme', $style_path, [], $style_modified_time);
        wp_register_style('webfonts', 'https://use.typekit.net/lvt1bmv.css', [], '1.0');
        wp_register_style('fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', [], '3.5.7');

        wp_enqueue_style('theme');
        wp_enqueue_style('webfonts');
        wp_enqueue_style('fancybox');

        //  Scripts
        // ----------------------------

        // wp_register_script($handle, $src, $deps, $ver, $in_footer);

        $vendor_js_path = get_stylesheet_directory_uri() . '/public/js/vendor.js';
        $custom_js_path = get_stylesheet_directory_uri() . '/public/js/custom.js';
        $vendor_js_modified_time = file_exists($vendor_js_path) ? filemtime($vendor_js_path) : '';
        $custom_js_modified_time = file_exists($custom_js_path) ? filemtime($custom_js_path) : '';

        wp_register_script('vendorjs', $vendor_js_path, ['jquery'], $vendor_js_modified_time, true);
        wp_register_script('customjs', $custom_js_path, ['jquery', 'vendorjs'], $custom_js_modified_time, true);

        wp_enqueue_script('vendorjs');

        wp_localize_script('custom', 'custom_params', [
          'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
          'load_posts_nonce' => wp_create_nonce('load_posts'),
        ]);
        wp_enqueue_script('customjs');
    }
}
