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
	TimberHelper::function_wrapper('wp_get_attachment_image_srcset');
	TimberHelper::function_wrapper('category_description');
	TimberHelper::function_wrapper('get_field');

	if (is_singular('product')) {
		// Reference: https://github.com/timber/timber/wiki/WooCommerce-Integration
		$timberContext['post'] = Timber::get_post();

		// Reference: https://docs.woocommerce.com/wc-apidocs/class-WC_Product.html
		$timberContext['product'] = wc_get_product( $timberContext['post']->ID );

		$terms = get_the_terms( $timberContext['post']->ID, 'product_cat' );
        $timberContext['category'] = get_term(reset($terms)->term_id, 'product_cat' );

		$templates[] =  'page-product-single.twig';
	}else{
		$templates[] =  'page-product-archive.twig';
	}
}else{
	$templates[] =  'page-plugin.twig';
}

Timber::render( $templates, $timberContext );
