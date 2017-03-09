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
    'posts_per_page'    => 8,
    'no_found_rows'     => 1,
    'post_status'       => 'publish',
    'post_type'         => 'product',
    'meta_query'        => WC()->query->get_meta_query(),
    'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
);
$products = get_posts( $query_args );
$context['products'] = $products;
$templates[] = 'page-shop-sale.twig' ;

Timber::render($templates, $context);