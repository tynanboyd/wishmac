<?php

    $query_args = [
        'post_type' => 'used_equipment',
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'tax_query' => [],
    ];

    if (!empty($post_cat)) {
        $query_args['tax_query'][] = [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $post_cat,
        ];
    }

    $context['posts'] = Timber::get_posts($query_args);

    Timber::render('partials/list-posts.twig', $context);
