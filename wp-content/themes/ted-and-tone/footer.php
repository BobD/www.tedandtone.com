<?php
/**
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the view/page-plugin.twig template.
 *
 * If you're not using a plugin that requries this behavior (ones that do include Events Calendar Pro and 
 * WooCommerce) you can delete this file and header.php
 */

$timberContext = $GLOBALS['timberContext'];
if ( ! isset( $timberContext ) ) {
	throw new \Exception( 'Timber context not set in footer.' );
}
$timberContext['content'] = ob_get_contents();
ob_end_clean();
$templates = array();

if(is_woocommerce()){
	TimberHelper::function_wrapper('get_woocommerce_term_meta');
	TimberHelper::function_wrapper('get_post_thumbnail_id');
	TimberHelper::function_wrapper('get_category_link');
	TimberHelper::function_wrapper('get_permalink');
	TimberHelper::function_wrapper('wp_get_attachment_image_url');
	TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
	TimberHelper::function_wrapper('wp_get_attachment_image_sizes');
	TimberHelper::function_wrapper('category_description');
	TimberHelper::function_wrapper('get_field');

	// Reference: https://docs.woocommerce.com/document/conditional-tags/
	// Reference: https://github.com/timber/timber/wiki/WooCommerce-Integration
	if (is_singular('product')) {
		$timberContext['post'] = Timber::get_post();
		$timberContext['product'] = wc_get_product( $timberContext['post']->ID );
		$terms = get_the_terms( $timberContext['post']->ID, 'product_cat' );
        $timberContext['category'] = get_term(reset($terms)->term_id, 'product_cat' );
		$templates[] = 'page-shop-product.twig';
	}

	if(is_shop()){
		// Reference: https://gist.github.com/Bradley-D/7287723
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		$timberContext['post'] = Timber::get_post($shop_page_id);
		$timberContext['intro'] = get_the_excerpt($shop_page_id);
		$shop_categories = get_categories( array(
	         'taxonomy'     => 'product_cat',
	         'orderby'      => 'name',
	         'show_count'   => 0,
	         'pad_counts'   => 0,
	         'hierarchical' => 1,
	         'title_li'     => '',
	         'hide_empty'   => 0
	  	));
	  	$timberContext['categories'] = $shop_categories;
		$templates[] =  'page-shop-home.twig';
	}

	if(is_product_category()){
		TimberHelper::function_wrapper('wc_get_product');
		TimberHelper::function_wrapper('wc_price');

	 	$queried_object = get_queried_object();
		$category_id = $queried_object->term_id;
        $timberContext['category'] = get_term($category_id, 'product_cat' );
        $timberContext['intro'] = term_description($category_id, 'product_cat' );
        $timberContext['products'] = Timber::get_posts();
        $timberContext['pagination'] = Timber::get_pagination();
		$templates[] = 'page-shop-categories.twig';
	}
}else{
	$templates[] =  'page-plugin.twig';
}

Timber::render( $templates, $timberContext );
