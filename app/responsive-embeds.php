<?php
/* ------------------------------------ */
/*  Add responsive container to embeds
/* ------------------------------------ */

function wlns_embed_html($html) {
    return '<div class="embed-container">' . $html . '</div>';
}

add_filter('embed_oembed_html', 'wlns_embed_html', 10, 3);
add_filter('video_embed_html', 'wlns_embed_html'); // Jetpack
