<?php
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('wp_get_attachment_image_sizes');
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );