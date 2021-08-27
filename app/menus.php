<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Register menu positions
// ---------------------------

add_action('init', 'pd_register_menus');

function pd_register_menus() {
    register_nav_menus([
        'main-menu' => __('Main Navigation', 'wishmac'), // main nav in header
        'footer-menu' => __('Footer Menu', 'wishmac'),  // nav in footer
    ]);
}
