<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

//--------------------------------
// # Load Posts
//--------------------------------

function icom_load_used_equipment_handler() {
    check_ajax_referer('load_posts', 'nonce');

    $post_cat = $_POST['post_cat'] ?? '';
    include(locate_template('template-parts/load-posts.php', false, false));

    wp_die();
}

add_action('wp_ajax_load_used_equipment', 'icom_load_used_equipment_handler');
add_action('wp_ajax_nopriv_load_used_equipment', 'icom_load_used_equipment_handler');
