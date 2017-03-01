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
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
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
		$context['env'] = WP_ENV;
		$context['site'] = $this;
		$context['user_logged_in'] = is_user_logged_in();
		$context['is_mobile'] = wp_is_mobile();

		foreach(get_registered_nav_menus() as $k => $v) {
		    $context['menu_' . $k] = new TimberMenu($k);
		}

		// echo '<pre>' . var_export($context['menu_contact']) . '</pre>';

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
			http://bradley-davis.com/woocommerce-add-text-regular-sale-price/
			https://mikejolley.com/2016/05/10/woocommerce-remove-product-data-tabs-and-hook-content-in-sequence-instead/
		*/

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

		// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_action( 'init', array( $this, 'tat_remove_wc_breadcrumbs') );
		add_filter( 'woocommerce_product_tabs', array( $this, 'tat_remove_wc_reviews_tab'));
		add_action( 'after_setup_theme', array( $this, 'tat_wc_support') );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_description_tab' );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_additional_information_tab' );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_show_product_sale_flash' );
		add_filter( 'woocommerce_product_description_heading', array( $this, 'tat_wc_description_heading') );
		add_filter( 'woocommerce_product_additional_information_heading', array( $this, 'tat_wc_information_heading') );
		add_filter('gettext', array( $this, 'tat_wc_change_checkout_btn'));
		add_filter('ngettext', array( $this, 'tat_wc_change_checkout_btn'));

		add_action( 'woocommerce_sidebar', 'woocommerce_upsell_display', 15 );
		add_action( 'woocommerce_sidebar', 'woocommerce_output_related_products', 20 );
	}

	function tat_wc_support() {
    	add_theme_support( 'woocommerce' );
	}


	function tat_wc_description_heading() {
		return 'What is it?';
	}

	function tat_wc_information_heading() {
		return '';
	}

	function tat_remove_wc_reviews_tab($tabs){
		return [];
	}

	function tat_wc_change_checkout_btn($checkout_btn){
	  	$checkout_btn= str_ireplace('Add to cart', 'Add to shoppingbag', $checkout_btn);
  		return $checkout_btn;	
	}

	function tat_remove_wc_breadcrumbs() {
    	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

}

new TedAndTone();
