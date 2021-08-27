<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ------------------------------
//  Registers Timber Specifics
// ------------------------------

if (class_exists('Timber')) {
    add_filter('timber_context', 'add_to_context');

    function add_to_context($data) {
        $data['main_menu'] = new TimberMenu('main-menu');
        $data['secondary_menu'] = new TimberMenu('secondary-menu');
        $data['footer_menu'] = new TimberMenu('footer-menu');
        $data['options'] = get_fields('option');

        return $data;
    }

    Timber::$dirname = ['templates/views', 'views'];
}

// ------------------------------
//  Registers ACF block Specifics
// ------------------------------

/**
 *  This is the callback that displays all ACF block. see https://timber.github.io/docs/guides/gutenberg/
 *  The template name must match this format "content-" . {name-of-registered-block set in acf-options.php}
 *
 * @param   array  $block      The block settings and attributes.
 * @param   string $content    The block content (empty string).
 * @param   bool   $is_preview True during AJAX preview.
 */
function acf_block_render_callback($block, $content = '', $is_preview = false) {
    // convert name ex. ("acf/slider-promo") into path friendly slug ("slider-promo")
    $slug = str_replace('acf/', '', $block['name']);

    $context = Timber::context();

    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

    // include a twig view from within the "template-parts/blocks" folder, partial name must match "content-" . {name-of-registered-block}
    if (file_exists(get_theme_file_path("/templates/template-parts/blocks/content-{$slug}.twig"))) {
        Timber::render("templates/template-parts/blocks/content-{$slug}.twig", $context);
    }
}
