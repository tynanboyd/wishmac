<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ----------------------------
//  Custom Login Page Styles
// ---------------------------

function pd_login_css() {
    wp_enqueue_style('login_css', get_template_directory_uri() . '/public/css/wp-login.css', false);
}

function pd_login_url() {
    return home_url();
}

function pd_login_title() {
    return get_option('blogname');
}

add_action('login_enqueue_scripts', 'pd_login_css', 10);
add_filter('login_headerurl', 'pd_login_url');
add_filter('login_headertext', 'pd_login_title');
