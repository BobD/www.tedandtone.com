<?php
/**
 * This is the front page template of the Ted and Tone website theme.
 * The twig template to show depend on the front page settings in the Wordpress administration panel.
 * If 'latest posts' is selected the blog.twig will be shown, otherwise the home.twig template.
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

TimberHelper::function_wrapper('get_post_thumbnail_id');
TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
TimberHelper::function_wrapper('get_permalink');
TimberHelper::function_wrapper('get_field');

$post = new TimberPost();
$products = get_field('products');
$categories = array();

foreach ($products as $product) {
	$product_categories = get_the_terms($product->ID, 'product_cat');
	$product_category = reset($product_categories);
	$categories[] = $product_category;
}

foreach ($products as $product) {
	$product_categories = get_the_terms($product->ID, 'product_cat');
	$product_category = reset($product_categories);
}

$context = Timber::get_context();
$context['post'] = $post;
$context['quote'] = get_the_excerpt();
$context['intro_blocks'] = get_field('intro_blocks');
$context['categories'] = $categories;

$templates = array( 'home.twig' );

if ( is_home() ) {
	array_unshift( $templates, 'blog.twig' );
}
Timber::render( $templates, $context );