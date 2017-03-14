<?php

TimberHelper::function_wrapper('get_post_thumbnail_id');
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('do_shortcode');
TimberHelper::function_wrapper('do_action');
TimberHelper::function_wrapper('get_field');

$context = Timber::get_context();
Timber::render( 'templates/page-not-found.twig', $context );
