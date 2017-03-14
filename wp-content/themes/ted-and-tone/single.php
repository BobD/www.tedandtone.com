<?php
TimberHelper::function_wrapper('get_post_thumbnail_id');
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('do_shortcode');
TimberHelper::function_wrapper('do_action');
TimberHelper::function_wrapper('get_field');

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['intro'] = get_the_excerpt();
$sidebar = get_field('sidebar');

if ($sidebar) { 
	$context['sidebar'] = $sidebar;
} 

if ( post_password_required( $post->ID ) ) {
} else {
	Timber::render( array( 'page-post-single-' . $post->ID . '.twig', 'page-post-single-' . $post->post_type . '.twig', 'page-post-single.twig' ), $context );
}
