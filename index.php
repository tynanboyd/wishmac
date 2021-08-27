<?php

    if (!defined('ABSPATH')) {
        exit;
    } // Exit if accessed directly

    get_header();

    $context = Timber::context();
    $context['post'] = new TimberPost();

    Timber::render('page.twig', $context);

    get_footer();
