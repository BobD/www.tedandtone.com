<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');

class TedAndTone extends TimberSite {

	function __construct() {
		add_post_type_support( 'page', 'excerpt' );
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action('customize_register', array( $this, 'customize_register') );

		$this->init_woocommerce();

		parent::__construct();
	}

	function customize_register($wp_customize) {
  		$wp_customize->remove_section( 'static_front_page' );
	}

	function register_post_types() {
	}

	function register_taxonomies() {
	}

	function register_menus(){
		register_nav_menus( array(
			'shop' => 'Shop',
			'about' => 'About',
			'customer_care' => 'Customer Care',
			'contact' => 'Contact',
		) );
	}

	function add_to_context( $context ) {
		// References: https://www.skyverge.com/blog/get-woocommerce-page-urls/

		global $woocommerce;
		$account_page_id = get_option( 'woocommerce_myaccount_page_id' );

		$context['env'] = WP_ENV;
		$context['site'] = $this;
		$context['user_logged_in'] = is_user_logged_in();
		$context['is_mobile'] = wp_is_mobile();
		$context['shop_url'] = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$context['shop_cart_url'] = $woocommerce->cart->get_cart_url();
		$context['shop_cart_total'] = $woocommerce->cart->cart_contents_count;
		$context['shop_checkout_url'] = $woocommerce->cart->get_checkout_url();

		if ( $account_page_id ) {
		  $context['shop_account_url'] = get_permalink( $account_page_id );
		}

		foreach(get_registered_nav_menus() as $k => $v) {
		    $context['menu_' . $k] = new TimberMenu($k);
		}

		// var_dump($context['menu_about'] );

		return $context;
	}

	function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('attachment_background_styles', new Twig_SimpleFilter('attachment_background_styles', array($this, 'get_attachment_background_styles')));
		return $twig;
	}

	function get_attachment_background_styles($srcset){
		if(empty($srcset)){
			return;
		}

		$srset_split = explode(', ', $srcset);
		$sizes = array();
		$styles = array();

		foreach ($srset_split as $v){
			$split = explode(' ', $v);
			$src = $split[0];
			$width = str_replace('w', '', $split[1]);
			$sizes[$width] = $src;
		}

		return $sizes;
	}

	function init_woocommerce(){
		/* References for customizing the WC templates 
			https://docs.woocommerce.com/wc-apidocs/hook-docs.html
			http://bradley-davis.com/woocommerce-add-text-regular-sale-price/
			https://mikejolley.com/2016/05/10/woocommerce-remove-product-data-tabs-and-hook-content-in-sequence-instead/
		*/

		add_action( 'after_setup_theme', array( $this, 'tat_wc_support') );
		
		// Single product
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		add_action( 'init', array( $this, 'tat_remove_wc_breadcrumbs') );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_product_description_tab' );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_product_additional_information_tab' );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15 );

		add_filter( 'woocommerce_product_tabs', array( $this, 'tat_remove_wc_reviews_tab'));
		add_filter( 'woocommerce_product_description_heading', array( $this, 'tat_wc_description_heading') );
		add_filter( 'woocommerce_product_additional_information_heading', array( $this, 'tat_wc_information_heading') );
		add_filter('woocommerce_sale_flash', array( $this, 'tat_wc_sales_flash'));
		add_filter( 'woocommerce_get_price_html', array( $this, 'tat_wc_price_single_product') );
		add_filter('gettext', array( $this, 'tat_wc_change_string'), 20, 3);

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15 );
	}

	function tat_wc_support() {
    	add_theme_support( 'woocommerce' );
	}

	function tat_remove_wc_breadcrumbs() {
    	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

	function tat_remove_wc_reviews_tab($tabs){
		return [];
	}

	function tat_wc_description_heading() {
		return 'What is it?';
	}

	function tat_wc_information_heading() {
		return '';
	}

	function tat_wc_sales_flash(){
		return false;
	}

	function tat_wc_price_single_product($price){
		global $product;

		$labels = array();
		$labels[] =  '<div class="title">price</div>';

		if($product->is_on_sale()){
			$labels[] = '<span class="label label--sale">Sale!</span>';
		}

		$labels[] = $price;

		$result = join('', $labels);
		return $result;
	}

	function tat_wc_change_string($translated_text, $text, $domain){

		switch ( $translated_text ) {
			case 'Add to cart' :
				$translated_text = str_ireplace('Add to cart', 'Add to shoppingbag', $translated_text);
				break;
			case 'View Cart' :
				$translated_text = str_ireplace('View Cart', 'View your shoppingbag', $translated_text);
				break;
			case 'You may also like&hellip;' :
				$translated_text = str_ireplace('You may also like&hellip;', "Hey! Maybe you'll also like these:", $translated_text);;
				break;
			case 'Cart Totals' :
				$translated_text = str_ireplace('Cart Totals', 'Total', $translated_text);
			break;
		}

  		return $translated_text;	
	}

}

new TedAndTone();
