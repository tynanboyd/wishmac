<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/*
This file handles the admin area and functions.
*/

//-----------------------
// # Admin Styles
//-----------------------

function enqueue_custom_admin_stylesheets() {
    wp_enqueue_style('custom-admin-styles', get_stylesheet_directory_uri() . '/public/css/wp-admin.css');
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_stylesheets');


// ----------------------------------------------------
// # Default Image Alignment, Link Type and Size
// ----------------------------------------------------

function wnd_default_image_settings() {
    update_option('image_default_align', 'center');
    update_option('image_default_link_type', 'none');
    update_option('image_default_size', 'large');
}
add_action( 'after_setup_theme', 'wnd_default_image_settings' );


// ----------------------------------------------------
// # Disable Admin Bar for Non-Admin Users
// ----------------------------------------------------

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
// add_action('after_setup_theme', 'remove_admin_bar');


//-----------------------
// # Admin Favicon
//-----------------------

function add_favicon() {
    $favicon_url = get_stylesheet_directory_uri() . '/assets/images/favicons/favicon-32x32-greyscale.png';
    echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
// add_action('login_head', 'add_favicon');
// add_action('admin_head', 'add_favicon');


//-----------------------
// # Menu Items
//-----------------------

function pd_remove_menu_pages() {
    // remove_menu_page( 'edit.php' );                 // Posts
    // remove_menu_page( 'edit-comments.php' );        // Comments
    // remove_menu_page( 'tools.php' );              // Tools

    /* remove for editor and below, but not administrator */
    if (!current_user_can('manage_options')) {
        remove_menu_page('index.php');               // Dashboard
        remove_menu_page('themes.php');              // Appearance
        remove_menu_page('users.php');               // Users
        remove_menu_page('edit.php?post_type=acf-field-group');
    }
}
// add_action( 'admin_menu', 'pd_remove_menu_pages' );


//-----------------------
// # Admin Bar
//-----------------------

// Remove unnecessary items from the admin bar
function remove_some_nodes_from_admin_top_bar_menu($wp_admin_bar) {
    $wp_admin_bar->remove_menu('customize');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('wpseo-menu');
}
add_action('admin_bar_menu', 'remove_some_nodes_from_admin_top_bar_menu', 999);

//-----------------------
// # Dashboard Widgets
//-----------------------

/**
 *  Disable Default Dashboard Widgets
 */
function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset(
        $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'],
        $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'],
        $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
        $wp_meta_boxes['dashboard']['normal']['core']['welcome-panel'],
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'],
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'],
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']
    );
    // backupbuddy
    if (get_current_user_id() !== 1) {
        unset($wp_meta_boxes['dashboard']['normal']['core']['pb_backupbuddy_stats']);
    }
    // wordfence
    unset($wp_meta_boxes['dashboard']['normal']['core']['wordfence_activity_report_widget']);
    // postman smtp
    // unset($wp_meta_boxes['dashboard']['normal']['core']['example_dashboard_widget']);
    // yoast seo
    unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);
    // gravity forms
    // unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}
// add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets', 999);


//-----------------------------------
// # Remove Yoast SEO Columns
//-----------------------------------

add_filter('wpseo_use_page_analysis', '__return_false');


//-----------------------------------
// # Reposition Yoast SEO meta box
//-----------------------------------

add_filter('wpseo_metabox_prio', 'lnz_filter_yoast_seo_metabox');
function lnz_filter_yoast_seo_metabox() {
    return 'low';
}


//-----------------------------------
// # Remove Default Post Type
//-----------------------------------

add_action( 'admin_menu', 'remove_default_post_type' );

function remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );

function remove_default_post_type_menu_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-post' );
}

add_action( 'wp_dashboard_setup', 'remove_draft_widget', 999 );

function remove_draft_widget(){
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}

