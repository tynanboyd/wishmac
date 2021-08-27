<?php
/**
 * Clean up WordPress defaults
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

if (!function_exists('foundationpress_start_cleanup')) {
    function foundationpress_start_cleanup() {
        add_action('init', 'foundationpress_cleanup_head'); // Clean up <head>
        add_filter('the_generator', 'foundationpress_remove_rss_version'); // Remove WP version from RSS.
        add_filter('wp_head', 'foundationpress_remove_wp_widget_recent_comments_style', 1); // Remove injected css for recent comments widget
        add_action('wp_head', 'foundationpress_remove_recent_comments_style', 1); // Clean up comment styles in the head
        add_filter('img_caption_shortcode', 'foundationpress_remove_figure_inline_style', 10, 3); // Remove inline width attribute from figure tag
        add_filter('the_content', 'bones_filter_ptags_on_images'); // cleaning up random code around images
        add_filter('style_loader_src', 'vc_remove_wp_ver_css_js', 9999); // remove WP version from stylesheets
        add_filter('script_loader_src', 'vc_remove_wp_ver_css_js', 9999); // remove WP version from scripts
        add_filter('excerpt_more', 'bones_excerpt_more'); // cleaning up excerpt
    }

    add_action('after_setup_theme', 'foundationpress_start_cleanup');
}

// --------------------------------------
// Clean up <head>
// --------------------------------------

if (!function_exists('foundationpress_cleanup_head')) {
    function foundationpress_cleanup_head() {
        remove_action('wp_head', 'rsd_link'); // EditURI link
        remove_action('wp_head', 'wp_generator'); // WP version
        remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
        remove_action('wp_head', 'rel_canonical', 10); // Canonical
        remove_action('wp_head', 'feed_links', 2); // Post and comment feed links
        remove_action('wp_head', 'feed_links_extra', 3); // Category feed links
        remove_action('wp_head', 'index_rel_link'); // Index link
        remove_action('wp_head', 'start_post_rel_link', 10); // Start link
        remove_action('wp_head', 'parent_post_rel_link', 10); // Previous link
        remove_action('wp_head', 'adjacent_posts_rel_link', 10);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10); // Links for adjacent posts
        remove_action('wp_head', 'wp_shortlink_wp_head', 10); // Shortlink
        remove_action('wp_head', 'print_emoji_detection_script', 7); // Emoji detection script
        remove_action('wp_print_styles', 'print_emoji_styles'); // Emoji styles
    }
}

// --------------------------------------
// Clean Up & Security Functions
// --------------------------------------

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
    global $post;
    // edit here if you like

    return '...  <a class="excerpt-read-more" href="' . get_permalink($post->ID) . '" title="' . __('Read ', 'bonestheme') . esc_attr(get_the_title($post->ID)) . '">' . __('Read more &raquo;', 'bonestheme') . '</a>';
}


// Remove WP version param from any enqueued scripts (if it matches current WP version)
function vc_remove_wp_ver_css_js( $src ) {
    if (strpos($src, 'ver=' . get_bloginfo('version'))) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}

// Remove WP version from RSS.
if (!function_exists('foundationpress_remove_rss_version')) :
    function foundationpress_remove_rss_version() {
        return '';
    }
endif;

// Remove injected CSS for recent comments widget.
if (!function_exists('foundationpress_remove_wp_widget_recent_comments_style')) :
    function foundationpress_remove_wp_widget_recent_comments_style() {
        if (has_filter( 'wp_head', 'wp_widget_recent_comments_style')) {
            remove_filter('wp_head', 'wp_widget_recent_comments_style');
        }
    }
endif;

 // Clean up comment styles in the head
if (!function_exists('foundationpress_remove_recent_comments_style')) :
    function foundationpress_remove_recent_comments_style() {
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
        }
    }
endif;

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// Remove inline width attribute from figure tag causing images wider than 100% of its container
if (!function_exists('foundationpress_remove_figure_inline_style')) :
    function foundationpress_remove_figure_inline_style($output, $attr, $content) {
        $options = [
            'id' => '',
            'align' => 'alignnone',
            'width' => '',
            'caption' => '',
            'class' => '',
        ];

        $atts = shortcode_atts($options, $attr, 'caption');

        $atts['width'] = (int) $atts['width'];
        if ($atts['width'] < 1 || empty($atts['caption'])) {
            return $content;
        }

        if (!empty($atts['id'])) {
            $atts['id'] = 'id="' . esc_attr($atts['id']) . '" ';
        }

        $class = trim('wp-caption ' . $atts['align'] . ' ' . $atts['class']);

        if (current_theme_supports('html5', 'caption')) {
            return '<figure ' . $atts['id'] . ' class="' . esc_attr($class) . '">'
            . do_shortcode($content) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
        }
    }
endif;
