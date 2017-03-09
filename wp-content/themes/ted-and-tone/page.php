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
TimberHelper::function_wrapper('do_shortcode');
TimberHelper::function_wrapper('do_action');
TimberHelper::function_wrapper('get_field');

$templates = array();
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['intro'] = get_the_excerpt();
$sidebar = get_field('sidebar');

if ($sidebar) { 
	$context['sidebar'] = $sidebar;
} 

if(is_account_page()){
	TimberHelper::function_wrapper('wc_print_notices');
	$context['is_shop_dashboard'] = !is_wc_endpoint_url();
	$templates[] =  is_user_logged_in() ? 'page-shop-account.twig' : 'page-shop-login.twig' ;
}else if(is_cart()){
	$templates[] = 'page-shop-cart.twig' ;
}else if(is_checkout()){
	$templates[] = 'page-shop-checkout.twig' ;
}else{
	$parent_pages = get_post_ancestors( $post );
	$parent_template_parts = array();

	foreach ($parent_pages as $parent_id) {
		$parent_template_parts[] = get_post_field( 'post_name', $parent_id);
	}

	$parent_template_path = join("-", $parent_template_parts);
	if(count($parent_pages) > 0){
		$parent_template_path .= '-';
	}

	$templates[] =  'page-' . $parent_template_path . $post->post_name . '.twig';
	$templates[] =  'page-text.twig';
}

Timber::render($templates, $context );