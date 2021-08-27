<?php

    if (!defined('ABSPATH')) {
        exit;
    } // Exit if accessed directly

    $context = Timber::context();
    Timber::render('footer.twig', $context);
