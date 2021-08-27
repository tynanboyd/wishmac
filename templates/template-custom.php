<?php
    /* Template Name: Custom Template! */

    get_header();

    $context = Timber::context();
    $context['post'] = new TimberPost();

    Timber::render('template-custom.twig', $context);

    get_footer();
