<?php
/**
 * This is the generic page template of the Ted and Tone website theme.
 * This template is show when viewing a page which is not designated as either the front page, or blog overview page
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

TimberHelper::function_wrapper('get_post_thumbnail_id');
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('get_field');

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['intro'] = get_the_excerpt();
$sidebar = get_field('sidebar');

if ($sidebar) { 
	$context['sidebar'] = $sidebar;
} 

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );