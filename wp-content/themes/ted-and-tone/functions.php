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
}

new TedAndTone();
