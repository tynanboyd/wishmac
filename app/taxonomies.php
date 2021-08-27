<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Taxonomies
// ---------------------------

/**
 * Registers `book_genre` custom taxonomy.
 */
function register_book_genre_taxonomy(): void
{
    register_taxonomy(
        'book_genre',
        'book',
        [
            'rewrite' => [
                'slug' => 'books/genre',
                'with_front' => true,
                'hierarchical' => true,
            ],
            'hierarchical' => true,
            'public' => true,
            'labels' => [
                'name' => _x('Genres', 'taxonomy general name', 'textdomain'),
                'singular_name' => _x('Genre', 'taxonomy singular name', 'textdomain'),
                'search_items' => __('Search Genres', 'textdomain'),
                'all_items' => __('All Genres', 'textdomain'),
                'parent_item' => __('Parent Genre', 'textdomain'),
                'parent_item_colon' => __('Parent Genre:', 'textdomain'),
                'edit_item' => __('Edit Genre', 'textdomain'),
                'update_item' => __('Update Genre', 'textdomain'),
                'add_new_item' => __('Add New Genre', 'textdomain'),
                'new_item_name' => __('New Genre Name', 'textdomain'),
                'menu_name' => __('Genre', 'textdomain'),
            ],
        ]
    );
}
// add_action('init', 'register_book_genre_taxonomy');
