<?php

$query = array( 
    'where'   => 'ID = ' . $post->ID, 
); 
$pods = pods( 'page', $query); 


TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('wp_get_attachment_image_sizes');
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['intro'] = get_the_excerpt();

if ( !empty($pods) && trim($pods->display('sidebar')) !== '') { 
	$context['sidebar'] = do_shortcode($pods->display('sidebar'));
} 

// echo 'tja'. get_extended( $post->post_content )['extended'];

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );