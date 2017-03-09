<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

TimberHelper::function_wrapper('get_post_thumbnail_id');
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('do_shortcode');
TimberHelper::function_wrapper('do_action');
TimberHelper::function_wrapper('get_field');

$context = Timber::get_context();
Timber::render( 'page-not-found.twig', $context );
