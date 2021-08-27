<?php

    if (!defined('ABSPATH')) {
        exit;
    } // Exit if accessed directly

    get_header();

    $context = Timber::context();
    $context['post'] = new TimberPost();

    $projectArgs = [
        'post_type' => 'project',
        'posts_per_page' => -1,
    ];

    $context['projects'] = Timber::get_posts($projectArgs);

    Timber::render('front-page.twig', $context);

    get_footer();
