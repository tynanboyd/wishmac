<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


// ---------------------------
//  Post Revisions
// ---------------------------

add_filter('wp_revisions_to_keep', 'pd_revisions_filter', 10, 2);

function pd_revisions_filter ($num, $post) {
  $num = 7;
  return $num;
}

// ---------------------------
//  Post Types
// ---------------------------

/**
 * Registers `project` custom post type.
 *
 * @return void
 */
function register_project_post_type()
{
    register_post_type('project', [
        'description' => __('Collection of projects.', 'textdomain'),
        'public' => true,
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'comments'],
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'films',
            'with_front' => 'false',
        ],
        'menu_icon' => 'dashicons-video-alt',
        'labels' => [
            'name' => _x('Projects', 'post type general name', 'textdomain'),
            'singular_name' => _x('Project', 'post type singular name', 'textdomain'),
            'menu_name' => _x('Projects', 'admin menu', 'textdomain'),
            'name_admin_bar' => _x('Project', 'add new on admin bar', 'textdomain'),
            'add_new' => _x('Add New', 'project', 'textdomain'),
            'add_new_item' => __('Add New Project', 'textdomain'),
            'new_item' => __('New Project', 'textdomain'),
            'edit_item' => __('Edit Project', 'textdomain'),
            'view_item' => __('View Project', 'textdomain'),
            'all_items' => __('All Projects', 'textdomain'),
            'search_items' => __('Search projects', 'textdomain'),
            'parent_item_colon' => __('Parent projects:', 'textdomain'),
            'not_found' => __('No projects found.', 'textdomain'),
            'not_found_in_trash' => __('No projects found in Trash.', 'textdomain'),
        ],
    ]);
}
add_action('init', 'register_project_post_type');
