<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// ---------------------------
//  Image Sizes
// ---------------------------

// Add image sizes
// ---------------------------

// add_image_size('featured_image', 1200, 495, true);

// Name image sizes
// ---------------------------

//function pd_custom_image_sizes($sizes) {
//    return array_merge($sizes, [
//        'banner_image' => __('Featured Image - 1200px by 485px'),
//    ]);
//}
//add_filter('image_size_names_choose', 'pd_custom_image_sizes');

// ---------------------------
//  Common image functions
// ---------------------------

/**
 * Return srcset for Home Tiles + Community tiles from image object array
 *
 * @param $image array
 * @param array $keys
 * @return string
 */
function getSrcset($image, $keys = []): string
{
    $srcset = [];
    $defaultKeys = [
        '2048x2048',
        '1536x1536',
        'large',
        'medium_large',
        'medium'
    ];
    $keys = $keys ?: $defaultKeys;
    $current_image = null;

    foreach ($keys as $key) {
        if($image['sizes'][$key] !== $current_image){
            $srcset[] = $image['sizes'][$key].' '.$image['sizes'][$key.'-width'].'w';
            $current_image = $image['sizes'][$key];
        }
    }

    return implode(',', $srcset);
}

/**
 * Generate <img> tag from an image object array, adding attributes such as srcset and alt.
 *
 * @param $image array
 * @param string $defaultSize
 * @param string $sizes
 * @param string $classes
 * @param string $loading
 */
function imageTag($image, $sizes = '', $classes = '', $loading = 'auto', $defaultSize = 'large') {
    $attrs = [];
    $attrs['src'] = $image['sizes'][$defaultSize];
    $attrs['alt'] = htmlentities($image['alt']);
    $attrs['class'] = $classes;

    if ($image['mime_type'] === 'image/svg+xml' || $image['mime_type'] === 'svg') {
        ?>
            <img <?php foreach ($attrs as $key => $value) { echo $key.'="'.$value.'" '; }?> />
        <?php
    } else {
        $attrs['srcset'] = getSrcset($image);
        $attrs['sizes'] = $sizes;

        if ($sizes) {
            $attrs['sizes'] = preg_replace('/\s+/', ' ', trim(preg_replace("/\r|\n/", '', $sizes)));
        }

        $attrs['width'] = $image['sizes'][$defaultSize.'-width'];
        $attrs['height'] = $image['sizes'][$defaultSize.'-height'];
        $attrs['loading'] = $loading;

        if (!$sizes) {
            $attr['sizes'] = $attrs['width'];
        }

        ?>
            <img <?php foreach ($attrs as $key => $value) { echo $key . '="' . $value . '" '; }?> />
        <?php
    }
}
