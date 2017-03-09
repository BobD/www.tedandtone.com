<?php
/**
 * This is the generic page template of the Ted and Tone website theme.
 * This template is show when viewing a page which is not designated as either the front page, or blog overview page
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

TimberHelper::function_wrapper('get_woocommerce_term_meta');
TimberHelper::function_wrapper('get_post_thumbnail_id');
TimberHelper::function_wrapper('get_category_link');
TimberHelper::function_wrapper('get_permalink');
TimberHelper::function_wrapper('wp_get_attachment_image_url');
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('wp_get_attachment_image_sizes');
TimberHelper::function_wrapper('category_description');
TimberHelper::function_wrapper('get_field');
TimberHelper::function_wrapper('wc_get_product');
TimberHelper::function_wrapper('wc_price');

$templates = array();
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['intro'] = get_the_excerpt();
$sidebar = get_field('sidebar');

if ($sidebar) { 
	$context['sidebar'] = $sidebar;
} 

$query_args = array(
	'post_type' => 'product',
	'stock' => 1,
	'posts_per_page' => get_option( 'posts_per_page' ),
	'orderby' =>'date',
	'order' => 'DESC'
);

query_posts($query_args);
$context['products'] = Timber::get_posts();
// $context['pagination'] = Timber::get_pagination();
$templates[] = 'page-shop-new.twig' ;

Timber::render($templates, $context);