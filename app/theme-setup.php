<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Theme Setup
// ---------------------------

function pd_theme_setup() {
    add_theme_support('menus');
    add_theme_support( 'title-tag' );
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
}

add_action('after_setup_theme', 'pd_theme_setup');
