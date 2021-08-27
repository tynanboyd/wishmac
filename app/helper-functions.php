<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Helper Functions
// ---------------------------


//  Get Top Level Parent
// ---------------------------

function get_top_level_parent($post_id) {
    $post = get_post($post_id);

    if ($post->post_parent) {
        $ancestors = get_post_ancestors($post->ID);
        $root = count($ancestors) - 1;
        $parent = $ancestors[$root];
    } else {
        $parent = $post->ID;
    }

    return $parent;
}

//  Get Limited Title
// ---------------------------

function get_limited_title($limit, $post_id) {
    $title = get_the_title($post_id);

    if(strlen($title) > $limit) {
        $title = substr($title, 0, $limit);
        $title = substr($title, 0, strripos($title, " "));
        $title = trim(preg_replace('/\s+/', ' ', $title));

        if (!empty($title)) {
            $title .= '...';
        }
    }

    return $title;
}


//  Get Excerpt
// ---------------------------

/*
 * get_excerpt()
 *
 * limits the excerpt by characters without truncating the last word.
 *
 */

// Usage:
// get_excerpt(140, 'content'); // excerpt is grabbed from get_the_content
// get_excerpt(140); // excerpt is grabbed from get_the_excerpt, uses the_content as fallback

function get_excerpt($limit, $post_id, $source = null) {
    $the_post = get_post($post_id);

    if ($source === 'content') {
        $excerpt = $the_post->post_content;
    } else {
        $excerpt = ($the_post->post_excerpt) ?: $the_post->post_content;

        if (empty($excerpt)) {
            if(get_field('home_banner_text', $post_id)) {
                $excerpt = get_field('home_banner_text', $post_id) . ' ';
            }

            if(have_rows('content_blocks', $post_id)) {
                while (have_rows('content_blocks', $post_id)) {
                    the_row();
                    if (get_row_layout() === 'wysiwyg_content_module') {
                        $excerpt .= get_sub_field('wysiwyg_content') . ' ';
                        break;
                    }
                    if (get_row_layout() === 'wysiwyg_module') {
                        $excerpt .= get_sub_field('wysiwyg_content') . ' ';
                        break;
                    }
                }
            } else if(have_rows('content_blocks_fw', $post_id)) {
                while (have_rows('content_blocks_fw', $post_id)) {
                    the_row();
                    if(get_row_layout() === 'content_cards_module') {
                        if (have_rows('cards', $post_id)) {
                            while( have_rows('cards', $post_id) ) {
                                the_row();
                                $excerpt .= get_sub_field('content') . ' ';
                                break;
                            }
                        }
                    }
                    if (get_row_layout() === 'text_with_image_module') {
                        $excerpt .= get_sub_field('wysiwyg_content');
                        break;
                    }
                    if (get_row_layout() === 'centered_text_module') {
                        $excerpt .= get_sub_field('wysiwyg_content');
                        break;
                    }
                    if (get_row_layout() === 'full_width_content_module') {
                        $excerpt .= get_sub_field('wysiwyg_content');
                        break;
                    }
                }
            }
        }
    }

    $excerpt = preg_replace(" (\[.*?\])",'', $excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit+1);
    $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
    if (strlen($excerpt) > $limit) {
        $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    }
    $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));

    if (!empty($excerpt)){
        $excerpt .= '...';
    }

    return $excerpt;
}
