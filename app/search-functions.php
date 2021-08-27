<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/* ---------------------------
/*  Search Custom Fields
/* --------------------------- */

/* Search ACF Fields */

// Define list of ACF fields you want to search through
function list_searcheable_acf() {
    return [
        'field_name_1',
        'field_name_2',
    ];
}

/*
 * Search that encompasses ACF/advanced custom fields and taxonomies and split expression before request
*/
function advanced_custom_search($search, $wp_query) {
    global $wpdb;

    if (empty($search)) {
        return $search;
    }
    // 1 - get search expression
    $terms_raw = $wp_query->query_vars['s'];

    // 2 - check search term for XSS attacks
    $terms_xss_cleared = strip_tags($terms_raw);

    // 3 - do another check for SQL injection, use WP esc_sql
    $terms = esc_sql($terms_xss_cleared);

    // 4 - explode search expression to get search terms
    $exploded = explode(' ', $terms);
    if ($exploded === FALSE || count($exploded) === 0) {
        $exploded = [0 => $terms];
    }

    // 5 - setup search variable as a string
    $search = '';

    // 6 - get searcheable_acf, a list of advanced custom fields you want to search content in
    $list_searcheable_acf = list_searcheable_acf();

    // 7 - get custom table prefixes, thanks to Brian Douglas @bmdinteractive on github for this improvement
    $table_prefix = $wpdb->prefix;

    // 8 - search through tags, inject each into SQL query
    foreach ($exploded as $tag) {
        $search .= '
        AND (
        (' . $table_prefix . "posts.post_title LIKE '%$tag%')
        OR (" . $table_prefix . "posts.post_content LIKE '%$tag%')
        " .

        // 9- Adds to $search DB data from custom post types
        'OR EXISTS (
        SELECT * FROM ' . $table_prefix . 'postmeta
        WHERE post_id = ' . $table_prefix . 'posts.ID
        AND (';

        // 9b - reads through $list_searcheable_acf array to see which custom post types you want to include in the search string
        $metaStatements = [];
        foreach ($list_searcheable_acf as $key => $searcheable_acf) {
            if (is_array($searcheable_acf)) {
                foreach ($searcheable_acf as $repeater_acf) {
                    $metaStatements[] = "(meta_key LIKE '" . $key . "_%_" . $repeater_acf . "' AND meta_value LIKE '%$tag%')";
                }
            } else {
                $metaStatements[] = "(meta_key = '" . $searcheable_acf . "' AND meta_value LIKE '%$tag%')";
            }
        }
        $search .= join( $metaStatements, "\n          OR " );
        $search .= ')
        )' .
        ')'; // closes $search
    } // closes foreach

    return $search;
} // closes function advanced_custom_search

add_filter('posts_search', 'advanced_custom_search', 500, 2);

